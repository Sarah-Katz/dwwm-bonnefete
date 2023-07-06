<nav class="navbar blue-background is-flex is-justify-content-space-between" role="navigation" aria-label="main navigation">
    <div class="navbar-brand column is-4 is-flex-desktop">
        <a href="http://localhost<?php echo LOCALPATH ?>post/feed">
            <img class="image is-48x48" id="logo" src="http://localhost<?php echo LOCALPATH ?>img/logo.png">
        </a>
        <div class="navbar-item is-hidden-mobile">
            <a href="<?= LOCALPATH ?>post/feed" id="logo-name" class="m-0 p-1 has-text-black">Bonnefete</a>
        </div>
    </div>

    <div class="column is-4 is-5-mobile">
        <form class="form" action="<?php echo LOCALPATH ?>user/search" method="post">
            <div class="control has-icons-right">
                <input class="input is-rounded" type="search" name="searchTerm" placeholder="Recherchez un utilisateur">
                <div class="icon is-small is-right">
                    <i class="fas fa-search"></i>
                </div>
            </div>
        </form>
    </div>

    <div class="navbar-end">
        <div class="navbar-item">
            <p class="has-text-white is-hidden-mobile">Bonjour, <span class="orange-text has-text-weight-bold"><?= ucfirst(strtolower($_SESSION['username'])) ?></span>
            </p>
            <div class="buttons">
                <a href="<?php echo LOCALPATH ?>user/profile/<?php echo $_SESSION['ID_user'] ?>" class="button blue-background button-no-border is-rounded">
                    <i class="fa-xl fa-solid fa-user" style="color: white;"></i>
                </a>
                <form action="<?php echo LOCALPATH ?>user/confirm" method="post">
                    <input type="hidden" name="action" value="logout">
                    <button type="submit" href="" class="button is-rounded button-no-border">
                        <i class="fa-xl fa-solid fa-right-to-bracket" style="color: #ff0000;"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>