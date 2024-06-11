<?php
include "views/_header.php";
include "views/_navbar.php";
require_once 'controllers/user-controller.php';
require_once 'controllers/transaction-controller.php';
require_once 'controllers/transaction-item-controller.php';
require_once 'controllers/book-controller.php';

$userController = new UserController();
$bookController = new BookController();
$transactionItemController = new TransactionItemController();

// Kullanıcının giriş yapıp yapmadığını kontrol et, eğer giriş yapmamışsa login sayfasına yönlendir
if (!$userController->isLogged()) {
    header("Location: login.php");
    exit();
}

// Oturumdan kullanıcı ID'sini al ve kullanıcı bilgilerini getir
$userId = $_SESSION['user_id'];
$user = $userController->getById($userId);


// TransactionController sınıfını başlat ve kullanıcının işlemlerini getir
$transactionController = new TransactionController();
$transactions = $transactionController->getTransactionsByUserId($userId);
?>

<div class="container my-3">
    <div class="row">
        <div class="col-md-3 my-5">
            <!-- Kullanıcı menüsünü dahil et -->
            <?php include "views/_user-menu.php"; ?>
        </div>
        <div class="col-md-9 my-2">
            <h3 class="mb-3">Siparişlerim</h3>
            <?php foreach ($transactions as $transaction) : ?>

                <table class="table table-bordered">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-4 text-center"><b>Sipariş Tarihi</b></div>
                                <div class="col-md-4 text-center"><b>Alıcı</b></div>
                                <div class="col-md-4 text-center"><b>Tutar</b></div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 text-center"><?php echo $transaction['created_at']; ?></div>
                                <div class="col-md-4 text-center"><?php echo $user['firstName'] . ' ' . $user['lastName']; ?></div>
                                <div class="col-md-4 text-center"><?php echo $transaction['amount']; ?> TL</div>
                            </div>
                        </div>

                        <div class="card-body">
                            <?php
                            // İşlemdeki tüm öğeleri getir
                            $items = $transactionItemController->getAllTransactionItems($transaction['id']);
                            foreach ($items as $item) :
                                // Ürün bilgilerini getir
                                $product = $bookController->getById($item['product_id']); 
                                // Toplam fiyatı hesapla
                                $totalPrice = number_format($item['quantity'] * $product['price'], 2);
                            ?>
                                <div class="row m-3 p-3">
                                    <div class="col-md-2">
                                        <!-- Ürün resmini göster -->
                                        <img src="img/<?php echo $product["image"]; ?>" class="img-fluid rounded-start" style="width: 75px;">
                                    </div>
                                    <div class="col-md-4 d-flex align-items-center">
                                        <div class="card-body px-0">
                                            <!-- Ürün adını göster -->
                                            <h5 class="card-title"><?php echo $product["name"]; ?></h5>
                                        </div>
                                    </div>
                                    <div class="col-md-3 d-flex align-items-center">
                                        <!-- Ürün adedini göster -->
                                        <p class="card-text"><?php echo $item['quantity']; ?> Adet</p>
                                    </div>
                                    <div class="col-md-3 d-flex align-items-center">
                                        <div class="text-end">
                                            <!-- Ürünün toplam fiyatını göster -->
                                            <span class="price d-block"><?php echo $totalPrice; ?> TL</span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </table>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php include "views/_footer.php"; ?>