<?php
require_once "controllers/favorite-controller.php";

$favoriteController = new FavoriteController();
?>

<div class="row">
    <?php while (!empty($books) && $item = $books->fetch_assoc()) : ?>
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                <a href="book-detail.php?id=<?php echo $item['id']; ?>" class="text-decoration-none text-dark d-block">
                    <div class="position-relative">
                        <img src="<?php echo "img/" . $item["image"]; ?>" class="card-img-top mx-auto d-block mt-3" style="height: 12rem; width: auto;">
                        <?php if (isset($_SESSION['user_id'])) : ?>
                            <?php
                            $userId = $_SESSION['user_id'];
                            $id = $item['id'];
                            if ($favoriteController->isFavorite($userId, $id)) : ?>
                                <!-- Favori kaldırma butonu -->
                                <span class="favorite-btn position-absolute top-0 end-0 p-2" data-user-id="<?php echo $userId; ?>" data-book-id="<?php echo $id; ?>" data-action="remove">
                                    <i class="fa-solid fa-heart fa-2xl" style="color: #FFD43B;"></i>
                                </span>
                            <?php else : ?>
                                <!-- Favori ekleme butonu -->
                                <span class="favorite-btn position-absolute top-0 end-0 p-2" data-user-id="<?php echo $userId; ?>" data-book-id="<?php echo $id; ?>" data-action="add">
                                    <i class="fa-regular fa-heart fa-2xl" style="color: #FFD43B;"></i>
                                </span>
                            <?php endif; ?>
                        <?php else : ?>
                            <!-- Oturum açmamış kullanıcılar için favori ekleme butonu -->
                            <span class="favorite-btn position-absolute top-0 end-0 p-2" data-user-id="<?php echo $userId; ?>" data-book-id="<?php echo $id; ?>" data-action="add">
                                <i class="fa-regular fa-heart fa-2xl" style="color: #FFD43B;"></i>
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="card-body my-2">
                        <h5 class="card-title h-50 py-1"><?php echo $item['name']; ?></h5>
                        <h6 class="card-subtitle text-muted py-1"><?php echo $authorController->getById($item["author_id"])["name"]; ?></h6>
                        <div class="badge text-center mt-3 mb-3 py-2" style="background-color: #faf6e1;">
                            <small class="text-muted"><?php echo $publisherController->getById($item["publisher_id"])["name"]; ?></small>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<script src="js/favorites.js"></script>
