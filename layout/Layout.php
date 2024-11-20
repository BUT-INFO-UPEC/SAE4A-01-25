
<?php
// Récupérer le chemin absolu de l'URL
$phpSelfPath = $_SERVER['PHP_SELF'];

// Diviser le chemin en segments (en utilisant '/' comme séparateur)
$pathSegments = explode('/', trim($phpSelfPath, '/'));

// Calculer le nombre de niveaux à remonter
$numberOfLevelsToGoUp = count($pathSegments)-2;

// Construire le préfixe avec "../" répété pour chaque niveau
$i = 0;
$prefixe = "";
while ($i < $numberOfLevelsToGoUp) {
    $prefixe .= '../';
    $i++;
}
$prefixe .= 'layout/';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?php
        echo isset($titre) ? $titre : "Titre";
    ?> </title>
    <link rel="stylesheet" href="<?php 
        echo $prefixe . 'css/style.css';
    ?>">
</head>

<body>
    <?php include "composants_balistiques_communs/Header.php"; ?>

    <main class="flex">
        <div class="sidebar" style="display: block; width: 6cm;">
            <?php include "composants_balistiques_communs/SideBar.php"; ?>
        </div>

        <div style="flex-grow: 1; position: relative;">
            <?php echo $main; ?>
        </div>
    </main>

    <?php include "composants_balistiques_communs/Footer.php"; ?>
</body>

</html>