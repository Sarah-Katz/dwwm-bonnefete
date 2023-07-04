<?php
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
    <?php require_once 'Views/post/post.php'; ?>
<?php endif; ?>

<?php require_once 'Views/footer.php'; ?>