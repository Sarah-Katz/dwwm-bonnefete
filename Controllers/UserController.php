<?php

namespace App\Controllers;

require_once 'Models/UserModel.php';

use App\Models\UserModel;

class UserController {
    protected $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function getRegister() {
        require_once 'Views/user/register.php';
    }

    public function postRegister() {
        $user = $_POST;
        $message = $this->userModel->createUser($user);
        echo $message;
        echo '<a href="../user/login>Se connecter</a>"';
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
        } elseif($check === "inactive") {
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
        require_once 'Views/user/profile.php';
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
        header('Location: ../login');
    }
}
