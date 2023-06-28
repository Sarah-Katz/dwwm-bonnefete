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
        require_once 'Views/user/login.php';
    }

    public function postLogin() {
        $user = $_POST;
    }

    public function getLogout() {
        session_destroy();
        header('Location: ../character/index');
    }
}
