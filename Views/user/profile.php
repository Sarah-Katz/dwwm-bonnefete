<?php
require_once 'Views/header.php';
require_once 'Views/navbar.php';
?>
<div class="columns">
    <div class="column is-2 is-offset-1 mt-6" id="user-infos">
        <div class="box blue-background">
            <div class="card has-text-weight-bold">
                <div class="card-content">
                    <h4 class="card-title">
                        <span class="card-title-text">Nom d'utilisateur:</span>
                    </h4>
                    <span><?= $user->getUsername() ?></span>
                </div>
                <div class="card-content">
                    <h4 class="card-title">
                        <span class="card-title-text">Adresse Email:</span>
                    </h4>
                    <span><?= $user->getEmail() ?></span>
                </div>
                <div class="card-content">
                    <h4 class="card-title">
                        <span class="card-title-text">Date d'inscription:</span>
                    </h4>
                    <span><?= $user->getRegister_date() ?></span>
                </div>
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
<?php else : ?>
    <div class="column is-4 is-offset-4">
        <div class="box has-text-centered">
            <p><?= $user->getUsername() ?> n'as posté aucun contenu.</p>
        </div>
    </div>
<?php endif; ?>
</div>


<?php require_once 'Views/footer.php'; ?>