<?php
class Favorite
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    //Yeni favori ekleme işlemi
    public function add($userId, $bookId)
    {
        $stmt = $this->conn->prepare("INSERT INTO favorites (user_id, book_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $userId, $bookId);
        return $stmt->execute();
    }

    //Favori kaldırma işlemi
    public function remove($userId, $bookId)
    {
        $stmt = $this->conn->prepare("DELETE FROM favorites WHERE user_id = ? AND book_id = ?");
        $stmt->bind_param("ii", $userId, $bookId);
        return $stmt->execute();
    }

    //Tüm favorileri all
    public function getAll($userId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM favorites WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->get_result();
    }

    //Favorilerde var mı
    public function isFavorite($userId, $bookId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM favorites WHERE user_id = ? AND book_id = ?");
        $stmt->bind_param("ii", $userId, $bookId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }
}
