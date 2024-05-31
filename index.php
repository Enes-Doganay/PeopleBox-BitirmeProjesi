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
            <div class="row">
                <?php while ($item = $books->fetch_assoc()) : ?>
                    <div class="col-md-3 mb-4">
                        <a href="book-detail.php?id=<?php echo $item['id']; ?>" class="text-decoration-none text-dark">
                            <div class="card h-100">
                                <img src="<?php echo "img/" . $item["image"]; ?>" class="card-img-top mx-auto d-block mt-3" style="height: 12rem; width: auto;">
                                <div class="card-body my-2">
                                    <h5 class="card-title h-50 py-1"><?php echo $item['name']; ?></h5>
                                    <h6 class="card-subtitle text-muted py-1"><?php echo $authorController->getById($item["author_id"])["name"]; ?></h6>
                                    <div class="badge text-center mt-3 mb-3 py-2" style="background-color: #faf6e1;">
                                        <small class="text-muted"><?php echo $publisherController->getById($item["publisher_id"])["name"]; ?></small>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>

<?php include "views/_ckeditor.php" ?>
<?php include "views/_footer.php"; ?>