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
                        <p class="title is-4"><?= $user->getUsername() ?></p>
                        <p class="subtitle is-6"><?= $user->getEmail() ?></p>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($posts) : ?>
            <?php foreach ($posts as $post) : ?>
                <!-- Ses postes récents -->
                <div class="card column is-4 is-offset-4 mb-2">
                    <div class="card-content">
                        <div class="content is-large has-border">
                            <?= $post->getMessage() ?>
                        </div>
                        <h2 class="subtitle is-6 is-pulled-right">Par : <?= $user->getUsername() ?> le <?= $post->getPost_date() ?> </h2>
                    </div>
                </div>
            <?php endforeach; ?>
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