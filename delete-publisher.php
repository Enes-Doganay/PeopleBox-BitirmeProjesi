<?php
require_once 'controllers/publisher-controller.php';
require_once "controllers/user-controller.php" ;

$userController = new UserController();

if(!$userController->isAdmin()){
    header('Location: index.php');
}

//Author id'yi çek
$id = $_GET["id"];
$publisherController = new PublisherController();

//Kategoriyi sil
if($publisherController->delete($id)){
    header('Location: edit-publishers.php');
}
else{
    echo "Kategori silerken hata!";
}
?>