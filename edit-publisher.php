<?php

include "views/_header.php";
include "views/_navbar.php";
include "libs/functions.php";
require_once 'controllers/publisher-controller.php';
require_once "controllers/user-controller.php" ;

$userController = new UserController();

if(!$userController->isAdmin()){
    header('Location: index.php');
}

//Publisher bilgilerini çekme
$id = $_GET["id"];
$publisherController = new PublisherController();
$publishers = $publisherController->getAll();
$publisher = $publisherController->getById($id);

$publisherName = "";
$publisherName_err = "";

//Yayıncı güncelleme işlemleri
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update"])) {
    $publisherName = control_input($_POST["publisherName"]);

    if (empty($publisherName)) {
        $publisherName_err = "Yayıncı adı girmelisiniz.";
    } else {
        $result_message = $publisherController->update($id,$publisherName);
        if (strpos($result_message, "başarılı") !== false) {
            echo "<div class='alert alert-success'>{$result_message}</div>";
        } else {
            echo "<div class='alert alert-danger'>{$result_message}</div>";
        }
    }
}

?>

<div class="container my-3">
    <div class="row">
        <div class="col-md-3 my-5">
            <?php include "views/_admin-menu.php"; ?>
        </div>
        <div class="col-md-9" id="content">
            <h3>Yayınevini Düzenle</h3>
            <form action="" method="POST">
                <!-- Yayıncı Adı -->
                <div class="mb-3">
                    <label for="publisherName" class="form-label">Yayınevi Adı</label>
                    <input type="text" class="form-control <?php echo !empty($publisherName_err) ? 'is-invalid' : ''; ?>" id="publisherName" name="publisherName" value="<?php echo empty($publisherName) ?
                    htmlspecialchars($publisher["name"]) : $publisherName ?>">
                    <div class="invalid-feedback"><?php echo $publisherName_err; ?></div>
                </div>
                <button type="submit" name="update" class="btn btn-primary">Güncelle</button>
            </form>
        </div>
    </div>
</div>

<?php include "views/_footer.php"; ?>
