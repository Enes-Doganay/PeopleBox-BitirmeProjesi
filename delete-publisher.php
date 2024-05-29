<?php
require_once 'controllers/publisher-controller.php';

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