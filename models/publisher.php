<?php
class Publisher
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    //Yeni yayıncı oluşturma işlemi
    public function create($name)
    {
        $stmt = $this->conn->prepare("INSERT INTO publishers (name) VALUES (?)");
        $stmt->bind_param("s", $name);

        if ($stmt->execute()) {
            return true;
        } else {
            throw new mysqli_sql_exception("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        }
    }

    //Tüm yayıncıları çekme işlemi
    public function getAll()
    {
        $stmt = $this->conn->prepare("SELECT * FROM publishers");
        $stmt->execute();
        return $stmt->get_result();
    }

    //Tüm belirli id'ye göre yayıncı çekme işlemi
    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM publishers WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Yayıncı güncelleme işlemi
    public function update($id, $name)
    {
        $stmt = $this->conn->prepare("UPDATE publishers SET name = ? WHERE id = ?");
        $stmt->bind_param("si", $name, $id);
        return $stmt->execute();
    }

    // Yayıncı silme işlemi
    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM publishers WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
