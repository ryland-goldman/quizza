<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '/var/www/html/docs/lib/email-endpoint/vendor/phpmailer/phpmailer/src/Exception.php';
require '/var/www/html/docs/lib/email-endpoint/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '/var/www/html/docs/lib/email-endpoint/vendor/phpmailer/phpmailer/src/SMTP.php';

require 'vendor/autoload.php';

$mail = new PHPMailer(true);
try {
//    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.mail.me.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'rylandgoldman@icloud.com';             //SMTP username
    $mail->Password   = trim(file_get_contents("/var/www/email.privkey")); //SMTP password
    $mail->SMTPSecure = 'tls';                                  //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    $mail->setFrom("noreply@quizza.org","Quizza");
    $mail->addAddress($to_email);

    $mail->isHTML(true);
    $mail->Subject = $from_name." shared a set with you";
    $mail->Body = "<style>@font-face {font-family: 'Gotham';font-weight: 400;src: url('https://www.quizza.org/static/fonts/gotham-reg.ttf') format(truetype');}@font-face {font-family: 'Gotham';font-weight: 700;src: url('https://www.quizza.org/static/fonts/gotham-bold.ttf') format('truetype');}*{font-family:'Gotham';} @media (prefers-color-scheme: dark) { background-color: #333; color: white; }</style><div style='padding:12px;text-align:center;'><h1 style='text-align:center;'>$from_name Sent a Study Set</h1><p style='text-align:center;'><img src='https://www.quizza.org/static/images/favicon.png' style='height:40px;'><br>$from_name ($from_email) has invited you to collaborate on a private study set ($setname) on Quizza. Access your Quizza sets at <a href='https://www.quizza.org/private'>quizza.org/private</a>.</p><p><a href='https://www.quizza.org/private'><button style='color:#rgba(0,0,0,0);border:2px solid #0fbd9d;border-radius:8px;padding:8px;'>Open Quizza</button></a></p><p><small>Copyright 2023 &copy; Ryland Goldman and Collin Wentzien</small></p></div>";
    $mail->send();
} catch (Exception $e){
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
