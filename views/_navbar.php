<?php 
require_once 'controllers/user-controller.php'; 
session_start();
?>

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
                <li class="nav-item">
                    <a class="nav-link" href="#">Favori Listem</a>
                </li>
                <?php

                //Kullanıcı girişi ve rolüne göre linklerin düzenlenmesi

                $userController = new UserController();

                if ($userController->isLogged()) {
                    if ($userController->isAdmin()) {
                        echo '<li class="nav-item"><a class="nav-link" href="admin-panel.php">Admin Panel</a></li>';
                    }
                    echo '<li class="nav-item"><a class="nav-link" href="logout.php">Çıkış Yap</a></li>';
                } else {
                    echo '<li class="nav-item"><a class="nav-link" href="login.php">Giriş Yap</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="register.php">Kayıt Ol</a></li>';
                }
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="cart.php">Sepetim
                    <i class="fa-solid fa-cart-shopping"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
