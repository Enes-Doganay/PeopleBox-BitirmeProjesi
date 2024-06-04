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
$categories = $categoryController->getAll();
?>


<div class="container my-3">
    <div class="row">
        <div class="col-md-3 my-5">
            <?php include "views/_admin-menu.php"; ?>
        </div>
        <div class="col-md-9 my-2">
            <h3>Kategorileri Düzenle</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>İsim</th>
                        <th>Aktif mi?</th>
                        <th>Bağlı Olduğu Kategori</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Kategorileri listele -->
                    <?php while ($item = $categories->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $item["id"]; ?></td>
                            <td><?php echo htmlspecialchars($item['name'], ENT_QUOTES); ?></td>
                            <td>
                                <?php if ($item["is_active"]) : ?>
                                    <i class="fas fa-check"></i>  <!-- Aktif simgesi -->
                                <?php else : ?>
                                    <i class="fas fa-times"></i>  <!-- Pasif simgesi -->
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($categoryController->getById($item['parent_id'])['name'] ?? '', ENT_QUOTES); ?></td>
                            <td>
                                <a href="edit-category.php?id=<?php echo $item["id"]; ?>" class="btn btn-warning btn-sm">Düzenle</a>
                                <a href="delete-category.php?id=<?php echo $item["id"]; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Silmek istediğinize emin misiniz?');">Sil</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php include "views/_footer.php"; ?>