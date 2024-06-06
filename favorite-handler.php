<?php
require_once 'controllers/favorite-controller.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST["userId"];
    $bookId = $_POST["bookId"];
    $action = $_POST["action"];
    $favoriteController = new FavoriteController();

    if ($action == "add") {
        $response = $favoriteController->add($userId, $bookId);
    } else if ($action == "remove") {
        $response = $favoriteController->remove($userId, $bookId);
    }

    echo json_encode($response);
}
?>