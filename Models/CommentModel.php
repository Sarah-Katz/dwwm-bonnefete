<?php

namespace App\Models;

require_once 'Database.php';
require_once 'Models/Comment.php';

use App\Database;
use PDO;

class CommentModel {
    private $connection;

    public function __construct() {
        $this->connection = new Database();
    }

    public function createComment($comment) {
        try {
            $query = $this->connection->getPdo()->prepare("INSERT INTO comments (ID_user, ID_post, ID_comment, message, timestamp) VALUES (:ID_user, :ID_post, :ID_comment, :message, :timestamp)");
            $query->execute(array(
                ':ID_user' => $comment['ID_user'],
                ':ID_post' => $comment['ID_post'],
                ':ID_comment' => $comment['ID_comment'],
                ':message' => $comment['message'],
                ':timestamp' => date('y-m-d h:i:s')
            ));
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
        $query = $this->connection->getPdo()->prepare("SELECT ID, ID_user, ID_post, message, timestamp FROM comments WHERE ID_post = :ID_post");
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
        $query = $this->connection->getPdo()->prepare("SELECT COUNT(ID_comment) FROM comments WHERE ID_post = :ID_post");
        $query->execute([
            ':ID_post' => $id
        ]);
        return $query->fetchColumn();
    }

    public function countCommentsByCommentId($id) {
        $query = $this->connection->getPdo()->prepare("SELECT COUNT(ID_comment) FROM comments WHERE ID_comment = :ID_comment");
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
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return " une erreur est survenue";
        }
    }
}
