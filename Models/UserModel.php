<?php

namespace App\Models;

require_once  'Database.php';
require_once 'Models/User.php';
require_once 'Models/LogModel.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Database;
use PDO;

class UserModel {
    private $connection;
    private $logger;

    public function __construct() {
        $this->connection = new Database();
        $this->logger = new LogModel();
    }

    public function createUser($user) {
        // Regex de vérification pour le mot de passe
        if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $user['password'])) {
            return "regex";
        }
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
                $key = rand(1, 99999);
                $this->sendVerificationMail($user, $key);
                $password = password_hash($user['password'], PASSWORD_DEFAULT);
                $activation_key = password_hash($key, PASSWORD_DEFAULT);
                $query = $this->connection->getPdo()->prepare('UPDATE users SET email = :email, password = :password, username = :name, activation_key = :activation_key WHERE email = :email');
                $query->execute([
                    'email' => $user['email'],
                    'password' => $password,
                    'name' => $user['name'],
                    'activation_key' => $activation_key
                ]);
                return "reactivated";
            }
        }
        // Enregistrement normal d'un utilisateur
        $key = rand(1, 99999);
        $this->sendVerificationMail($user, $key);
        $password = password_hash($user['password'], PASSWORD_DEFAULT);
        $activation_key = password_hash($key, PASSWORD_DEFAULT);
        try {
            $query = $this->connection->getPdo()->prepare("INSERT INTO users (email, password, username, register_date, activation_key) VALUES (:email, :password, :username, :register_date, :activation_key)");
            $query->execute([
                'email' => $user['email'],
                'password' => $password,
                'username' => strtoupper($user['name']),
                'register_date' => date('y-m-d h:i:s'),
                'activation_key' => $activation_key
            ]);
            $id = $this->connection->getPdo()->lastInsertId();
            $this->logger->createLog(array("type" => "userCreate", "ID_user" =>$id, "ID_post" => null, "ID_comment" => null, "ID_admin" => null));
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
            if ($_SESSION['ID_role'] == 1) {
                $this->logger->createLog(array("type" => "userEdit", "ID_user" => $userId, "ID_post" => null, "ID_comment" => null, "ID_admin" => null));
            } else {
                $this->logger->createLog(array("type" => "userEditAdmin", "ID_user" => $userId, "ID_post" => null, "ID_comment" => null, "ID_admin" => $_SESSION['ID_user']));
            }
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
        // Regex de vérification pour le mot de passe
        if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $user['password'])) {
            return "regex";
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
        $this->logger->createLog(array("type" => "userEditPass", "ID_user" =>$userId, "ID_post" => null, "ID_comment" => null, "ID_admin" => null));
        return "success";
    }

    public function editPasswordAdmin($user, $userId) {
        // Vérification de la présence d'info dans les champs
        if ($user['password'] == "" || $user['passwordConfirm'] == "") {
            return "empty";
        }
        // Regex de vérification pour le mot de passe
        if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $user['password'])) {
            return "regex";
        }
        // Verification de la concordance des champs de mot de passe
        if ($user['password'] != $user['passwordConfirm']) {
            return "passwordConfirm";
        }
        // Modification de l'utilisateur
        $query = $this->connection->getPdo()->prepare("UPDATE users SET password = :password WHERE ID_user = :id");
        $query->execute([
            'password' => password_hash($user['password'], PASSWORD_DEFAULT),
            'id' => $userId
        ]);
        $this->logger->createLog(array("type" => "userEditPassAdmin", "ID_user" => $userId, "ID_post" => null, "ID_comment" => null, "ID_admin" => $_SESSION['ID_user']));
        return "success";
    }

    public function deleteUser($id) {
        try {
            $query = $this->connection->getPdo()->prepare("UPDATE users SET is_active = 0, username = 'Utilisateur désactivé' WHERE ID_user = :id");
            $query->execute([
                'id' => $id
            ]);
            if ($_SESSION['ID_role'] == 1) {
                $this->logger->createLog(array("type" => "userDelete", "ID_user" =>$id, "ID_post" => null, "ID_comment" => null, "ID_admin" => null));
            } else {
                $this->logger->createLog(array("type" => "userDeleteAdmin", "ID_user" => $id, "ID_post" => null, "ID_comment" => null, "ID_admin" => $_SESSION['ID_user']));
            }
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
                $this->logger->createLog(array("type" => "userLogin", "ID_user" => $userCo['ID_user'], "ID_post" => null, "ID_comment" => null, "ID_admin" => null));
            } else {
                $res = "false";
            }
        }
        return $res;
    }

    public function getRecentPosts($id) {
        $query = $this->connection->getPdo()->prepare("SELECT ID_post, ID_user, message, url_image, post_date FROM posts WHERE ID_user = :ID_user ORDER BY post_date DESC LIMIT 2");
        $query->execute([
            'ID_user' => $id
        ]);
        return $query->fetchAll(PDO::FETCH_CLASS, "App\Models\Post");
    }

    public function makeModerator($id) {
        try {
            $query = $this->connection->getPdo()->prepare("UPDATE users SET ID_role = 2 WHERE ID_user = :ID_user");
            $query->execute([
                'ID_user' => $id
            ]);
            $this->logger->createLog(array("type" => "userMakeModerator", "ID_user" => $id, "ID_post" => null, "ID_comment" => null, "ID_admin" => $_SESSION['ID_user']));
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return " une erreur est survenue";
        }
    }

    public function demoteModerator($id) {
        try {
            $query = $this->connection->getPdo()->prepare("UPDATE users SET ID_role = 1 WHERE ID_user = :ID_user");
            $query->execute([
                'ID_user' => $id
            ]);
            $this->logger->createLog(array("type" => "userDemoteModerator", "ID_user" => $id, "ID_post" => null, "ID_comment" => null, "ID_admin" => $_SESSION['ID_user']));
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return " une erreur est survenue";
        }
    }

    private function sendVerificationMail($user, $key) {
        $email = $user['email'];

        // Configuration de PHPMailer pour l'envoi des emails
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->Port       = 465;
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Username   = MAIL_USER;
        $mail->Password   = MAIL_PASS;

        // Contenu
        $mail->setFrom('ne-pas-repondre@bonnefete.fr');
        $mail->addAddress($email, $user['name']);
        $mail->isHTML(true);
        $mail->Subject = 'Votre lien de verification BonneFete';
        $mail->Body    = '
        <h1>BonneFete</h1>
        <h2>' . $user['name'] . ', Votre lien de verification</h2>
        <a href="http://localhost' . LOCALPATH . 'user/verify/' . $key . '/' . $email . '">Cliquez sur ce lien pour vérifier votre adresse e-mail</a>
        ';
        try {
            $mail->send();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function verifyUser($key, $email) {
        $queryKey = $this->connection->getPdo()->prepare("SELECT activation_key FROM users WHERE email = :email");
        $queryKey->execute(['email' => $email]);
        $keyBdd = $queryKey->fetch();
        if (password_verify($key, $keyBdd['activation_key'])) {
            $query = $this->connection->getPdo()->prepare("UPDATE users SET is_active = 1 WHERE email = :email");
            $query->execute(['email' => $email]);
            $this->logger->createLog(array("type" => "userVerify", "ID_user" => $_SESSION['ID_user'], "ID_post" => null, "ID_comment" => null, "ID_admin" => null));
            return "success";
        }
    }
}
