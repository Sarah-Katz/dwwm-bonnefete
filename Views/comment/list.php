<?php

use App\Models\UserModel;
use App\Models\PostModel;
use App\Models\LikeModel;
use App\Models\CommentModel;

require_once 'views/header.php';
require_once 'views/navbar.php';
?>

<?php
$userModel = new UserModel();
$postModel = new PostModel();
$likeModel = new LikeModel();
$commentModel = new CommentModel();
$post = $postModel->getPostById($data['ID_post']);
if ($data['ID_comment'] != null) {
    $comments = $commentModel->getCommentsByCommentId($data['ID_comment']);
    $isNested = true;
} else {
    $comments = $commentModel->getCommentsByPostId($data['ID_post']);
    $isNested = false;
}
$posts[] = $post;

$isFirst = true;
if ($isNested) {
    $comment = $commentModel->getCommentById($data['ID_comment']);
    require_once 'views/comment/comment.php';
}

if (!$isNested) {
    require_once 'views/post/post.php';
}
?>
<!-- Formulaire d'ajout de commentaire -->
<form action="<?= LOCALPATH ?>comment/addComment" method="post">
    <div class="column is-4 is-offset-4 mt-2 mb-2">
        <div class="card">
            <span>Ajouter un commentaire</span>
            <div class="card-content">
                <div class="field has-addons">
                    <p class="control has-icons-left is-expanded">
                        <input class="input" type="text" name="message" id="message" maxlength="200" required>
                        <span class="icon is-small is-left">
                            <i class="fa-solid fa-comment"></i>
                        </span>
                    </p>
                    <input type="hidden" name="ID_post" value="<?= $data['ID_post'] ?>">
                    <!-- Si commentaire de commentaire -->
                    <?php if ($data['ID_comment'] != null) : ?>
                        <input type="hidden" name="ID_comment" value="<?= $data['ID_comment'] ?>">
                        <!-- Si commentaire de poste -->
                    <?php else : ?>
                        <input type="hidden" name="ID_comment" value="null">
                    <?php endif; ?>
                    <input type="hidden" name="ID_user" value="<?= $_SESSION['ID_user'] ?>">
                    <input type="hidden" name="origin" value="<?= $_SERVER['REQUEST_URI'] ?>">
                    <div class="control">
                        <input type="submit" class="button blue-background has-text-white" value="Commenter"></input>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<?php
$count = 0;
$isFirst = false;
if (!$isNested) {
    $isFirst = true;
}
foreach ($comments as $comment) {
    require 'views/comment/comment.php';
} ?>

<?php require_once 'views/footer.php'; ?>