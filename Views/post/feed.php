<?php

require_once "Models/UserModel.php";

use App\Models\UserModel;

require_once 'Views/header.php';
require_once 'Views/navbar.php'; ?>

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
        ?>
        <div class="column is-4 is-offset-4">
            <div class="card column">
                <div class="card-content">
                    <!-- Condition de propirétaire ou modérateur ou super admin -->
                    <?php if ($_SESSION['ID_user'] == $post->getID_user() || $_SESSION['ID_role'] == 2 || $_SESSION['ID_role'] == 3) : ?>
                        <div class="is-pulled-right">
                            <a href="<?php echo LOCALPATH ?>post/edit/<?= $post->getID_post() ?>"><i class="ml-1 fas fa-xl fa-pen" style="color: var(--orange);"></i></a>
                            <a href="<?php echo LOCALPATH ?>post/deletepost/<?= $post->getID_post() ?>"><i class="ml-1 fas fa-xl fa-trash" style="color: red;"></i></a>
                        </div>
                    <?php endif; ?>
                    <div class="content is-large has-border">
                        <?= $post->getMessage() ?>
                    </div>
                    <h2 class="subtitle is-6 is-pulled-right">Par : <?= $user->getUsername() ?> le <?= $post->getPost_date() ?> </h2>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>



<?php require_once 'Views/footer.php'; ?>