<?php

include "views/_header.php";
include "views/_navbar.php";
include "libs/functions.php";
require_once 'controllers/author-controller.php';

//Author bilgilerini çekme
$id = $_GET["id"];
$authorController = new AuthorController();
$authors = $authorController->getAll();
$author = $authorController->getById($id);

$authorName = "";
$authorName_err = "";

//Kategori güncelleme işlemleri
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update"])) {
    $authorName = control_input($_POST["authorName"]);

    if (empty($authorName)) {
        $authorName_err = "Yazar adı girmelisiniz.";
    } else {
        $result_message = $authorController->update($id,$authorName);
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
            <h3>Yazarı Düzenle</h3>
            <form action="" method="POST">
                <!-- Yazar Adı -->
                <div class="mb-3">
                    <label for="authorName" class="form-label">Yazar Adı</label>
                    <input type="text" class="form-control <?php echo !empty($authorName_err) ? 'is-invalid' : ''; ?>" id="authorName" name="authorName" value="<?php echo empty($authorName) ?
                    htmlspecialchars($author["name"]) : $authorName ?>">
                    <div class="invalid-feedback"><?php echo $authorName_err; ?></div>
                </div>
                <button type="submit" name="update" class="btn btn-primary">Güncelle</button>
            </form>
        </div>
    </div>
</div>

<?php include "views/_footer.php"; ?>
