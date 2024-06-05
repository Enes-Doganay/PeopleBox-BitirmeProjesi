<?php
include "views/_header.php";
include "views/_navbar.php";
require_once "controllers/category-controller.php";
require_once 'controllers/book-controller.php';
require_once 'controllers/author-controller.php';
require_once 'controllers/publisher-controller.php';

$categoryController = new CategoryController();
$categoryId = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

$subCategories = $categoryController->getSubcategories($categoryId);
$subCategoryIds = $categoryController->getSubcategoryIds($categoryId);
$subCategoryIds = array_column($subCategoryIds->fetch_all(MYSQLI_ASSOC), 'id');

$categories = $subCategories;
$categoryIds = [$categoryId];

$categoryIds = array_merge([$categoryId], $subCategoryIds);

$bookController = new BookController();
$authorController = new AuthorController();
$publisherController = new PublisherController();

$authorIds = isset($_GET["author_ids"]) ? array_map('intval', $_GET["author_ids"]) : [];
$publisherIds = isset($_GET["publisher_ids"]) ? array_map('intval', $_GET["publisher_ids"]) : [];

$limit = 3; // Sayfa başına gösterilecek ürün sayısı
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Filtreleme parametrelerini query string olarak oluşturma
$filterParams = "";
if (!empty($authorIds)) {
    foreach ($authorIds as $id) {
        $filterParams .= "&author_ids[]=$id";
    }
}
if (!empty($publisherIds)) {
    foreach ($publisherIds as $id) {
        $filterParams .= "&publisher_ids[]=$id";
    }
}

$books = $bookController->getFilteredBooksByCategories($categoryIds, $authorIds, $publisherIds, $limit, $offset);

// Toplam kitap sayısını almak için limit ve offset olmadan aynı filtre ile tüm kitapları çek
$totalBooksResult = $bookController->getFilteredBooksByCategories($categoryIds, $authorIds, $publisherIds);
$totalBooks = $totalBooksResult->num_rows;
$totalPages = ceil($totalBooks / $limit);
?>

<div class="container my-3">
    <div class="row">
        <!-- Kategori Menü Alanı -->
        <div class="col-md-3">
            <div class="list-group">
                <a href=<?php echo $categoryId == 0 ? "index.php" : "category.php?id=" . $categoryId; ?> class="list-group-item list-group-item-action">Tüm Kategoriler</a>
                <!-- Kategorinin Alt Kategorilerini Al -->
                <?php while ($subCategory = $subCategories->fetch_assoc()) : ?>
                    <a href="category.php?id=<?php echo $subCategory['id']; ?>" class="list-group-item list-group-item-action <?php echo $categoryId == $subCategory['id'] ? 'active' : ''; ?>">
                        <?php echo htmlspecialchars($subCategory['name'], ENT_QUOTES); ?>
                    </a>
                <?php endwhile; ?>
            </div>

            <!-- Filtreleme Alanı -->
            <?php include "views/_filter-form.php"; ?>
        </div>

        <!-- Ana İçerik Alanı -->
        <div class="col-md-9">
            <?php if ($books->num_rows == 0) : ?>
                <div class="alert alert-warning" role="alert">
                    Bu kategoride henüz ürün bulunmamaktadır.
                </div>
            <?php else : ?>
                <?php include "views/_book-list.php"; ?>

                <!-- Sayfalama -->
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                            <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                                <a class="page-link" href="category.php?id=<?php echo $categoryId; ?>&page=<?php echo $i . $filterParams; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include "views/_footer.php"; ?>