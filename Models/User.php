<?php

namespace App\Models;

class User {
    protected int $id;
    protected string $email;
    protected string $surname;
    protected string $name;
    protected string $password;

    public function getId() {
        return $this->id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getSurname() {
        return $this->surname;
    }

    public function getName() {
        return $this->name;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setSurname($surname) {
        $this->surname = $surname;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setPassword(string $password) {
        $this->password = $password;
    }
}
