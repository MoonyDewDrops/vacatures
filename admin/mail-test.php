<?php
include 'auth_check.php';
include '../db_connect.php';
require_once __DIR__ . '/includes/mail_helper.php';

$result = null;
$testTo = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['test_email'])) {
    if (!validateCSRFToken($_POST['csrf_token'] ?? '')) {
        $result = ['ok' => false, 'error' => 'Vernieuw de pagina en probeer opnieuw.'];
    } else {
        $testTo = trim($_POST['to'] ?? '');
        $result = sendPlainTextMail(
            $testTo,
            'Test e-mail Bureau Jobs',
            "Dit is een test.\n\nAls je dit op de live server ontvangt, werkt PHP mail() goed.\n\nVerzonden: " . date('d-m-Y H:i:s')
        );
    }
}

$config = loadMailConfig();
$transport = $config['_resolved_transport'] ?? 'auto';
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-mail testen - Bureau Jobs</title>
    <link rel="icon" type="image/png" href="/vacatures/assets/img/favicon.png">
    <link rel="stylesheet" href="css/admin-style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="admin-container">
        <?php include 'includes/sidebar.php'; ?>

        <main class="admin-content">
            <div class="page-header">
                <h1>E-mail testen</h1>
                <a href="submissions" class="btn-secondary">← Terug</a>
            </div>

            <div class="detail-card" style="max-width: 720px;">
                <p style="color: #b3b3b3; line-height: 1.6; margin-bottom: 16px;">
                    Je project gebruikt de ingebouwde PHP-functie <strong>mail()</strong> op de live site
                    <strong>bureau.gluwebsite.nl</strong>. Alleen het no-reply-adres in
                    <code>admin/includes/mail_config.php</code> hoef je in te stellen.
                </p>

                <div style="background: #1a1a1a; padding: 16px; border-radius: 6px; margin-bottom: 20px; color: #ccc; line-height: 1.7;">
                    <strong style="color: #fff;">Nu actief:</strong> <?php echo htmlspecialchars(getMailEnvironmentLabel()); ?><br>
                    <strong style="color: #fff;">Verzendwijze:</strong> <?php echo htmlspecialchars($transport); ?><br>
                    <strong style="color: #fff;">Afzender:</strong> <?php echo htmlspecialchars($config['from_email'] ?? ''); ?><br>
                    <strong style="color: #fff;">Antwoord naar:</strong> <?php echo htmlspecialchars($config['reply_to'] ?? ''); ?>
                </div>

                <?php if (isLocalDevelopment()): ?>
                <p style="color: #f39c12; margin-bottom: 16px;">
                    Je zit op <strong>localhost</strong> (XAMPP). Echte mail werkt hier meestal niet.
                    Testberichten worden opgeslagen in <code>admin/logs/mail.log</code>.
                    Test opnieuw na upload naar <strong>https://bureau.gluwebsite.nl/vacatures/</strong>.
                </p>
                <?php endif; ?>

                <?php if ($result !== null): ?>
                    <div class="<?php echo $result['ok'] ? 'success-message' : 'error-message'; ?>" style="margin-bottom: 16px;">
                        <?php if ($result['ok']): ?>
                            <?php if ($transport === 'log'): ?>
                                Gelukt (testmodus). Open <code>admin/logs/mail.log</code> op je computer.
                            <?php else: ?>
                                Verzonden naar <?php echo htmlspecialchars($testTo); ?> — controleer je inbox (en spam).
                            <?php endif; ?>
                        <?php else: ?>
                            <?php echo htmlspecialchars($result['error'] ?? 'Onbekende fout'); ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <form method="post" style="max-width: 400px;">
                    <?php csrfField(); ?>
                    <div class="form-group">
                        <label for="to">Jouw e-mailadres (om te testen)</label>
                        <input type="email" id="to" name="to" required class="form-text-inp" style="width: 100%;"
                               value="<?php echo htmlspecialchars($testTo); ?>"
                               placeholder="jouw.naam@school.nl">
                    </div>
                    <button type="submit" name="test_email" value="1" class="btn-primary">Verstuur testmail</button>
                </form>

                <p style="color: #888; font-size: 13px; margin-top: 24px; line-height: 1.6;">
                    Werkt het op de live server niet? Vraag je docent of
                    <code><?php echo htmlspecialchars($config['from_email'] ?? 'noreply@...'); ?></code>
                    bestaat bij de hosting en mail mag versturen.
                </p>
            </div>
        </main>
    </div>
</body>
</html>
