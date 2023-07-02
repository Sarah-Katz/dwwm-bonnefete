<?php

namespace App\Models;

require_once 'Database.php';
require_once 'Models/Like.php';

use App\Database;
use PDO;

class LikeModel {
    private $connection;

    public function __construct() {
        $this->connection = new Database();
    }

    public function createLike($like) {
        try {
            $query = $this->connection->getPdo()->prepare("INSERT INTO likes (ID_user, ID_post, ID_comment) VALUES (:ID_user, :ID_post, :ID_comment)");
            $query->execute(array(
                ':ID_user' => $like['ID_user'],
                ':ID_post' => $like['ID_post'],
                ':ID_comment' => $like['ID_comment']
            ));
            return "Bien enregistré";
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return " une erreur est survenue";
        }
    }

    public function getLikes() {
        $query = $this->connection->getPdo()->prepare("SELECT ID_like, ID_user, ID_post, ID_comment, message FROM likes");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_CLASS, "App\Models\Like");
    }

    public function getLikeById($id) {
        $query = $this->connection->getPdo()->prepare("SELECT ID_like, ID_user, ID_post, ID_comment FROM likes WHERE ID_like = :ID_like");
        $query->execute([
            ':ID_like' => $id
        ]);
        $query->setFetchMode(PDO::FETCH_CLASS, "App\Models\Like");
        return $query->fetch();
    }

    public function getLikesByUserId($id) {
        $query = $this->connection->getPdo()->prepare("SELECT ID_like, ID_user, ID_post, ID_comment FROM likes WHERE ID_user = :ID_user");
        $query->execute([
            ':ID_user' => $id
        ]);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_CLASS, "App\Models\Like");
    }

    public function getLikesByPostId($id) {
        $query = $this->connection->getPdo()->prepare("SELECT ID_like, ID_user, ID_post FROM likes WHERE ID_post = :ID_post");
        $query->execute([
            ':ID_post' => $id
        ]);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_CLASS, "App\Models\Like");
    }

    public function getLikesByCommentId($id) {
        $query = $this->connection->getPdo()->prepare("SELECT ID_like, ID_user, ID_post, ID_comment FROM likes WHERE ID_comment = :ID_comment");
        $query->execute([
            ':ID_comment' => $id
        ]);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_CLASS, "App\Models\Like");
    }

    public function countLikesByPostId($id) {
        $query = $this->connection->getPdo()->prepare("SELECT COUNT(ID_like) FROM likes WHERE ID_post = :ID_post");
        $query->execute([
            ':ID_post' => $id
        ]);
        return $query->fetchColumn();
    }

    public function countLikesByCommentId($id) {
        $query = $this->connection->getPdo()->prepare("SELECT COUNT(ID_like) FROM likes WHERE ID_comment = :ID_comment");
        $query->execute([
            ':ID_comment' => $id
        ]);
        return $query->fetchColumn();
    }

    public function deleteLike($id) {
        try {
            $query = $this->connection->getPdo()->prepare("DELETE FROM likes WHERE ID_like = :ID_like");
            $query->execute([
                ':ID_like' => $id
            ]);
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return " une erreur est survenue";
        }
    }
}
