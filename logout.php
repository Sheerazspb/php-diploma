<?php 
session_start();
setcookie('login', $_SESSION['login'], time() - 100);
setcookie('name', $_SESSION['name'], time() - 100);
setcookie('role', $_SESSION['role'], time() - 100);
session_destroy();

header('Location: index.php');
