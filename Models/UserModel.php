<?php

namespace App\Models;

require_once  'Database.php';
require_once 'Models/User.php';

use App\Database;
use PDO;

class UserModel {
    private $connection;

    public function __construct() {
        $this->connection = new Database();
    }

    public function createUser($user) {
        // Verification de la présence d'info dans les champs
        if ($user['email'] == "" || $user['password'] == "" || $user['name'] == "" || $user['passwordConfirm'] == "" || $user['emailConfirm'] == "") {
            return "empty";
        }
        // Verification de la concordance des champs Email
        if ($user['email'] != $user['emailConfirm']) {
            return "emailConfirm";
        }
        // Verification de la concordance des champs de mot de passe
        if ($user['password'] != $user['passwordConfirm']) {
            return "passwordConfirm";
        }

        // Vérification du doublon de mail
        $query = $this->connection->getPdo()->prepare('SELECT email, is_active FROM users WHERE email = :email');
        $query->execute(['email' => $user['email']]);
        $mailCheck = $query->fetch();
        if ($mailCheck) {
            //  Si l'utilisateur existe déjà et est actif
            if ($mailCheck['is_active'] == 1) {
                return "doubleEmail";
            } else {
                // Si l'utilisateur existe déjà et n'est pas actif
                $password = password_hash($user['password'], PASSWORD_DEFAULT);
                $query = $this->connection->getPdo()->prepare('UPDATE users SET email = :email, password = :password, username = :name, is_active = :is_active WHERE email = :email');
                $query->execute([
                    'email' => $user['email'],
                    'password' => $password,
                    'name' => $user['name'],
                    'is_active' => 1
                ]);
                return "reactivated";
            }
        }
        // Enregistrement normal d'un utilisateur
        $password = password_hash($user['password'], PASSWORD_DEFAULT);
        try {
            $query = $this->connection->getPdo()->prepare("INSERT INTO users (email, password, username, register_date) VALUES (:email, :password, :username, :register_date)");
            $query->execute([
                'email' => $user['email'],
                'password' => $password,
                'username' => strtoupper($user['name']),
                'register_date' => date('y-m-d h:i:s')
            ]);
            return "success";
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return " une erreur est survenue";
        }
    }

    public function getUsers() {
        $query = $this->connection->getPdo()->prepare("SELECT ID_user, ID_role, username, email, register_date, is_active FROM users");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_CLASS, "App\Models\User");
    }

    public function getUserById($id) {
        $query = $this->connection->getPdo()->prepare("SELECT ID_user, ID_role, username, email, register_date, is_active FROM users WHERE ID_user = :id");
        $query->execute([
            'id' => $id
        ]);
        $query->setFetchMode(PDO::FETCH_CLASS, "App\Models\User");
        return $query->fetch();
    }

    public function getUsersByUsername($username) {
        $query = $this->connection->getPdo()->prepare("SELECT ID_user, ID_role, username, email, register_date, is_active FROM users WHERE username LIKE :username");
        $query->execute([
            'username' => '%' . $username . '%'
        ]);
        return $query->fetchAll(PDO::FETCH_CLASS, "App\Models\User");
    }

    public function editUser($user, $userId) {
        try {
            $oldUser = $this->getUserById($userId);
            // Vérification de la présence d'info dans les champs
            if ($user['email'] == "" || $user['emailConfirm'] == "" || $user['username'] == "") {
                return "empty";
            }
            // Verification de la concordance des champs Email
            if ($user['email'] != $user['emailConfirm']) {
                return "emailConfirm";
            }
            // vérification du doublon de mail
            if ($user['email'] != $oldUser->getEmail()) {
                $query = $this->connection->getPdo()->prepare('SELECT email FROM users WHERE email = :email');
                $query->execute(['email' => $user['email']]);
                $mailCheck = $query->fetch();
                if ($mailCheck) {
                    return "emailUsed";
                }
            }
            // Modification de l'utilisateur
            $query = $this->connection->getPdo()->prepare("UPDATE users SET email = :email, username = :username WHERE ID_user = :id");
            $query->execute([
                'email' => $user['email'],
                'username' => $user['username'],
                'id' => $userId
            ]);
            return "success";
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return " une erreur est survenue";
        }
    }

    public function editPassword($user, $userId) {
        // Vérification de la présence d'info dans les champs
        if ($user['oldPassword'] == "" || $user['password'] == "" || $user['passwordConfirm'] == "") {
            return "empty";
        }
        // Verification de la concordance des champs de mot de passe
        if ($user['password'] != $user['passwordConfirm']) {
            return "passwordConfirm";
        }
        // Vérification de l'ancien mot de passe
        $query = $this->connection->getPdo()->prepare("SELECT password FROM users WHERE ID_user = :id");
        $query->execute([
            'id' => $userId
        ]);
        $passwordCheck = $query->fetch();
        $oldPassword = $user['oldPassword'];
        $passCheck = password_verify($oldPassword, $passwordCheck['password']);
        if (!$passCheck) {
            return "noVerify";
        }
        // Modification de l'utilisateur
        $query = $this->connection->getPdo()->prepare("UPDATE users SET password = :password WHERE ID_user = :id");
        $query->execute([
            'password' => password_hash($user['password'], PASSWORD_DEFAULT),
            'id' => $userId
        ]);
        return "success";
    }

    public function deleteUser($id) {
        try {
            $query = $this->connection->getPdo()->prepare("UPDATE users SET is_active = 0, username = 'Utilisateur désactivé' WHERE ID_user = :id");
            $query->execute([
                'id' => $id
            ]);
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return " une erreur est survenue";
        }
    }

    public function login($user) {
        $email = $user['email'];
        $password = $user['password'];
        // Vérification du mot de passe
        $query = $this->connection->getPdo()->prepare("SELECT password, is_active FROM users WHERE email = :email");
        $query->execute(['email' => $email]);
        $passBdd = $query->fetch();
        // Verification de l'inscription de cet email
        if (!$passBdd) {
            $res = "email";
        } elseif ($passBdd['is_active'] == 0) {
            $res = "inactive";
        } else {
            if (password_verify($password, $passBdd['password'])) {
                $query = $this->connection->getPdo()->prepare("SELECT username, ID_user, ID_role FROM users WHERE email = :email");
                $query->execute(['email' => $email]);
                $userCo = $query->fetch(PDO::FETCH_ASSOC);
                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;
                $_SESSION['username'] = $userCo['username'];
                $_SESSION['ID_user'] = $userCo['ID_user'];
                $_SESSION['ID_role'] = $userCo['ID_role'];
                $res =  "true";
            } else {
                $res = "false";
            }
        }
        return $res;
    }

    public function getRecentPosts($id) {
        $query = $this->connection->getPdo()->prepare("SELECT ID_post, ID_user, message, post_date FROM posts WHERE ID_user = :ID_user ORDER BY post_date DESC LIMIT 2");
        $query->execute([
            'ID_user' => $id
        ]);
        return $query->fetchAll(PDO::FETCH_CLASS, "App\Models\Post");
    }
}
