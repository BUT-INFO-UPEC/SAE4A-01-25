<?php
// Récupérer le chemin absolu de l'URL
$phpSelfPath = $_SERVER['PHP_SELF'];

// Diviser le chemin en segments (en utilisant '/' comme séparateur)
$pathSegments = explode('/', trim($phpSelfPath, '/'));

// Calculer le nombre de niveaux à remonter
$numberOfLevelsToGoUp = count($pathSegments) - 2;

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
    <link rel="stylesheet" href="<?php echo $prefixe . 'css/style.css'; ?>">
    <link rel="stylesheet" href="<?php echo $prefixe . 'css/style_layout.css'; ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>
    <?php include __DIR__ . "/composants_balistiques_communs/Header.php"; ?>

    <?php include __DIR__ . "/composants_balistiques_specifiques/Form.php"; ?>
    <main class="flex">
        <div class="sidebar" style="display: block; width: 6cm;">
            <?php include "composants_balistiques_communs/SideBar.php"; ?>
        </div>

        <div style="flex-grow: 1; position: relative">
            <?php echo $main; ?>
        </div>
    </main>
    <?php include __DIR__ .  "/composants_balistiques_communs/Footer.php"; ?>
</body>

</html>