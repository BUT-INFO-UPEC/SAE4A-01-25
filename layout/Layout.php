<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?php
        echo isset($titre) ? $titre : "Titre";
    ?> </title>
    <link rel="stylesheet" href="<?php 
        $prefixe = strpos($_SERVER['PHP_SELF'], 'Vues') ? "../" : "";
        echo $prefixe . 'layout/css/style.css';
    ?>">
</head>

<body>
    <header>
        <?php include "composants_balistiques_communs/Header.php"; ?>
    </header>

    <main class="flex">
        <div class="sidebar" style="display: block; width: 6cm;">
            <?php include "layout/composants_balistiques_communs/SideBar.php"; ?>
        </div>

        <div style="flex-grow: 1; position: relative;">
            <?php echo $main; ?>
        </div>
    </main>

    <footer>
        <?php include "layout/composants_balistiques_communs/Footer.php"; ?>
    </footer>
</body>

</html>