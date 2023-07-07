<?php
require_once 'Views/header.php';
require_once 'Views/navbar.php';
?>

<!-- Confirmation de déconnexion -->
<?php if ($action == 'logout') : ?>
    <div class="column is-4 is-offset-4">
        <div class="box">
            <p class="title has-text-centered is-4">
                Confirmez vous vouloir vous déconnecter ?
            </p>
            <div class="buttons is-centered">
                <a href="<?= LOCALPATH ?>post/feed">
                    <button class="button is-danger">
                        <span class="icon">
                            <i class="fa-solid fa-left-long"></i>
                        </span>
                        <span>Non</span>
                    </button>
                </a>
                <a href="<?= LOCALPATH ?>user/logout">
                    <button class="button is-success">
                        <span class="icon">
                            <i class="fas fa-sign-out-alt"></i>
                        </span>
                        <span>Oui</span>
                    </button>
                </a>
            </div>
        </div>
    </div>
    <!-- Confirmation de modification de commentaire -->
<?php elseif ($action == 'editComment') : ?>
    <div class="column is-4 is-offset-4">
        <form class="card" action="<?= LOCALPATH ?>comment/edit" method="post">
            <div class="card-content">
                <p class="title has-text-centered is-4">
                    Confirmez vous vouloir modifier le commentaire ?
                </p>
                <input type="hidden" name="message" id="message" value="<?= $post['message'] ?>">
                <input type="hidden" name="id" value="<?= $post['id'] ?>">
                <div class="buttons is-centered">
                    <a href="<?= LOCALPATH ?>post/feed" class="button is-danger">
                        <span class="icon"> <i class="fa-solid fa-left-long"></i></span>
                        <span>Non</span>
                    </a>
                    <button type="submit" class="button is-success">
                        <span class="icon">
                            <i class="fa-solid fa-check"></i>
                        </span>
                        <span>Oui</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
    <!-- Confirmation de suppression du post -->
<?php elseif ($action == 'deletePost') : ?>
    <div class="column is-4 is-offset-4">
        <div class="card">
            <div class="card-content">
                <p class="title has-text-centered is-4">
                    Confirmez vous vouloir supprimer le message ?
                </p>
                <div class="buttons is-centered">
                    <a href="<?= LOCALPATH ?>post/feed" class="button is-danger">
                        <span class="icon">
                            <i class="fa-solid fa-left-long"></i>
                        </span>
                        <span>Non</span>
                    </a>
                    <a href="<?= LOCALPATH ?>post/deletePost/<?= $post['ID_post'] ?>" class="button is-success">
                        <span class="icon">
                            <i class="fa-solid fa-check"></i>
                        </span>
                        <span>Oui</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Confirmation de suppression du commentaire -->
<?php elseif ($action == 'deleteComment') : ?>
    <div class="column is-4 is-offset-4">
        <div class="card">
            <div class="card-content">
                <p class="title has-text-centered is-4">
                    Confirmez vous vouloir supprimer le commentaire ?
                </p>
                <div class="buttons is-centered">
                    <a href="<?= LOCALPATH ?>post/feed" class="button is-danger">
                        <span class="icon">
                            <i class="fa-solid fa-left-long"></i>
                        </span>
                        <span>Non</span>
                    </a>
                    <a href="<?= LOCALPATH ?>comment/deleteComment/<?= $post['ID'] ?>" class="button is-success">
                        <span class="icon">
                            <i class="fa-solid fa-check"></i>
                        </span>
                        <span>Oui</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Confirmation de modification du profil -->
<?php elseif ($action == 'editUser') : ?>
    <div class="column is-4 is-offset-4">
        <form class="card" action="<?= LOCALPATH ?>user/edit" method="post">
            <div class="card-content">
                <p class="title has-text-centered is-4">
                    Confirmez vous vouloir modifier l'utilisateur ?
                </p>
                <input type="hidden" name="email" id="email" value="<?= $post['email'] ?>">
                <input type="hidden" name="emailConfirm" id="emailConfirm" value="<?= $post['emailConfirm'] ?>">
                <input type="hidden" name="username" id="username" value="<?= $post['username'] ?>">
                <input type="hidden" name="ID_user" value="<?= $post['ID_user'] ?>">
                <div class="buttons is-centered">
                    <a href="<?= LOCALPATH ?>post/feed" class="button is-danger">
                        <span class="icon">
                            <i class="fa-solid fa-left-long"></i>
                        </span>
                        <span>Non</span>
                    </a>
                    <button type="submit" class="button is-success">
                        <span class="icon">
                            <i class="fa-solid fa-check"></i>
                        </span>
                        <span>Oui</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
    <!-- Confirmation de modification du mot de passe -->
<?php elseif ($action == 'editPassword') : ?>
    <div class="column is-4 is-offset-4">
        <form class="card" action="<?= LOCALPATH ?>user/passwordEdit" method="post">
            <div class="card-content">
                <p class="title has-text-centered is-4">
                    Confirmez vous vouloir modifier le mot de passe de l'utilisateur ?
                </p>
                <input type="hidden" name="oldPassword" id="oldPassword" value="<?= $post['oldPassword'] ?>">
                <input type="hidden" name="password" id="password" value="<?= $post['password'] ?>">
                <input type="hidden" name="passwordConfirm" id="passwordConfirm" value="<?= $post['passwordConfirm'] ?>">
                <input type="hidden" name="ID_user" value="<?= $post['ID_user'] ?>">
                <div class="buttons is-centered">
                    <a href="<?= LOCALPATH ?>post/feed" class="button is-danger">
                        <span class="icon">
                            <i class="fa-solid fa-left-long"></i>
                        </span>
                        <span>Non</span>
                    </a>
                    <button type="submit" class="button is-success">
                        <span class="icon">
                            <i class="fa-solid fa-check"></i>
                        </span>
                        <span>Oui</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
    <!-- Confirmation de modification du mot de passe par un admin-->
<?php elseif ($action == 'editPasswordAdmin') : ?>
    <div class="column is-4 is-offset-4">
        <form class="card" action="<?= LOCALPATH ?>user/passwordEditAdmin" method="post">
            <div class="card-content">
                <p class="title has-text-centered is-4">
                    Confirmez vous vouloir modifier le mot de passe de l'utilisateur ?
                </p>
                <input type="hidden" name="password" id="password" value="<?= $post['password'] ?>">
                <input type="hidden" name="passwordConfirm" id="passwordConfirm" value="<?= $post['passwordConfirm'] ?>">
                <input type="hidden" name="ID_user" value="<?= $post['ID_user'] ?>">
                <div class="buttons is-centered">
                    <a href="<?= LOCALPATH ?>post/feed" class="button is-danger">
                        <span class="icon">
                            <i class="fa-solid fa-left-long"></i>
                        </span>
                        <span>Non</span>
                    </a>
                    <button type="submit" class="button is-success">
                        <span class="icon">
                            <i class="fa-solid fa-check"></i>
                        </span>
                        <span>Oui</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
    <!-- Confirmation de la suppression d'un utilisateur -->
<?php elseif ($action == 'deleteUser') : ?>
    <div class="column is-4 is-offset-4">
        <div class="card">
            <div class="card-content">
                <p class="title has-text-centered is-4">
                    Confirmez vous vouloir désactiver l'utilisateur ?
                </p>
                <div class="buttons is-centered">
                    <a href="<?= LOCALPATH ?>post/feed" class="button is-danger">
                        <span class="icon">
                            <i class="fa-solid fa-left-long"></i>
                        </span>
                        <span>Non</span>
                    </a>
                    <a href="<?php echo LOCALPATH ?>user/delete/<?= $post['ID_user'] ?>" class="button is-success">
                        <span class="icon">
                            <i class="fa-solid fa-check"></i>
                        </span>
                        <span>Oui</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php require_once 'Views/logButton.php'; ?>
<?php require_once 'Views/footer.php'; ?>