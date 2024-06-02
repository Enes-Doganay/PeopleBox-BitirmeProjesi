<?php

include "views/_header.php";
include "views/_navbar.php";
require_once 'controllers/user-controller.php';
include "libs/functions.php";

// CSRF token oluşturma ve kontrol etme
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$firstName = $lastName = $email = $password = $confirmPassword = "";
$firstName_err = $lastName_err = $email_err = $password_err = $confirmPassword_err = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["register"])) {

    // CSRF token kontrolü
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Geçersiz CSRF token");
    }

    $firstName = control_input($_POST["firstName"]);
    $lastName = control_input($_POST["lastName"]);
    $email = control_input($_POST["email"]);
    $password = control_input($_POST["password"]);
    $confirmPassword = control_input($_POST["confirmPassword"]);

    //Ad kontrolü
    if (empty($firstName)) {
        $firstName_err = "Adınızı girmelisiniz";
    }

    //Soyad kontrolü
    if (empty($lastName)) {
        $lastName_err = "Soyadınızı girmelisiniz";
    }

    //Email kontrolü
    if (empty($email)) {
        $email_err = "E-posta adresinizi girmelisiniz";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_err = "Geçerli bir e-posta adresi kullanınız.";
    }

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

    //Hata yoksa kayıt işlemini sağla varsa hata mesajı göster
    if (empty($firstName_err) && empty($lastName_err) && empty($email_err) && empty($password_err) && empty($confirmPassword_err)) {
        $controller = new UserController();
        $result_message = $controller->register($firstName, $lastName, $email, $password);
        if (strpos($result_message, "başarılı") !== false) {
            $success_message = $result_message;

            // Başarılı kayıt olduğunda modalı açmak için JavaScript kodu
            echo "<script>
                    $(document).ready(function() {
                        $('#successModal').modal('show');
                    });
                    setTimeout(function() {
                        window.location.href = 'login.php';
                    }, 2000); // 2 saniye bekle
                  </script>";
        } else {
            echo "<div class='alert alert-danger'>{$result_message}</div>";
        }
    } else {
        $error_message = "Lütfen formu eksiksiz doldurun.";
    }
}
?>

<div class="container my-3">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="register.php" method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <div class="mb-3">
                            <label for="firstName" class="form-label">Adınız</label>
                            <input type="text" class="form-control" name="firstName" id="firstName" value="<?php echo htmlspecialchars($_POST['firstName'] ?? '', ENT_QUOTES); ?>">
                            <?php if (!empty($firstName_err)) echo "<div class='text-danger'>{$firstName_err}</div>"; ?>
                        </div>
                        <div class="mb-3">
                            <label for="lastName" class="form-label">Soyadınız</label>
                            <input type="text" class="form-control" name="lastName" id="lastName" value="<?php echo htmlspecialchars($_POST['lastName'] ?? '', ENT_QUOTES); ?>">
                            <?php if (!empty($lastName_err)) echo "<div class='text-danger'>{$lastName_err}</div>"; ?>
                        </div>
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
                            <label for="confirmPassword" class="form-label">Şifre Tekrar</label>
                            <input type="password" class="form-control" name="confirmPassword" id="confirmPassword">
                            <?php if (!empty($confirmPassword_err)) echo "<div class='text-danger'>{$confirmPassword_err}</div>"; ?>
                        </div>
                        <input type="submit" name="register" value="Submit" class="btn btn-primary">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Başarılı Kayıt Modalı -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="successModalLabel">Kayıt Başarılı</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Kayıt işlemi başarılı! <br> Giriş sayfasına yönlendiriliyorsunuz...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="redirectButton">Tamam</button>
            </div>
        </div>
    </div>
</div>

<?php
// Kayıt başarılıysa modalı çağır
if (!empty($success_message)) {
    include "views/_modal.php";
    renderSuccessModal($success_message);
}
?>

<?php include "views/_footer.php"; ?>