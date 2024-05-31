<?php
include "views/_header.php";
include "views/_navbar.php";
require_once 'controllers/book-controller.php';
require_once 'controllers/author-controller.php';
require_once 'controllers/publisher-controller.php';

$bookController = new BookController();
$authorController = new AuthorController();
$publisherController = new PublisherController();
$books = $bookController->getHomeBooks();

// Arama işlemi
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
$books = null;
$noResultsFound = false;

//Arama sorgusu geliyorsa sorguya göre filtreleyerek çek
if (!empty($searchQuery)) {
    $books = $bookController->getSearchBooks($searchQuery);
    if ($books->num_rows == 0) {
        $noResultsFound = true;
    }
} else {    //Arama sorgusu gelmiyorsa anasayfa kitaplarını çek
    $books = $bookController->getHomeBooks();
}

?>

<div class="container my-3">
    <div class="row">
        <!-- Menü Alanı -->
        <div class="col-md-3">
            <?php include "views/_menu.php"; ?>
        </div>

        <!-- Ana İçerik Alanı -->
        <div class="col-md-9">

            <!-- Sonuç bulunamadıysa bulunamadı bilgisini ver-->
            <?php if ($noResultsFound) : ?>
                <div class="alert alert-warning" role="alert">
                    Aradığınız ürün bulunamadı.
                </div>
                <?php endif; ?>
                
            <!-- Sonuç bulunamadıysa veya aranan değer yoksa anasayfa içeriklerini göster -->
            <?php if (!$noResultsFound || empty($searchQuery)) 
            {
                include "views/_book-list.php";
            } ?>

        </div>
    </div>
</div>

<?php include "views/_ckeditor.php"; ?>
<?php include "views/_footer.php"; ?>