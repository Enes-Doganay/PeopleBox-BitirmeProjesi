<?php
class Author
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    //Yeni yazar oluşturma işlemi
    public function create($name)
    {
        $stmt = $this->conn->prepare("INSERT INTO authors (name) VALUES (?)");
        $stmt->bind_param("s", $name);

        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            throw new mysqli_sql_exception("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        }
    }

    //Tüm yazarları çekme işlemi
    public function getAll()
    {
        $stmt = $this->conn->prepare("SELECT * FROM authors");
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result;
    }

    //Tüm belirli id'ye göre yazar çekme işlemi
    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM authors WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $result;
    }

    // Yazar güncelleme işlemi
    public function update($id, $name)
    {
        $stmt = $this->conn->prepare("UPDATE authors SET name = ? WHERE id = ?");
        $stmt->bind_param("si", $name, $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // Yazar silme işlemi
    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM authors WHERE id = ?");
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
}
