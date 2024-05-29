<?php
require_once 'models/database.php';
require_once 'models/publisher.php';

class PublisherController
{
    private $publisher;

    // Veritabanı bağlantısı ve publisher sınıfı oluşturma
    public function __construct()
    {
        $database = new database();
        $db = $database->getConnection();
        $this->publisher = new Publisher($db);
    }
    //Yeni yayıncı oluşturma işlemi
    public function create($name)
    {
        $result = $this->publisher->create($name);

        if ($result === true) {
            return "Yazar oluşturma başarılı";
        } else {
            return "Yazar oluşturma başarısız";
        }
    }

    //Tüm yayıncıları çekme işlemi
    public function getAll()
    {
        return $this->publisher->getAll();
    }

    //Tüm belirli bir id'ye göre yayıncı çekme işlemi
    public function getById($id)
    {
        return $this->publisher->getById($id);
    }

    // Yayıncı güncelleme işlemi
    public function update($id, $name)
    {
        $result = $this->publisher->update($id, $name);

        if ($result === true) {
            return "Güncelleme başarılı";
        } else {
            return "Güncelleme başarısız: " . $result;
        }
    }

    // Yayıncı silme işlemi
    public function delete($id)
    {
        $result = $this->publisher->delete($id);

        if ($result === true) {
            return "Silme başarılı";
        } else {
            return "Silme başarısız: " . $result;
        }
    }
}
