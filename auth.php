<?php 
require 'autoload.php';

session_start();

if (isset($_POST['login']) && isset($_POST['password'])) {
    $jsonFileAccessModel = new JsonFileAccessModel('users');
    $users = json_decode($jsonFileAccessModel->read(), true);
    foreach ($users as $user) {
        if ($user['login'] == $_POST['login'] && $user['password'] == $_POST['password']) {
            $_SESSION['login'] = $user['login'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            setcookie('login', $user['login'], time() + Config::COOKIE_LIFE_TIME);
            setcookie('name', $user['name'], time() + Config::COOKIE_LIFE_TIME);
            setcookie('role', $user['role'], time() + Config::COOKIE_LIFE_TIME);
        }
    }
}

header('Location: index.php');
