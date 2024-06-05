<?php
require_once 'models/database.php';
require_once 'models/book.php';

class BookController
{
    private $book;

    // Veritabanı bağlantısı ve kitap sınıfı oluşturma
    public function __construct()
    {
        $database = new database();
        $db = $database->getConnection();
        $this->book = new Book($db);
    }

    // Yeni kitap oluşturma işlemi
    public function create($name, $description = null, $isbn, $image, $pageCount, $categoryId, $authorId, $publisherId, $isActive = 1, $isHome = 0)
    {
        if ($this->book->isBookExists($isbn)) {
            return "Bu kitap zaten kayıtlı.";
        }

        $result = $this->book->create($name, $description, $isbn, $image, $pageCount, $categoryId, $authorId, $publisherId, $isActive, $isHome);

        if ($result === true) {
            return "Kitap ekleme başarılı";
        } else {
            return "Kitap ekleme başarısız";
        }
    }

    // Kitap güncelleme işlemi
    public function update($id, $name, $description, $isbn, $image = null, $pageCount, $categoryId, $authorId, $publisherId, $isActive = 1, $isHome = 0)
    {
        $result = $this->book->update($id, $name, $description, $isbn, $image, $pageCount, $categoryId, $authorId, $publisherId, $isActive, $isHome);

        if ($result === true) {
            return "Güncelleme başarılı";
        } else {
            return "Güncelleme başarısız";
        }
    }

    // Kitap silme işlemi
    public function delete($id)
    {
        $result = $this->book->delete($id);

        if ($result === true) {
            return "Silme başarılı";
        } else {
            return "Silme başarısız: " . $result;
        }
    }

    //Stok güncelleme işlemi
    public function updateStock($id, $newStock)
    {
        $this->book->updateStock($id, $newStock);
    }

    //Tüm kitapları çekme işlemi
    public function getAll()
    {
        return $this->book->getAll();
    }

    // Belirli bir kitabı idye göre çekme işlemi
    public function getById($id)
    {
        return $this->book->getById($id);
    }

    // Belirli bir kategori idye göre çekme işlemi
    public function getByCategoryId($categoryId)
    {
        return $this->book->getByCategoryId($categoryId);
    }

    //Aranan kitapları görüntülemek için kitapları çekme işlemi
    public function getSearchBooks($searchQuery, $limit, $offset)
    {
        return $this->book->getSearchBooks($searchQuery, $limit, $offset);
    }

    public function getPaginatedHomeBooks($limit, $offset)
    {
        return $this->book->getPaginatedHomeBooks($limit, $offset);
    }

    //Filtrelenen kitapları kategori yazar ve yayınevlerine göre al
    public function getFilteredBooksByCategories($categoryIds = [], $authorIds = [], $publisherIds = [], $limit = null, $offset = null)
    {
        return $this->book->getFilteredBooksByCategories($categoryIds, $authorIds, $publisherIds, $limit, $offset);
    }
}
