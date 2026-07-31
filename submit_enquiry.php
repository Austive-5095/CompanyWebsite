<?php

/*
|--------------------------------------------------------------------------
| Austive Website - Contact Form
|--------------------------------------------------------------------------
| Sends Contact Us enquiries through Hostinger SMTP.
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
   ESCAPE HTML
   ========================================================= */

$htmlName = htmlspecialchars(
    $name,
    ENT_QUOTES,
    'UTF-8'
);

$htmlEmail = htmlspecialchars(
    $email,
    ENT_QUOTES,
    'UTF-8'
);

$htmlPhone = htmlspecialchars(
    $phone,
    ENT_QUOTES,
    'UTF-8'
);

$htmlTopic = htmlspecialchars(
    $topic,
    ENT_QUOTES,
    'UTF-8'
);

$htmlMessage = nl2br(
    htmlspecialchars(
        $message,
        ENT_QUOTES,
        'UTF-8'
    )
);


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
    writeEmailDebug(
        'ERROR: SMTP configuration is incomplete.'
    );

    header('Location: contact.php?status=error');
    exit;
}


/* =========================================================
   EMAIL SUBJECT
   ========================================================= */

$subject = 'New Website Enquiry - ' . $topic;


/* =========================================================
   HTML EMAIL
   ========================================================= */

$htmlBody = <<<HTML
<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>New Website Enquiry</title>

</head>

<body style="
    margin: 0;
    padding: 0;
    background-color: #f4f6f8;
    font-family: Arial, Helvetica, sans-serif;
    color: #333333;
">

<table
    width="100%"
    cellpadding="0"
    cellspacing="0"
    border="0"
    style="background-color: #f4f6f8; padding: 40px 15px;"
>

<tr>

<td align="center">

<table
    width="100%"
    cellpadding="0"
    cellspacing="0"
    border="0"
    style="
        max-width: 650px;
        background-color: #ffffff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 3px 15px rgba(0,0,0,0.08);
    "
>

<!-- =====================================================
     HEADER
====================================================== -->

<tr>

<td
    style="
        padding: 30px 35px;
        background-color: #111827;
        color: #ffffff;
    "
>

<div style="
    font-size: 13px;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: #cbd5e1;
    margin-bottom: 8px;
">
    Austive Human Capital Management
</div>

<div style="
    font-size: 26px;
    font-weight: bold;
    line-height: 1.3;
">
    New Website Enquiry
</div>

</td>

</tr>


<!-- =====================================================
     INTRO
====================================================== -->

<tr>

<td style="padding: 32px 35px 10px 35px;">

<p style="
    margin: 0 0 8px 0;
    font-size: 15px;
    color: #6b7280;
">
    You have received a new enquiry through the
    Austive website.
</p>

<p style="
    margin: 0;
    font-size: 20px;
    font-weight: bold;
    color: #111827;
">
    {$htmlTopic}
</p>

</td>

</tr>


<!-- =====================================================
     CONTACT INFORMATION
====================================================== -->

<tr>

<td style="padding: 25px 35px;">

<table
    width="100%"
    cellpadding="0"
    cellspacing="0"
    border="0"
    style="
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        overflow: hidden;
    "
>

<tr>

<td
    colspan="2"
    style="
        padding: 15px 18px;
        background-color: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
        font-size: 15px;
        font-weight: bold;
        color: #111827;
    "
>
    Contact Information
</td>

</tr>


<tr>

<td
    width="35%"
    style="
        padding: 14px 18px;
        border-bottom: 1px solid #eeeeee;
        color: #6b7280;
        font-size: 14px;
    "
>
    Full Name
</td>

<td
    style="
        padding: 14px 18px;
        border-bottom: 1px solid #eeeeee;
        font-size: 14px;
        font-weight: 600;
        color: #111827;
    "
>
    {$htmlName}
</td>

</tr>


<tr>

<td
    style="
        padding: 14px 18px;
        border-bottom: 1px solid #eeeeee;
        color: #6b7280;
        font-size: 14px;
    "
>
    Email Address
</td>

<td
    style="
        padding: 14px 18px;
        border-bottom: 1px solid #eeeeee;
        font-size: 14px;
    "
>
    <a
        href="mailto:{$htmlEmail}"
        style="
            color: #2563eb;
            text-decoration: none;
        "
    >
        {$htmlEmail}
    </a>
</td>

</tr>


<tr>

<td
    style="
        padding: 14px 18px;
        border-bottom: 1px solid #eeeeee;
        color: #6b7280;
        font-size: 14px;
    "
>
    Phone Number
</td>

<td
    style="
        padding: 14px 18px;
        border-bottom: 1px solid #eeeeee;
        font-size: 14px;
        color: #111827;
    "
>
    {$htmlPhone}
</td>

</tr>


<tr>

<td
    style="
        padding: 14px 18px;
        color: #6b7280;
        font-size: 14px;
    "
>
    Enquiry Type
</td>

<td
    style="
        padding: 14px 18px;
        font-size: 14px;
        font-weight: 600;
        color: #111827;
    "
>
    {$htmlTopic}
</td>

</tr>

</table>

</td>

</tr>


<!-- =====================================================
     MESSAGE
====================================================== -->

<tr>

<td style="padding: 0 35px 30px 35px;">

<div style="
    font-size: 15px;
    font-weight: bold;
    color: #111827;
    margin-bottom: 12px;
">
    Message
</div>

<div style="
    padding: 20px;
    background-color: #f9fafb;
    border-left: 4px solid #111827;
    border-radius: 6px;
    font-size: 14px;
    line-height: 1.7;
    color: #374151;
">
    {$htmlMessage}
</div>

</td>

</tr>

<!-- =====================================================
     FOOTER
====================================================== -->

<tr>

<td
    style="
        padding: 22px 35px;
        background-color: #f9fafb;
        border-top: 1px solid #e5e7eb;
        text-align: center;
    "
>

<p style="
    margin: 0 0 5px 0;
    font-size: 12px;
    color: #6b7280;
">
    This enquiry was submitted through the Austive website.
</p>

<p style="
    margin: 0;
    font-size: 12px;
    color: #9ca3af;
">
    austive.com
</p>

</td>

</tr>

</table>

</td>

</tr>

</table>

</body>

</html>
HTML;

/* =========================================================
   PLAIN TEXT FALLBACK
========================================================= */

/*
 * Some email clients do not display HTML.
 * This is the fallback version.
 */

$plainBody = '';

$plainBody .= "AUSTIVE HUMAN CAPITAL MANAGEMENT\r\n";
$plainBody .= "NEW WEBSITE ENQUIRY\r\n";
$plainBody .= "========================================\r\n\r\n";

$plainBody .= "CONTACT INFORMATION\r\n\r\n";

$plainBody .= "Name: " . $name . "\r\n";
$plainBody .= "Email: " . $email . "\r\n";
$plainBody .= "Phone: " . $phone . "\r\n";
$plainBody .= "Enquiry Type: " . $topic . "\r\n\r\n";

$plainBody .= "MESSAGE\r\n";
$plainBody .= "========================================\r\n\r\n";

$plainBody .= $message . "\r\n\r\n";

$plainBody .= "----------------------------------------\r\n";
$plainBody .= "Submitted via austive.com\r\n";

/* =========================================================
   CREATE MIME BOUNDARY
   ========================================================= */

$boundary = '=_AUSTIVE_' . md5(uniqid('', true));

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
 * VERY IMPORTANT:
 *
 * The visitor's email goes into Reply-To.
 *
 * When you click Reply in your email client,
 * it will reply directly to the visitor.
 */

$emailHeaders .= 'Reply-To: <' .
    $email .
    ">\r\n";

$emailHeaders .= 'Subject: ' .
    encodeSubject($subject) .
    "\r\n";

$emailHeaders .= "MIME-Version: 1.0\r\n";

$emailHeaders .=
    'Content-Type: multipart/alternative; boundary="' .
    $boundary .
    '"' .
    "\r\n";

$emailHeaders .= "\r\n";

/* =========================================================
   CREATE MIME EMAIL BODY
========================================================= */

$emailData = '';

/*
 * Plain text version
 */

$emailData .= '--' . $boundary . "\r\n";

$emailData .=
    "Content-Type: text/plain; charset=UTF-8\r\n";

$emailData .=
    "Content-Transfer-Encoding: 8bit\r\n\r\n";

$emailData .= $plainBody . "\r\n";

/*
 * HTML version
 */

$emailData .= '--' . $boundary . "\r\n";

$emailData .=
    "Content-Type: text/html; charset=UTF-8\r\n";

$emailData .=
    "Content-Transfer-Encoding: 8bit\r\n\r\n";

$emailData .= $htmlBody . "\r\n";

/*
 * End MIME boundary
 */

$emailData .= '--' . $boundary . "--\r\n";

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

stream_set_timeout(
    $socket,
    20
);

/* =========================================================
   SMTP GREETING
========================================================= */

$response = readSmtpResponse($socket);

if (!smtpResponseStartsWith($response, '220')) {

    writeEmailDebug(
        'SMTP greeting failed: ' .
        trim($response)
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
        'EHLO failed: ' .
        trim($response)
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
        'STARTTLS failed: ' .
        trim($response)
    );

    fclose($socket);

    header('Location: contact.php?status=error');
    exit;
}

/* =========================================================
   ENABLE TLS
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
        'EHLO after STARTTLS failed: ' .
        trim($response)
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
        'AUTH LOGIN failed: ' .
        trim($response)
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
        'SMTP username authentication failed: ' .
        trim($response)
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
        'SMTP password authentication failed.'
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
    'MAIL FROM:<' .
    $fromEmail .
    '>'
);

if (!smtpResponseStartsWith($response, '250')) {

    writeEmailDebug(
        'MAIL FROM failed: ' .
        trim($response)
    );

    fclose($socket);

    header('Location: contact.php?status=error');
    exit;
}


/* =========================================================
   RCPT TO
========================================================= */

$response = sendSmtpCommand(
    $socket,
    'RCPT TO:<' .
    $to .
    '>'
);

if (
    !smtpResponseStartsWith($response, '250') &&
    !smtpResponseStartsWith($response, '251')
) {

    writeEmailDebug(
        'RCPT TO failed: ' .
        trim($response)
    );

    fclose($socket);

    header('Location: contact.php?status=error');
    exit;
}


/* =========================================================
   DATA
========================================================= */

$response = sendSmtpCommand(
    $socket,
    'DATA'
);

if (!smtpResponseStartsWith($response, '354')) {

    writeEmailDebug(
        'DATA command failed: ' .
        trim($response)
    );

    fclose($socket);

    header('Location: contact.php?status=error');
    exit;
}


/* =========================================================
   SEND EMAIL DATA
========================================================= */

fwrite(
    $socket,
    $emailHeaders .
    $emailData .
    "\r\n.\r\n"
);


/* =========================================================
   FINAL SMTP RESPONSE
========================================================= */

$response = readSmtpResponse($socket);

if (!smtpResponseStartsWith($response, '250')) {

    writeEmailDebug(
        'Email sending failed: ' .
        trim($response)
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
   QUIT SMTP
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
    'HTML email successfully sent to ' .
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
        '[' .
        $timestamp .
        '] ' .
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

        $line = fgets(
            $socket,
            515
        );

        if ($line === false) {
            break;
        }

        $response .= $line;

        /*
         * SMTP multiline responses:
         *
         * 250-example
         * 250-example
         * 250 OK
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
 * Send SMTP command.
 */
function sendSmtpCommand(
    $socket,
    $command
) {
    fwrite(
        $socket,
        $command . "\r\n"
    );

    return readSmtpResponse(
        $socket
    );
}


/**
 * Check SMTP response code.
 */
function smtpResponseStartsWith(
    $response,
    $code
) {
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