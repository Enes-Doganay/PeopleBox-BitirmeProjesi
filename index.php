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
?>

<div class="container my-3">
    <div class="row">
        <!-- Menü Alanı -->
        <div class="col-md-3">
            <?php include "views/_menu.php"; ?>
        </div>

        <!-- Ana İçerik Alanı -->
        <div class="col-md-9">
            <?php include "views/_book-list.php"; ?>
        </div>
    </div>
</div>

<?php include "views/_ckeditor.php"; ?>
<?php include "views/_footer.php"; ?>