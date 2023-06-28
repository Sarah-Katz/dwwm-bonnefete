<?php

namespace App\Models;

class User {
    protected int $id;
    protected string $email;
    protected string $username;
    protected string $password;
    protected $createdAt;
    protected int $role;
    protected bool $isActive;

    public function getId() {
        return $this->id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function getRole() {
        return $this->role;
    }

    public function isActive() {
        return $this->isActive;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function setPassword(string $password) {
        $this->password = $password;
    }

    public function setRole($role) {
        $this->role = $role;
    }

    public function setActive($bool) {
        $this->isActive = $bool;
    }
}
