<link rel="stylesheet" href="/assets/css/styleProfile.css">
<div class="flex justify-content-cetner gap-2">
	<div class="w-100">
		<div class="card">
			<h5 class="card-header">Informations Utilisateur</h5>
			<div class="card-body">
				<p><strong>Nom</strong>: <?= htmlspecialchars($user['utilisateur_nom']) ?></p>
				<p><strong>Prénom</strong>: <?= htmlspecialchars($user['utilisateur_prenom']) ?></p>
				<p><strong>Email</strong>: <?= htmlspecialchars($user['utilisateur_mail']) ?></p>
				<p><strong>Créer le</strong>: <?= htmlspecialchars($user['created_at']) ?></p>
			</div>
		</div>
	</div>
	<div class="w-100">
		<div class="card">
			<h5 class="card-header">Statistiques Utilisateur</h5>
			<div class="card-body">
				<p><strong>Nombre de connexions :</strong><?= htmlspecialchars($user['utilisateur_nb_conn']) ?></p>
				<?php if (!empty($user['utilisateur_last_conn'])): ?>
					<p><strong>Dernière connexion :</strong> <?= htmlspecialchars($user['utilisateur_last_conn']) ?> </p>
				<?php else: ?>
					<p><strong>Dernière connexion :</strong> 0</p>
				<?php endif; ?>
				<p><strong>Nombre de publications :</strong> 5</p>
			</div>
		</div>
	</div>
</div>