<!DOCTYPE html>
<html lang="fr">

<?php include __DIR__ . '/../composants_balistiques_communs/'; ?>

<body>
    <?php
    // Démarrer la session si elle n'est pas déjà démarrée
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Récupérer le message d'erreur depuis la session, avec un message par défaut si non défini
    $error = $_SESSION['error'] ?? null;
    unset($_SESSION['error']); // On supprime le message après récupération pour éviter qu'il ne persiste
    ?>

    <!-- Afficher la carte seulement si un message d'erreur est présent -->
    <?php if ($error): ?>
        <div class="d-flex align-items-center justify-content-center min-vh-100">
            <!-- Carte Bootstrap pour afficher l'erreur -->
            <div class="card border-danger shadow" style="max-width: 500px; width: 100%;">
                <div class="card-header bg-danger text-white text-center">
                    <h2>Erreur</h2>
                </div>
                <div class="card-body text-center">
                    <p class="card-text text-danger">
                        <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
                    </p>
                    <a href="?action=readAll" class="btn btn-primary mt-3">Retour à la liste</a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <!-- Si aucun message d'erreur n'est défini, rediriger vers la page principale -->
        <?php header('Location: ?action=readAll'); exit; ?>
    <?php endif; ?>
</body>

</html>
