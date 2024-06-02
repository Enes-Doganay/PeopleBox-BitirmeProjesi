<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class Mailer
{
    private $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer();

        date_default_timezone_set('Europe/Istanbul');
        // Server settings
        $this->mail->isSMTP();
        $this->mail->SMTPDebug = 0; // Hata ayıklama modu
        $this->mail->Host = 'smtp.gmail.com';
        $this->mail->SMTPAuth = true;
        $this->mail->Username = 'voltage.clans1@gmail.com';
        $this->mail->Password = 'qskz sebz cahn nzpf';
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port =  587;

        // Character encoding
        $this->mail->CharSet = 'UTF-8';

        // Recipients
        $this->mail->setFrom('voltage.clans1@gmail.com', 'Enes');
    }

    public function sendMail($to, $subject, $body)
    {
        try {
            $this->mail->addAddress($to);
            $this->mail->Subject = $subject;
            $this->mail->Body = $body;
            $this->mail->isHTML(true); // HTML formatını etkinleştir

            if (!$this->mail->send()) {
                throw new Exception($this->mail->ErrorInfo);
            }
            return true;
        } catch (Exception $e) {
            error_log("Mailer Error: " . $e->getMessage());
            return false;
        }
    }
}
