<?php

namespace App\Models;

class Post {
    protected int $ID_post;
    protected int $ID_user;
    protected $post_date;
    protected string $message;
    protected ?string $url_image;

    public function getID_post() {
        return $this->ID_post;
    }

    public function getID_user() {
        return $this->ID_user;
    }

    public function getPost_date() {
        $date = strtotime($this->post_date);
        $date = date('d/m/Y', $date);
        return $date;
    }

    public function getMessage() {
        return $this->message;
    }

    public function getUrl_image() {
        return $this->url_image;
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

    public function setUrl_image($url_image) {
        $this->url_image = $url_image;
    }
}
