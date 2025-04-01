<!-- Ajouter les fichiers CSS et JS pour DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<style>
	tbody tr {
		cursor: pointer;
	}
</style>

<!-- Table avec l'ID "stations_table" -->
<table id="stations_table" class="table table-striped table-hover">
	<thead>
		<tr>
			<th>Nom Station</th>
			<th>Ville</th>
			<th>Départment</th>
			<th>Région</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($stations as $item) : ?>
			<tr>
				<td><?= $item['station_name'] ?></td>
				<td><?= $item['ville_name'] ?></td>
				<td><?= $item['dept_name'] ?></td>
				<td><?= $item['region_name'] ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<script>
	// Activer DataTables sur le tableau
	$(document).ready(function() {
		$('#stations_table').DataTable({
			// Options personnalisées si nécessaire
			order: [
				[0, 'asc'], // Tri par défaut sur la première colonne (Nom Station)
			], // Pas de tri par défaut
			searching: true, // Activer la recherche
			paging: false, // Activer la pagination
			info: true, // Désactiver l'info sur le nombre d'éléments
		});
	});
</script>
