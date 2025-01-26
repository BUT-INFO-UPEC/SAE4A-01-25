<link rel="stylesheet" href="/assets/css/styleProfile.css">

<div class="flex justify-content-center gap-2">
	<!-- Informations utilisateur -->
	<div class="w-100">
		<div class="card">
			<h5 class="card-header">Informations Utilisateur</h5>
			<div class="card-body">
				<p><strong>Nom :</strong> <?= htmlspecialchars($user['utilisateur_nom'] ?? 'Non renseigné') ?></p>
				<p><strong>Prénom :</strong> <?= htmlspecialchars($user['utilisateur_prenom'] ?? 'Non renseigné') ?></p>
				<p><strong>Email :</strong> <?= htmlspecialchars($user['utilisateur_mail'] ?? 'Non renseigné') ?></p>
				<p><strong>Créer le :</strong> <?= htmlspecialchars($user['created_at'] ?? 'Non renseigné') ?></p>
			</div>
		</div>
	</div>

	<!-- Statistiques utilisateur -->
	<div class="w-100">
		<div class="card">
			<h5 class="card-header">Statistiques Utilisateur</h5>
			<div class="card-body">
				<p><strong>Nombre de connexions :</strong> <?= htmlspecialchars($user['utilisateur_nb_conn'] ?? 0) ?></p>
				<p><strong>Dernière connexion :</strong>
					<?= htmlspecialchars($user['utilisateur_last_conn'] ?? 'Non disponible') ?></p>
				<p><strong>Nombre de publications :</strong> <?= htmlspecialchars($user['utilisateur_nb_pub'] ?? 0) ?></p>
			</div>
		</div>
	</div>
</div>