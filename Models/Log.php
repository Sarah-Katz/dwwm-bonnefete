<?php

namespace App\Models;

class Log {
    protected int $ID_log;
    protected string $type;
    protected $timestamp;
    protected ?int $ID_user;
    protected ?int $ID_post;
    protected ?int $ID_comment;
    protected ?int $ID_admin;

    public function getID_log(): int {
        return $this->ID_log;
    }

    public function getStyle(): string {
        return $this->type;
    }

    public function getTimestamp(): string {
        return $this->timestamp;
    }

    public function getID_user():?int {
        return $this->ID_user;
    }

    public function getID_post():?int {
        return $this->ID_post;
    }

    public function getID_comment():?int {
        return $this->ID_comment;
    }

    public function getID_admin():?int {
        return $this->ID_admin;
    }

    public function setID_log(int $ID_log): void {
        $this->ID_log = $ID_log;
    }

    public function setStyle(string $type): void {
        $this->type = $type;
    }

    public function setID_user(?int $ID_user): void {
        $this->ID_user = $ID_user;
    }

    public function setID_post(?int $ID_post): void {
        $this->ID_post = $ID_post;
    }

    public function setID_comment(?int $ID_comment): void {
        $this->ID_comment = $ID_comment;
    }

    public function setID_admin(?int $ID_admin): void {
        $this->ID_admin = $ID_admin;
    }
}
