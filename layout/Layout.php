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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</head>
<?php include __DIR__ . "/composants_balistiques_communs/Header.php"; ?>

<body>

    <main class="flex">
        <button class="btn btn-primary" id="toggleSidebar">
            &equiv;
        </button>
        <?php include __DIR__ . "/composants_balistiques_communs/SideBar.php"; ?>

        <div class="main" style="flex-grow: 1; position: relative">
            <?php echo $main; ?>
        </div>
    </main>
    <?php include __DIR__ .  "/composants_balistiques_communs/Footer.php"; ?>
</body>

</html>