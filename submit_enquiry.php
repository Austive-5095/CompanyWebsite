<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contact.php');
    exit;
}

function writeEmailDebug($message) {
    $logFile = __DIR__ . '/email_debug.log';
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($logFile, "[$timestamp] $message\n", FILE_APPEND);
}

function sendSmtpEmail($to, $subject, $body, $fromEmail, $fromName, $smtpHost, $smtpPort, $smtpUsername, $smtpPassword) {
    $socket = fsockopen($smtpHost, $smtpPort, $errno, $errstr, 20);
    if (!$socket) {
        writeEmailDebug("SMTP connection failed: {$errstr} ({$errno})");
        return ['success' => false, 'error' => 'Connection to SMTP server failed'];
    }

    $response = readSmtpResponse($socket);
    if (strpos($response, '220') !== 0) {
        writeEmailDebug("SMTP greeting failed: $response");
        fclose($socket);
        return ['success' => false, 'error' => 'SMTP greeting failed'];
    }

    $responses = [];
    $responses[] = sendSmtpCommand($socket, 'EHLO localhost');
    $responses[] = sendSmtpCommand($socket, 'STARTTLS');

    if (!stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
        writeEmailDebug('TLS handshake failed');
        fclose($socket);
        return ['success' => false, 'error' => 'TLS handshake failed'];
    }

    $responses[] = sendSmtpCommand($socket, 'EHLO localhost');
    $responses[] = sendSmtpCommand($socket, 'AUTH LOGIN');
    $responses[] = sendSmtpCommand($socket, base64_encode($smtpUsername));
    $responses[] = sendSmtpCommand($socket, base64_encode($smtpPassword));

    $responses[] = sendSmtpCommand($socket, 'MAIL FROM:<' . $fromEmail . '>');
    $responses[] = sendSmtpCommand($socket, 'RCPT TO:<' . $to . '>');
    $responses[] = sendSmtpCommand($socket, 'DATA');

    $message = "From: {$fromName} <{$fromEmail}>\r\n";
    $message .= "To: {$to}\r\n";
    $message .= "Subject: {$subject}\r\n";
    $message .= "MIME-Version: 1.0\r\n";
    $message .= "Content-Type: text/plain; charset=UTF-8\r\n\r\n";
    $message .= $body . "\r\n.";

    fwrite($socket, $message . "\r\n");
    $dataResponse = readSmtpResponse($socket);
    if (strpos($dataResponse, '250') !== 0 && strpos($dataResponse, '354') !== 0) {
        writeEmailDebug('Mail data failed: ' . $dataResponse);
        fclose($socket);
        return ['success' => false, 'error' => 'Mail data failed'];
    }

    sendSmtpCommand($socket, 'QUIT');
    fclose($socket);
    return ['success' => true, 'error' => ''];
}

function readSmtpResponse($socket) {
    $response = '';
    while ($line = fgets($socket, 515)) {
        $response .= $line;
        if (substr($line, 3, 1) === ' ') {
            break;
        }
    }
    return $response;
}

function sendSmtpCommand($socket, $command) {
    fwrite($socket, $command . "\r\n");
    return readSmtpResponse($socket);
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$topic = trim($_POST['topic'] ?? '');
$message = trim($_POST['message'] ?? '');

$name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
$phone = htmlspecialchars($phone, ENT_QUOTES, 'UTF-8');
$topic = htmlspecialchars($topic, ENT_QUOTES, 'UTF-8');
$message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

$to = 'elearningwebsite02@gmail.com';
$subject = 'New enquiry from website: ' . $topic;
$body = "You have received a new enquiry from your website.\n\n";
$body .= "Name: $name\n";
$body .= "Email: $email\n";
$body .= "Phone: $phone\n";
$body .= "Enquiry Type: $topic\n\n";
$body .= "Message:\n$message\n";

$smtpHost = 'smtp.gmail.com';
$smtpPort = 587;
$smtpUsername = getenv('SMTP_USERNAME') ?: 'your_email@gmail.com';
$smtpPassword = getenv('SMTP_PASSWORD') ?: 'your_app_password';
$fromEmail = getenv('SMTP_FROM_EMAIL') ?: 'your_email@gmail.com';
$fromName = 'Austive Website';

if ($smtpUsername === 'your_email@gmail.com' || $smtpPassword === 'your_app_password') {
    writeEmailDebug('SMTP credentials are still placeholders. Please fill in real values.');
    header('Location: contact.php?status=error');
    exit;
}

$result = sendSmtpEmail(
    $to,
    $subject,
    $body,
    $fromEmail,
    $fromName,
    $smtpHost,
    $smtpPort,
    $smtpUsername,
    $smtpPassword
);

if ($result['success']) {
    header('Location: contact.php?status=success');
} else {
    writeEmailDebug($result['error']);
    header('Location: contact.php?status=error');
}
exit;
