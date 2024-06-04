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

$bookName =  $pageCount = $isbn = $image = $categoryId = $authorId = $publisherId = "";
$bookName_err = $pageCount_err = $isbn_err = $image_err = $categoryId_err = $authorId_err = $publisherId_err = "";

//Kitap bilgilerini çekme
$id = $_GET["id"];
$bookController = new BookController();
$book = $bookController->getById($id);

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
        $image = $book["image"];    //Daha önce kaydedilen image'i al
    } else {
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

    //Hata yoksa güncelle
    if (empty($bookName_err) && empty($isbn_err) && empty($image_err) && empty($pageCount_err) && empty($categoryId_err) && empty($authorId_err) && empty($publisherId_err)) {
        $result_message = $bookController->update($id, $bookName, $description, $isbn, $image, $pageCount, $categoryId, $authorId, $publisherId, $isActive, $isHome);

        if (strpos($result_message, "başarılı") !== false) {
            echo "<div class='alert alert-success'>{$result_message}</div>";
        } else {
            echo "<div class='alert alert-danger'>{$result_message}</div>";
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
            <h3>Kitabı Düzenle</h3>
            <form action="" method="POST" enctype="multipart/form-data">
                <!-- Kitap Adı -->
                <div class="mb-3">
                    <label for="bookName" class="form-label">Kitap Adı</label>
                    <input type="text" class="form-control <?php echo !empty($bookName_err) ? 'is-invalid' : ''; ?>" id="bookName" name="bookName" value="<?php echo empty($bookName) ?
                                                                                                                                                                htmlspecialchars($book["name"]) : $bookName ?>">
                    <div class="invalid-feedback"><?php echo $bookName_err; ?></div>
                </div>

                <!-- Kitap Açıklaması -->
                <div class="mb-3">
                    <label for="description" class="form-label">Kitap Açıklaması</label>
                    <textarea name="description" id="description" class="form-control"><?php echo empty($description) ?
                                                                                            $book["description"] : $description ?></textarea>

                </div>

                <!-- ISBN -->
                <div class="mb-3">
                    <label for="isbn" class="form-label">ISBN</label>
                    <input type="text" class="form-control <?php echo !empty($isbn_err) ? 'is-invalid' : ''; ?>" id="isbn" name="isbn" value="
                        <?php echo empty($isbn) ? htmlspecialchars($book["isbn"]) : $isbn ?>">
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
                    <input type="text" class="form-control <?php echo !empty($pageCount_err) ? 'is-invalid' : ''; ?>" id="pageCount" name="pageCount" value="
                    <?php echo empty($pageCount) ?
                        htmlspecialchars($book["page_count"]) :
                        $pageCount ?>">
                    <div class="invalid-feedback"><?php echo $pageCount_err; ?></div>
                </div>

                <!-- Kategoriler -->
                <div class="mb-3">
                    <label for="categoryId" class="form-label">Kategoriler</label>
                    <select class="form-control" name="categoryId" id="categoryId">
                        <option value="">Kategoriler</option>
                        <?php while ($item = $categories->fetch_assoc()) : ?>
                            <option value="<?php echo $item['id']; ?>" <?php if ((empty($categoryId) ? htmlspecialchars($book["category_id"]) : $categoryId) == $item['id']) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($item['name'], ENT_QUOTES); ?></option>
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
                            <option value="<?php echo $item['id']; ?>" <?php if ((empty($authorId) ? htmlspecialchars($book["author_id"]) : $authorId) == $item['id']) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($item['name'], ENT_QUOTES); ?></option>
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
                            <option value="<?php echo $item['id']; ?>" <?php if ((empty($publisherId) ? htmlspecialchars($book["publisher_id"]) : $publisherId) == $item['id']) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($item['name'], ENT_QUOTES); ?></option>
                        <?php endwhile; ?>
                    </select>
                    <div class="invalid-feedback d-block"> <?php echo $publisherId_err ?> </div>
                </div>

                <!-- Yayın Durumu -->
                <div class="mb-3 form-check">
                    <label class="form-check-label" for="isActive">Yayınlansın mı?</label>
                    <input type="checkbox" class="form-check-input" name="isActive" id="isActive" <?php if ($book["is_active"]) echo "checked" ?>>
                </div>

                <!-- Anasayfada gösterilme durumu -->
                <div class="mb-3 form-check">
                    <label class="form-check-label" for="isHome">Anasayfada gösterilsin mi?</label>
                    <input type="checkbox" class="form-check-input" name="isHome" id="isHome" <?php if ($book["is_home"]) echo "checked" ?>>
                </div>

                <button type="submit" name="create" class="btn btn-primary">Ekle</button>
            </form>
        </div>
    </div>
</div>

<?php include "views/_ckeditor.php" ?>
<?php include "views/_footer.php"; ?>