<?php
require_once 'controllers/author-controller.php';
require_once 'controllers/publisher-controller.php';

$authorController = new AuthorController();
$publisherController = new PublisherController();

$authors = $authorController->getAll();
$publishers = $publisherController->getAll();
?>

<form method="GET" action="category.php">
    <div class="my-2">
        <input type="text" hidden name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''?>">
        <label for="publisher-search" class="form-label"><b>Yayınevi Ara</b></label>
        <!-- Kullanıcının yayınevi araması için metin girişi -->
        <input type="text" id="publisher-search" class="form-control" onkeyup="filterOptions('publisher-search', 'publishers-list')">
        <div id="publishers-list" class="mt-2">

            <!-- Yayınevleri listesini oluştur -->
            <?php while ($publisher = $publishers->fetch_assoc()) : ?>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="publisher_ids[]" value="<?php echo $publisher['id']; ?>" <?php echo (isset($_GET['publisher_ids']) && in_array($publisher['id'], $_GET['publisher_ids'])) ? 'checked' : ''; ?>>
                    <label class="form-check-label">
                        <?php echo htmlspecialchars($publisher['name'], ENT_QUOTES); ?>
                    </label>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    <div class="my-3">
        <label for="author-search" class="form-label"><b>Yazar Ara</b></label>
        <!-- Kullanıcının yazar araması için metin girişi -->
        <input type="text" id="author-search" class="form-control" onkeyup="filterOptions('author-search', 'authors-list')">
        <div id="authors-list" class="mt-2">
            <!-- Yazarlar listesini oluştur -->
            <?php while ($author = $authors->fetch_assoc()) : ?>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="author_ids[]" value="<?php echo $author['id']; ?>" <?php echo (isset($_GET['author_ids']) && in_array($author['id'], $_GET['author_ids'])) ? 'checked' : ''; ?>>
                    <label class="form-check-label">
                        <?php echo htmlspecialchars($author['name'], ENT_QUOTES); ?>
                    </label>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Filtrele</button>
</form>

<script>

// Arama girişine göre listeyi filtreler
function filterOptions(searchId, listId) {
    var input, filter, div, label, i;
    input = document.getElementById(searchId);
    filter = input.value.toUpperCase();
    div = document.getElementById(listId);
    label = div.getElementsByTagName("label");
    for (i = 0; i < label.length; i++) {
        txtValue = label[i].textContent || label[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            label[i].parentElement.style.display = "";
        } else {
            label[i].parentElement.style.display = "none";
        }
    }
}
</script>
