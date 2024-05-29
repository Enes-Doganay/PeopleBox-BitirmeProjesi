<?php
require_once 'models/database.php';
require_once 'models/author.php';

class AuthorController
{
    private $author;

    // Veritabanı bağlantısı ve author sınıfı oluşturma
    public function __construct()
    {
        $database = new database();
        $db = $database->getConnection();
        $this->author = new Author($db);
    }
    //Yeni yazar oluşturma işlemi
    public function create($name)
    {
        $result = $this->author->create($name);

        if ($result === true) {
            return "Yazar oluşturma başarılı";
        } else {
            return "Yazar oluşturma başarısız";
        }
    }

    //Tüm yazarları çekme işlemi
    public function getAll()
    {
        return $this->author->getAll();
    }

    //Tüm belirli bir id'ye göre yazar çekme işlemi
    public function getById($id)
    {
        return $this->author->getById($id);
    }

    // Yazar güncelleme işlemi
    public function update($id, $name)
    {
        $result = $this->author->update($id, $name);

        if ($result === true) {
            return "Güncelleme başarılı";
        } else {
            return "Güncelleme başarısız: " . $result;
        }
    }

    // Yazar silme işlemi
    public function delete($id)
    {
        $result = $this->author->delete($id);

        if ($result === true) {
            return "Silme başarılı";
        } else {
            return "Silme başarısız: " . $result;
        }
    }
}
