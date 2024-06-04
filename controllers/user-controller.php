<?php 
require_once 'models/database.php';
require_once 'models/user.php';
require_once 'libs/mailer.php';

class UserController {
    private $user;

    public function __construct() {
        $database = new database();
        $db = $database->getConnection();
        $this->user = new user($db);
        date_default_timezone_set('Europe/Istanbul');
    }

    public function register($firstName, $lastName, $email, $password, $role = 'user') {

        if($this->user->isEmailExists($email)){
            return "Bu e-posta adresi zaten kullanılıyor.";
        }

        $result = $this->user->register($firstName, $lastName, $email, $password, $role);

        if ($result === true) {
            return "Kayıt başarılı";
        } else {
            return "Kayıt başarısız: " . $result;
        }
    }

    public function login($email, $password) {
        $result = $this->user->login($email, $password);

        if ($result === true) {
            header('Location: index.php');
        } else {
            return $result;
        }
    }

    public function logout() {
        $this->user->logout();
        header('Location: index.php');
    }

    public function getById($id){
        return $this->user->getById($id);
    }

    public function isAdmin() {
        return $this->user->isAdmin();
    }

    public function isLogged() {
        return $this->user->isLogged();
    }

    public function requestPasswordReset($email) {
        if (!$this->user->isEmailExists($email)) {
            return "Bu e-posta adresi bulunamadı.";
        }

        $token = bin2hex(random_bytes(32));
        $expires = new DateTime('now');
        $expires->modify('+1 hour');
        $expiresFormatted = $expires->format('Y-m-d H:i:s');

        // Hata ayıklama için loglama
        //error_log("Token oluşturuldu: $token, Süresi: $expiresFormatted");

        if ($this->user->setResetToken($email, $token, $expiresFormatted)) {
            $resetLink = "http://localhost/PeopleBox-BitirmeProjesi/reset-password.php?token=$token";
            $mailer = new Mailer();
            $subject = "Şifre Sıfırlama Talebi";
            $body = "Şifrenizi sıfırlamak için bu linke tıklayın: <a href='$resetLink'>$resetLink</a>";
            if ($mailer->sendMail($email, $subject, $body)) {
                return "Şifre sıfırlama linki e-posta adresinize gönderildi.";
            } else {
                return "E-posta gönderimi başarısız.";
            }
        } else {
            return "Şifre sıfırlama işlemi başarısız.";
        }
    }

    public function resetPassword($token, $password) {
        $user = $this->user->getUserByResetToken($token);
    
        // Token geçerliliğini kontrol et
        if ($user && new DateTime($user['reset_token_expires']) > new DateTime()) {
            // Şifreyi güncelle
            if ($this->user->updatePassword($user['email'], $password)) {
                // Şifre güncelleme başarılıysa token'ı temizle
                $this->user->clearResetToken($user['email']);
                return "Şifreniz başarıyla güncellendi.";
            } else {
                return "Şifre güncelleme başarısız.";
            }
        } else {
            // Token geçerli değilse hata mesajı
            return "Geçersiz veya süresi dolmuş token.";
        }
    }
    
}
?>