<?php

use App\Models\UserModel;
use App\Models\LikeModel;

require_once 'Views/header.php';
require_once 'Views/navbar.php';
?>

<?php if ($_SESSION['ID_role'] == 1) : ?>
    <div class="column is-4 is-offset-4 mt-2 mb-2">
        <form class="card" action="../post/feed" method="post">
            <div class="card-content">
                <div class="field has-addons">
                    <p class="control has-icons-left is-expanded">
                        <input class="input" type="text" name="message" id="message" maxlength="200" required>
                        <span class="icon is-small is-left">
                            <i class="fa-solid fa-comment"></i>
                        </span>
                    </p>
                    <input type="hidden" name="ID_user" value="<?= $_SESSION['ID_user'] ?>">
                    <div class="control">
                        <input type="submit" class="button blue-background has-text-white" value="Envoyer"></input>
                    </div>
                </div>
            </div>
        </form>
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
                    <a href="<?= LOCALPATH ?>user/profile/<?= $user->getID_user() ?>" class="subtitle is-6 is-pulled-right">Par : <?= $user->getUsername() ?> le <?= $post->getPost_date() ?> </a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php require_once 'Views/footer.php'; ?>