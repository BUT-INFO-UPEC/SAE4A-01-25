<div id="nom_staion">
	<h2>Informations Générales sur <span>stations</span></h2>

</div>

<div id="info_station">
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th>Nom Station</th>
				<th>Ville</th>
				<th>Départment</th>
				<th>Région</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><?= $station['station_name'] ?></td>
				<td><?= $station['ville_name'] ?></td>
				<td><?= $station['dept_name'] ?></td>
				<td><?= $station['region_name'] ?></td>
			</tr>
		</tbody>
	</table>

</div>
