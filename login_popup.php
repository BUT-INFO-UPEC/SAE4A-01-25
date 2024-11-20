<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="../layout/style.css"> 
    <style>
        /* Style de base pour l'arrière-plan et le popup */
        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            display: none; /* Caché par défaut */
            justify-content: center;
            align-items: center;
        }
        .popup-content {
            background-color: #fff;
            padding: 20px;
            width: 300px;
            border-radius: 8px;
            text-align: center;
        }
        .popup-content input[type="text"],
        .popup-content input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
        }
        .popup-content button {
            padding: 10px 20px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="popup-overlay" id="popup">
    <div class="popup-content">
        <h2>Connexion</h2>
        <form action="traitement_connexion.php" method="post">
            <input type="text" name="username" placeholder="Nom d'utilisateur" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <button type="submit">Se connecter</button>
        </form>
        <button onclick="closePopup()">Fermer</button>
    </div>
</div>

<script>
    function openPopup() {
        document.getElementById("popup").style.display = "flex";
    }
    function closePopup() {
        document.getElementById("popup").style.display = "none";
    }
</script>

</body>
</html>
