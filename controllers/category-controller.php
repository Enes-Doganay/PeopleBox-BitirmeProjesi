<?php
require_once 'models/database.php';
require_once 'models/category.php';

class CategoryController
{
    private $category;

    // Veritabanı bağlantısı ve kategori sınıfı oluşturma
    public function __construct()
    {
        $database = new database();
        $db = $database->getConnection();
        $this->category = new Category($db);
    }

    // Yeni kategori oluşturma işlemi
    public function create($name, $isActive = 1, $parentId = null)
    {
        if ($this->category->isCategoryExists($name)) {
            return "Bu kategori zaten kayıtlı.";
        }

        $result = $this->category->create($name, $isActive, $parentId);

        if ($result === true) {
            return "Kategori oluşturma başarılı";
        } else {
            return "Kategori oluşturma başarısız";
        }
    }

    //Tüm kategorileri çekme işlemi
    public function getAll()
    {
        return $this->category->getAll();
    }

    // Belirli bir kategoriyi idye göre çekme işlemi
    public function getById($id)
    {
        return $this->category->getById($id);
    }

    // Alt kategorileri belirli bir üst kategoriye göre çekme işlemi
    public function getSubcategories($parent_id)
    {
        return $this->category->getSubcategories($parent_id);
    }
    public function getSubcategoryIds($parent_id)
    {
        return $this->category->getSubCategoryIds($parent_id);
    }

    // Kategori güncelleme işlemi
    public function update($id, $name, $isActive, $parent_id = null)
    {
        $result = $this->category->update($id, $name, $isActive, $parent_id);

        if ($result === true) {
            return "Güncelleme başarılı";
        } else {
            return "Güncelleme başarısız: " . $result;
        }
    }

    // Kategori silme işlemi
    public function delete($id)
    {
        // Alt kategorilerin parent_id'sini null yap
        $this->category->nullifySubCategories($id);
        
        // Kategoriyi sil
        $result = $this->category->delete($id);

        if ($result === true) {
            return "Silme başarılı";
        } else {
            return "Silme başarısız: " . $result;
        }
    }
}
?>