<?php
include "views/_header.php";
include "views/_navbar.php";
include "libs/functions.php";
require_once 'controllers/book-controller.php';
require_once 'controllers/author-controller.php';
require_once 'controllers/publisher-controller.php';
require_once "controllers/user-controller.php" ;

$userController = new UserController();

if(!$userController->isAdmin()){
    header('Location: index.php');
}

//Kitap bilgilerini çekme
$bookController = new BookController();
$books = $bookController->getAll();

$authorController = new AuthorController();
$publisherController = new PublisherController();
?>

<div class="container my-3">
    <div class="row">
        <div class="col-md-3 my-5">
            <?php include "views/_admin-menu.php"; ?>
        </div>
        <div class="col-md-9 my-2">
            <h3>Kitapları Düzenle</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>İsim</th>
                        <th>Yazar</th>
                        <th>Yayınevi</th>
                        <th>Fiyat</th>
                        <th>Stok</th>
                        <th style="width: 130px;">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Kitapları listele -->
                    <?php while ($item = $books->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $item["id"]; ?></td>
                            <td><?php echo htmlspecialchars($item['name'], ENT_QUOTES); ?></td>
                            <td><?php echo htmlspecialchars($authorController->getById($item['author_id'])["name"], ENT_QUOTES); ?></td>
                            <td><?php echo htmlspecialchars($publisherController->getById($item['publisher_id'])["name"], ENT_QUOTES); ?></td>
                            <td><?php echo $item["price"]; ?></td>
                            <td><?php echo $item["stock"]; ?></td>
                            <td>
                                <a href="edit-book.php?id=<?php echo $item["id"]; ?>" class="btn btn-warning btn-sm">Düzenle</a>
                                <a href="delete-book.php?id=<?php echo $item["id"]; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Silmek istediğinize emin misiniz?');">Sil</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php include "views/_footer.php"; ?>