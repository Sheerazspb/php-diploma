<?php 

class User
{
    private $logged = false;
    public $login;
    public $name;
    public $role;

    public function __construct($session_data = null) 
    {
        if (is_array($session_data) && isset($session_data['login'])) {
            $this->logged = true;
            $this->login = $session_data['login'];
            $this->name = $session_data['name'];
            $this->role = $session_data['role'];
        } elseif (isset($_COOKIE['login'])) {
            $this->logged = true;
            $this->login = $_COOKIE['login'];
            $this->name = $_COOKIE['name'];
            $this->role = $_COOKIE['role'];
        }
    }

    public function isLogined() 
    {
        return $this->logged;
    }
}