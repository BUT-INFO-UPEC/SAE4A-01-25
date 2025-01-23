<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/styleProfile.css">
<div class="row w-100">
	<div class="col-md-6">
		<div class="card">
			<h5 class="card-header">Informations Utilisateur</h5>
				<div class="card-body">
					<p><strong>Nom</strong> : <?= htmlspecialchars($user['utilisateur_nom']) ?></p>
					<p><strong>Prenom</strong> : <?= htmlspecialchars($user['utilisateur_prenom']) ?></p>
					<p><strong>Email</strong> : <?= htmlspecialchars($user['utilisateur_mail']) ?></p>
					<p><strong>Créer le</strong> : <?= htmlspecialchars($user['created_at']) ?></p>
				</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="card">
			<div class="card-body">
				<h5 class="card-title">Statistiques Utilisateur</h5>
				<p><strong>Nombre de connexions :</strong><?=htmlspecialchars($user['utilisateur_nb_conn']) ?></p>
				<p><strong>Dernière connexion :</strong> <?= htmlspecialchars($user['utilisateur_last_conn']) ?> </p>
				<p><strong>Nombre de publications :</strong> 5</p>
			</div>
		</div>
	</div>
</div>
