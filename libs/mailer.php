<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class Mailer {
    private $mail;

    public function __construct() {
        $this->mail = new PHPMailer(true);

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

    public function sendMail($to, $subject, $body) {
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

    public function sendInvoice($to, $items, $totalAmount) {
        $subject = 'Siparişinizin Faturası';
        $body = '<h1>Siparişiniz için teşekkür ederiz</h1>';
        $body .= '<p>Ödemeniz başarıyla alındı. Sipariş detaylarınız aşağıdadır:</p>';
        $body .= '<table border="1" cellspacing="0" cellpadding="5">';
        $body .= '<tr><th>Ürün Adı</th><th>Adet</th><th>Fiyat</th></tr>';

        foreach ($items as $item) {
            $body .= '<tr>';
            $body .= '<td>' . $item['name'] . '</td>';
            $body .= '<td>' . $item['quantity'] . '</td>';
            $body .= '<td>' . number_format($item['price'], 2, ',', '.') . ' TL</td>';
            $body .= '</tr>';
        }

        $body .= '</table>';
        $body .= '<p>Toplam Tutar: ' . number_format($totalAmount / 100, 2, ',', '.') . ' TL</p>';

        return $this->sendMail($to, $subject, $body);
    }
}
?>
