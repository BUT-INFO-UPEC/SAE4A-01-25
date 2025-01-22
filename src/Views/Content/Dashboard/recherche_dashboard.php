<?php
require_once __DIR__ . "/../../Model/entete.php";

// Démarrer la mise en tampon pour capturer le contenu spécifique
ob_start();
?>

<form method="GET" class="dashboard-search">
	<input type="text" placeholder="Recherchez un Dashboard">
	<button type="submit" style="border-radius: 5px;">Rechercher</button>
</form>

<style>
	.dashboard-search {
		display: flex;
		align-items: center;
		justify-content: center;
		padding: 3vh;
		background-color: #999999;
		border-radius: 2vh;
	}

	.dashboard-search input {
		flex: 1;
		margin-right: 1.5vh;
		padding: 2vh;
		font-size: 2vh;
		border: none;
		border-radius: 1.5vh;
		background-color: #f9f9f9;
		outline: none;
	}

	.dashboard-search button {
		padding: 2vh 4vh;
		font-size: 2vh;
		color: white;
		background-color: #343a40;
		border: none;
		border-radius: 1.5vh;
		cursor: pointer;
		transition: background-color 0.3s;
	}

	.dashboard-search button:hover {
		background-color: #000000;
	}
</style>

<form action="/web/?action=search_dasbord">

</form>

<?php
// Récupération du contenu html/php
$main = ob_get_clean();
// Chargement du Layout APRES avoir Récupérer le contenu pour qu'il puisse le mettre en forme
include "../Layout.php";
?>