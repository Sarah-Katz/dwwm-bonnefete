<?php

namespace App\Models;

class Post {
    protected int $ID_post;
    protected int $ID_user;
    protected $post_date;
    protected string $message;

    public function getID_post() {
        return $this->ID_post;
    }

    public function getID_user() {
        return $this->ID_user;
    }

    public function getPost_date() {
        return $this->post_date;
    }

    public function getMessage() {
        return $this->message;
    }

    public function setID_post($ID_post) {
        $this->ID_post = $ID_post;
    }

    public function setID_user($ID_user) {
        $this->ID_user = $ID_user;
    }

    public function setPost_date($post_date) {
        $this->post_date = $post_date;
    }

    public function setMessage($message) {
        $this->message = $message;
    }
}
