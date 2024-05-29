<?php
include "views/_header.php";
include "views/_navbar.php";
require_once "controllers/category-controller.php";

$categoryController = new CategoryController();
$categoryId = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

$category = $categoryController->getById($categoryId);
$subCategories = $categoryController->getSubcategories($categoryId);

?>
<div class="container my-3">
    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
                <?php while ($subCategory = $subCategories->fetch_assoc()) : ?>
                    <a href="category.php?id=<?php echo $subCategory['id']; ?>" class="list-group-item list-group-item-action"><?php echo htmlspecialchars($subCategory['name'], ENT_QUOTES); ?></a>
                <?php endwhile; ?>
            </div>
        </div>

        <div class="col-9">
            <!-- Main content goes here -->
        </div>
    </div>
</div>



<?php include "views/_footer.php"; ?>