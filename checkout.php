<?php
require_once 'controllers/cart-controller.php';
require_once 'controllers/book-controller.php';
include "views/_header.php";
include "views/_navbar.php";


// Sepet ve kitap kontrolcülerini oluştur
$cartController = new CartController();
$items = $cartController->getCartItems();
$bookController = new BookController();
$totalPrice = 0;

// Sepetteki ürünlerin toplam fiyatını hesapla
foreach ($items as $productId => $quantity) {
    $book = $bookController->getById($productId);
    $price = $book['price'];
    $subtotal = $price * $quantity;
    $totalPrice += $subtotal;
}
?>

<link rel="stylesheet" href="css/checkout.css">
<script src="https://js.stripe.com/v3/"></script>

<div class="container col-md-8 py-5">
    <h1>Ödeme</h1>
     <!-- Ödeme formu -->
    <form action="charge.php" method="post" id="payment-form">
        <div class="form-row py-3">
            <label for="card-element" class="pb-3">Kredi Kartı</label>
            <div id="card-element"></div>
            <div id="card-errors" role="alert"></div>
        </div>
        <!-- Toplam tutarı saklamak için gizli bir input alanı -->
        <input type="hidden" name="totalAmount" value="<?php echo $totalPrice * 100; ?>"> <!-- Total amount in cents -->
        <button>Ödeme Yap</button>
    </form>
</div>

<script src="js/checkout.js"></script>

<?php include "views/_footer.php"; ?>