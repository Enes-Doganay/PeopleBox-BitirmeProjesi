<?php 

class user {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    //prepared statement kullanarak kayıt fonksiyonu
    public function register($firstName, $lastName, $email, $password, $role = 'user') {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->conn->prepare("INSERT INTO users (firstName, lastName, email, password, role) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt) {
            return "Prepare failed: (" . $this->conn->errno . ") " . $this->conn->error;
        }
        $stmt->bind_param("sssss", $firstName, $lastName, $email, $hashedPassword, $role);
        if ($stmt->execute()) {
            return true;
        } else {
            return "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
    }

    //prepared statement kullanarak giriş fonksiyonu
    public function login($email, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        //kullanıcı doğrulaması
        if($user){
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];
                return true;
            }else{
                return "Şifre yanlış!";
            }
        }
        else{
            return "E-posta bulunamadı!";
        }        
    }

    public function logout() {
        session_unset();
        session_destroy();
    }

    public function getById($id){
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function isAdmin() {
        return (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');
    }

    public function isLogged() {
        return isset($_SESSION['user_id']);
    }

    //email sisteme kayıtlı mı 
    public function isEmailExists($email) {
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }    

    public function setResetToken($email, $token, $expires) {
        $stmt = $this->conn->prepare("UPDATE users SET reset_token = ?, reset_token_expires = ? WHERE email = ?");
        $stmt->bind_param("sss", $token, $expires, $email);
        return $stmt->execute();
    }

    public function getUserByResetToken($token) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE reset_token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function updatePassword($email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $hashedPassword, $email);
        return $stmt->execute();
    }

    public function clearResetToken($email) {
        $stmt = $this->conn->prepare("UPDATE users SET reset_token = NULL, reset_token_expires = NULL WHERE email = ?");
        $stmt->bind_param("s", $email);
        return $stmt->execute();
    }
}
?>