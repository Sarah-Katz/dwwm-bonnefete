<?php

namespace App\Models;

require_once 'Database.php';
require_once 'Models/Log.php';

use App\Database;
use PDO;

class LogModel {
    private $connection;

    public function __construct() {
        $this->connection = new Database();
    }

    public function createLog(array $log) {
            $query = $this->connection->getPdo()->prepare('INSERT INTO logs (type, timestamp, ID_user, ID_post, ID_comment, ID_admin) VALUES (:type, :timestamp, :ID_user, :ID_post, :ID_comment, :ID_admin)');
            $query->execute([
                ':type' => $log['type'],
                ':timestamp' => date('y-m-d h:i:s'),
                ':ID_user' => $log['ID_user'],
                ':ID_post' => $log['ID_post'],
                ':ID_comment' => $log['ID_comment'],
                ':ID_admin' => $log['ID_admin']
            ]);
    }

    public function getLogs() {
        $query = $this->connection->getPdo()->prepare('SELECT ID_log, type, timestamp, ID_user, ID_post, ID_comment, ID_admin FROM logs ORDER BY ID_log DESC');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_CLASS, "App\Models\Log");
    }
}
