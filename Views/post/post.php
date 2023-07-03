<?php

use App\Models\UserModel;
use App\Models\LikeModel;
use App\Models\CommentModel;
?>
<?php foreach ($posts as $post) : ?>
    <?php
    $userModel = new UserModel();
    $user = $userModel->getUserById($post->getID_user());
    $likeModel = new LikeModel();
    $likes = $likeModel->getLikesByPostId($post->getID_post());
    $likesNumber = $likeModel->countLikesByPostId($post->getID_post());
    $commentModel = new CommentModel();
    $comments = $commentModel->getCommentsByPostId($post->getID_post());
    $commentsNumber = $commentModel->countCommentsByPostId($post->getID_post());
    ?>
    <div class="column is-4 is-offset-4">
        <div class="card column">
            <div class="card-content">
                <!-- Condition d'affichage des boutons d'édition-->
                <div class="buttons is-pulled-right">
                    <?php if ($_SESSION['ID_user'] == $post->getID_user()) : ?>
                        <a class="button is-ghost m-0 p-1" href="<?php echo LOCALPATH ?>post/edit/<?= $post->getID_post() ?>"><i class="fas fa-xl fa-pen" style="color: var(--orange);"></i></a>
                    <?php endif; ?>
                    <?php if ($_SESSION['ID_user'] == $post->getID_user() || $_SESSION['ID_role'] == 2 || $_SESSION['ID_role'] == 3) : ?>
                        <form action="<?= LOCALPATH ?>user/confirm" method="post">
                            <input type="hidden" name="action" value="deletePost">
                            <input type="hidden" name="ID_post" value="<?= $post->getID_post() ?>">
                            <button class="button is-ghost m-0 p-1"><i class=" fas fa-xl fa-trash" style="color: red;"></i></button>
                        </form>
                    <?php endif; ?>
                </div>
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

                <!-- Gestion des commentaires -->
                <form action="<?= LOCALPATH ?>comment/showComments" method="post">
                    <input type="hidden" name="ID_post" value="<?= $post->getID_post() ?>">
                    <input type="hidden" name="ID_comment" value="">
                    <input type="hidden" name="origin" value="<?= $_SERVER['REQUEST_URI'] ?>">
                    <button class="button is-ghost is-pulled-left m-0 p-1" type="submit">
                        <span class="blue-text is-pulled-left"><?= $commentsNumber ?> Commentaires</span>
                    </button>
                </form>

                <!-- Auteur et date -->
                <h2 class="subtitle is-6 is-pulled-right">Par : <?= $user->getUsername() ?> le <?= $post->getPost_date() ?> </h2>
            </div>
        </div>
    </div>
<?php endforeach; ?>