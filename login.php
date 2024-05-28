<?php
include "views/_header.php";
include "views/_navbar.php";
require_once 'controllers/user-controller.php';
include "config/functions.php";

// CSRF token oluşturma ve kontrol etme
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$email = $password = "";
$email_err = $password_err = "";


if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["login"]))
{
    // CSRF token kontrolü
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Geçersiz CSRF token");
    }

    $email = control_input($_POST["email"]);
    $password = control_input($_POST["password"]);

    if(empty($email)){
        $email_err = "E-posta adresi girmelisiniz.";
    }
    else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $email_err = "Geçerli bir e-posta kullanınız.";
    }

    if(empty($password)){
        $password_err = "Şifre girmelisiniz.";
    }
    else if(strlen($password) < 8){
        $password = "Şifre en az 8 karakterden oluşmalıdır.";
    }

    if(empty($email_err) && empty($password_err)){
        $controller = new UserController();
        $resultMessage = $controller->login($email,$password);

        if(strpos($resultMessage,"başarısız") === true){
            echo "<div class='alert alert-danger'>{$result_message}</div>";
        }
    }else{
        echo "<div class='alert alert-danger'> Formu eksiksiz doldurun.</div>";
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
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Beni Hatırla</label>
                    </div>
                    <button type="submit" name="login" value="Submit" class="btn btn-primary">Giriş Yap</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "views/_footer.php"; ?>