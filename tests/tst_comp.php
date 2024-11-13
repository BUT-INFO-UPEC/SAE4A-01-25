<?php
require_once "../Model/classes/requetteur_BDD.php";

// Récupère le numéro envoyé via le formulaire ou utilise "1" par défaut
$numero = isset($_GET['numero']) ? (int)$_GET['numero'] : 0;

// Appelle la fonction avec le numéro sélectionné
$resultat = BDD_fetch_visualisation($numero);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Visualisation des données</title>
</head>
<body>
    <h1>Visualisation des données</h1>

    <!-- Formulaire pour saisir le numéro -->
    <form method="get" action="">
        <label for="numero">Numéro de visualisation :</label>
        <input type="number" id="numero" name="numero" value="<?php echo htmlspecialchars($numero); ?>" min="0" max="4" required>
        <button type="submit">Afficher</button>
    </form>

    <!-- Affichage du résultat -->
    <h2>Résultat :</h2>
    <pre><?php var_dump($resultat); ?></pre>
</body>
</html>
