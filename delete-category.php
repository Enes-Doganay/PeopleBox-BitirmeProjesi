<?php
require_once 'controllers/category-controller.php';
require_once "controllers/user-controller.php" ;

$userController = new UserController();

if(!$userController->isAdmin()){
    header('Location: index.php');
}

$categoryController = new CategoryController();
//Kategori id'yi çek
$id = $_GET["id"];

//Kategoriyi sil
if($categoryController->delete($id)){
    header('Location: edit-categories.php');
}
else{
    echo "Kategori silerken hata!";
}
?>