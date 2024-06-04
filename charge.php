<?php
// Stripe PHP kütüphanesini dahil et
session_start();

require_once 'vendor/autoload.php';
require_once 'controllers/transaction-controller.php';
require_once 'controllers/cart-controller.php';
require_once 'controllers/book-controller.php';
require_once 'controllers/user-controller.php';
require_once 'libs/mailer.php';

// Stripe API anahtarını ayarla
\Stripe\Stripe::setApiKey('sk_test_51PNEIYIzrk4FBfXJkKaRyMdNSwnVoEuZGvH9wSxSHFn39FNLziaBP3qnLjCuKKOlXRVYuHxMXdfs6Xho5bOGfUw200DCZlvLAQ');

// Formdan gelen Stripe token'ını al
$token = $_POST['stripeToken'];
$amount = $_POST['totalAmount']; // Toplam tutar kuruş olarak

$userController = new UserController();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
}

$userId = $_SESSION['user_id'];
$user = $userController->getById($userId);

try {
    // Stripe üzerinden ödeme işlemini gerçekleştir
    $charge = \Stripe\Charge::create([
        'amount' => $amount, // toplam miktar
        'currency' => 'try',
        'description' => 'Sipariş Ödemesi',
        'source' => $token,
    ]);

    // İşlem başarılı olduğunda, transaction veritabanına kaydediyoruz
    $transactionController = new TransactionController();
    $cartController = new CartController();
    $bookController = new BookController();
    $items = $cartController->getCartItems();

    // Fatura bilgilerini hazırlıyoruz
    $invoiceItems = [];
    foreach ($items as $bookId => $quantity) {
        $book = $bookController->getById($bookId);
        $invoiceItems[] = [
            'name' => $book['name'],
            'quantity' => $quantity,
            'price' => $book['price'] * $quantity
        ];
    }

    $transactionController->saveTransaction($userId, $charge, $items);

    // Fatura göndermek için Mailer sınıfını kullan
    $mailer = new Mailer();
    if ($mailer->sendInvoice($user['email'], $invoiceItems, $amount)) {
        echo 'Fatura başarıyla gönderildi.';
    } else {
        echo 'Fatura gönderilemedi.';
    }

    // Sepeti temizle
    $cartController->clearCart();

    // Ödeme başarılı olduğunda
    header('Location: success.php');
    exit();

} catch (\Stripe\Exception\CardException $e) {
    echo 'Ödeme başarısız: ' . $e->getError()->message;
} catch (\Stripe\Exception\RateLimitException $e) {
    echo 'Çok fazla istek yapıldı. Lütfen daha sonra tekrar deneyin.';
} catch (\Stripe\Exception\InvalidRequestException $e) {
    echo 'Geçersiz istek. Ödeme bilgilerinizi kontrol edin.';
} catch (\Stripe\Exception\AuthenticationException $e) {
    echo 'Kimlik doğrulama başarısız. Lütfen API anahtarlarınızı kontrol edin.';
} catch (\Stripe\Exception\ApiConnectionException $e) {
    echo 'Ağ hatası. Lütfen internet bağlantınızı kontrol edin.';
} catch (\Stripe\Exception\ApiErrorException $e) {
    echo 'Bir hata oluştu. Lütfen daha sonra tekrar deneyin.';
} catch (Exception $e) {
    echo 'Bir hata oluştu. Lütfen daha sonra tekrar deneyin.';
}
?>