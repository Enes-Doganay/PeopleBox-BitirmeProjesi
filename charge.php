<?php
// Stripe PHP kütüphanesini dahil et
require 'vendor/autoload.php';

// Stripe API anahtarını ayarla
\Stripe\Stripe::setApiKey('sk_test_51PNEIYIzrk4FBfXJkKaRyMdNSwnVoEuZGvH9wSxSHFn39FNLziaBP3qnLjCuKKOlXRVYuHxMXdfs6Xho5bOGfUw200DCZlvLAQ');

// Formdan gelen Stripe token'ını al
$token = $_POST['stripeToken'];
$amount = $_POST['totalAmount']; // Total amount in cents

try {
    // Stripe üzerinden ödeme işlemini gerçekleştir
    $charge = \Stripe\Charge::create([
        'amount' => $amount, // toplam miktar
        'currency' => 'try',
        'description' => 'Test Ödemesi',
        'source' => $token,
    ]);

    // Ödeme başarılı olduğunda
    echo 'Ödeme başarılı!';
} catch (\Stripe\Exception\CardException $e) {
    // Hata durumunda
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
