<?php

namespace App\Models;

require_once 'Database.php';
require_once 'Models/Post.php';
require_once 'Models/LogModel.php';

use App\Database;
use PDO;

class PostModel {
    private $connection;
    private $logger;

    public function __construct() {
        $this->connection = new Database();
        $this->logger = new LogModel();
    }

    public function createPost($post) {
        try {
            $query = $this->connection->getPdo()->prepare("INSERT INTO posts (ID_user, post_date, message, url_image) VALUES (:ID_user, :post_date, :message, :url_image)");
            $query->execute(array(
                ':ID_user' => $post['ID_user'],
                ':post_date' => date('y-m-d h:i:s'),
                ':message' => $post['message'],
                ':url_image' => $post['url_image']
            ));
            $id = $this->connection->getPdo()->lastInsertId();
            $this->logger->createLog(array("type" => "postCreate", 'ID_post' => $id, "ID_user" => $post['ID_user'], "ID_comment" => null, "ID_admin" => null));
            return "Bien enregistré";
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return " une erreur est survenue";
        }
    }

    public function getPosts() {
        $query = $this->connection->getPdo()->prepare("SELECT ID_post, ID_user, post_date, message, url_image FROM posts ORDER BY ID_post DESC");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_CLASS, "App\Models\Post");
    }

    public function getPostById($id) {
        $query = $this->connection->getPdo()->prepare("SELECT ID_post, ID_user, post_date, message, url_image FROM posts WHERE ID_post = :ID_post");
        $query->execute([
            ':ID_post' => $id
        ]);
        $query->setFetchMode(PDO::FETCH_CLASS, "App\Models\Post");
        return $query->fetch();
    }

    public function getPostsByUserId($id) {
        $query = $this->connection->getPdo()->prepare("SELECT ID_post, ID_user, post_date, message, url_image FROM posts WHERE ID_user = :ID_user ORDER BY post_date DESC");
        $query->execute([
            ':ID_user' => $id
        ]);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_CLASS, "App\Models\Post");
    }

    public function updatePost($id, $post) {
        try {
            $query = $this->connection->getPdo()->prepare("UPDATE posts SET message = :message, url_image = :url_image WHERE ID_post = :ID_post");
            $query->execute([
                ':ID_post' => $id,
                ':message' => $post['message'],
                ':url_image' => $post['url_image']
            ]);
            if (($_SESSION['ID_role'] == 1) || ($_SESSION['ID_role'] != 1 && $_SESSION['ID_user'] == $post['ID_user'])) {
                $this->logger->createLog(array("type" => "postUpdate", 'ID_post' => $id, "ID_user" => $post['ID_user'], "ID_comment" => null, "ID_admin" => null));
            } else {
                $this->logger->createLog(array("type" => "postUpdateAdmin", 'ID_post' => $id, "ID_admin" => $_SESSION['ID_user'], "ID_comment" => null, "ID_admin" => null));
            }
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return " une erreur est survenue";
        }
    }

    public function deletePost($id) {
        try {
            $query = $this->connection->getPdo()->prepare("DELETE FROM posts WHERE ID_post = :ID_post");
            $query->execute([
                ':ID_post' => $id
            ]);
            if (($_SESSION['ID_role'] == 1) || ($_SESSION['ID_role'] != 1 && $_SESSION['ID_user'] == $id)) {
                $this->logger->createLog(array("type" => "postDelete", 'ID_post' => $id, "ID_user" =>$id, "ID_comment" => null, "ID_admin" => null));
            } else {
                $this->logger->createLog(array("type" => "postDeleteAdmin", 'ID_post' => $id, "ID_admin" => $_SESSION['ID_user'], "ID_comment" => null, "ID_user" => null));
            }
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return " une erreur est survenue";
        }
    }
}
