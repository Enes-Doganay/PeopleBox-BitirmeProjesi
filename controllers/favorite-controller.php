<?php
require_once __DIR__ . '/../models/database.php';
require_once __DIR__ . '/../models/favorite.php';

class FavoriteController
{
    private $favorite;

    public function __construct()
    {
        $database = new Database();
        $db = $database->getConnection();
        $this->favorite = new Favorite($db);
    }

    //Yeni favori ekleme işlemi
    public function add($userId, $bookId)
    {
        if ($this->favorite->add($userId, $bookId)) {
            return ["status" => "success", "message" => "Favori başarıyla eklendi"];
        } else {
            return ["status" => "error", "message" => "Favori eklenirken bir hata oluştu"];
        }
    }

    //Favori kaldırma işlemi
    public function remove($userId, $bookId)
    {
        if ($this->favorite->remove($userId, $bookId)) {
            return ["status" => "success", "message" => "Favori başarıyla kaldırıldı"];
        } else {
            return ["status" => "error", "message" => "Favori kaldırılırken bir hata oluştu"];
        }
    }

    //Tüm favorileri all
    public function getAll($userId)
    {
        return $this->favorite->getAll($userId);
    }

    //Favorilerde var mı
    public function isFavorite($userId, $bookId)
    {
        return $this->favorite->isFavorite($userId, $bookId);
    }
}
