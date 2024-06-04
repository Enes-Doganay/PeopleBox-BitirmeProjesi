<?php
include "views/_header.php";
include "views/_navbar.php";
include "libs/functions.php";
require_once 'controllers/author-controller.php';
require_once "controllers/user-controller.php" ;

$userController = new UserController();

if(!$userController->isAdmin()){
    header('Location: index.php');
}

$authorName = "";
$authorName_err = "";

$authorController = new AuthorController();

//Yazar ekleme işlemleri
if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["create"])){
    $authorName = control_input($_POST["authorName"]);

    if(empty($authorName)){
        $authorName_err = "Yazar adı girmelisiniz.";
    }
    else{
        $result_message = $authorController->create($authorName);
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
            <h3>Yazar Ekle</h3>
            <form action="add-author.php" method="POST">
                <!-- Yazar Adı -->
                <div class="mb-3">
                    <label for="authorName" class="form-label">Yazar Adı</label>
                    <input type="text" class="form-control <?php echo !empty($authorName_err) ? 'is-invalid' : ''; ?>" id="authorName" name="authorName" value="<?php echo htmlspecialchars($authorName); ?>">
                    <div class="invalid-feedback"><?php echo $authorName_err; ?></div>
                </div>
                <button type="submit" name="create" class="btn btn-primary">Ekle</button>
            </form>
        </div>
    </div>
</div>

<?php include "views/_footer.php"; ?>