<?php
require_once 'models/database.php';
require_once 'models/book.php';

class BookController
{
    private $book;

    public function __construct($book = null)
    {
        if ($book === null) {
            $database = new Database();
            $db = $database->getConnection();
            $this->book = new Book($db);
        } else {
            $this->book = $book;
        }
    }

    public function create($name, $description = null, $isbn, $image, $pageCount, $categoryId, $authorId, $publisherId, $isActive = 1, $isHome = 0, $price, $stock)
    {
        if ($this->book->isBookExists($isbn)) {
            return "Bu kitap zaten kayıtlı.";
        }

        $result = $this->book->create($name, $description, $isbn, $image, $pageCount, $categoryId, $authorId, $publisherId, $isActive, $isHome, $price, $stock);

        if ($result === true) {
            return "Kitap ekleme başarılı";
        } else {
            return "Kitap ekleme başarısız";
        }
    }

    public function update($id, $name, $description, $isbn, $image = null, $pageCount, $categoryId, $authorId, $publisherId, $isActive = 1, $isHome = 0, $price, $stock)
    {
        $result = $this->book->update($id, $name, $description, $isbn, $image, $pageCount, $categoryId, $authorId, $publisherId, $isActive, $isHome, $price, $stock);

        if ($result === true) {
            return "Güncelleme başarılı";
        } else {
            return "Güncelleme başarısız";
        }
    }

    public function delete($id)
    {
        $result = $this->book->delete($id);

        if ($result === true) {
            return "Silme başarılı";
        } else {
            return "Silme başarısız: " . $result;
        }
    }

    public function updateStock($id, $newStock)
    {
        $this->book->updateStock($id, $newStock);
    }

    public function getAll()
    {
        return $this->book->getAll();
    }

    public function getById($id)
    {
        return $this->book->getById($id);
    }

    public function getByCategoryId($categoryId)
    {
        return $this->book->getByCategoryId($categoryId);
    }

    public function getSearchBooks($searchQuery, $limit, $offset)
    {
        return $this->book->getSearchBooks($searchQuery, $limit, $offset);
    }

    public function getTotalSearchBooks($searchQuery)
    {
        return $this->book->getTotalSearchBooks($searchQuery);
    }

    public function getPaginatedHomeBooks($limit, $offset)
    {
        return $this->book->getPaginatedHomeBooks($limit, $offset);
    }

    public function getTotalHomeBooks()
    {
        return $this->book->getTotalHomeBooks();
    }

    public function getFilteredBooksByCategories($categoryIds = [], $authorIds = [], $publisherIds = [], $limit = null, $offset = null)
    {
        return $this->book->getFilteredBooksByCategories($categoryIds, $authorIds, $publisherIds, $limit, $offset);
    }
}
?>