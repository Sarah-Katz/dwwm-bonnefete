<?php

require_once 'Views/header.php';
require_once 'Views/navbar.php';
require_once 'Models/UserModel.php';
require_once 'Models/PostModel.php';
require_once 'Models/CommentModel.php';

use App\Models\UserModel;
use App\Models\PostModel;
use App\Models\CommentModel;

$userModel = new UserModel();
$postModel = new PostModel();
$commentModel = new CommentModel();
?>

<ul class="column is-4 is-offset-4 has-text-centered">
    <?php foreach ($logs as $log) : ?>
        <?php
        if ($log->getID_user() != null) {
            $user = $userModel->getUserById($log->getID_user());
        }
        if ($log->getID_admin() != null) {
            $admin = $userModel->getUserById($log->getID_admin());
        }
        if ($log->getID_post() != null) {
            $post = $postModel->getPostById($log->getID_post());
        }
        if ($log->getID_comment() != null) {
            $comment = $commentModel->getCommentById($log->getID_comment());
        }
        ?>

        <?php switch ($log->getType()) {
            case 'userCreate':
                echo '<li class="notification">' . $user->getUsername()  . " s'est enregistré.e avec le mail : " . $user->getEmail() . "</li>";
                break;
            case 'userUpdate':
                echo '<li class="notification">' . $user->getUsername()  . " a modifié son profil" . '<br>' . $log->getTimestamp() . "</li>";
            case 'userEditAdmin':
                echo '<li class="notification">Le.a modérateur.ice ' . $admin->getUsername() . " a modifié le profil de : " . $user->getUsername()  . '<br>' . $log->getTimestamp() . "</li>";
                break;
            case 'userEditPass':
                echo '<li class="notification">' . $user->getUsername()  . " a modifié son mot de passe" . '<br>' . $log->getTimestamp() . "</li>";
                break;
            case 'userEditPassAdmin':
                echo '<li class="notification">Le.a modérateur.ice ' . $admin->getUsername() . " a modifié le mot de passe de : " . $user->getUsername()  . '<br>' . $log->getTimestamp() . "</li>";
                break;
            case 'userDelete':
                echo '<li class="notification">' . $user->getUsername()  . " a désactivé son compte" . '<br>' . $log->getTimestamp() . "</li>";
                break;
            case 'userDeleteAdmin':
                echo '<li class="notification">Le.a modérateur.ice ' . $admin->getUsername() . " a désactivé le compte de : " . $user->getUsername()  . '<br>' . $log->getTimestamp() . "</li>";
                break;
            case 'userLogin':
                echo '<li class="notification">' . $user->getUsername()  . " s'est connecté.e" . '<br>' . $log->getTimestamp() . "</li>";
                break;
            case 'userLogout':
                echo '<li class="notification">' . $user->getUsername()  . " s'est déconnecté.e" . '<br>' . $log->getTimestamp() . "</li>";
                break;
            case 'userMakeModerator':
                echo '<li class="notification">' . $user->getUsername()  . " a été promu.e modérateur.ice par " . $admin->getUsername() . '<br>' . $log->getTimestamp() . "</li>";
                break;
            case 'userDemoteModerator':
                echo '<li class="notification">' . $user->getUsername()  . " a été destitué.e modérateur.ice par " . $admin->getUsername() . '<br>' . $log->getTimestamp() . "</li>";
                break;
            case 'userVerify':
                echo '<li class="notification">' . $user->getUsername()  . " a vérifié.e son email : " . $user->getEmail() . '<br>' . $log->getTimestamp() . "</li>";
                break;
            case 'postCreate':
                echo '<li class="notification">' . $user->getUsername()  . " a publié un poste ID : " . $log->getID_post() . '<br>' . $log->getTimestamp() . "</li>";
                break;
            case 'postUpdate':
                echo '<li class="notification">' . $user->getUsername()  . " a modifié un poste ID : " . $log->getID_post() . '<br>' . $log->getTimestamp() . "</li>";
                break;
            case 'postUpdateAdmin':
                echo '<li class="notification">Le.a modérateur.ice ' . $admin->getUsername() . " a modifié un poste ID : " . $log->getID_post() . '<br>' . $log->getTimestamp() . "</li>";
                break;
            case 'postDelete':
                echo '<li class="notification">' . $user->getUsername()  . " a supprimé un poste ID : " . $log->getID_post() . '<br>' . $log->getTimestamp() . "</li>";
                break;
            case 'postDeleteAdmin':
                echo '<li class="notification">Le.a modérateur.ice ' . $admin->getUsername() . " a supprimé un poste ID : " . $log->getID_post() . '<br>' . $log->getTimestamp() . "</li>";
                break;
            case 'commentCreate':
                echo '<li class="notification">' . $user->getUsername()  . " a publié un commentaire ID : " . $log->getID_comment() . '<br>' . $log->getTimestamp() . "</li>";
                break;
            case 'commentUpdate':
                echo '<li class="notification">' . $user->getUsername()  . " a modifié un commentaire ID : " . $log->getID_comment() . '<br>' . $log->getTimestamp() . "</li>";
                break;
            case 'commentUpdateAdmin':
                echo '<li class="notification">Le.a modérateur.ice ' . $admin->getUsername() . " a modifié un commentaire ID : " . $log->getID_comment() . '<br>' . $log->getTimestamp() . "</li>";
                break;
            case 'commentDelete':
                echo '<li class="notification">' . $user->getUsername()  . " a supprimé un commentaire ID : " . $log->getID_comment() . '<br>' . $log->getTimestamp() . "</li>";
                break;
            case 'commentDeleteAdmin':
                echo '<li class="notification">Le.a modérateur.ice ' . $admin->getUsername() . " a supprimé un commentaire ID : " . $log->getID_comment() . '<br>' . $log->getTimestamp() . "</li>";
                break;
            case 'likeCreate':
                if ($log->getID_comment() == null) {
                    echo '<li class="notification">' . $user->getUsername()  . ' à liké le poste ID : ' . $log->getID_post() . '<br>' . $log->getTimestamp() . '</li>';
                } else {
                    echo '<li class="notification">' . $user->getUsername()  . ' à liké le commentaire ID : ' . $log->getID_comment() . '<br>' . $log->getTimestamp() . '</li>';
                }
                break;
            case 'likeDelete':
                if ($log->getID_comment() == null) {
                    echo '<li class="notification">' . $user->getUsername()  . ' à disliké le poste ID : ' . $log->getID_post() . '<br>' . $log->getTimestamp() . '</li>';
                } else {
                    echo '<li class="notification">' . $user->getUsername()  . ' à disliké le commentaire ID : ' . $log->getID_comment() . '<br>' . $log->getTimestamp() . '</li>';
                }
                break;
            default:
                break;
        } ?>
    <?php endforeach; ?>
</ul>
</table>

<?php require_once 'Views/footer.php'; ?>