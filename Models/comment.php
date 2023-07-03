<?php

namespace App\Models;

class Comment {
    protected int $ID;
    protected int $ID_user;
    protected ?int $ID_post;
    protected ?int $ID_comment;
    protected string $message;
    protected $timestamp;

    public function getID() {
        return $this->ID;
    }

    public function getID_user() {
        return $this->ID_user;
    }

    public function getID_post() {
        return $this->ID_post;
    }

    public function getID_comment() {
        return $this->ID_comment;
    }

    public function getMessage() {
        return $this->message;
    }

    public function getTimestamp() {
        $date = strtotime($this->timestamp);
        $date = date('d/m/Y', $date);
        return $date;
    }

    public function setID_user($ID_user) {
        $this->ID_user = $ID_user;
    }

    public function setID_post($ID_post) {
        $this->ID_post = $ID_post;
    }

    public function setID_comment($ID_comment) {
        $this->ID_comment = $ID_comment;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    public function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
    }
}
