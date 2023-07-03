<?php

namespace App\Controllers;

require_once 'Models/LikeModel.php';

use App\Models\LikeModel;

class LikeController {
    protected $likeModel;

    public function __construct() {
        $this->likeModel = new LikeModel();
    }

    public function postLikePost() {
        $like = $_POST;
        $origin = $_POST['origin'];
        $this->likeModel->createLike($like);
        header('Location: ' . $origin);
    }

    public function getDislikePost($id) {
        $this->likeModel->deleteLike($id);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    public function postShowLikes() {
        $data = $_POST;
        require_once 'Views/like/list.php';
    }

    public function postLikeComment() {
        $data = $_POST;
        $origin = $_POST['origin'];
        $post = $_POST['ID_post'];
        $data['ID_post'] = null;
        $this->likeModel->createLike($data);
        $data['ID_post'] = $post;
        if ($data['isNested'] == 0) {
            $data['ID_comment'] = null;
        }
        require_once 'Views/comment/likeRedirect.php';
    }

    public function postDislikeComment() {
        $data = $_POST;
        $origin = $_POST['origin'];
        $this->likeModel->deleteLike($data['ID_like']);
        if ($data['isNested'] == 0) {
            $data['ID_comment'] = null;
        }
        require_once 'Views/comment/likeRedirect.php';
    }
}
