<?php


namespace app\services;


use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Dotenv\Dotenv;

class EmailService implements IEmailService
{

    public function EmailSending($subject, $message, $address)
    {
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 2;

        $mail->Debugoutput = function($data){$myFile = "log";
            $fh = fopen($myFile, 'a') or die("can't open file");
            fwrite($fh, $data);
            fclose($fh);};

        $mail->isSMTP();
        $mail->Host = "smtp.mailgun.org";
        $mail->Port = 587;
        $mail->Username = "postmaster@sandboxa61ab481a40d445e9ab412b9b6d2f01a.mailgun.org";
        $mail->Password = getenv("MAILGUN_PASSWORD");
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;

        $mail->From = "phpwebstore@gmail.com";
        try {
            $mail->addAddress($address);
        } catch (Exception $e) {
            echo $e->errorMessage();
        }
        $mail->Subject = $subject;
        $mail->Body = $message;
        try {
            $mail->send();
        } catch (Exception $e) {
            echo $e->errorMessage();
        }


    }
}