<?php

use App\Models\UserModel;
use App\Models\PostModel;
use App\Models\LikeModel;

$userModel = new UserModel();
$postModel = new PostModel();
$likeModel = new LikeModel();

$post = $postModel->getPostById($data['ID_post']);
$likes = $likeModel->getLikesByPostId($data['ID_post']);

require_once 'Views/header.php';
require_once 'Views/navbar.php';
?>

<div class="column is-4 is-offset-4">
    <div class="box">
        <!-- Show every user that liked the post -->
        <a href="<?= $data[('origin')] ?>" class="button orange-background has-text-weight-bold">Retour</a>
        <h1 class="title has-text-centered">Utilisateurs ayant liké:</h1>
        <div class="card">
            <?php foreach ($likes as $like) : ?>
                <?php $user = $userModel->getUserById($like->getID_user()); ?>
                <div class="card-content">
                    <?php if ($user->getID_role() == 2) : ?> <i class="fa-solid fa-star" style="color: var(--orange);"></i> <span class="orange-text">Modérateur</span> <?php endif; ?>
                    <a href="<?= LOCALPATH ?>user/profile/<?= $user->getID_user() ?>" class="blue-text has-text-weight-bold"><?= $user->getUsername() ?></a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>


<?php require_once 'Views/footer.php'; ?>