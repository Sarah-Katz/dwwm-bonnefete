<?php

namespace App\Controllers;

require_once 'Models/PostModel.php';

use App\Models\PostModel;

class UserController {
    protected $userModel;

    public function __construct() {
        $this->userModel = new PostModel();
    }

    
}
