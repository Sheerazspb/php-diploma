<?php
    require 'autoload.php';

    session_start();
    $user = new User($_SESSION);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?=Config::TITLE ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,700&display=swap&subset=cyrillic-ext" rel="stylesheet">
</head>
<body>
    <?php 
    if ($user->isLogined()) {
        include 'admin_panel.php';
    } else {
        include 'login_form.php';
    }
    ?>
   
</body>
</html>