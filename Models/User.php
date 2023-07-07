<?php

namespace App\Models;

class User {
    protected int $ID_user;
    protected string $email;
    protected string $username;
    protected string $password;
    protected $register_date;
    protected int $ID_role;
    protected bool $is_active;

    public function getID_user() {
        return $this->ID_user;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getUsername() {
        return ucfirst(strtolower($this->username));
    }

    public function getPassword() {
        return $this->password;
    }

    public function getRegister_date() {
        $date = strtotime($this->register_date);
        $date = date('d/m/Y', $date);
        return $date;
    }

    public function getID_role() {
        return $this->ID_role;
    }

    public function is_active() {
        return $this->is_active;
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

    public function setID_role($ID_role) {
        $this->ID_role = $ID_role;
    }

    public function setActive($bool) {
        $this->is_active = $bool;
    }
}
