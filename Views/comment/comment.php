<?php
$user = $userModel->getUserById($comment->getID_user());
$likes = $likeModel->getLikesByCommentId($comment->getID());
$likesNumber = count($likes);
$nestedComments = $commentModel->getCommentsByCommentId($comment->getID());
$nestedCommentsNumber = count($nestedComments);
?>
<div class="columns is-centered">
    <div class="column is-3 p-0">
        <div class="card column p-2">
            <div class="card-content p-2 pb-5">
                <!-- Auteur et date -->
                <h2 class="subtitle is-6 m-0">
                    <span class="has-text-weight-bold"><?= $user->getUsername() ?></span>
                    <span>le <?= $comment->getTimestamp() ?>
                </h2></span>
                <!-- Condition d'affichage des boutons d'édition-->
                <div class="buttons is-pulled-right">
                    <?php if ($_SESSION['ID_user'] == $comment->getID_user()) : ?>
                        <a class="button is-ghost m-0 p-1" href="<?php echo LOCALPATH ?>comment/edit/<?= $comment->getID() ?>"><i class="fas fa-xl fa-pen" style="color: var(--orange);"></i></a>
                    <?php endif ?>
                    <?php if ($_SESSION['ID_user'] == $comment->getID_user() || $_SESSION['ID_role'] === 2 || $_SESSION['ID_role'] === 3) : ?>
                        <form action="<?= LOCALPATH ?>user/confirm" method="post">
                            <input type="hidden" name="action" value="deleteComment">
                            <input type="hidden" name="ID" value="<?= $comment->getID() ?>">
                            <button class="button is-ghost m-0 p-1"><i class=" fas fa-xl fa-trash" style="color: red;"></i></button>
                        </form>
                </div>
            <?php endif; ?>
            <!-- Message -->
            <div class="content is-large has-border">
                <?= $comment->getMessage() ?>
            </div>

            <!-- Gestion des likes -->
            <?php if ($likes) : ?>
                <form action="<?= LOCALPATH ?>like/showLikes" method="post">
                    <input type="hidden" name="ID_comment" value="<?= $comment->getID() ?>">
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
            <!-- Vérification, le comment est-il liké par l'utilisateur connecté ? -->
            <?php $hasLiked = false; ?>
            <?php foreach ($likes as $like) : ?>
                <?php if ($_SESSION['ID_user'] == $like->getID_user()) : ?>
                    <!-- Si oui, form de dislike -->
                    <?php $hasLiked = true; ?>
                    <form action="<?= LOCALPATH ?>like/dislikeComment" method="post">
                        <input type="hidden" name="ID_like" value="<?= $like->getID_like() ?>">
                        <input type="hidden" name="ID_post" value="<?= $post->getID_post() ?>">
                        <input type="hidden" name="ID_comment" value="<?= $comment->getID() ?>">
                        <input type="hidden" name="ID_user" value="<?= $_SESSION['ID_user'] ?>">
                        <input type="hidden" name="origin" value="<?= $_SERVER['REQUEST_URI'] ?>">
                        <?php if ($isNested) : ?>
                            <input type="hidden" name="isNested" value="1">
                        <?php else : ?>
                            <input type="hidden" name="isNested" value="0">
                        <?php endif; ?>
                        <button class="button is-ghost m-0 p-1 is-pulled-left" type="submit">
                            <span class="icon">
                                <i class="fa-solid fa-thumbs-down" style="color: var(--blue);"></i>
                            </span>
                        </button>
                    </form>
                <?php endif; ?>
            <?php endforeach; ?>
            <?php if (!$hasLiked) : ?>
                <!-- Si non, formulaire caché de like -->
                <form action="<?= LOCALPATH ?>like/likeComment" method="post">
                    <input type="hidden" name="ID_post" value="<?= $post->getID_post() ?>">
                    <input type="hidden" name="ID_comment" value="<?= $comment->getID() ?>">
                    <input type="hidden" name="ID_user" value="<?= $_SESSION['ID_user'] ?>">
                    <input type="hidden" name="origin" value="<?= $_SERVER['REQUEST_URI'] ?>">
                    <?php if ($isNested) : ?>
                        <input type="hidden" name="isNested" value="1">
                    <?php else : ?>
                        <input type="hidden" name="isNested" value="0">
                    <?php endif; ?>
                    <button class="button is-ghost m-0 p-1 is-pulled-left" type="submit">
                        <span class="icon">
                            <i class="fa-solid fa-thumbs-up" style="color: var(--blue);"></i>
                        </span>
                    </button>
                </form>
            <?php endif; ?>

            <!-- Gestion des commentaires -->
            <?php if ($isFirst) : ?>
                <form action="<?= LOCALPATH ?>comment/showComments" method="post">
                    <input type="hidden" name="ID_post" value="<?= $post->getID_post() ?>">
                    <input type="hidden" name="ID_comment" value="<?= $comment->getID() ?>">
                    <input type="hidden" name="origin" value="<?= $_SERVER['REQUEST_URI'] ?>">
                    <button class="button is-ghost is-pulled-left m-0 p-1" type="submit">
                        <span class="blue-text is-pulled-left"><?= $nestedCommentsNumber ?> Commentaires</span>
                    </button>
                </form>
            <?php endif; ?>
            </div>
        </div>
    </div>
</div>