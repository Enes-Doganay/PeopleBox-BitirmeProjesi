<?php
include "views/_header.php";
include "views/_navbar.php";
include "libs/functions.php";
require_once 'controllers/publisher-controller.php';

$publisherName = "";
$publisherName_err = "";

$publisherController = new PublisherController();

//Yayıncı ekleme işlemleri
if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["create"])){
    $publisherName = control_input($_POST["publisherName"]);

    if(empty($publisherName)){
        $publisherName_err = "Yayıncı adı girmelisiniz.";
    }
    else{
        $result_message = $publisherController->create($publisherName);
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
            <h3>Yayınevi Ekle</h3>
            <form action="add-publisher.php" method="POST">
                <!-- Yayıncı Adı -->
                <div class="mb-3">
                    <label for="publisherName" class="form-label">Yayınevi Adı</label>
                    <input type="text" class="form-control <?php echo !empty($publisherName_err) ? 'is-invalid' : ''; ?>" id="publisherName" name="publisherName" value="<?php echo htmlspecialchars($publisherName); ?>">
                    <div class="invalid-feedback"><?php echo $publisherName_err; ?></div>
                </div>
                <button type="submit" name="create" class="btn btn-primary">Ekle</button>
            </form>
        </div>
    </div>
</div>

<?php include "views/_footer.php"; ?>