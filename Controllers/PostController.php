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

    public function postFeed() {
        $post = $_POST;
        $this->postModel->createPost($post);
        header('Location: ../post/feed');
    }

    public function getDeletePost($id) {
        $this->postModel->deletePost($id);
        header('Location: ../feed');
    }

    public function getEdit($id) {
        $post = $this->postModel->getPostById($id);
        require_once 'Views/post/edit.php';
    }

    public function postEdit() {
            $post = $_POST;
            $id = $post['id'];
            $this->postModel->updatePost($id, $post);
            header('location: ../post/feed');
        }
}
