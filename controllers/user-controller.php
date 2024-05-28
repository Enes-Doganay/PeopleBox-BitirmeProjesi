<?php 
require_once 'models/database.php';
require_once 'models/user.php';

class UserController {
    private $user;

    public function __construct() {
        $database = new database();
        $db = $database->getConnection();
        $this->user = new user($db);
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
        if ($this->user->login($email, $password)) {
            header('Location: index.php');
        } else {
            return "Giriş başarısız!";
        }
    }

    public function logout() {
        $this->user->logout();
        header('Location: index.php');
    }

    public function isAdmin() {
        return $this->user->isAdmin();
    }

    public function isLogged() {
        return $this->user->isLogged();
    }
}
?>