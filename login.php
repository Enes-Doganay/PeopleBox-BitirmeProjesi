<?php

use Stripe\Terminal\Location;

include "views/_header.php";
include "views/_navbar.php";
require_once 'controllers/user-controller.php';
include "libs/functions.php";

$controller = new UserController();

if ($controller->isLogged()) {
    header('Location: index.php');
}

// CSRF token oluşturma ve kontrol etme
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$email = $password = "";
$email_err = $password_err = "";


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["login"])) {
    // CSRF token kontrolü
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Geçersiz CSRF token");
    }

    $email = control_input($_POST["email"]);
    $password = control_input($_POST["password"]);

    //e posta kontrolü
    if (empty($email)) {
        $email_err = "E-posta adresi girmelisiniz.";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_err = "Geçerli bir e-posta kullanınız.";
    }

    //şifre kontrolü
    if (empty($password)) {
        $password_err = "Şifre girmelisiniz.";
    } else if (strlen($password) < 8) {
        $password = "Şifre en az 8 karakterden oluşmalıdır.";
    }

    //hata yoksa kullanıcı girişini sağla varsa hata mesajı göster
    if (empty($email_err) && empty($password_err)) {

        $resultMessage = $controller->login($email, $password);

        if ($resultMessage !== true) {
            echo "<div class='alert alert-danger'>{$resultMessage}</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Formu eksiksiz doldurun.</div>";
    }
}
?>

<div class="container my-3">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="login.php" method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <div class="mb-3">
                            <label for="email" class="form-label">E-posta Adresiniz</label>
                            <input type="email" class="form-control" name="email" id="email" value="<?php echo htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES); ?>">
                            <?php if (!empty($email_err)) echo "<div class='text-danger'>{$email_err}</div>"; ?>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Şifre</label>
                            <input type="password" class="form-control" name="password" id="password">
                            <?php if (!empty($password_err)) echo "<div class='text-danger'>{$password_err}</div>"; ?>
                        </div>
                        <div class="mb-3">
                            <p><a href="reset-password-request.php" class="link-danger link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">Şifremi Unuttum</a></p>
                        </div>
                        <button type="submit" name="login" value="Submit" class="btn btn-primary">Giriş Yap</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "views/_footer.php"; ?>