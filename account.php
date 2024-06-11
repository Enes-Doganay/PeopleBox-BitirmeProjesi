<?php
include "views/_header.php";
include "views/_navbar.php";
include "libs/functions.php";
require_once 'controllers/user-controller.php';
require_once 'controllers/transaction-controller.php';

$userController = new UserController();

// Kullanıcının giriş yapıp yapmadığını kontrol et, eğer giriş yapmamışsa login sayfasına yönlendir
if (!$userController->isLogged()) {
    header("Location: login.php");
    exit();
}

// Oturumdan kullanıcı ID'sini al ve kullanıcı bilgilerini getir
$userId = $_SESSION['user_id'];
$user = $userController->getById($userId);

$updateMessage = $firstName_err = $lastName_err = $email_err = $currentPassword_err = $newPassword_err = '';

// Form gönderildiğinde kullanıcı bilgilerini güncelle
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user'])) {
    // Formdan gelen verileri al
    $firstName = control_input($_POST['firstName']);
    $lastName = control_input($_POST['lastName']);
    $email = control_input($_POST['email']);
    $currentPassword = !empty($_POST['current_password']) ? control_input($_POST['current_password']) : null;
    $newPassword = !empty($_POST['new_password']) ? control_input($_POST['new_password']) : null;
    $confirmPassword = !empty($_POST['confirm_password']) ? control_input($_POST['confirm_password']) : null;


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

    //Mevcut şifre kontrolü
    if (!empty($currentPassword)) {
        if (strlen($currentPassword) < 8) {
            $currentPassword_err = "Şifre en az 8 karakterden oluşturulmalıdır.";
        }

        //Yeni şifre kontrolü
        if (empty($newPassword)) {
            $newPassword_err = "Yeni şifre girmelisiniz.";
        } else if (strlen($newPassword) < 8) {
            $newPassword_err = "Şifre en az 8 karakterden oluşturulmalıdır.";
        } else if (empty($confirmPassword)) {
            $confirmPassword_err = "Şifre tekrarı girmelisiniz";
        } else if (strlen($confirmPassword) < 8) {
            $newPassword_err = "Şifre en az 8 karakterden oluşturulmalıdır.";
        }
    }

    if (empty($firstName_err) && empty($lastName_err) && empty($email_err) && empty($currentPassword_err) && empty($newPassword_err) && empty($confirmPassword_err)) {
        // Kullanıcı bilgilerini güncelle ve sonucu kontrol et
        $result_message = $userController->updateUser($userId, $firstName, $lastName, $email, $currentPassword, $newPassword, $confirmPassword);
        if (strpos($result_message, "başarılı") !== false) {
            echo "<div class='alert alert-success'>{$result_message}</div>";
            // Güncellenmiş kullanıcı bilgilerini tekrar çek
            $user = $userController->getById($userId);
        } else {
            echo "<div class='alert alert-danger'>{$result_message}</div>";
        }
    } else {
        echo  "<div class='alert alert-danger'>Lütfen formu eksiksiz doldurunuz.</div>";
    }
}
?>

<div class="container my-3">
    <div class="row">
        <div class="col-md-3 my-5">
            <!-- Kullanıcı menüsünü dahil et -->
            <?php include "views/_user-menu.php"; ?>
        </div>
        <div class="col-md-9 my-2">
            <h3>Hesabım</h3>

            <!-- Kullanıcı Bilgileri Güncelleme Formu -->
            <form method="post" action="account.php">
                <h4>Üyelik Bilgilerim</h4>

                <div class="form-group">
                    <label for="firstname">Ad:</label>
                    <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo $user['firstName']; ?>" required>
                    <?php if (!empty($firstName_err)) echo "<div class='text-danger'>{$firstName_err}</div>"; ?>
                </div>
                <div class="form-group">
                    <label for="lastname">Soyad:</label>
                    <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo $user['lastName']; ?>" required>
                    <?php if (!empty($lastName_err)) echo "<div class='text-danger'>{$lastName_err}</div>"; ?>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" required>
                    <?php if (!empty($email_err)) echo "<div class='text-danger'>{$email_err}</div>"; ?>
                </div>
                <div class="form-group">
                    <label for="current_password">Mevcut Şifre:</label>
                    <input type="password" class="form-control" id="current_password" name="current_password">
                    <?php if (!empty($currentPassword_err)) echo "<div class='text-danger'>{$currentPassword_err}</div>"; ?>
                </div>
                <div class="form-group">
                    <label for="new_password">Yeni Şifre:</label>
                    <input type="password" class="form-control" id="new_password" name="new_password">
                    <?php if (!empty($newPassword_err)) echo "<div class='text-danger'>{$newPassword_err}</div>"; ?>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Yeni Şifre (Tekrar):</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                    <?php if (!empty($confirmPassword_err)) echo "<div class='text-danger'>{$confirmPassword_err}</div>"; ?>
                </div>
                <button type="submit" name="update_user" class="btn btn-primary my-2">Güncelle</button>
            </form>
        </div>
    </div>
</div>
<?php include "views/_footer.php"; ?>