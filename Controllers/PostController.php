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
        $post = $this->uploadFile($_POST, $_FILES);
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
        if (($_FILES['image']['name'] == '')) {
            $post['url_image'] =  $_POST['old_url_image'];
        } else {
            $post = $this->uploadFile($_POST, $_FILES);
        }
        $this->postModel->updatePost($id, $post);
        header('location: ../post/feed');
    }

    private function uploadFile($post, $files) {
        if (($files['image']['name'] != '')) {
            $image = $files['image'];
            $imageName = $image['name'];
            $imageType = $image['type'];
            $imageSize = $image['size'];
            $imageError = $image['error'];
            $imageTemp = $image['tmp_name'];
            $imageNewName = uniqid() . '.' . pathinfo($imageName, PATHINFO_EXTENSION);
            $imageNewPath = 'img/userUploads/' . $imageNewName;
            move_uploaded_file($imageTemp, $imageNewPath);
            $post['url_image'] = $imageNewPath;
        } else {
            $post['url_image'] = null;
        }
        return $post;
    }
}
