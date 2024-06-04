<?php

include "views/_header.php";
include "views/_navbar.php";
include "libs/functions.php";
require_once 'controllers/category-controller.php';
require_once "controllers/user-controller.php" ;

$userController = new UserController();

if(!$userController->isAdmin()){
    header('Location: index.php');
}

//Kategori bilgilerini çekme
$categoryController = new CategoryController();
$id = $_GET["id"];
$categories = $categoryController->getAll();
$category = $categoryController->getById($id);
$categoryName = "";
$categoryName_err = "";


//Kategori güncelleme işlemleri
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update"])) {
    $categoryName = control_input($_POST["categoryName"]);
    $parentId = isset($_POST["parentId"]) && $_POST["parentId"] !== "" ? intval($_POST["parentId"]) : null;
    $isActive = isset($_POST["isActive"]) ? 1 : 0;

    if (empty($categoryName)) {
        $categoryName_err = "Kategori adı girmelisiniz.";
    } else {
        $result_message = $categoryController->update($id,$categoryName, $isActive, $parentId);
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
            <h3>Kategoriyi Düzenle</h3>
            <form action="" method="POST">
                <!-- Kategori Adı -->
                <div class="mb-3">
                    <label for="categoryName" class="form-label">Kategori Adı</label>
                    <input type="text" class="form-control <?php echo !empty($categoryName_err) ? 'is-invalid' : ''; ?>" id="categoryName" name="categoryName" value="<?php echo empty($categoryName) ?
                    htmlspecialchars($category["name"]) : $categoryName ?>">
                    <div class="invalid-feedback"><?php echo $categoryName_err; ?></div>
                </div>
                  <!-- Bağlı Olduğu Kategori -->
                <div class="mb-3">
                    <label for="parentId" class="form-label">Bağlı Olduğu Kategori</label>
                    <select class="form-control" name="parentId" id="parentId">
                        <option value="">Yok</option>
                        <?php while($item = $categories->fetch_assoc()): ?>
                            <option value="<?php echo $item['id']; ?>"><?php echo htmlspecialchars($item['name'], ENT_QUOTES); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <!-- Yayın Durumu -->
                <div class="mb-3 form-check">
                    <label class="form-check-label" for="isActive">Yayınlansın mı?</label>
                    <input type="checkbox" class="form-check-input" name="isActive" id="isActive" <?php if($category["is_active"]) echo "checked" ?>>
                </div>
                <button type="submit" name="update" class="btn btn-primary">Güncelle</button>
            </form>
        </div>
    </div>
</div>

<?php include "views/_footer.php"; ?>