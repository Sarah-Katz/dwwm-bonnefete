<?php
require_once 'Views/header.php';
require_once 'Views/navbar.php';
?>

<div class="column is-2 is-offset-10 has-text-weight-bold">
    <a href="<?php echo LOCALPATH ?>user/profile/<?= $user->getID_user() ?>" class="button orange-background">Retour</a>
</div>

<div class="column is-4 is-offset-4">
    <h1 class="title blue-text has-text-centered">Modification du profil</h1>

    <?php if ($error) : ?>
        <div class="notification alert-danger has-text-centered has-text-danger"> <?= $error ?> </div>
    <?php endif ?>

    <form class="card" action="../profileEdit/<?= $user->getID_user() ?>" method="post">
        <div class="card-content">
            <div class="field">
                <label class="label" for="email">Email:</label>
                <p class="control has-icons-left">
                    <input class="input" type="email" name="email" id="email" required value="<?= $user->getEmail() ?>">
                    <span class="icon is-small is-left">
                        <i class="fas fa-envelope"></i>
                    </span>
                </p>
            </div>

            <div class="field">
                <label class="label" for="emailConfirm">Confirmez votre Email:</label>
                <p class="control has-icons-left">
                    <input class="input" type="email" name="emailConfirm" id="emailConfirm" required>
                    <span class="icon is-small is-left">
                        <i class="fas fa-envelope"></i>
                    </span>
                </p>
            </div>

            <div class="field">
                <label class="label" for="name">Nom d'utilisateur:</label>
                <p class="control has-icons-left">
                    <input class="input" type="text" name="username" id="name" required value="<?= $user->getUsername() ?>">
                    <span class="icon is-small is-left">
                        <i class="fas fa-solid fa-user"></i>
                    </span>
                </p>
            </div>

            <div class="buttons is-centered">
                <input class="button is-success" type="submit" value="Confirmer les changements">
            </div>
        </div>
    </form>

    <form class="card mt-2" action="../passwordEdit/<?= $user->getID_user() ?>" method="post">
        <div class="card-content">

            <div class="field">
                <label class="label" for="oldPassword">Ancien Mot de Passe:</label>
                <p class="control has-icons-left">
                    <input class="input" type="password" name="oldPassword" id="oldPassword" required>
                    <span class="icon is-small is-left">
                        <i class="fas fa-lock"></i>
                    </span>
                </p>
            </div>

            <div class="field">
                <label class="label" for="password">Nouveau Mot de Passe:</label>
                <p class="control has-icons-left">
                    <input class="input" type="password" name="password" id="password" required>
                    <span class="icon is-small is-left">
                        <i class="fas fa-lock"></i>
                    </span>
                </p>
            </div>

            <div class="field">
                <label class="label" for="passwordConfirm">Confirmez le Mot de Passe:</label>
                <p class="control has-icons-left">
                    <input class="input" type="password" name="passwordConfirm" id="passwordConfirm" required>
                    <span class="icon is-small is-left">
                        <i class="fas fa-lock"></i>
                    </span>
                </p>
            </div>

            <div class="buttons is-centered">
                <input class="button is-success" type="submit" value="Changer le mot de passe">
            </div>

        </div>
    </form>
</div>

<!-- Boutons conditionels de promotion et de suppression de profil -->
<!-- Promotion -->
<?php if ($user->getID_role() == 1) : ?>
    <div class="column is-2 is-offset-10 has-text-weight-bold">
        <a href="../makeMod/<?= $user->getID_user() ?>" class="button is-warning">Promouvoir en modérateur</a>
    </div>
<?php endif; ?>
<!-- Destitution -->
<?php if ($user->getID_role() == 2) : ?>
    <div class="column is-2 is-offset-10 has-text-weight-bold">
        <a href="../demoteMod/<?= $user->getID_user() ?>" class="button is-warning">Destituer le modérateur</a>
    </div>
<?php endif; ?>
<!-- Suppression -->
<?php if (($_SESSION['ID_user'] == $user->getID_user() || $_SESSION['ID_role'] == 2 || $_SESSION['ID_role'] == 3) && ($user->getID_role() != 3)) : ?>
    <div class="column is-2 is-offset-10 has-text-weight-bold">
        <a href="<?php echo LOCALPATH ?>user/delete/<?= $user->getID_user() ?>" class="button is-danger">Désactiver le profil</a>
    </div>
<?php endif; ?>

<?php require_once 'Views/footer.php'; ?>