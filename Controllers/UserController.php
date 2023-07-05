<?php

namespace App\Controllers;

require_once 'Models/UserModel.php';
require_once 'Models/PostModel.php';

use App\Models\UserModel;
use App\Models\PostModel;

class UserController {
    protected $userModel;
    protected $postModel;

    public function __construct() {
        $this->userModel = new UserModel();
        $this->postModel = new PostModel();
    }

    public function getRegister() {
        $error = "";
        require_once 'Views/user/register.php';
    }

    public function postRegister() {
        $user = $_POST;
        $check = $this->userModel->createUser($user);
        if ($check == "success") {
            $error = "success";
            require_once 'Views/user/login.php';
        } elseif ($check == "reactivated") {
            $error = "reactivated";
            require_once 'Views/user/login.php';
        } elseif ($check == "doubleEmail") {
            $error = "Email déjà enregistré";
            require_once 'Views/user/register.php';
        } elseif ($check == "emailConfirm") {
            $error = "Les deux emails ne sont pas identiques";
            require_once 'Views/user/register.php';
        } elseif ($check == "passwordConfirm") {
            $error = "Les deux mots de passe ne sont pas identiques";
            require_once 'Views/user/register.php';
        } elseif ($check == "empty") {
            $error = "Veuillez remplir tous les champs";
            require_once 'Views/user/register.php';
        }
    }

    public function getLogin() {
        $error = "";
        require_once 'Views/user/login.php';
    }

    public function postLogin() {
        $user = $_POST;
        $check = $this->userModel->login($user);
        if ($check === "true") {
            // Rediriger vers le fil des posts
            header('Location:../post/feed');
        } elseif ($check === "email") {
            // Rediriger vers le login avec erreur
            $error = "Aucun compte trouvé avec cet email";
            require_once 'Views/user/login.php';
        } elseif ($check === "inactive") {
            $error = "Votre compte est désactivé, merci de vous réinscrire avec cet email";
            require_once 'Views/user/login.php';
        } else {
            // Rediriger vers le login avec erreur
            $error = "Erreur d'authentification";
            require_once 'Views/user/login.php';
        }
    }

    public function getLogout() {
        session_destroy();
        header('Location: ../user/login');
    }

    public function postSearch() {
        $searchTerm = $_POST['searchTerm'];
        if ($searchTerm) {
            $users = $this->userModel->getUsersByUsername($searchTerm);
            $this->getSearch($users);
        } else {
            $users = $this->userModel->getUsers();
            $searchTerm = ' ';
            $this->getSearch($users);
        }
    }

    public function getSearch($users) {
        require_once 'Views/user/search.php';
    }

    public function getProfile($userId) {
        $user = $this->userModel->getUserById($userId);
        $posts = $this->postModel->getPostsByUserId($userId);
        require_once 'Views/user/profile.php';
    }

    public function getProfileEdit($userId) {
        $user = $this->userModel->getUserById($userId);
        $error = "";
        require_once 'Views/user/profileEdit.php';
    }

    public function postProfileEdit($userId) {
        $user = $_POST;
        $check = $this->userModel->editUser($user, $userId);
        if ($check == "success") {
            header('Location:../profile/' . $userId);
        } elseif ($check == "emailConfirm") {
            $error = "Les deux emails ne sont pas identiques";
            $user = $this->userModel->getUserById($userId);
            require_once 'Views/user/profileEdit.php';
        } elseif ($check == "emailUsed") {
            $error = "Email déjà enregistré";
            $user = $this->userModel->getUserById($userId);
            require_once 'Views/user/profileEdit.php';
        } elseif ($check == "empty") {
            $error = "Veuillez remplir tous les champs";
            $user = $this->userModel->getUserById($userId);
            require_once 'Views/user/profileEdit.php';
        }
    }

    public function postPasswordEdit() {
        $user = $_POST;
        $userId = $user['ID_user'];
        $check = $this->userModel->editPassword($user, $userId);
        if ($check == "success") {
            header('Location:../user/profile/' . $userId);
        } elseif ($check == "passwordConfirm") {
            $error = "Les deux mots de passe ne sont pas identiques";
            $user = $this->userModel->getUserById($userId);
            require_once 'Views/user/profileEdit.php';
        } elseif ($check == "noVerify") {
            $error = "Votre ancien mot de passe est incorrect";
            $user = $this->userModel->getUserById($userId);
            require_once 'Views/user/profileEdit.php';
        } elseif ($check == "empty") {
            $error = "Veuillez remplir tous les champs";
            $user = $this->userModel->getUserById($userId);
            require_once 'Views/user/profileEdit.php';
        }
    }

    public function postPasswordEditAdmin() {
        $user = $_POST;
        $userId = $user['ID_user'];
        $check = $this->userModel->editPasswordAdmin($user, $userId);
        if ($check == "success") {
            header('Location:../user/profile/' . $userId);
        } elseif ($check == "passwordConfirm") {
            $error = "Les deux mots de passe ne sont pas identiques";
            $user = $this->userModel->getUserById($userId);
            require_once 'Views/user/profileEdit.php';
        } elseif ($check == "empty") {
            $error = "Veuillez remplir tous les champs";
            $user = $this->userModel->getUserById($userId);
            require_once 'Views/user/profileEdit.php';
        }
    }

    public function getEdit($userId) {
        $user = $this->userModel->getUserById($userId);
        require_once 'Views/user/edit.php';
    }

    public function postEdit() {
        $user = $_POST;
        $this->userModel->editUser($user, $user['ID_user']);
        $this->getProfile($user['ID_user']);
    }

    public function getDelete($id) {
        $this->userModel->deleteUser($id);
        if ($_SESSION['ID_role'] == 2 || $_SESSION['ID_role'] == 3) {
            header('Location:../profile/' . $id);
        } elseif ($_SESSION['ID_user'] == $id || $_SESSION['ID_role'] == 1) {
            session_destroy();
            header('Location: ../login');
        }
    }

    public function getCgu() {
        require_once 'Views/cgu.php';
    }

    public function getMakeMod($id) {
        $this->userModel->makeModerator($id);
        header('Location:../profile/' . $id);
    }

    public function getDemoteMod($id) {
        $this->userModel->demoteModerator($id);
        header('Location:../profile/' . $id);
    }

    public function postConfirm() {
        $action = $_POST['action'];
        $post = $_POST;
        require_once 'Views/user/confirm.php';
    }
}
