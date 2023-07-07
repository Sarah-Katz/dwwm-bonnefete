<?php require_once 'Views/header.php'; ?>

<div class="column is-4 is-offset-4">
    <h1 class="title blue-text has-text-centered">Inscrivez-vous !</h1>

    <?php if ($error) : ?>
        <div class="notification alert-danger has-text-centered has-text-danger"> <?= $error ?> </div>
    <?php endif ?>

    <form class="card" action="<?= LOCALPATH ?>/user/register" method="post">
        <div class="card-content">
            <div class="field">
                <label class="label" for="email">Email:</label>
                <p class="control has-icons-left">
                    <input class="input" type="email" name="email" id="email" required>
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
                <label class="label" for="password">Mot de Passe:</label>
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

            <div class="field">
                <label class="label" for="name">Nom d'utilisateur:</label>
                <p class="control has-icons-left">
                    <input class="input" type="text" name="name" id="name" required maxlength="25">
                    <span class="icon is-small is-left">
                        <i class="fas fa-solid fa-user"></i>
                    </span>
                </p>
            </div>

            <div class="field">
                <label class="checkbox has-text-weight-bold" for="cgu">
                    <input type="checkbox" name="cgu" id="cgu" required>
                    J'accepte les <a href="http://localhost<?php echo LOCALPATH ?>user/cgu">C.G.U</a>
                </label>
            </div>
            <div class="buttons is-centered">
                <a class="button blue-background has-text-white" href="http://localhost<?php echo LOCALPATH ?>user/login">Retour login</a>
                <input class="button is-success" type="submit" value="S'inscrire">
            </div>
        </div>
    </form>
</div>

<?php require_once 'Views/footer.php'; ?>