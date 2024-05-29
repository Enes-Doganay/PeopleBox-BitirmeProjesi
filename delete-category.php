<?php
require_once 'controllers/category-controller.php';

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