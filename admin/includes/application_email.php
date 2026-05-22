<?php
/**
 * Verstuurt e-mail naar sollicitant bij acceptatie of afwijzing.
 */

require_once __DIR__ . '/mail_helper.php';

/** Laatste foutmelding (voor admin/debug). */
function getLastApplicationEmailError(): string
{
    return $GLOBALS['_last_application_email_error'] ?? '';
}

function sendApplicationStatusEmail(array $submission, string $status): bool
{
    $GLOBALS['_last_application_email_error'] = '';

    if (!in_array($status, ['accepted', 'rejected'], true)) {
        return false;
    }

    $to = $submission['email'] ?? '';
    if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
        $GLOBALS['_last_application_email_error'] = 'Geen geldig e-mailadres bij deze sollicitatie.';
        return false;
    }

    $config = loadMailConfig();
    $naam = $submission['naam'] ?? 'sollicitant';
    $vacature = $submission['vacature'] ?? 'de vacature';

    if ($status === 'accepted') {
        $subject = "Je sollicitatie voor {$vacature} is geaccepteerd";
        $body = buildAcceptedEmailBody($naam, $vacature, $config);
    } else {
        $subject = "Update over je sollicitatie voor {$vacature}";
        $body = buildRejectedEmailBody($naam, $vacature, $config);
    }

    $result = sendPlainTextMail($to, $subject, $body);

    if (!$result['ok']) {
        $GLOBALS['_last_application_email_error'] = $result['error'] ?? 'Onbekende fout bij verzenden.';
        error_log('Application email failed: ' . $GLOBALS['_last_application_email_error']);
        return false;
    }

    return true;
}

function buildAcceptedEmailBody(string $naam, string $vacature, array $config): string
{
    $site = $config['from_name'];
    return <<<TEXT
Beste {$naam},

Goed nieuws! Je sollicitatie voor "{$vacature}" bij {$site} is geaccepteerd.

We nemen zo snel mogelijk contact met je op over de vervolgstappen.

Met vriendelijke groet,
{$site}
TEXT;
}

function buildRejectedEmailBody(string $naam, string $vacature, array $config): string
{
    $site = $config['from_name'];
    return <<<TEXT
Beste {$naam},

Bedankt voor je interesse in "{$vacature}" bij {$site}.

Helaas moeten we je meedelen dat we op dit moment niet verder gaan met je sollicitatie. We waarderen de tijd die je hebt genomen om te reageren.

We wensen je veel succes bij je verdere zoektocht.

Met vriendelijke groet,
{$site}
TEXT;
}
