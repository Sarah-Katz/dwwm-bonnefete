<?php

use App\Models\UserModel;
use App\Models\LikeModel;

require_once 'Views/header.php';
require_once 'Views/navbar.php';
?>

<div class="columns">
    <div class="column is-2 is-offset-1 mt-6" id="user-infos">
        <div class="box blue-background">
            <div class="card has-text-weight-bold">
                <div class="card-content p-2">
                    <h4 class="card-title">
                        <span class="card-title-text">Nom d'utilisateur:</span>
                    </h4>
                    <span><?= $user->getUsername() ?></span>
                </div>
                <div class="card-content p-2">
                    <h4 class="card-title">
                        <span class="card-title-text">Adresse Email:</span>
                    </h4>
                    <span><?= $user->getEmail() ?></span>
                </div>
                <div class="card-content p-2">
                    <h4 class="card-title">
                        <span class="card-title-text">Date d'inscription:</span>
                    </h4>
                    <span><?= $user->getRegister_date() ?></span>
                </div>
                <?php if ($user->getID_role() == 2) : ?>
                    <div class="card-content has-text-info p-2">
                        <span>Cet utilisateur est modérateur</span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Bouton conditionel de modificatiopn de profil -->
<?php if ($_SESSION['ID_user'] == $user->getID_user() || $_SESSION['ID_role'] == 2 || $_SESSION['ID_role'] == 3) : ?>
    <div class="column is-2 is-offset-10 has-text-weight-bold">
        <a href="<?php echo LOCALPATH ?>user/profileEdit/<?= $user->getID_user() ?>" class="button orange-background"> <i class="fa-solid fa-gear mr-1"></i> Modifier le profil</a>
    </div>
<?php endif; ?>

<?php if ($posts) : ?>
    <?php foreach ($posts as $post) : ?>
        <?php
        $userModel = new UserModel();
        $user = $userModel->getUserById($post->getID_user());
        $likeModel = new LikeModel();
        $likes = $likeModel->getLikesByPostId($post->getID_post());
        $likesNumber = $likeModel->countLikesByPostId($post->getID_post());
        ?>
        <div class="column is-4 is-offset-4">
            <div class="card column">
                <div class="card-content">
                    <!-- Condition d'affichage des boutons d'édition-->
                    <?php if ($_SESSION['ID_user'] == $post->getID_user() || $_SESSION['ID_role'] == 2 || $_SESSION['ID_role'] == 3) : ?>
                        <div class="buttons is-pulled-right">
                            <a class="button is-ghost m-0 p-1" href="<?php echo LOCALPATH ?>post/edit/<?= $post->getID_post() ?>"><i class="fas fa-xl fa-pen" style="color: var(--orange);"></i></a>
                            <form action="<?= LOCALPATH ?>user/confirm" method="post">
                                <input type="hidden" name="action" value="deletePost">
                                <input type="hidden" name="ID_post" value="<?= $post->getID_post() ?>">
                                <button class="button is-ghost m-0 p-1"><i class=" fas fa-xl fa-trash" style="color: red;"></i></button>
                            </form>
                        </div>
                    <?php endif; ?>
                    <!-- Message -->
                    <div class="content is-large has-border">
                        <?= $post->getMessage() ?>
                    </div>
                    <!-- Gestion des likes -->
                    <?php if ($likes) : ?>
                        <form action="<?= LOCALPATH ?>like/showLikes" method="post">
                            <input type="hidden" name="ID_post" value="<?= $post->getID_post() ?>">
                            <input type="hidden" name="origin" value="<?= $_SERVER['REQUEST_URI'] ?>">
                            <button class="button is-ghost is-pulled-left m-0 p-1" type="submit">
                                <span class="blue-text has-text-weight-bold"><?= $likesNumber ?></span>
                            </button>
                        </form>
                    <?php else : ?>
                        <button class="button is-ghost is-pulled-left m-0 p-1">
                            <span class="blue-text has-text-weight-bold is-pulled-left"><?= $likesNumber ?></span>
                        </button>
                    <?php endif; ?>
                    <!-- Vérification, le post est-il liké par l'utilisateur connecté ? -->
                    <?php $hasLiked = false; ?>
                    <?php foreach ($likes as $like) : ?>
                        <?php if ($_SESSION['ID_user'] == $like->getID_user()) : ?>
                            <!-- Si oui, lien de dislike -->
                            <?php $hasLiked = true; ?>
                            <a href="<?= LOCALPATH ?>like/dislikePost/<?= $like->getID_like() ?>" class="button is-ghost m-0 p-1 is-pulled-left">
                                <span class="icon">
                                    <i class="fa-solid fa-thumbs-down" style="color: var(--blue);"></i>
                                </span>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <?php if (!$hasLiked) : ?>
                        <!-- Si non, formulaire caché de like -->
                        <form action="<?= LOCALPATH ?>like/likePost" method="post">
                            <input type="hidden" name="ID_post" value="<?= $post->getID_post() ?>">
                            <input type="hidden" name="ID_user" value="<?= $_SESSION['ID_user'] ?>">
                            <input type="hidden" name="origin" value="<?= $_SERVER['REQUEST_URI'] ?>">
                            <button class="button is-ghost m-0 p-1 is-pulled-left" type="submit">
                                <span class="icon">
                                    <i class="fa-solid fa-thumbs-up" style="color: var(--blue);"></i>
                                </span>
                            </button>
                        </form>
                    <?php endif; ?>

                    <!-- Auteur et date -->
                    <h2 class="subtitle is-6 is-pulled-right">Par : <?= $user->getUsername() ?> le <?= $post->getPost_date() ?> </h2>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php else : ?>
    <div class="column is-4 is-offset-4">
        <div class="box has-text-centered">
            <p><?= $user->getUsername() ?> n'as posté aucun contenu.</p>
        </div>
    </div>
<?php endif; ?>
</div>


<?php require_once 'Views/footer.php'; ?>