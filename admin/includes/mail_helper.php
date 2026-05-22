<?php
/**
 * Verstuurt e-mail via PHP mail() op de live server, of logt lokaal op XAMPP.
 */

require_once __DIR__ . '/smtp_mailer.php';

function isLocalDevelopment(): bool
{
    $host = strtolower($_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? '');
    if ($host === '' && PHP_SAPI === 'cli') {
        return true;
    }
    return $host === 'localhost'
        || strpos($host, 'localhost:') === 0
        || $host === '127.0.0.1'
        || strpos($host, '127.0.0.1:') === 0;
}

function resolveMailTransport(array $config): string
{
    $transport = strtolower($config['transport'] ?? 'auto');

    if ($transport !== 'auto') {
        return $transport;
    }

    return isLocalDevelopment() ? 'log' : 'php_mail';
}

function loadMailConfig(): array
{
    $config = require __DIR__ . '/mail_config.php';

    $localPath = __DIR__ . '/mail_config.local.php';
    if (is_readable($localPath)) {
        $local = require $localPath;
        $config = array_replace_recursive($config, $local);
    }

    $config['_resolved_transport'] = resolveMailTransport($config);
    return $config;
}

/**
 * @return array{ok: bool, error: string|null}
 */
function sendPlainTextMail(
    string $to,
    string $subject,
    string $body,
    ?string $fromEmail = null,
    ?string $fromName = null,
    ?string $replyTo = null
): array {
    $config = loadMailConfig();
    $fromEmail = $fromEmail ?: ($config['from_email'] ?? '');
    $fromName = $fromName ?: ($config['from_name'] ?? 'Bureau Jobs');
    $replyTo = $replyTo ?: ($config['reply_to'] ?? $fromEmail);
    $transport = $config['_resolved_transport'] ?? resolveMailTransport($config);

    if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
        return ['ok' => false, 'error' => 'Ongeldig e-mailadres van de ontvanger.'];
    }

    if (!filter_var($fromEmail, FILTER_VALIDATE_EMAIL)) {
        return ['ok' => false, 'error' => 'from_email in mail_config.php is geen geldig adres.'];
    }

    if ($transport === 'log') {
        $logDir = dirname(__DIR__) . '/logs';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }
        $entry = sprintf(
            "[%s] VAN: %s | NAAR: %s | ONDERWERP: %s\n%s\n\n---\n\n",
            date('Y-m-d H:i:s'),
            $fromEmail,
            $to,
            $subject,
            $body
        );
        file_put_contents($logDir . '/mail.log', $entry, FILE_APPEND | LOCK_EX);
        return ['ok' => true, 'error' => null];
    }

    if ($transport === 'smtp') {
        $mailer = new SmtpMailer($config['smtp'] ?? []);
        $ok = $mailer->send($to, $subject, $body, $fromEmail, $fromName, $replyTo);
        return ['ok' => $ok, 'error' => $ok ? null : $mailer->getLastError()];
    }

    // php_mail — de standaard PHP mail()-functie (werkt op de meeste live servers)
    $headers = [
        'MIME-Version: 1.0',
        'Content-Type: text/plain; charset=UTF-8',
        'From: =?UTF-8?B?' . base64_encode($fromName) . "?= <{$fromEmail}>",
        'Reply-To: ' . $replyTo,
    ];
    $encodedSubject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
    $additional = '-f' . $fromEmail;

    $ok = @mail($to, $encodedSubject, $body, implode("\r\n", $headers), $additional);

    if (!$ok) {
        $hint = isLocalDevelopment()
            ? 'Op XAMPP werkt mail() niet — dat is normaal. Upload naar bureau.gluwebsite.nl of zet transport op "log".'
            : 'mail() op de server mislukt. Vraag je docent/host of noreply@gluwebsite.nl bestaat en mail mag versturen.';
        return ['ok' => false, 'error' => $hint];
    }

    return ['ok' => true, 'error' => null];
}

function getMailSetupHint(): string
{
    $config = loadMailConfig();
    $transport = $config['_resolved_transport'] ?? resolveMailTransport($config);

    if ($transport === 'log') {
        return 'Lokaal (XAMPP): e-mail staat in admin/logs/mail.log — op de live server gaat het via PHP mail().';
    }

    if ($transport === 'php_mail') {
        return 'Live server gebruikt PHP mail() vanaf ' . ($config['from_email'] ?? '?') . '.';
    }

    if ($transport === 'smtp') {
        $smtp = $config['smtp'] ?? [];
        if (empty($smtp['username']) || empty($smtp['password'])) {
            return 'SMTP staat aan maar username/wachtwoord ontbreken in mail_config.local.php.';
        }
        return 'SMTP: ' . ($smtp['host'] ?? '?');
    }

    return 'Controleer admin/includes/mail_config.php';
}

function getMailEnvironmentLabel(): string
{
    $config = loadMailConfig();
    $transport = $config['_resolved_transport'] ?? 'auto';

    if (isLocalDevelopment()) {
        return $transport === 'log'
            ? 'Lokaal (XAMPP) — testmodus, geen echte mail'
            : 'Lokaal (XAMPP)';
    }

    return 'Live server (' . ($_SERVER['HTTP_HOST'] ?? 'onbekend') . ') — PHP mail()';
}
