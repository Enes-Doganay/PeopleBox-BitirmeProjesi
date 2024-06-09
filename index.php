<?php
include "views/_header.php";
include "views/_navbar.php";
require_once 'controllers/book-controller.php';
require_once 'controllers/author-controller.php';
require_once 'controllers/publisher-controller.php';

$bookController = new BookController();
$authorController = new AuthorController();
$publisherController = new PublisherController();

$limit = 12; // Sayfa başına gösterilecek ürün sayısı
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
$books = null;
$noResultsFound = false;
$totalBooks = 0;

if (!empty($searchQuery)) {
    // Arama sonuçlarının toplam sayısını al
    $totalBooks = $bookController->getTotalSearchBooks($searchQuery);

    // Sayfalama için gerekli arama sonuçlarını getir
    $books = $bookController->getSearchBooks($searchQuery, $limit, $offset);
    if ($books->num_rows == 0) {
        $noResultsFound = true;
    }
} else {
    // Ana sayfa kitaplarının toplam sayısını al
    $totalBooks = $bookController->getTotalHomeBooks();

    // Sayfalama için gerekli ana sayfa kitaplarını getir
    $books = $bookController->getPaginatedHomeBooks($limit, $offset);
}

$totalPages = ceil($totalBooks / $limit);
?>

<div class="container my-3">
    <div class="row">
        <!-- Menü Alanı -->
        <div class="col-md-3">
            <?php include "views/_menu.php"; ?>
        </div>

        <!-- Ana İçerik Alanı -->
        <div class="col-md-9">
            <?php if ($noResultsFound) : ?>
                <div class="alert alert-warning" role="alert">
                    Aradığınız ürün bulunamadı.
                </div>
            <?php endif; ?>

            <?php if (!$noResultsFound || empty($searchQuery)) {
                include "views/_book-list.php";
            } ?>
        </div>
        
        <!-- Sayfalama -->
        <nav aria-label="Page navigation example" class="d-flex justify-content-center">
            <ul class="pagination">
                <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                    <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                        <a class="page-link" href="index.php?page=<?php echo $i; ?><?php echo !empty($searchQuery) ? '&search=' . urlencode($searchQuery) : ''; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
</div>

<?php include "views/_footer.php"; ?>