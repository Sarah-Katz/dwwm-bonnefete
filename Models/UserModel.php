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
        var_dump($user);
        $password = password_hash($user['password'], PASSWORD_DEFAULT);
        var_dump($password);
        try {
            $query = $this->connection->getPdo()->prepare("INSERT INTO users (email, password, username, register_date) VALUES (:email, :password, :username, :register_date)");
            $query->execute([
                'email' => $user['email'],
                'password' => $password,
                'username' => $user['name'],
                'register_date' => date('y-m-d h:i:s')
            ]);
            return "Bien enregistré";
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
            $query = $this->connection->getPdo()->prepare("UPDATE users SET email = :email, username = :username WHERE ID_user = :id");
            $query->execute([
                'email' => $user['email'],
                'username' => $user['username'],
                'id' => $userId
            ]);
            return "Bien enregistré";
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return " une erreur est survenue";
        }
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

        $query = $this->connection->getPdo()->prepare("SELECT password FROM users WHERE email = :email");
        $query->execute(['email' => $email]);
        $passBdd = $query->fetch();
        if (password_verify($password, $passBdd['password'])) {
            $query = $this->connection->getPdo()->prepare("SELECT username FROM users WHERE email = :email");
            $query->execute(['email' => $email]);
            $userCo = $query->fetch(PDO::FETCH_ASSOC);
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $password;
            $_SESSION['username'] = $userCo['username'];
            return true;
        } else {
            return false;
        }
    }
}