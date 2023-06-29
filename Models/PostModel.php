<?php

namespace App\Models;

require_once  'Database.php';
require_once 'Models/Post.php';

use App\Database;
use PDO;

class PostModel {
    private $connection;

    public function __construct() {
        $this->connection = new Database();
    }

    public function createPost($post) {
        try {
            $query = $this->connection->getPdo()->prepare("INSERT INTO posts (ID_user, post_date, message) VALUES (:ID_user, :post_date, :message)");
            $query->execute(array(
                ':ID_user' => $post['user_id'],
                ':post_date' => date('y-m-d h:i:s'),
                ':message' => $post['message']
            ));
            return "Bien enregistré";
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return " une erreur est survenue";
        }
    }
}
