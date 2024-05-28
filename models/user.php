<?php 

class user {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

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

    public function login($email, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            return true;
        }
        return false;
    }

    public function logout() {
        session_unset();
        session_destroy();
    }

    public function isAdmin() {
        return (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');
    }

    public function isLogged() {
        return isset($_SESSION['user_id']);
    }

    public function isEmailExists($email) {
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }    
}
?>