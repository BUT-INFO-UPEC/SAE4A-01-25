<?php

// Exemple de données utilisateur (à remplacer par une récupération depuis une base de données ou session)
$user = [
	'nom' => $_SESSION['login'],
	'email' => 'amine@example.com',
	'role' => 'Utilisateur',
	'date_inscription' => '2024-01-01',
];
?>

<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/styleProfile.css">

<div class="row w-100">
	<div class="col-md-6">
		<div class="card">
			<div class="card-body">
				<h5 class="card-title">Dashboard Utilisateur</h5>
				<p><strong>Nom :</strong> <?php echo htmlspecialchars($user['nom']); ?></p>
				<p><strong>Email :</strong> <?php echo htmlspecialchars($user['email']); ?></p>
				<p><strong>Rôle :</strong> <?php echo htmlspecialchars($user['role']); ?></p>
				<p><strong>Date d'inscription :</strong> <?php echo htmlspecialchars($user['date_inscription']); ?></p>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="card">
			<div class="card-body">
				<h5 class="card-title">Statistiques Utilisateur</h5>
				<p><strong>Nombre de connexions :</strong> 10</p>
				<p><strong>Dernière connexion :</strong> <?php echo htmlspecialchars(date("Y-m-d")); ?> </p>
				<p><strong>Nombre de publications :</strong> 5</p>
			</div>
		</div>
	</div>
</div>
