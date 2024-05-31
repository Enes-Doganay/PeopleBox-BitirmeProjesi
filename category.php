<?php
include "views/_header.php";
include "views/_navbar.php";
require_once "controllers/category-controller.php";
require_once 'controllers/book-controller.php';
require_once 'controllers/author-controller.php';
require_once 'controllers/publisher-controller.php';

$categoryController = new CategoryController();
$categoryId = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

$category = $categoryController->getById($categoryId);
$subCategories = $categoryController->getSubcategories($categoryId);

$bookController = new BookController();
$books = $bookController->getByCategoryId($categoryId);

$authorController = new AuthorController();
$publisherController = new PublisherController();
?>

<div class="container my-3">
    <div class="row">
        <!-- Kategori Menü Alanı -->
        <div class="col-md-3">
            <div class="list-group">
            <a href=<?php echo $categoryId == 0 ? "index.php" : "category.php?id=".$categoryId; ?> class="list-group-item list-group-item-action">Tüm Kategoriler</a>
                <!-- Kategorinin Alt Kategorilerini Al -->
                <?php while ($subCategory = $subCategories->fetch_assoc()) : ?>
                    <a href="category.php?id=<?php echo $subCategory['id']; ?>" class="list-group-item list-group-item-action <?php echo $categoryId == $subCategory['id'] ? 'active' : ''; ?>">
                        <?php echo htmlspecialchars($subCategory['name'], ENT_QUOTES); ?>
                    </a>
                <?php endwhile; ?>

            </div>
        </div>
        
        <!-- Ana İçerik Alanı -->
        <div class="col-md-9">
            <?php include "views/_book-list.php"; ?>
        </div>
    </div>
</div>

<?php include "views/_footer.php"; ?>