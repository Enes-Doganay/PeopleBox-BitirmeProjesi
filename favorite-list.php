<?php
include "views/_header.php";
include "views/_navbar.php";
require_once 'controllers/favorite-controller.php';
require_once 'controllers/book-controller.php';
require_once 'controllers/author-controller.php';
require_once 'controllers/publisher-controller.php';
require_once 'controllers/cart-controller.php';

$userId = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : "";

if (empty($userId)) {
    exit();
}

$favoriteController = new FavoriteController();
$bookController = new BookController();
$authorController = new AuthorController();
$publisherController = new PublisherController();
$cartController = new CartController();

$favorites = $favoriteController->getAll($userId);

//Sepete ekle
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_to_cart"])){
    $productId = $_POST["product_id"];
    $quantity = 1;
    $cartController->addToCart($productId, $quantity);
}
?>

<div class="container mt-5">
    <h2>Favorilerim</h2>
    <div class="row">
        <div class="col-md-12">
            <?php while ($item = $favorites->fetch_assoc()) :
                $book = $bookController->getById($item["book_id"]);
                $author = $authorController->getById($book['author_id']);
                $publisher = $publisherController->getById($book['publisher_id']);
            ?>
                <div class="card mb-3">
                    <div class="row g-0 p-4">
                        <div class="col-md-2">
                            <a href="book-detail.php?id=<?php echo $book['id'];?>">
                                <img src="img/<?php echo $book["image"]; ?>" class="img-fluid rounded-start" style="width: 100px;">
                            </a>
                        </div>
                        <div class="col-md-3 d-flex align-items-center">
                            <div class="card-body px-0">
                                <h5 class="card-title"><?php echo $book["name"]; ?></h5>
                                <p class="card-text"><?php echo $author["name"]; ?></p>
                                <p class="card-text"><small class="text-body-secondary"><?php echo $publisher["name"]; ?></small></p>
                            </div>
                        </div>
                        <div class="col-md-5 d-flex align-items-center">
                            <p><?php echo strip_tags(htmlspecialchars_decode(substr($book['description'], 0, 390))); ?>...</p>
                        </div>
                        <div class="col-md-2 d-flex align-items-center justify-content-end">
                            <div class="text-end">
                                <h5 class="price"><?php echo $book['price']; ?> TL</h5>

                                <!-- Sepete Ekle Formu -->
                                <form method="POST" action="">
                                    <input type="hidden" name="product_id" value="<?php echo $book['id']; ?>">
                                    <div class="d-grid gap-2 ">
                                        <button type="submit" name="add_to_cart" class="btn btn-primary">Sepete Ekle</button>
                                    </div>
                                </form>
                                
                                <div class="mt-2">
                                    <?php if ($favoriteController->isFavorite($userId, $book['id'])) : ?>
                                        
                                        <!-- Favori kaldırma butonu -->
                                        <a href="#" class="favorite-btn" data-user-id="<?php echo $userId; ?>" data-book-id="<?php echo $book['id']; ?>" data-action="remove">
                                            <i class="fa-solid fa-heart fa-2xl" style="color: #FFD43B;"></i>
                                        </a>

                                    <?php else : ?>
                                        
                                        <!-- Favori ekleme butonu -->
                                        <a href="#" class="favorite-btn" data-user-id="<?php echo $userId; ?>" data-book-id="<?php echo $book['id']; ?>" data-action="add">
                                            <i class="fa-regular fa-heart fa-2xl" style="color: #FFD43B;"></i>
                                        </a>

                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

    </div>
</div>

<script src="js/cart.js"></script>
<script src="js/favorites.js"></script>

<?php include "views/_ckeditor.php"; ?>
<?php include "views/_footer.php"; ?>