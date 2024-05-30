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
    //Yeni yayınevi oluşturma işlemi
    public function create($name)
    {
        $result = $this->publisher->create($name);

        if ($result === true) {
            return "Yayınevi oluşturma başarılı";
        } else {
            return "Yayınevi oluşturma başarısız";
        }
    }

    //Tüm yayınevlerini çekme işlemi
    public function getAll()
    {
        return $this->publisher->getAll();
    }

    //Tüm belirli bir id'ye göre yayınevlerini çekme işlemi
    public function getById($id)
    {
        return $this->publisher->getById($id);
    }

    // Yayınevi güncelleme işlemi
    public function update($id, $name)
    {
        $result = $this->publisher->update($id, $name);

        if ($result === true) {
            return "Güncelleme başarılı";
        } else {
            return "Güncelleme başarısız: " . $result;
        }
    }

    // Yayınevi silme işlemi
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
