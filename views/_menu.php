<?php
require_once 'controllers/category-controller.php';

//Tüm kategorileri çekme işlemi
$categoryController = new CategoryController();
$categories = $categoryController->getAll();

$categoryId = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

?>

<!-- Ana kategorileri listele-->

<div class="list-group">
    <a href=<?php echo $categoryId == 0 ? "index.php" : "category.php?id=".$categoryId; ?> class="list-group-item list-group-item-action">Tüm Kategoriler</a>
    <?php while ($item = $categories->fetch_assoc()) : ?>
        <?php if ($item["is_active"] && $item["parent_id"] == null): ?>
            <a href="category.php?id=<?php echo $item['id']; ?>" class="list-group-item list-group-item-action <?php echo $categoryId == $item['id'] ? 'active' : ''; ?>"><?php echo htmlspecialchars($item['name'], ENT_QUOTES); ?></a>
        <?php endif; ?>
    <?php endwhile; ?>
</div>