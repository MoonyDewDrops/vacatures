<?php
/**
 * Statusupdates voor sollicitaties (accept / reject / pending).
 */

require_once __DIR__ . '/activity_log.php';
require_once __DIR__ . '/application_email.php';

function getSubmissionById(mysqli $conn, int $id): ?array
{
    $stmt = $conn->prepare('SELECT * FROM bureau_sollicitaties WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $sub = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $sub ?: null;
}

function ensureSubmissionStatusColumn(mysqli $conn): void
{
    $columnCheck = $conn->query("SHOW COLUMNS FROM bureau_sollicitaties LIKE 'status'");
    if ($columnCheck && $columnCheck->num_rows === 0) {
        $conn->query("ALTER TABLE bureau_sollicitaties ADD COLUMN status ENUM('pending', 'accepted', 'rejected') DEFAULT 'pending' AFTER descriptie");
    }
}

/**
 * @return array{ok: bool, email_sent: bool|null, submission: ?array}
 */
function updateSubmissionStatus(mysqli $conn, int $id, string $status): array
{
    if (!in_array($status, ['pending', 'accepted', 'rejected'], true)) {
        return ['ok' => false, 'email_sent' => null, 'submission' => null];
    }

    $submission = getSubmissionById($conn, $id);
    if (!$submission) {
        return ['ok' => false, 'email_sent' => null, 'submission' => null];
    }

    $stmt = $conn->prepare('UPDATE bureau_sollicitaties SET status = ? WHERE id = ?');
    $stmt->bind_param('si', $status, $id);
    $ok = $stmt->execute();
    $stmt->close();

    if (!$ok) {
        return ['ok' => false, 'email_sent' => null, 'submission' => $submission];
    }

    $logLabels = [
        'accepted' => 'Geaccepteerd',
        'rejected' => 'Afgewezen',
        'pending'  => 'Terug naar In Behandeling',
    ];
    logActivity(
        $conn,
        'update',
        'sollicitatie',
        $id,
        ($submission['naam'] ?? '') . ' - ' . ($logLabels[$status] ?? $status)
    );

    $emailSent = null;
    if (in_array($status, ['accepted', 'rejected'], true)) {
        $emailSent = sendApplicationStatusEmail($submission, $status);
        if (!$emailSent) {
            $err = getLastApplicationEmailError();
            $_SESSION['email_error'] = $err !== '' ? $err : 'E-mail kon niet worden verstuurd.';
        } else {
            unset($_SESSION['email_error']);
        }
    }

    return ['ok' => true, 'email_sent' => $emailSent, 'submission' => $submission];
}

function getEmailStatusNote(): string
{
    if (!isset($_GET['email'])) {
        return '';
    }
    if ($_GET['email'] === 'sent') {
        return ' Er is een e-mail naar de sollicitant verstuurd.';
    }
    $detail = isset($_SESSION['email_error']) ? $_SESSION['email_error'] : getMailSetupHint();
    unset($_SESSION['email_error']);
    return ' Let op: de e-mail kon niet worden verstuurd. ' . $detail;
}

function redirectAfterSubmissionStatus(string $status, int $id, bool $fromView, ?bool $emailSent): void
{
    $params = ['success' => $status];
    if ($emailSent !== null) {
        $params['email'] = $emailSent ? 'sent' : 'failed';
    }

    if ($fromView) {
        $params['id'] = $id;
        header('Location: submission-view?' . http_build_query($params));
    } else {
        header('Location: submissions?' . http_build_query($params));
    }
    exit;
}

function handleSubmissionStatusRequest(mysqli $conn): void
{
    ensureSubmissionStatusColumn($conn);

    $map = [
        'accept'  => 'accepted',
        'reject'  => 'rejected',
        'pending' => 'pending',
    ];

    foreach ($map as $param => $status) {
        if (!isset($_GET[$param])) {
            continue;
        }

        $id = intval($_GET[$param]);
        $fromView = isset($_GET['from']) && $_GET['from'] === 'view';
        $result = updateSubmissionStatus($conn, $id, $status);

        if ($result['ok']) {
            redirectAfterSubmissionStatus($status, $id, $fromView, $result['email_sent']);
        }

        header('Location: submissions?error=update_failed');
        exit;
    }
}
