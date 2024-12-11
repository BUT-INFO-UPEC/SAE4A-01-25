<?php

// Exemple de données utilisateur (à remplacer par une récupération depuis une base de données ou session)
$user = [
    'nom' => 'Amine',
    'email' => 'amine@example.com',
    'role' => 'Utilisateur',
    'date_inscription' => '2024-01-01',
];
?>

<section id="profile-section">
    <!-- Conteneur principal avec la photo et les informations personnelles -->
    <div id="profile-container">
        <!-- Conteneur de la photo -->
        <div id="avatar-container">
            <!-- Affichage de la photo de profil -->
            <img src="../assets/img/default-avatar.jpg" id="avatar" alt="Avatar">

            <!-- Bouton pour modifier la photo et afficher les options -->
            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#UpdateUserModal" class="btn btn-primary">
                Modifier utilisateur
            </a>
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

<style>
    section {
        margin-bottom: 30px;
    }

    /* Conteneur principal pour la photo et les informations personnelles */
    #profile-section {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 30px;
    }

    #profile-container {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        gap: 40px;
        width: 100%;
    }

    /* Conteneur de la photo */
    #avatar-container {
        text-align: center;
        position: relative;
    }

    /* Photo de profil */
    #avatar {
        width: 160px;
        height: 160px;
        border-radius: 50%;
        border: 5px solid #272626;
        /* Bordure orange vif */
        object-fit: cover;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    /* Bouton Modifier la photo */
    #modify-photo-btn {
        background-color: #272626;
        /* Orange vif */
        color: white;
        padding: 8px 20px;
        border: none;
        cursor: pointer;
        border-radius: 4px;
        transition: background-color 0.3s ease;
        margin-top: 15px;
    }

    /* Informations personnelles */
    #user-info {
        display: flex;
        flex-direction: column;
        gap: 10px;
        color: #555;
        /* Gris clair pour les textes */
    }

    #user-info h2{

        font-size: 1.6rem;
        margin-bottom: 15px;
        border-bottom: 2px solid #0066cc;
    }

    #user-info h2,
    #user-info p {
        color: #333;
        /* Ligne bleue sous le titre */
        padding-bottom: 10px;

    }

    #user-info p {
        font-size: 1.1rem;
        margin: 5px 0;
    }


    a:hover {
        text-decoration: underline;
        color: #004a99;
        /* Bleu plus foncé au survol */
    }

    /* Actions (Modifier Profil, Changer Mot de Passe, Se Déconnecter) */
    #user-actions {
        margin-top: 30px;
    }

    #user-actions ul {
        list-style: none;
        padding: 0;
    }

    #user-actions li {
        margin: 10px 0;
    }

    #user-actions a {
        display: inline-block;
        background-color: #ff6600;
        /* Boutons orange vif */
        color: white;
        padding: 10px 20px;
        border-radius: 50px;
        text-transform: uppercase;
        font-weight: bold;
        letter-spacing: 1px;
        transition: all 0.3s ease-in-out;
    }

    #user-actions a:hover {
        background-color: #e65c00;
        transform: translateY(-2px);
        /* Légère animation de bouton au survol */
    }
</style>