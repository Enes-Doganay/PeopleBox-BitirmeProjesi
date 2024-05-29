<?php
include "views/_header.php";
include "views/_navbar.php";
include "libs/functions.php";
require_once 'controllers/author-controller.php';

//Authors bilgilerini çekme
$authorController = new AuthorController();
$authors = $authorController->getAll();
?>

<div class="container my-3">
    <div class="row">
        <div class="col-md-3 my-5">
            <?php include "views/_admin-menu.php"; ?>
        </div>
        <div class="col-md-9 my-2">
            <h3>Yazarları Düzenle</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>İsim</th>
                        <th style="width: 150px;">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Yazarları listele -->
                    <?php while ($item = $authors->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $item["id"]; ?></td>
                            <td><?php echo htmlspecialchars($item['name'], ENT_QUOTES); ?></td>
                            <td>
                                <a href="edit-author.php?id=<?php echo $item["id"]; ?>" class="btn btn-warning btn-sm">Düzenle</a>
                                <a href="delete-author.php?id=<?php echo $item["id"]; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Silmek istediğinize emin misiniz?');">Sil</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php include "views/_footer.php"; ?>