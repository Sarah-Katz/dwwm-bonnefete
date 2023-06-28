<?php require_once 'Views/header.php'; ?>

<form action="../user/register" method="post">
    <div class="form-group">
        <label for="email">Email:</label>
        <input class="form-control" type="email" name="email" id="email" required>
    </div>

    <div class="form-group">
        <label for="emailConfirm">Confirmez votre Email:</label>
        <input class="form-control" type="email" name="emailConfirm" id="emailConfirm" required>
    </div>

    <div class="form-group">
        <label for="password">Mot de Passe:</label>
        <input class="form-control" type="password" name="password" id="password" required>
    </div>

    <div class="form-group">
        <label for="passwordConfirm">Confirmez le Mot de Passe:</label>
        <input class="form-control" type="password" name="passwordConfirm" id="passwordConfirm" required>
    </div>

    <div class="form-group">
        <label for="name">Nom d'utilisateur:</label>
        <input class="form-control" type="text" name="name" id="name" required>
    </div>

    <div class="form-group">
        <input class="form-check-input" type="checkbox" name="cgu" id="cgu" required>
        <label class="form-check-label" for="cgu">J'accepte les <a href="http://">C.G.U</a></label>
    </div>
    <input class="button is-primary" type="submit" value="S'inscrire">
</form>

<?php require_once 'Views/footer.php'; ?>