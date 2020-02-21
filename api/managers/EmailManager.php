<?php

//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailManager
{
    public function send(string $from, string $to, string $subject, string $message): bool
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.mailtrap.io';  //mailtrap SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'fe96d7679427ff';   //username
            $mail->Password = '64a1dfe2642dd8';   //password
            $mail->Port = 2525;                    //smtp port

            $mail->setFrom($from, 'Awesome app');
            $mail->addAddress($to);

            $mail->isHTML(true);

            $mail->Subject = $subject;
            $mail->Body = $message;

            if (!$mail->send()) {
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                return true;
            }
        } catch (Exception $e) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
        return false;
    }
}