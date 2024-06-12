<?php
require_once 'controllers/user-controller.php';
session_start();
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
<script src="js/dropdown.js"></script>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="index.php">Book Store</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#"></a>
                </li>
            </ul>
            <form class="d-flex" method="GET">
                <input class="form-control me-2" type="search" name="search" aria-label="Search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search'], ENT_QUOTES) : ''; ?>" style="width: 400px;">
                <button class="btn btn-outline-primary" type="submit">Ara</button>
            </form>
            <ul class="navbar-nav">
                <?php
                // Kullanıcı girişi ve rolüne göre linklerin düzenlenmesi
                $userController = new UserController();
                if ($userController->isLogged()) {
                    if ($userController->isAdmin()) {
                        echo '<li class="nav-item"><a class="nav-link" href="admin-panel.php">Admin Panel</a></li>';
                    }
                    echo ' <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" onclick="window.location.href=\'my-orders.php\';">
                            Hesabım
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="accountDropdown">
                            <li><a class="dropdown-item" href="my-orders.php">Siparişlerim</a></li>
                            <li><a class="dropdown-item" href="account.php">Hesap Bilgilerim</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="logout.php">Çıkış Yap</a></li>
                        </ul>
                    </li>';
                } else {
                    echo '<li class="nav-item"><a class="nav-link" href="login.php">Giriş Yap</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="register.php">Kayıt Ol</a></li>';
                }
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="favorite-list.php">Favorilerim</a>
                </li>
                <li class="nav-item">
                    <?php 
                        require_once "controllers/cart-controller.php";
                        $cartController = new CartController();
                        $items = $cartController->getCartItems();
                    ?>
                    <a class="nav-link" href="cart.php">Sepetim (<?php echo count($items); ?>)
                        <i class="fa-solid fa-cart-shopping"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>