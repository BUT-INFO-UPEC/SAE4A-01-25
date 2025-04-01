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
			<tr onclick="window.location.href='<?= BASE_URL ?>?controller=ControllerGeneral&action=info_station&id=<?= $item['station_id'] ?>'">
				<td><?= htmlspecialchars($item['station_name']) ?></td>
				<td><?= htmlspecialchars($item['ville_name']) ?></td>
				<td><?= htmlspecialchars($item['dept_name']) ?></td>
				<td><?= htmlspecialchars($item['region_name']) ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<script>
	// Activer DataTables sur le tableau
	$(document).ready(function() {
		$('#stations_table').DataTable({
			order: [
				[0, 'asc']
			], // Tri par défaut sur la première colonne (Nom Station)
			searching: true, // Activer la recherche
			paging: true, // Activer la pagination (changer à false si non souhaité)
			info: false // Afficher le nombre d'éléments
		});
	});
</script>
