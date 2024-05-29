<?php
require_once 'controllers/author-controller.php';

//Author id'yi çek
$id = $_GET["id"];
$authorController = new AuthorController();

//Kategoriyi sil
if($authorController->delete($id)){
    header('Location: edit-authors.php');
}
else{
    echo "Kategori silerken hata!";
}
?>