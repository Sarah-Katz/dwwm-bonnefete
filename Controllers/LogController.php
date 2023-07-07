<?php

namespace App\Controllers;

require_once 'Models/LogModel.php';

use App\Models\LogModel;

class LogController {
    protected $logModel;

    public function __construct() {
        $this->logModel = new LogModel();
    }

    public function getHistory() {
        if ($_SESSION['ID_user'] == null) {
            header('Location: ' . LOCALPATH . 'user/login');
        } elseif ($_SESSION['ID_role'] != 3) {
            header('Location: ' . LOCALPATH . 'post/feed');
        } else {
            $logs = $this->logModel->getLogs();
            require_once 'Views/log/history.php';
        }
    }
}
