<?php
include "views/_header.php";
include "views/_navbar.php";
require_once 'controllers/cart-controller.php';
require_once 'controllers/book-controller.php';
require_once 'controllers/author-controller.php';
require_once 'controllers/publisher-controller.php';

$cartController = new CartController();
$bookController = new BookController();
$authorController = new AuthorController();
$publisherController = new PublisherController();

$items = $cartController->getCartItems();
$errorMessages = [];

// POST isteği ile gelen ürün güncelleme ve silme işlemleri
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['productId'] ?? null;
    $quantity = $_POST['quantity'] ?? null;
    $action = $_POST['action'] ?? null;

    if ($productId && $quantity) {
        try {
            $cartController->updateCart($productId, $quantity);
            http_response_code(200);
        } catch (Exception $e) {
            http_response_code(500);
            echo $e->getMessage();
        }
    } elseif ($productId && $action === 'delete') {
        try {
            $cartController->removeFromCart($productId);
            http_response_code(200);
        } catch (Exception $e) {
            http_response_code(500);
            echo $e->getMessage();
        }
    } elseif (isset($_POST['checkout'])) {
        if (checkStock($items, $bookController, $errorMessages)) {
            header("Location: checkout.php");
            exit;
        }
    } else {
        http_response_code(400);
        echo "Geçersiz istek.";
    }
    exit;
}

function checkStock($items, $bookController, &$errorMessages) {
    $insufficientStock = false;
    foreach ($items as $productId => $quantity) {
        $book = $bookController->getById($productId);
        if ($book['stock'] < $quantity) {
            $insufficientStock = true;
            $errorMessages[] = "{$book['name']} kitabının stoğu yetersiz.";
        }
    }
    return !$insufficientStock;
}

function getTotalAmount($items, $bookController) {
    $totalAmount = 0;
    foreach ($items as $productId => $quantity) {
        $book = $bookController->getById($productId);
        $totalAmount += $book["price"] * $quantity;
    }
    return $totalAmount;
}
?>

<div class="container mt-5">
    <h2>Sepetim (<?php echo count($items); ?> Ürün)</h2>
    <div class="row">
        <div class="col-md-8">
            <div class="container">
                <div class="row g-0 p-3">
                    <div class="col-md-6 d-flex justify-content-center">
                        <strong>Ürün Adı</strong>
                    </div>
                    <div class="col-md-2 d-flex justify-content-center">
                        <strong>Adet</strong>
                    </div>
                    <div class="col-md-4 d-flex justify-content-end">
                        <strong>Fiyat</strong>
                    </div>
                </div>
            </div>
            <?php foreach ($items as $productId => $quantity) : 
                $book = $bookController->getById($productId);
                $author = $authorController->getById($book["author_id"]);
                $publisher = $publisherController->getById($book["publisher_id"]);
                $totalPrice = number_format($book["price"] * $quantity, 2, ',', '.');
            ?>
                <div class="card mb-3">
                    <div class="row g-0 p-3">
                        <div class="col-md-2">
                            <img src="img/<?php echo $book["image"]; ?>" class="img-fluid rounded-start" style="width: 100px;">
                        </div>
                        <div class="col-md-4">
                            <div class="card-body px-0">
                                <h5 class="card-title"><?php echo $book["name"]; ?></h5>
                                <p class="card-text"><?php echo $author["name"]; ?></p>
                                <p class="card-text"><small class="text-body-secondary"><?php echo $publisher["name"]; ?></small></p>
                                <?php if (in_array("{$book['name']} kitabının stoğu yetersiz.", $errorMessages)) : ?>
                                    <p class="text-danger">Bu ürünün stoğu yetersiz! (Stok: <?php echo $book['stock']; ?>)</p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-2 d-flex align-items-center">
                            <div class="input-group">
                                <button class="btn btn-outline-secondary btn-decrease" data-id="<?php echo $productId; ?>">-</button>
                                <input type="number" class="form-control text-center quantity" value="<?php echo $quantity ?>" min="1" data-id="<?php echo $productId; ?>">
                                <button class="btn btn-outline-secondary btn-increase" data-id="<?php echo $productId; ?>">+</button>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex align-items-center justify-content-end">
                            <div class="text-end">
                                <span class="price d-block"><?php echo $totalPrice; ?> TL</span>
                                <a href="" class="link-danger link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover btn-remove d-block mt-1" data-id="<?php echo $productId; ?>">Sil</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Sipariş Özeti</h4>
                    <p class="card-text"><?php echo count($items); ?> Ürün</p>
                    <h3 class="card-text">Ödenecek Tutar: <?php echo number_format(getTotalAmount($items, $bookController), 2, ',', '.'); ?> TL</h3>
                    <form method="post">
                        <input type="hidden" name="checkout" value="1">
                        <button type="submit" class="btn btn-danger btn-block">SATIN AL</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="js/cart.js"></script>

<?php include "views/_footer.php"; ?>
