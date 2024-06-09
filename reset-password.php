<?php
include "views/_header.php";
include "views/_navbar.php";
include "libs/functions.php";
require_once 'controllers/user-controller.php';

$password_err = $confirmPassword_err = $message = "";
$success_message = "";

// Token'ın geçerliliğini kontrol etmek için GET isteği ile gelen token'ı alın
if (isset($_GET['token'])) {
    $token = $_GET['token'];
} else {
    die("Geçersiz token");
}

// CSRF token oluşturma ve kontrol etme
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// POST isteği geldiğinde formdan token ve diğer bilgileri alıp işle
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["reset_password"])) {
    // CSRF token kontrolü
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Geçersiz CSRF token");
    }
    
    $token = $_POST["token"];
    $password = control_input($_POST["password"]);
    $confirmPassword = control_input($_POST["confirmPassword"]);

    //Şifre kontrolü
    if (empty($password)) {
        $password_err = "Şifre girmelisiniz";
    } else if (strlen($password) < 8) {
        $password_err = "Şifre en az 8 karakterden oluşturulmalıdır.";
    }

    //Şifre tekrarı kontrolü
    if (empty($confirmPassword)) {
        $confirmPassword_err = "Şifre tekrarı girmelisiniz";
    } else if ($password !== $confirmPassword) {
        $confirmPassword_err = "Şifreler eşleşmiyor.";
    }

    //Şifrelerde bir hata yoksa şifreyi sıfırla
    if (empty($password_err) && empty($confirmPassword_err)) {
        $controller = new UserController();
        $message = $controller->resetPassword($token, $password);
        
        // Şifre sıfırlama başarılıysa mesajı ayarla
        if ($message === "Şifreniz başarıyla güncellendi.") {
            $success_message = $message;
        }
    }
}
?>

<!-- Form -->
<div class="container my-3">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="reset-password.php?token=<?php echo htmlspecialchars($token, ENT_QUOTES, 'UTF-8'); ?>" method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token, ENT_QUOTES, 'UTF-8'); ?>">
                        <div class="mb-3">
                            <label for="password" class="form-label">Yeni Şifre</label>
                            <input type="password" class="form-control" name="password" id="password">
                            <?php if (!empty($password_err)) echo "<div class='text-danger'>{$password_err}</div>"; ?>
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Yeni Şifre Tekrar</label>
                            <input type="password" class="form-control" name="confirmPassword" id="confirmPassword">
                            <?php if (!empty($confirmPassword_err)) echo "<div class='text-danger'>{$confirmPassword_err}</div>"; ?>
                        </div>
                        <input type="submit" name="reset_password" value="Şifre Sıfırla" class="btn btn-primary">
                        <?php if (!empty($message) && $message !== "Şifreniz başarıyla güncellendi.") echo "<div class='text-danger'>{$message}</div>"; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Başarılı Kayıt Modalı -->
<?php
if (!empty($success_message)) {
    include "views/_modal.php";
    renderSuccessModal($success_message);
}
?>

<?php include "views/_footer.php"; ?>