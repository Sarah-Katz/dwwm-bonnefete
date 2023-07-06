<?php
require_once 'Views/header.php';
require_once 'Views/navbar.php';
?>

<div class="column is-4 is-offset-4 mt-2 mb-2">

    <form class="card" action="<?= LOCALPATH ?>post/edit" method="post" enctype="multipart/form-data">
        <div class="card-content">
            <!-- Image -->
            <?php if ($post->getUrl_image() != null) : ?>
                <div class="level-item">
                    <div class="image pb-5">
                        <img src="<?php echo LOCALPATH . $post->getUrl_image() ?>" alt="">
                    </div>
                </div>
            <?php endif; ?>
            <div class="field has-addons">
                <p class="control has-icons-left is-expanded">
                    <input class="input" type="text" name="message" id="message" maxlength="200" required value="<?= $post->getMessage() ?>">
                    <span class="icon is-small is-left">
                        <i class="fa-solid fa-comment"></i>
                    </span>
                </p>
                <input type="hidden" name="old_url_image" value="<?= $post->getUrl_image() ?>">
                <input type="hidden" name="ID_user" value="<?= $_SESSION['ID_user'] ?>">
                <input type="hidden" name="id" value="<?= $post->getID_post() ?>">
                <div class="control">
                    <input type="submit" class="button blue-background has-text-white" value="Modifier"></input>
                </div>
            </div>
            <!-- Input images -->
            <div class="file is-small is-boxed">
                <label class="file-label">
                    <input class="file-input" type="file" name="image" id="image">
                    <span class="file-cta blue-background p-1 pl-2">
                        <span class="file-icon">
                            <i class="fas fa-image" style="color: white;"></i>
                        </span>
                    </span>
                </label>
            </div>
        </div>
    </form>
</div>

<?php require_once 'Views/logButton.php'; ?>
<?php require_once 'Views/footer.php'; ?>