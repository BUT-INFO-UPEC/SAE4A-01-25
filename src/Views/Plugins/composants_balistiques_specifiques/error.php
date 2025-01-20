<!DOCTYPE html>
<html lang="fr">

<body>
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
          <a href="/sae/Controller/?action=accueil" class="btn btn-primary mt-3">Retour à la liste</a>
        </div>
      </div>
    </div>
</body>

</html>