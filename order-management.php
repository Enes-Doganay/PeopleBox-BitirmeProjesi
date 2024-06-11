<?php
include "views/_header.php";
include "views/_navbar.php";
require_once 'controllers/transaction-controller.php';
require_once 'controllers/transaction-item-controller.php';
require_once 'controllers/book-controller.php';
require_once "controllers/user-controller.php";

$userController = new UserController();

if (!$userController->isAdmin()) {
    header('Location: index.php');
}

$transactionController = new TransactionController();
$transactionItemController = new TransactionItemController();
$bookController = new BookController();

$status = isset($_GET['status']) ? $_GET['status'] : null;
$transactions = $transactionController->listTransactions($status);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $transactionId = $_POST['transaction_id'];
    $status = $_POST['order_status'];
    $transactionController->updateOrderStatus($transactionId, $status);
    header("Location: order-management.php");
    exit();
}
?>

<div class="container my-3">
    <div class="row">
        <div class="col-md-3 my-5">
            <?php include "views/_admin-menu.php"; ?>
        </div>
        <div class="col-md-9 my-2">
            <h3>Siparişler</h3>
            <form method="get" action="order-management.php" class="mb-4">
                <div class="form-group">
                    <label for="status">Sipariş Durumuna Göre Filtrele:</label>
                    <select name="status" id="status" class="form-control" onchange="this.form.submit()">
                        <option value="">Hepsi</option>
                        <option value="pending" <?php if ($status == 'pending') echo 'selected'; ?>>Beklemede</option>
                        <option value="processing" <?php if ($status == 'processing') echo 'selected'; ?>>Hazırlanıyor</option>
                        <option value="shipped" <?php if ($status == 'shipped') echo 'selected'; ?>>Gönderildi</option>
                        <option value="delivered" <?php if ($status == 'delivered') echo 'selected'; ?>>Teslim Edildi</option>
                        <option value="canceled" <?php if ($status == 'canceled') echo 'selected'; ?>>İptal Edildi</option>
                    </select>
                </div>
            </form>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ürünler</th>
                        <th>Tutar</th>
                        <th>Durum</th>
                        <th>Oluşturulma Tarihi</th>
                        <th>Kullanıcı ID</th>
                        <th>Sipariş Durumu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transactions as $transaction) : ?>
                        <?php
                        $items = $transactionItemController->getAllTransactionItems($transaction['id']);
                        $productDetails = [];
                        foreach ($items as $item) {
                            $product = $bookController->getById($item['product_id']);
                            $productDetails[] = $product['name'] . " (" . $item['quantity'] . " adet)"; // Ürün adı ve miktarını al
                        }
                        ?>
                        <tr>
                            <td><?php echo $transaction['id']; ?></td>
                            <td><?php echo implode('<br>', $productDetails); ?></td> <!-- Ürün adlarını ve miktarlarını alt alta göster -->
                            <td><?php echo number_format($transaction['amount'], 2, ',', '.') . ' ' . strtoupper($transaction['currency']); ?></td>
                            <td><?php echo $transaction['status']; ?></td>
                            <td><?php echo $transaction['created_at']; ?></td>
                            <td><?php echo $transaction['user_id']; ?></td>
                            <td>
                                <form method="post" action="order-management.php">
                                    <input type="hidden" name="transaction_id" value="<?php echo $transaction['id']; ?>">
                                    <select name="order_status" class="form-control mb-2">
                                        <option value="pending" <?php if ($transaction['order_status'] == 'pending') echo 'selected'; ?>>Beklemede</option>
                                        <option value="processing" <?php if ($transaction['order_status'] == 'processing') echo 'selected'; ?>>Hazırlanıyor</option>
                                        <option value="shipped" <?php if ($transaction['order_status'] == 'shipped') echo 'selected'; ?>>Gönderildi</option>
                                        <option value="delivered" <?php if ($transaction['order_status'] == 'delivered') echo 'selected'; ?>>Teslim Edildi</option>
                                        <option value="canceled" <?php if ($transaction['order_status'] == 'canceled') echo 'selected'; ?>>İptal Edildi</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary">Güncelle</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include "views/_footer.php"; ?>
