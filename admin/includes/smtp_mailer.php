<?php
/**
 * Minimal SMTP client (TLS/SSL, AUTH LOGIN).
 */

class SmtpMailer
{
    private array $config;
    private string $lastError = '';
    private $socket;

    public function __construct(array $smtpConfig)
    {
        $this->config = $smtpConfig;
    }

    public function getLastError(): string
    {
        return $this->lastError;
    }

    public function send(
        string $to,
        string $subject,
        string $body,
        string $fromEmail,
        string $fromName,
        ?string $replyTo = null
    ): bool {
        $host = $this->config['host'] ?? '';
        $port = (int)($this->config['port'] ?? 587);
        $encryption = strtolower($this->config['encryption'] ?? 'tls');
        $username = $this->config['username'] ?? '';
        $password = $this->config['password'] ?? '';

        if ($host === '' || $username === '' || $password === '') {
            $this->lastError = 'SMTP is niet volledig geconfigureerd (host, gebruikersnaam of wachtwoord ontbreekt).';
            return false;
        }

        if (!filter_var($to, FILTER_VALIDATE_EMAIL) || !filter_var($fromEmail, FILTER_VALIDATE_EMAIL)) {
            $this->lastError = 'Ongeldig e-mailadres voor verzender of ontvanger.';
            return false;
        }

        $remote = $encryption === 'ssl'
            ? 'ssl://' . $host . ':' . $port
            : $host . ':' . $port;

        $this->socket = @stream_socket_client(
            $remote,
            $errno,
            $errstr,
            20,
            STREAM_CLIENT_CONNECT,
            stream_context_create(['ssl' => ['verify_peer' => true, 'verify_peer_name' => true]])
        );

        if (!$this->socket) {
            $this->lastError = "Kan geen verbinding maken met {$host}:{$port} — {$errstr} ({$errno})";
            return false;
        }

        stream_set_timeout($this->socket, 20);

        try {
            $this->expect(220);

            $ehloHost = gethostname() ?: 'localhost';
            $this->cmd('EHLO ' . $ehloHost);

            if ($encryption === 'tls') {
                $this->cmd('STARTTLS', 220);
                $crypto = STREAM_CRYPTO_METHOD_TLS_CLIENT;
                if (defined('STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT')) {
                    $crypto |= STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT;
                }
                if (!stream_socket_enable_crypto($this->socket, true, $crypto)) {
                    throw new RuntimeException('STARTTLS mislukt. Controleer of OpenSSL in PHP is ingeschakeld.');
                }
                $this->cmd('EHLO ' . $ehloHost);
            }

            $this->cmd('AUTH LOGIN', 334);
            $this->cmd(base64_encode($username), 334);
            $this->cmd(base64_encode($password), 235);

            $this->cmd('MAIL FROM:<' . $fromEmail . '>', 250);
            $this->cmd('RCPT TO:<' . $to . '>', 250);
            $this->cmd('DATA', 354);

            $encodedSubject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
            $encodedFromName = '=?UTF-8?B?' . base64_encode($fromName) . '?=';
            $reply = $replyTo ?: $fromEmail;

            $message = "Date: " . date('r') . "\r\n";
            $message .= "From: {$encodedFromName} <{$fromEmail}>\r\n";
            $message .= "To: <{$to}>\r\n";
            $message .= "Reply-To: {$reply}\r\n";
            $message .= "Subject: {$encodedSubject}\r\n";
            $message .= "MIME-Version: 1.0\r\n";
            $message .= "Content-Type: text/plain; charset=UTF-8\r\n";
            $message .= "Content-Transfer-Encoding: 8bit\r\n";
            $message .= "\r\n";
            $message .= str_replace(["\r\n.", "\n."], ["\r\n..", "\n.."], $body);
            $message .= "\r\n";

            $this->write($message . "\r\n.\r\n");
            $this->expect(250);

            $this->cmd('QUIT', 221);
            fclose($this->socket);
            $this->socket = null;
            return true;
        } catch (Throwable $e) {
            $this->lastError = $e->getMessage();
            if (is_resource($this->socket)) {
                @fclose($this->socket);
            }
            $this->socket = null;
            return false;
        }
    }

    private function cmd(string $command, ?int $expectedCode = null): void
    {
        $this->write($command . "\r\n");
        if ($expectedCode !== null) {
            $this->expect($expectedCode);
        }
    }

    private function write(string $data): void
    {
        if (fwrite($this->socket, $data) === false) {
            throw new RuntimeException('Kon gegevens niet naar SMTP-server schrijven.');
        }
    }

    private function expect(int $code): string
    {
        $response = '';
        while (($line = fgets($this->socket, 515)) !== false) {
            $response .= $line;
            if (isset($line[3]) && $line[3] === ' ') {
                break;
            }
        }

        if ($response === '') {
            throw new RuntimeException('Geen antwoord van SMTP-server.');
        }

        $received = (int)substr($response, 0, 3);
        if ($received !== $code) {
            throw new RuntimeException(trim($response));
        }

        return $response;
    }
}
