<?php require_once 'Views/header.php'; ?>

<form action="http://localhost<?php echo LOCALPATH ?>user/search" method="post">
    <for class="field">
        <label class="label">
            Name</label>
        <div class="control">
            <input class="input" type="text" placeholder="Text input" name="searchTerm">
        </div>
    </for>

    <div class="field is-grouped">
        <div class="control">
            <button class="button is-link">Submit</button>
        </div>
        <div class="control">
            <button class="button is-text">Cancel</button>
        </div>
    </div>
</form>


<?php var_dump($users) ?>

<?php require_once 'Views/footer.php'; ?>