<?php

use PHPMailer\PHPMailer\PHPMailer;

require './vendor/autoload.php';

define('SMTP_SERVER', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'mail.smtpdemo@gmail.com');
define('SMTP_PASSWORD', 'tyycndwbbjlyajwq');

function sendMail($to, $name, $subject, $body)
{
    try {
        //Server settings
        $mail = new PHPMailer(true);
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = SMTP_SERVER;                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = SMTP_USERNAME;                     //SMTP username
        $mail->Password   = SMTP_PASSWORD;                               //SMTP password
        $mail->Port       = SMTP_PORT;

        //Recipients
        $mail->setFrom('mail.smtpdemo@gmail.com', 'Banking E-Authentication System');
        $mail->addAddress($to, $name);     //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();

        return true;
    } catch (\Throwable $th) {
        return false;
    }
}
