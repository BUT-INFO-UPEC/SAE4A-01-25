<?php
// require_once "../Model/classes/requetteur_BDD.php";

// // Récupère le numéro envoyé via le formulaire ou utilise "1" par défaut
// $numero_visu = isset($_GET['numero_visu']) ? (int)$_GET['numero_visu'] : 0;
// $numero_dash = isset($_GET['numero_dash']) ? (int)$_GET['numero_dash'] : 0;

// // Appelle les fonctions avec les numéro sélectionné
// $resultat = BDD_fetch_visualisation($numero_visu);
// $dash = BDD_fetch_dashboard($numero_dash);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Visualisation des données</title>
</head>
<body>
    <h1>Visualisation des données</h1>

<!--
    Formulaire pour saisir le numéro
    <form method="get" action="">
        <label for="numero_visu">Numéro de visualisation :</label>
        <input type="number" id="numero_visu" name="numero_visu" value="<?php echo htmlspecialchars($numero_visu); ?>" min="0" max="4" required>
        <button type="submit">Afficher</button>

        </br>

        <label for="numero_dash">Numéro de visualisation :</label>
        <input type="number" id="numero_dash" name="numero_dash" value="<?php echo htmlspecialchars($numero_dash); ?>" min="0" max="4" required>
        <button type="submit">Afficher</button>
    </form>

    Affichage du résultat
    <h2>Résultat :</h2>
    <pre><?php var_dump($resultat); ?></pre>
    <pre><?php var_dump($dash); ?></pre>
-->
    <?php
    require_once "../Model/classes/dashboard.php";
    $dash = new Dashboard(0);

    echo $dash->generate_dashboard();
    ?>
</body>
</html>