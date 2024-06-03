<?php
include "views/_header.php";
include "views/_navbar.php";
require_once 'controllers/book-controller.php';
require_once 'controllers/author-controller.php';
require_once 'controllers/publisher-controller.php';
require_once 'controllers/cart-controller.php';


$id = $_GET["id"];
$bookController = new BookController();
$book = $bookController->getById($id);

$authorController = new AuthorController();
$author = $authorController->getById($book["author_id"]);

$publisherController = new PublisherController();
$publisher = $publisherController->getById($book["publisher_id"]);

$cartController = new CartController();

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_to_cart"])){
    $productId = $_POST["product_id"];
    $quantity = 1;
    $cartController->addToCart($productId,$quantity);
    header("Location: cart.php"); // Sepet sayfasına yönlendirin
    exit();
}


?>

<div class="container">
    <div class="card">
        <div class="row my-5">
            <div class="col-md-6">
                <img src="img/<?php echo $book["image"]; ?>" class="mx-auto d-block" alt="...">
            </div>
            <div class="col-md-5">
                <div class="card-body">
                    <h4 class="card-title pb-4"><?php echo $book["name"]; ?></h4>
                    <div class="row my-2 py-5">
                        <h6 class="card-text pb-2">Öne çıkan bilgiler</h6>
                        <div class="col-md-6">
                            <p class="card-text"><small class="text-body-secondary"><b>Yazar:</b> <?php echo $author["name"]; ?></small></p>
                            <p class="card-text"><small class="text-body-secondary"><b>Sayfa Sayısı:</b> <?php echo $book["page_count"]; ?></small></p>
                        </div>
                        <div class="col-md-6">
                            <p class="card-text"><small class="text-body-secondary"><b>Yayınevi :</b> <?php echo $publisher["name"]; ?></small></p>
                            <p class="card-text"><small class="text-body-secondary"><b>ISBN :</b> <?php echo $book["isbn"]; ?></small></p>
                        </div>
                    </div>
                </div>

                <!-- Sepete Ekle Formu -->
                <form method="POST" action="book-detail.php?id=<?php echo $id; ?>">
                    <input type="hidden" name="product_id" value="<?php echo $book['id']; ?>">
                    <div class="d-grid gap-2 ">
                        <button type="submit" name="add_to_cart" class="btn btn-primary">Sepete Ekle</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

</div>
<div class="container py-3">
    <h2 class="card-title">Ürün Açıklaması</h2>
    <hr>
    <p class="card-text"><?php echo htmlspecialchars_decode($book["description"]) ?></p>
</div>

<div class="container mt-3 mb-5">
    <p class="card-text"><small class="text-body-secondary"><b>Kitap Adı : </b> <?php echo $book["name"]; ?></small></p>
    <p class="card-text"><small class="text-body-secondary"><b>Yazar : </b> <?php echo $author["name"]; ?></small></p>
    <p class="card-text"><small class="text-body-secondary"><b>Yayınevi : </b> <?php echo $publisher["name"]; ?></small></p>
    <p class="card-text"><small class="text-body-secondary"><b>Sayfa Sayısı : </b> <?php echo $book["page_count"]; ?></small></p>
    <p class="card-text"><small class="text-body-secondary"><b>ISBN : </b> <?php echo $book["isbn"]; ?></small></p>
</div>

<?php include "views/_footer.php"; ?>