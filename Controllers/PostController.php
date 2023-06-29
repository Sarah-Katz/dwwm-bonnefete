<?php

namespace App\Controllers;

require_once 'Models/PostModel.php';

use App\Models\PostModel;

class PostController {
    protected $postModel;

    public function __construct() {
        $this->postModel = new PostModel();
    }

    public function getFeed() {
        $posts = $this->postModel->getPosts();
        require_once 'Views/post/feed.php';
    }
}
