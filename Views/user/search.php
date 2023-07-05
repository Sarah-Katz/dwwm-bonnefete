<?php

require_once "Models/UserModel.php";

use App\Models\UserModel;

require_once 'Views/header.php';
require_once 'Views/navbar.php'; ?>

<?php if ($users) : ?>
    <?php foreach ($users as $user) : ?>
        <?php
        $UserModel = new UserModel();
        $posts = $UserModel->getRecentPosts($user->getID_user())
        ?>
        <!-- Utilisateur -->
        <div class="card column is-4 is-offset-4 mt-5 mb-2">
            <div class="card-content">
                <div class="media">
                    <div class="media-content">
                        <a class="is-pulled-right button blue-background has-text-white" href="../user/profile/<?= $user->getID_user() ?>">Voir le profil</a>
                        <div>
                            <?php if ($user->getID_role() == 2) : ?> <i class="fa-solid fa-star" style="color: var(--orange);"></i> <span class="orange-text">Modérateur</span> <?php endif; ?>
                            <p class="title is-4"><?= $user->getUsername() ?></p>
                        </div>
                        <p class="subtitle is-6"><?= $user->getEmail() ?></p>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($posts) : ?>
                <!-- Ses postes récents -->
                <?php require 'Views/post/post.php';?>
        <?php endif; ?>
    <?php endforeach; ?>
<?php else : ?>
    <div class="card column is-4 is-offset-4 mt-5 mb-2">
        <div class="card-content">
            <div class="media">
                <div class="media-content">
                    <p class="title is-4 has-text-centered">Aucun utilisateur ne correspond à votre recherche</p>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php require_once 'Views/footer.php'; ?>