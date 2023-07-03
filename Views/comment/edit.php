<?php
require_once 'Views/header.php';
require_once 'Views/navbar.php';
?>

<div class="column is-4 is-offset-4 mt-2 mb-2">
    <form class="card" action="<?= LOCALPATH ?>user/confirm" method="post">
        <div class="card-content">
            <div class="field has-addons">
                <p class="control has-icons-left is-expanded">
                    <input class="input" type="text" name="message" id="message" maxlength="200" required value="<?= $comment->getMessage() ?>">
                    <span class="icon is-small is-left">
                        <i class="fa-solid fa-comment"></i>
                    </span>
                </p>
                <input type="hidden" name="id" value="<?= $comment->getID() ?>">
                <input type="hidden" name="action" value="editComment">
                <div class="control">
                    <input type="submit" class="button blue-background has-text-white" value="Modifier"></input>
                </div>
            </div>
        </div>
    </form>
</div>

<?php require_once 'Views/footer.php'; ?>