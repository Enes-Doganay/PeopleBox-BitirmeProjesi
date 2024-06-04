<?php
include "views/_header.php"; 
include "views/_navbar.php"; 
require_once "controllers/user-controller.php" ;

$userController = new UserController();

if(!$userController->isAdmin()){
    header('Location: index.php');
}
?>
<div class="container my-3">
    <div class="row">
        <div class="col-md-3">
            <?php include "views/_admin-menu.php"; ?>
        </div>
        <div class="col-md-9" id="content">
            <h1>Admin Panel</h1>
            <p>Buradan kitap ve kategori ekleyebilir veya düzenleyebilirsiniz.</p>
        </div>
    </div>
</div>

<?php include "views/_footer.php"; ?>