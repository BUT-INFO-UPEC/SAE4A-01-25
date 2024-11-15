<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?php
        echo isset($titre) ? $titre : "Titre";
    ?> </title>
    <link rel="stylesheet" href="<?php 
        $prefixe = strpos($_SERVER['PHP_SELF'], 'Vue') ? "../" : "";
        echo $prefixe . 'layout/style.css';
    ?>">
</head>
<body>
    <header>
        <h1 class="header-title">Nom Du Site</h1>
        <img src="account-icon.png">
        <div class="hidden-menu">
            <a href="Layout.php">Sign in</a>
            <a href="Layout.php">Sign up</a>
        </div>
    </header>
</body>