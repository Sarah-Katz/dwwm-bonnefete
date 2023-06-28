<?php require_once 'Views/header.php'; ?>

<form action="<?php echo LOCALPATH ?>user/edit" method="post">
    <div class="form-group">
        <label for="email">Adresse email</label>
        <input type="email" class="form-control" name="email" id="email" value="<?php echo $user->getEmail() ?>">
    </div>
    <div class="form-group">
        <label for="username">Nom d'utilisateur</label>
        <input type="text" class="form-control" name="username" id="username" value="<?php echo $user->getUsername() ?>">
    </div>
    <input type="hidden" name="ID_user" value="<?php echo $user->getID_user() ?>">
    <button type="submit">Modifier le profil</button>
</form>

<form action="<?php echo LOCALPATH ?>user/editPassword" method="post">
    <div class="form-group">
        <label for="password">Ancien mot de passe</label>
        <input type="password" class="form-control" name="password" id="password" value="">
    </div>
    <div class="form-group">
        <label for="newPassword">Nouveau mot de passe</label>
        <input type="password" class="form-control" name="newPassword" id="newPassword" value="">
    </div>
    <div class="form-group">
        <label for="newPasswordConfirm">Confirmez le nouveau mot de passe</label>
        <input type="password" class="form-control" name="newPasswordConfirm" id="newPasswordConfirm" value="">
    </div>
    <button type="submit" disabled>Modifier le mot de passe</button>
</form>

<!-- Bouton de suppréssion du profil -->
<a href="../delete/<?php echo $user->getID_user() ?>" class="button is-danger">Effacer le profil</a>

<?php require_once 'Views/footer.php'; ?>
