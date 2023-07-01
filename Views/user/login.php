<?php require_once 'Views/header.php'; ?>

<div class="column is-4 is-offset-4">

    <h1 class="title blue-text has-text-centered">Connectez-vous !</h1>
    <?php if ($error === "success") : ?>
        <div class="notification alert-success has-text-centered has-text-success"> Compte créé avec succès, merci de vous connecter </div>
    <?php elseif ($error === "reactivated") : ?>
        <div class="notification alert-success has-text-centered has-text-success"> Compte réactivé avec succès, merci de vous connecter </div>
    <?php elseif ($error) : ?>
        <div class="notification alert-danger has-text-centered has-text-danger"> <?= $error ?> </div>
    <?php endif; ?>
    <form class="card" action="../user/login" method="post">
        <div class="card-content">
            <div class="field">
                <label class="label has-text-left" for="email">Email:</label>
                <p class="control has-icons-left">
                    <input class="input" type="email" name="email" id="email" required>
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

            <div class="buttons is-centered">
                <a href="http://localhost<?php echo LOCALPATH ?>user/register" class="button blue-background has-text-white">S'incrire</a>
                <input type="submit" class="button is-success" value="Connexion"></input>
            </div>
        </div>
    </form>
</div>

<?php require_once 'Views/footer.php'; ?>