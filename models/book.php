<?php

class Book
{
    private $conn;

    // Veritabanı bağlantısı kurucu fonksiyonunda ayarlanır
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Yeni kitap oluşturma işlemi
    public function create($name, $description = null, $isbn, $image, $pageCount, $categoryId, $authorId, $publisherId, $isActive = 1, $isHome = 0)
    {
        $stmt = $this->conn->prepare("INSERT INTO books (name,description,isbn,image,page_count,category_id,author_id,publisher_id, is_active, is_home) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssiiiiii", $name, $description, $isbn, $image, $pageCount, $categoryId, $authorId, $publisherId, $isActive, $isHome);
        if ($stmt->execute()) {
            return true;
        } else {
            throw new mysqli_sql_exception("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        }
    }

    //Tüm kitapları çekme işlemi
    public function getAll()
    {
        $stmt = $this->conn->prepare("SELECT * FROM books");
        $stmt->execute();
        return $stmt->get_result();
    }

    //Tüm belirli id'ye göre kitap çekme işlemi
    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM books WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Belirli bir kategori idye göre çekme işlemi
    public function getByCategoryId($categoryId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM categories WHERE category_id = ?");
        $stmt->bind_param("i", $categoryId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Anasayfada görüntülenecek aktif kitapları çekme işlemi
    public function getHomeBooks()
    {
        $stmt = $this->conn->prepare("SELECT * FROM books WHERE is_active = 1 AND is_home = 1");
        $stmt->execute();
        return $stmt->get_result();
    }

    // Kategori güncelleme işlemi
    public function update($id, $name, $description, $isbn, $image = null, $pageCount, $categoryId, $authorId, $publisherId, $isActive = 1, $isHome = 0)
    {
        $stmt = $this->conn->prepare("UPDATE books SET name = ?, description = ?, isbn = ?, image = ?, page_count = ?, category_id = ?, author_id = ?, publisher_id = ? , is_active = ?, is_home = ? WHERE id = ?");
        $stmt->bind_param("ssssiiiiiii", $name, $description, $isbn, $image, $pageCount, $categoryId, $authorId, $publisherId, $isActive, $isHome, $id);
        return $stmt->execute();
    }

    // Kitap silme işlemi
    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM books WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Belirli bir isbnin veritabanında var olup olmadığını kontrol etme işlemi (isbn unique)
    public function isBookExists($isbn)
    {
        $query = "SELECT * FROM books WHERE isbn = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $isbn);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }
}
