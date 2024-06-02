<?php
include "views/_header.php";
include "views/_navbar.php";
include "libs/functions.php";
require_once 'controllers/user-controller.php';

$email = $message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["reset"])) {
    $email = control_input($_POST["email"]);

    //Mail kontrolü
    if (empty($email)) {
        $email_err = "E-posta adresinizi girmelisiniz";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_err = "Geçerli bir e-posta adresi kullanınız.";
    } else {
        //Mail geçerliyse şifre sıfırlama isteği gönder
        $controller = new UserController();
        $message = $controller->requestPasswordReset($email);
    }
}
?>

<div class="container my-3">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="reset-password-request.php" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">E-posta Adresiniz</label>
                            <input type="email" class="form-control" name="email" id="email" value="<?php echo htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES); ?>">
                            <?php if (!empty($email_err)) echo "<div class='text-danger'>{$email_err}</div>"; ?>
                        </div>
                        <input type="submit" name="reset" value="Şifre Sıfırlama Talebi" class="btn btn-primary">
                        <?php if (!empty($message)) echo "<div class='text-success'>{$message}</div>"; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "views/_footer.php"; ?>
