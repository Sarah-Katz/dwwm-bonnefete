<?php

namespace App\Controllers;

require_once 'Models/CommentModel.php';

use App\Models\CommentModel;

class CommentController {
    protected $commentModel;

    public function __construct() {
        $this->commentModel = new CommentModel();
    }

    public function postShowComments() {
        $data = $_POST;
        require_once 'Views/comment/list.php';
    }

    public function postAddComment() {
        $comment = $_POST;
        $this->commentModel->createComment($comment);
        $data = $comment;
        $data['ID_comment'] === "null" ? $data['ID_comment'] = null : $data['ID_comment'];
        require_once 'Views/comment/likeRedirect.php';
    }

    public function getLikeRedirect() {
        require_once 'Views/comment/likeRedirect.php';
    }

    public function getEdit($id) {
        $comment = $this->commentModel->getCommentById($id);
        require_once 'Views/comment/edit.php';
    }

    public function postEdit() {
        $comment = $_POST;
        $this->commentModel->updateComment($comment);
        header('location: ../post/feed');
    }

    public function getDeleteComment($id) {
        $this->commentModel->deleteComment($id);
        header('location:../../post/feed');
    }
}
