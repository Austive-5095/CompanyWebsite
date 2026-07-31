<?php

/*
|--------------------------------------------------------------------------
| Austive Website - Contact Form
|--------------------------------------------------------------------------
| This file sends Contact Us enquiries through Hostinger SMTP.
|
| email_config.php should be OUTSIDE public_html:
|
| /home/your-account/
|     ├── email_config.php
|     └── public_html/
|          ├── contact.php
|          └── submit_enquiry.php
|
|--------------------------------------------------------------------------
*/


/* =========================================================
   LOAD SMTP CONFIG
   ========================================================= */

$configFile = dirname(__DIR__) . '/email_config.php';

if (!file_exists($configFile)) {
    writeEmailDebug('ERROR: email_config.php not found at: ' . $configFile);
    header('Location: contact.php?status=error');
    exit;
}

$config = require $configFile;


/* =========================================================
   ONLY ALLOW POST REQUEST
   ========================================================= */

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contact.php');
    exit;
}


/* =========================================================
   GET FORM DATA
   ========================================================= */

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$topic = trim($_POST['topic'] ?? '');
$message = trim($_POST['message'] ?? '');


/* =========================================================
   VALIDATE FORM DATA
   ========================================================= */

if ($name === '') {
    writeEmailDebug('Validation failed: Name is empty.');
    header('Location: contact.php?status=error');
    exit;
}

if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    writeEmailDebug('Validation failed: Invalid email address.');
    header('Location: contact.php?status=error');
    exit;
}

if ($phone === '') {
    writeEmailDebug('Validation failed: Phone is empty.');
    header('Location: contact.php?status=error');
    exit;
}

if ($topic === '') {
    writeEmailDebug('Validation failed: Topic is empty.');
    header('Location: contact.php?status=error');
    exit;
}

if ($message === '') {
    writeEmailDebug('Validation failed: Message is empty.');
    header('Location: contact.php?status=error');
    exit;
}


/* =========================================================
   CLEAN USER INPUT
   ========================================================= */

/*
 * Prevent CRLF / email header injection.
 */

$name = str_replace(["\r", "\n"], ' ', $name);
$email = str_replace(["\r", "\n"], '', $email);
$phone = str_replace(["\r", "\n"], ' ', $phone);
$topic = str_replace(["\r", "\n"], ' ', $topic);


/*
 * Limit input length.
 */

$name = mb_substr($name, 0, 100);
$email = mb_substr($email, 0, 254);
$phone = mb_substr($phone, 0, 50);
$topic = mb_substr($topic, 0, 100);
$message = mb_substr($message, 0, 5000);


/* =========================================================
   SMTP SETTINGS
   ========================================================= */

$smtpHost = $config['smtp_host'];
$smtpPort = $config['smtp_port'];

$smtpUsername = $config['smtp_username'];
$smtpPassword = $config['smtp_password'];

$fromEmail = $config['from_email'];
$fromName = $config['from_name'];

$to = $config['to_email'];


/* =========================================================
   CHECK SMTP CONFIG
   ========================================================= */

if (
    empty($smtpHost) ||
    empty($smtpPort) ||
    empty($smtpUsername) ||
    empty($smtpPassword) ||
    empty($fromEmail) ||
    empty($to)
) {
    writeEmailDebug('ERROR: SMTP configuration is incomplete.');

    header('Location: contact.php?status=error');
    exit;
}


/* =========================================================
   EMAIL SUBJECT
   ========================================================= */

$subject = 'New enquiry from Austive Website - ' . $topic;


/* =========================================================
   EMAIL BODY
   ========================================================= */

$body = "You have received a new enquiry from the Austive website.\r\n\r\n";

$body .= "========================================\r\n";
$body .= "CONTACT DETAILS\r\n";
$body .= "========================================\r\n\r\n";

$body .= "Name: " . $name . "\r\n";
$body .= "Email: " . $email . "\r\n";
$body .= "Phone: " . $phone . "\r\n";
$body .= "Enquiry Type: " . $topic . "\r\n\r\n";

$body .= "========================================\r\n";
$body .= "MESSAGE\r\n";
$body .= "========================================\r\n\r\n";

$body .= $message . "\r\n";


/* =========================================================
   CONNECT TO SMTP SERVER
   ========================================================= */

$errno = 0;
$errstr = '';

$socket = fsockopen(
    $smtpHost,
    $smtpPort,
    $errno,
    $errstr,
    20
);

if (!$socket) {

    writeEmailDebug(
        "SMTP connection failed: {$errstr} ({$errno})"
    );

    header('Location: contact.php?status=error');
    exit;
}


/* =========================================================
   SOCKET TIMEOUT
   ========================================================= */

stream_set_timeout($socket, 20);


/* =========================================================
   READ SMTP GREETING
   ========================================================= */

$response = readSmtpResponse($socket);

if (!smtpResponseStartsWith($response, '220')) {

    writeEmailDebug(
        'SMTP greeting failed: ' . trim($response)
    );

    fclose($socket);

    header('Location: contact.php?status=error');
    exit;
}


/* =========================================================
   EHLO
   ========================================================= */

$response = sendSmtpCommand(
    $socket,
    'EHLO austive.com'
);

if (!smtpResponseStartsWith($response, '250')) {

    writeEmailDebug(
        'EHLO failed: ' . trim($response)
    );

    fclose($socket);

    header('Location: contact.php?status=error');
    exit;
}


/* =========================================================
   STARTTLS
   ========================================================= */

$response = sendSmtpCommand(
    $socket,
    'STARTTLS'
);

if (!smtpResponseStartsWith($response, '220')) {

    writeEmailDebug(
        'STARTTLS failed: ' . trim($response)
    );

    fclose($socket);

    header('Location: contact.php?status=error');
    exit;
}


/* =========================================================
   ENABLE TLS ENCRYPTION
   ========================================================= */

$cryptoEnabled = stream_socket_enable_crypto(
    $socket,
    true,
    STREAM_CRYPTO_METHOD_TLS_CLIENT
);

if (!$cryptoEnabled) {

    writeEmailDebug(
        'TLS handshake failed.'
    );

    fclose($socket);

    header('Location: contact.php?status=error');
    exit;
}


/* =========================================================
   EHLO AGAIN AFTER TLS
   ========================================================= */

$response = sendSmtpCommand(
    $socket,
    'EHLO austive.com'
);

if (!smtpResponseStartsWith($response, '250')) {

    writeEmailDebug(
        'EHLO after STARTTLS failed: ' . trim($response)
    );

    fclose($socket);

    header('Location: contact.php?status=error');
    exit;
}


/* =========================================================
   AUTH LOGIN
   ========================================================= */

$response = sendSmtpCommand(
    $socket,
    'AUTH LOGIN'
);

if (!smtpResponseStartsWith($response, '334')) {

    writeEmailDebug(
        'AUTH LOGIN failed: ' . trim($response)
    );

    fclose($socket);

    header('Location: contact.php?status=error');
    exit;
}


/* =========================================================
   SMTP USERNAME
   ========================================================= */

$response = sendSmtpCommand(
    $socket,
    base64_encode($smtpUsername)
);

if (!smtpResponseStartsWith($response, '334')) {

    writeEmailDebug(
        'SMTP username authentication failed: ' . trim($response)
    );

    fclose($socket);

    header('Location: contact.php?status=error');
    exit;
}


/* =========================================================
   SMTP PASSWORD
   ========================================================= */

$response = sendSmtpCommand(
    $socket,
    base64_encode($smtpPassword)
);

if (!smtpResponseStartsWith($response, '235')) {

    writeEmailDebug(
        'SMTP password authentication failed: ' . trim($response)
    );

    fclose($socket);

    header('Location: contact.php?status=error');
    exit;
}


/* =========================================================
   MAIL FROM
   ========================================================= */

$response = sendSmtpCommand(
    $socket,
    'MAIL FROM:<' . $fromEmail . '>'
);

if (!smtpResponseStartsWith($response, '250')) {

    writeEmailDebug(
        'MAIL FROM failed: ' . trim($response)
    );

    fclose($socket);

    header('Location: contact.php?status=error');
    exit;
}


/* =========================================================
   RECIPIENT
   ========================================================= */

$response = sendSmtpCommand(
    $socket,
    'RCPT TO:<' . $to . '>'
);

if (
    !smtpResponseStartsWith($response, '250') &&
    !smtpResponseStartsWith($response, '251')
) {

    writeEmailDebug(
        'RCPT TO failed: ' . trim($response)
    );

    fclose($socket);

    header('Location: contact.php?status=error');
    exit;
}


/* =========================================================
   START DATA
   ========================================================= */

$response = sendSmtpCommand(
    $socket,
    'DATA'
);

if (!smtpResponseStartsWith($response, '354')) {

    writeEmailDebug(
        'DATA command failed: ' . trim($response)
    );

    fclose($socket);

    header('Location: contact.php?status=error');
    exit;
}


/* =========================================================
   EMAIL HEADERS
   ========================================================= */

$emailHeaders = '';

$emailHeaders .= 'From: ' .
    $fromName .
    ' <' .
    $fromEmail .
    ">\r\n";

$emailHeaders .= 'To: <' .
    $to .
    ">\r\n";


/*
 * IMPORTANT:
 *
 * Reply-To is the visitor's email.
 *
 * When you receive the enquiry and click Reply,
 * your email client will reply to the customer.
 */

$emailHeaders .= 'Reply-To: <' .
    $email .
    ">\r\n";

$emailHeaders .= 'Subject: ' .
    encodeSubject($subject) .
    "\r\n";

$emailHeaders .= "MIME-Version: 1.0\r\n";

$emailHeaders .=
    "Content-Type: text/plain; charset=UTF-8\r\n";

$emailHeaders .=
    "Content-Transfer-Encoding: 8bit\r\n";

$emailHeaders .= "\r\n";


/* =========================================================
   SEND EMAIL
   ========================================================= */

$emailData = $emailHeaders . $body;


/*
 * SMTP DATA must finish with:
 *
 * .\r\n
 */

fwrite(
    $socket,
    $emailData . "\r\n.\r\n"
);


/* =========================================================
   FINAL SMTP RESPONSE
   ========================================================= */

$response = readSmtpResponse($socket);

if (!smtpResponseStartsWith($response, '250')) {

    writeEmailDebug(
        'Email sending failed: ' . trim($response)
    );

    sendSmtpCommand(
        $socket,
        'QUIT'
    );

    fclose($socket);

    header('Location: contact.php?status=error');
    exit;
}


/* =========================================================
   CLOSE SMTP CONNECTION
   ========================================================= */

sendSmtpCommand(
    $socket,
    'QUIT'
);

fclose($socket);


/* =========================================================
   LOG SUCCESS
   ========================================================= */

writeEmailDebug(
    'Email successfully sent to ' .
    $to .
    ' from visitor ' .
    $email
);


/* =========================================================
   REDIRECT SUCCESS
   ========================================================= */

header(
    'Location: contact.php?status=success'
);

exit;


/* =========================================================
   FUNCTIONS
   ========================================================= */


/**
 * Write debug information to email_debug.log.
 */
function writeEmailDebug($message)
{
    $logFile = __DIR__ . '/email_debug.log';

    $timestamp = date('Y-m-d H:i:s');

    file_put_contents(
        $logFile,
        '[' . $timestamp . '] ' .
        $message .
        PHP_EOL,
        FILE_APPEND | LOCK_EX
    );
}


/**
 * Read SMTP server response.
 */
function readSmtpResponse($socket)
{
    $response = '';

    while (!feof($socket)) {

        $line = fgets($socket, 515);

        if ($line === false) {
            break;
        }

        $response .= $line;

        /*
         * SMTP multiline responses look like:
         *
         * 250-example
         * 250-example
         * 250 OK
         *
         * The final line contains a space
         * after the status code.
         */

        if (
            strlen($line) >= 4 &&
            $line[3] === ' '
        ) {
            break;
        }
    }

    return $response;
}


/**
 * Send SMTP command and return server response.
 */
function sendSmtpCommand($socket, $command)
{
    fwrite(
        $socket,
        $command . "\r\n"
    );

    return readSmtpResponse($socket);
}


/**
 * Check SMTP response code.
 */
function smtpResponseStartsWith($response, $code)
{
    return strpos(
        trim($response),
        $code
    ) === 0;
}


/**
 * Encode UTF-8 email subject.
 */
function encodeSubject($subject)
{
    return '=?UTF-8?B?' .
        base64_encode($subject) .
        '?=';
}