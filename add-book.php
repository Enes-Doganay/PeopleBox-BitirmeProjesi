<?php
include "views/_header.php";
include "views/_navbar.php";
include "libs/functions.php";
require_once 'controllers/book-controller.php';
require_once 'controllers/category-controller.php';
require_once 'controllers/author-controller.php';
require_once 'controllers/publisher-controller.php';
require_once "controllers/user-controller.php" ;

$userController = new UserController();

if(!$userController->isAdmin()){
    header('Location: index.php');
}

$bookName =  $pageCount = $isbn = $image = $categoryId = $authorId = $publisherId = $price = $stock = "";
$bookName_err = $pageCount_err = $isbn_err = $image_err = $categoryId_err = $authorId_err = $publisherId_err = $price_err = $stock_err = "";


//Kitap bilgilerini çekme
$bookController = new BookController();

//Kategori bilgilerini çekme
$categoryController = new CategoryController();
$categories = $categoryController->getAll();

//Kitap bilgilerini çekme
$authorController = new AuthorController();
$authors = $authorController->getAll();

//Yayınevi bilgilerini çekme
$publisherController = new PublisherController();
$publishers = $publisherController->getAll();

//Kitap ekleme işlemi
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["create"])) {
    $bookName = control_input($_POST["bookName"]);
    $description = control_input($_POST["description"]);
    $isbn = control_input($_POST["isbn"]);
    $pageCount = control_input($_POST["pageCount"]);
    $price = control_input($_POST["price"]);
    $stock = control_input($_POST["stock"]);
    $categoryId = intval($_POST["categoryId"]);
    $authorId = intval($_POST["authorId"]);
    $publisherId = intval($_POST["publisherId"]);
    $isActive = isset($_POST["isActive"]) ? 1 : 0;
    $isHome = isset($_POST["isHome"]) ? 1 : 0;

    //Kitap adı kontrolü
    if (empty($bookName)) {
        $bookName_err = "Kitap adı girmelisiniz.";
    } else if (strlen($bookName) > 200) {
        $bookName_err = "Kitap adı 200 karakterden az olmalı.";
    }
    
    //ISBN kontrolü
    if (empty($isbn)) {
        $isbn = "ISBN numarası girmelisiniz.";
    } else if (strlen($isbn) > 20) {
        $isbn_err = "ISBN numarası 20 karakterden az olmalı";
    }
    
    //Image kontrolü
    if (empty($_FILES["image"]["name"])) {
        $image_err = "Dosya seçiniz.";
    } else{
        $result = saveImage($_FILES["image"]);
        if ($result["isSuccess"]) {
            $image = $result["image"];
        } else {
            $image_err = "Başarısız: " . $result["message"];
        }
    }
    
    //Sayfa sayısı kontrolü
    if (empty($pageCount)) {
        $pageCount_err = "Sayfa sayısı girmelisiniz.";
    } else if (!is_numeric($pageCount)) {
        $pageCount_err = "Sayısal değer girmelisiniz.";
    }
    
    //Kategori kontrolü
    if (empty($categoryId)) {
        $categoryId_err = "Kategori seçmelisiniz.";
    }
    
    //Yazar kontrolü
    if (empty($authorId)) {
        $authorId_err = "Yazar seçmelisiniz.";
    }
    
    //Yayınevi kontrolü
    if (empty($publisherId)) {
        $publisherId_err = "Yayınevi seçmelisiniz.";
    }

        //Fiyat kontrolü
        if (empty($price)) {
            $price_err = "Fiyat için bir değer girmelisiniz.";
        } else if (!is_numeric($price)) {
            $price_err = "Fiyat için sayısal değer girmelisiniz.";
        } else if ($price < 0) {
            $price_err = "Fiyat negatif olamaz.";
        }
    
        //Stok kontrolü
        if (empty($stock)) {
            $stock_err = "Stok için bir değer girmelisiniz.";
        } else if (!is_numeric($stock)) {
            $stock_err = "Stok için sayısal değer girmelisiniz.";
        } else if ($stock < 0) {
            $stock_err = "Stok negatif olamaz.";
        }

    //Hata yoksa ekle
    if (empty($bookName_err) && empty($isbn_err) && empty($image_err) && empty($pageCount_err) && empty($categoryId_err) && empty($authorId_err) && empty($publisherId_err) && empty($price_err) && empty($stock_err)) {
        $result_message = $bookController->create($bookName, $description, $isbn, $image, $pageCount, $categoryId, $authorId, $publisherId, $isActive, $isHome, $price, $stock);
        
        if (strpos($result_message, "başarılı") !== false) {
            echo "<div class='alert alert-success'>{$result_message}</div>";
        } else {
            echo "<div class='alert alert-danger'>{$result_message}</div>";

            // Veritabanı kaydı başarısız olduğunda görseli sil
            if (!empty($image)) {
                unlink("./img/" . $image); 
            }
        }
    }
}
?>

<div class="container my-3">
    <div class="row">
        <div class="col-md-3 my-5">
            <?php include "views/_admin-menu.php"; ?>
        </div>
        <div class="col-md-9" id="content">
            <h3>Kitap Ekle</h3>
            <form action="add-book.php" method="POST" enctype="multipart/form-data">
                <!-- Kitap Adı -->
                <div class="mb-3">
                    <label for="bookName" class="form-label">Kitap Adı</label>
                    <input type="text" class="form-control <?php echo !empty($bookName_err) ? 'is-invalid' : ''; ?>" id="bookName" name="bookName" value="<?php echo htmlspecialchars($bookName); ?>">
                    <div class="invalid-feedback"><?php echo $bookName_err; ?></div>
                </div>

                <!-- Kitap Açıklaması -->
                <div class="mb-3">
                    <label for="description" class="form-label">Kitap Açıklaması</label>
                    <textarea name="description" id="description" class="form-control"><?php echo isset($description) ? $description : ''; ?></textarea>

                </div>

                <!-- ISBN -->
                <div class="mb-3">
                    <label for="isbn" class="form-label">ISBN</label>
                    <input type="text" class="form-control <?php echo !empty($isbn_err) ? 'is-invalid' : ''; ?>" id="isbn" name="isbn" value="<?php echo htmlspecialchars($isbn); ?>">
                    <div class="invalid-feedback"><?php echo $isbn_err ?></div>
                </div>

                <!-- Image -->
                <div class="mb-3">
                    <label for="image" class="form-label">Görsel</label>
                    <input type="file" class="form-control <?php echo (!empty($image_err)) ? 'is-invalid' : '' ?>" name="image" id="image">
                    <span class="invalid-feedback"><?php echo $image_err ?></span>
                </div>

                <!-- Sayfa sayısı -->
                <div class="mb-3">
                    <label for="pageCount" class="form-label">Sayfa Sayısı</label>
                    <input type="text" class="form-control <?php echo !empty($pageCount_err) ? 'is-invalid' : ''; ?>" id="pageCount" name="pageCount" value="<?php echo htmlspecialchars($pageCount); ?>">
                    <div class="invalid-feedback"><?php echo $pageCount_err; ?></div>
                </div>

                <div class="col-md-12">
                    <div class="row">
                        <!-- Fiyat -->
                        <div class="mb-3 col-md-6">
                            <label for="price" class="form-label">Fiyat</label>
                            <input type="text" class="form-control <?php echo !empty($price_err) ? 'is-invalid' : ''; ?>" id="price" name="price" value="<?php echo htmlspecialchars($price); ?>">
                            <div class="invalid-feedback"><?php echo $price_err; ?></div>
                        </div>
                        <!-- Stok -->
                        <div class="mb-3 col-md-6">
                            <label for="stock" class="form-label">Stok</label>
                            <input type="text" class="form-control <?php echo !empty($stock_err) ? 'is-invalid' : ''; ?>" id="stock" name="stock" value="<?php echo htmlspecialchars($stock); ?>">
                            <div class="invalid-feedback"><?php echo $stock_err; ?></div>
                        </div>
                    </div>
                </div>

                <!-- Kategoriler -->
                <div class="mb-3">
                    <label for="categoryId" class="form-label">Kategoriler</label>
                    <select class="form-control" name="categoryId" id="categoryId">
                        <option value="">Kategoriler</option>
                        <?php while ($item = $categories->fetch_assoc()) : ?>
                            <option value="<?php echo $item['id']; ?>" <?php if ($categoryId == $item['id']) echo 'selected'; ?>><?php echo htmlspecialchars($item['name'], ENT_QUOTES); ?></option>
                        <?php endwhile; ?>
                    </select>
                    <div class="invalid-feedback d-block"><?php echo $categoryId_err; ?></div>
                </div>

                <!-- Yazarlar -->
                <div class="mb-3">
                    <label for="authorId" class="form-label">Yazarlar</label>
                    <select class="form-control" name="authorId" id="authorId">
                        <option value="">Yazarlar</option>
                        <?php while ($item = $authors->fetch_assoc()) : ?>
                            <option value="<?php echo $item['id']; ?>" <?php if ($authorId == $item['id']) echo 'selected'; ?>><?php echo htmlspecialchars($item['name'], ENT_QUOTES); ?></option>
                        <?php endwhile; ?>
                    </select>
                    <div class="invalid-feedback d-block"><?php echo $authorId_err; ?></div>
                </div>

                <!-- Yayınevleri -->
                <div class="mb-3">
                    <label for="publisherId" class="form-label">Yayınevleri</label>
                    <select class="form-control" name="publisherId" id="publisherId">
                        <option value="">Yayınevi</option>
                        <?php while ($item = $publishers->fetch_assoc()) : ?>
                            <option value="<?php echo $item['id']; ?>" <?php if ($publisherId == $item['id']) echo 'selected'; ?>><?php echo htmlspecialchars($item['name'], ENT_QUOTES); ?></option>
                        <?php endwhile; ?>
                    </select>
                    <div class="invalid-feedback d-block"> <?php echo $publisherId_err ?> </div>
                </div>

                <!-- Yayın Durumu -->
                <div class="mb-3 form-check">
                    <label class="form-check-label" for="isActive">Yayınlansın mı?</label>
                    <input type="checkbox" class="form-check-input" name="isActive" id="isActive">
                </div>

                <!-- Anasayfada gösterilme durumu -->
                <div class="mb-3 form-check">
                    <label class="form-check-label" for="isHome">Anasayfada gösterilsin mi?</label>
                    <input type="checkbox" class="form-check-input" name="isHome" id="isHome">
                </div>

                <button type="submit" name="create" class="btn btn-primary">Ekle</button>
            </form>
        </div>
    </div>
</div>

<?php include "views/_ckeditor.php" ?>
<?php include "views/_footer.php"; ?>