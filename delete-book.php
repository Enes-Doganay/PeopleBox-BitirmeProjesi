<?php
require_once 'controllers/book-controller.php';

$bookController = new BookController();

//Kitap id'yi çek
$id = $_GET["id"];

//Kitabı sil
if($bookController->delete($id)){
    header('Location: edit-books.php');
}
else{
    echo "Kitap silerken hata!";
}
?>