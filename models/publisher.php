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
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            throw new mysqli_sql_exception("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        }
    }

    //Tüm yayıncıları çekme işlemi
    public function getAll()
    {
        $stmt = $this->conn->prepare("SELECT * FROM publishers");
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result;
    }

    //Tüm belirli id'ye göre yayıncı çekme işlemi
    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM publishers WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $result;
    }

    // Yayıncı güncelleme işlemi
    public function update($id, $name)
    {
        $stmt = $this->conn->prepare("UPDATE publishers SET name = ? WHERE id = ?");
        $stmt->bind_param("si", $name, $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // Yayıncı silme işlemi
    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM publishers WHERE id = ?");
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
}
