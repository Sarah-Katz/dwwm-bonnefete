<?php

namespace App\Models;

require_once 'Database.php';
require_once 'Models/Comment.php';
require_once 'Models/LogModel.php';

use App\Database;
use PDO;

class CommentModel {
    private $connection;
    private $logger;

    public function __construct() {
        $this->connection = new Database();
        $this->logger = new LogModel();
    }

    public function createComment($comment) {
        // Assignation des valeurs null
        if ($comment['ID_comment'] == "null") {
            $ID_comment = null;
        } else {
            $ID_comment = $comment['ID_comment'];
        }
        // Création du commentaire
        try {
            $query = $this->connection->getPdo()->prepare("INSERT INTO comments (ID_user, ID_post, ID_comment, message, timestamp) VALUES (:ID_user, :ID_post, :ID_comment, :message, :timestamp)");
            $query->execute(array(
                ':ID_user' => $comment['ID_user'],
                ':ID_post' => $comment['ID_post'],
                ':ID_comment' => $ID_comment,
                ':message' => $comment['message'],
                ':timestamp' => date('y-m-d h:i:s')
            ));
            $id = $this->connection->getPdo()->lastInsertId();
            $this->logger->createLog(array("type" => "commentCreate", "ID_comment" => $id, "ID_user" => $comment['ID_user'], "ID_post" => null, "ID_admin" => null));
            return "Bien enregistré";
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return " une erreur est survenue";
        }
    }

    public function updateComment($comment) {
        try {
            $query = $this->connection->getPdo()->prepare("UPDATE comments SET message = :message WHERE ID = :ID");
            $query->execute([
                ':message' => $comment['message'],
                ':ID' => $comment['id']
            ]);
            if (($_SESSION['ID_role'] == 1) || ($_SESSION['ID_role'] != 1 && ($_SESSION['ID_user'] == $comment['ID_user']))) {
                $this->logger->createLog(array("type" => "commentUpdate", "ID_comment" => $comment['id'], "ID_user" => $comment['ID_user'], "ID_post" => null, "ID_admin" => null));
            } else {
                $this->logger->createLog(array("type" => "commentUpdateAdmin", "ID_comment" => $comment['id'], "ID_admin" => $_SESSION['ID_user'], "ID_post" => null, "ID_user" => null));
            }
            return "Bien enregistré";
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return " une erreur est survenue";
        }
    }

    public function getComments() {
        $query = $this->connection->getPdo()->prepare("SELECT ID, ID_user, ID_post, ID_comment, message, timestamp FROM comments");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_CLASS, "App\Models\Comment");
    }

    public function getCommentById($id) {
        $query = $this->connection->getPdo()->prepare("SELECT ID, ID_user, ID_post, ID_comment, message, timestamp FROM comments WHERE ID = :ID");
        $query->execute([
            ':ID' => $id
        ]);
        $query->setFetchMode(PDO::FETCH_CLASS, "App\Models\Comment");
        return $query->fetch();
    }

    public function getCommentsByUserId($id) {
        $query = $this->connection->getPdo()->prepare("SELECT ID, ID_user, ID_post, ID_comment, message, timestamp FROM comments WHERE ID_user = :ID_user");
        $query->execute([
            ':ID_user' => $id
        ]);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_CLASS, "App\Models\Comment");
    }

    public function getCommentsByPostId($id) {
        $query = $this->connection->getPdo()->prepare("SELECT ID, ID_user, ID_post, message, timestamp FROM comments WHERE ID_post = :ID_post AND ID_comment IS NULL");
        $query->execute([
            ':ID_post' => $id
        ]);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_CLASS, "App\Models\Comment");
    }

    public function getCommentsByCommentId($id) {
        $query = $this->connection->getPdo()->prepare("SELECT ID, ID_user, ID_comment, message, timestamp FROM comments WHERE ID_comment = :ID_comment");
        $query->execute([
            ':ID_comment' => $id
        ]);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_CLASS, "App\Models\Comment");
    }

    public function countCommentsByPostId($id) {
        $query = $this->connection->getPdo()->prepare("SELECT COUNT(ID) FROM comments WHERE ID_post = :ID_post");
        $query->execute([
            ':ID_post' => $id
        ]);
        return $query->fetchColumn();
    }

    public function countCommentsByCommentId($id) {
        $query = $this->connection->getPdo()->prepare("SELECT COUNT(ID) FROM comments WHERE ID_comment = :ID_comment");
        $query->execute([
            ':ID_comment' => $id
        ]);
        return $query->fetchColumn();
    }

    public function deleteComment($id) {
        try {
            $query = $this->connection->getPdo()->prepare("DELETE FROM comments WHERE ID = :ID");
            $query->execute([
                ':ID' => $id
            ]);
            if (($_SESSION['ID_role'] == 1) || ($_SESSION['ID_role'] != 1 && ($_SESSION['ID_user'] == $id))) {
                $this->logger->createLog(array("type" => "commentDelete", "ID_comment" => $id, "ID_user" => $_SESSION['ID_user'], "ID_post" => null, "ID_admin" => null));
            } else {
                $this->logger->createLog(array("type" => "commentDeleteAdmin", "ID_comment" => $id, "ID_admin" => $_SESSION['ID_user'], "ID_post" => null, "ID_user" => null));
            }
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return " une erreur est survenue";
        }
    }
}
