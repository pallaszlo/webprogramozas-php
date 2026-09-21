<?php

// =============================================================
// 8.13. E-mail-küldés PHPMailerrel
// =============================================================

// Előkészítés a futtatáshoz (nem része a könyvbeli kódpéldának)
// A valódi küldéshez saját SMTP-kiszolgáló adatai kellenek. A példában szereplő
// smtp.example.com nem létezik, ezért a példa hibaüzenetet ír ki.
require __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);
$mail->CharSet    = PHPMailer::CHARSET_UTF8;
$mail->isSMTP();
$mail->Host       = 'smtp.example.com';
$mail->SMTPAuth   = true;
$mail->Username   = 'user@example.com';
$mail->Password   = 'secret';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port       = 587;

$mail->setFrom('noreply@example.com', 'Weboldal');
$mail->addAddress('recipient@example.com');
$mail->Subject = 'Tárgy';
$mail->Body    = 'Az üzenet szövege.';

try {
    $mail->send();
} catch (Exception $e) {
    echo "Hiba az e-mail küldésekor: " . $mail->ErrorInfo;
}
