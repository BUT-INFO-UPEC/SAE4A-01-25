<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/styleProfile.css">

<div class="flex justify-content-center gap-2">
	<!-- Informations utilisateur -->
	<div class="w-100">
		<div class="card">
			<h5 class="card-header">Informations Utilisateur</h5>
			<div class="card-body">
				<p><strong>Nom :</strong> <?= htmlspecialchars($user->getNom() ?? 'Non renseigné') ?></p>
				<p><strong>Prénom :</strong> <?= htmlspecialchars($user->getPrenom() ?? 'Non renseigné') ?></p>
				<p><strong>Email :</strong> <?= htmlspecialchars($user->getEmail() ?? 'Non renseigné') ?></p>
				<p><strong>Créer le :</strong> <?= htmlspecialchars($user->getUtilisateur_crea() ?? 'Non renseigné') ?></p>
			</div>
		</div>
	</div>

	<!-- Statistiques utilisateur -->
	<div class="w-100">
		<div class="card">
			<h5 class="card-header">Statistiques Utilisateur</h5>
			<div class="card-body">
				<p><strong>Nombre de publications :</strong> <?= htmlspecialchars($user->getNbPubli() ?? 0) ?></p>
			</div>
		</div>
	</div>
</div>