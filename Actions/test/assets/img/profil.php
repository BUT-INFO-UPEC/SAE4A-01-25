<?php
session_start();

// Exemple de données utilisateur (à remplacer par une récupération depuis une base de données ou session)
$user = [
    'nom' => 'Amine',
    'email' => 'amine@example.com',
    'role' => 'Utilisateur standard',
    'date_inscription' => '2024-01-01',
    'photo' => 'avatar1.jpg' // Photo de profil par défaut (peut être modifié)
];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - <?php echo htmlspecialchars($user['nom']); ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <script>
        // Fonction JavaScript pour afficher les options de photo
        function togglePhotoOptions() {
            const options = document.getElementById('photo-options');
            if (options.style.display === "none" || options.style.display === "") {
                options.style.display = "block";
            } else {
                options.style.display = "none";
            }
        }
    </script>
</head>
<body>
    <?php include('../includes/header.php'); ?>

    <main>
        <section id="profile-section">
            <!-- Conteneur principal avec la photo et les informations personnelles -->
            <div id="profile-container">
                <!-- Conteneur de la photo -->
                <div id="avatar-container">
                    <!-- Affichage de la photo de profil -->
                    <img src="../assets/img/<?php echo htmlspecialchars($user['photo'] ?? 'default-avatar.jpg'); ?>" id="avatar" alt="Avatar">

                    <!-- Bouton pour modifier la photo et afficher les options -->
                    <button id="modify-photo-btn" onclick="togglePhotoOptions()">Modifier la photo</button>

                    <!-- Options liées à la photo -->
                    <div id="photo-options" style="display:none;">
                        <form action="Profil.php" method="POST" enctype="multipart/form-data">
                            <label for="file-upload">Changer la photo</label>
                            <input type="file" name="avatar" id="file-upload" accept="image/*">
                            <button type="submit">Changer</button>
                        </form>
                        <form action="Profil.php" method="POST">
                            <button type="submit" name="delete-photo">Supprimer la photo</button>
                        </form>
                    </div>
                </div>

                <!-- Informations personnelles à droite de la photo -->
                <div id="user-info">
                    <h2>Informations personnelles</h2>
                    <p><strong>Nom :</strong> <?php echo htmlspecialchars($user['nom']); ?></p>
                    <p><strong>Email :</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                    <p><strong>Rôle :</strong> <?php echo htmlspecialchars($user['role']); ?></p>
                    <p><strong>Date d'inscription :</strong> <?php echo htmlspecialchars($user['date_inscription']); ?></p>
                </div>
            </div>
        </section>
    </main>

    <?php include('../includes/footer.php'); ?>
</body>
</html>
