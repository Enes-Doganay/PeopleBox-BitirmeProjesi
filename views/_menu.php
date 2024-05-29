<?php
require_once 'controllers/category-controller.php';

//Tüm kategorileri çekme işlemi
$categoryController = new CategoryController();
$categories = $categoryController->getAll();

?>

<!-- Ana kategorileri listele-->

<div class="list-group">
    <a href='categories.php' class="list-group-item list-group-item-action">Tüm Kategoriler</a>
    <?php while ($item = $categories->fetch_assoc()) : ?>
        <?php if ($item["is_active"] && $item["parent_id"] == null): ?>
            <a href="category.php?id=<?php echo $item['id']; ?>" class="list-group-item list-group-item-action"><?php echo htmlspecialchars($item['name'], ENT_QUOTES); ?></a>
        <?php endif; ?>
    <?php endwhile; ?>
</div>
