<?php

namespace App\Models;

class Like {
    protected int $ID_like;
    protected int $ID_user;
    protected int $ID_post;
    protected int $ID_comment;

    public function getID_like() {
        return $this->ID_like;
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

    public function setID_user($ID_user) {
        $this->ID_user = $ID_user;
    }

    public function setID_post($ID_post) {
        $this->ID_post = $ID_post;
    }

    public function setID_comment($ID_comment) {
        $this->ID_comment = $ID_comment;
    }
}
