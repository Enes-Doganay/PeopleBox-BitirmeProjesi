<?php

class Category
{
    private $conn;

    // Veritabanı bağlantısı kurucu fonksiyonunda ayarlanır
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

     // Yeni kategori oluşturma işlemi
    public function create($name, $isActive = 1, $parentId = null)
    {
        $stmt = $this->conn->prepare("INSERT INTO categories (name, is_active, parent_id) VALUES (?, ?, ?)");
        if ($parentId === null) {
            $nullValue = null;
            $stmt->bind_param("sii", $name, $isActive, $nullValue);
        } else {
            $stmt->bind_param("sii", $name, $isActive, $parentId);
        }
        if ($stmt->execute()) {
            return true;
        } else {
            throw new mysqli_sql_exception("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        }
    }

    //Tüm kategorileri çekme işlemi
    public function getAll()
    {
        $stmt = $this->conn->prepare("SELECT * FROM categories");
        $stmt->execute();
        return $stmt->get_result();
    }

    // Belirli bir kategoriyi idye göre çekme işlemi
    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Alt kategorileri belirli bir üst kategoriye göre çekme işlemi
    public function getSubCategories($parentId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM categories WHERE parent_id = ?");
        $stmt->bind_param("i", $parentId);
        $stmt->execute();
        return $stmt->get_result();
    }
    public function getSubCategoryIds($parentId)
    {
        $stmt = $this->conn->prepare("SELECT id FROM categories WHERE parent_id = ?");
        $stmt->bind_param("i", $parentId);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Kategori güncelleme işlemi
    public function update($id, $name, $isActive = 1, $parentId = null)
    {
        $stmt = $this->conn->prepare("UPDATE categories SET name = ?, is_active = ?, parent_id = ? WHERE id = ?");
        $stmt->bind_param("siii", $name, $isActive, $parentId, $id);
        return $stmt->execute();
    }

    // Kategori silme işlemi
    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Belirli bir kategori adının veritabanında var olup olmadığını kontrol etme işlemi (Kategory name unique)
    public function isCategoryExists($name)
    {
        $query = "SELECT * FROM categories WHERE name = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }
}
?>