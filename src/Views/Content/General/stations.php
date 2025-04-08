<!-- Ajouter les fichiers CSS et JS pour DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<style>
	tbody tr {
		cursor: pointer;
	}
</style>

<!-- Table avec l'ID "stations_table" -->
<table id="stations_table" class="display table table-striped table-hover">
	<thead>
		<tr>
			<a href="#">
				<th>Nom Station<br><select id="filter_station" class="form-select">
						<option value="">Tous</option>
					</select></th>
				<th>Ville<br><select id="filter_ville" class="form-select">
						<option value="">Toutes</option>
					</select></th>
				<th>Département<br><select id="filter_dept" class="form-select">
						<option value="">Tous</option>
					</select></th>
				<th>Région<br><select id="filter_region" class="form-select">
						<option value="">Toutes</option>
					</select></th>
				<th>Action</th>
			</a>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($stations as $item): ?>
			<tr>
				<td><?= htmlspecialchars($item['station_name']) ?></td>
				<td><?= htmlspecialchars($item['ville_name']) ?></td>
				<td><?= htmlspecialchars($item['dept_name']) ?></td>
				<td><?= htmlspecialchars($item['region_name']) ?></td>
				<th>
					<a href="<?= BASE_URL ?>?controller=ControllerGeneral&action=info_station&id=<?= $item['station_id'] ?>"></a>
					<button class="btn btn-primary">Voir</button>
				</th>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<script>
	$(document).ready(function() {
		const table = $('#stations_table').DataTable({
			order: [
				[0, 'asc']
			],
			searching: true,
			paging: false, // Désactive la pagination
			info: false
		});

		function populateFilter(columnIndex, selectId) {
			const uniqueValues = new Set();
			table.column(columnIndex).data().each(value => {
				uniqueValues.add(value.trim());
			});
			uniqueValues.forEach(value => {
				$(selectId).append(`<option value="${value}">${value}</option>`);
			});
		}

		populateFilter(0, "#filter_station");
		populateFilter(1, "#filter_ville");
		populateFilter(2, "#filter_dept");
		populateFilter(3, "#filter_region");

		$("#filter_station, #filter_ville, #filter_dept, #filter_region").on("change", function() {
			table.column(0).search($("#filter_station").val());
			table.column(1).search($("#filter_ville").val());
			table.column(2).search($("#filter_dept").val());
			table.column(3).search($("#filter_region").val());
			table.draw();
		});
	});
</script>
