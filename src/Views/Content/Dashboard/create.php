<form action="/?action=crea_dasbord" method="POST" class="container-fluid mt-4">
	<div class="row mb-4">
		<div class="col-md-6">
			<label for="nom_meteotheque" class="form-label">Nom météothèque :</label>
			<input type="text" id="nom_meteotheque" name="nom_meteotheque" class="form-control" placeholder="Titre">
		</div>
		<div class="col-md-6 text-end">
			<label for="visibility" class="form-label">Visibilité :</label>
			<select id="visibility" name="visibility" class="form-select">
				<option>Public</option>
			</select>
		</div>
	</div>

	<button type="submit" class="btn btn-primary mb-4">Sauvegarder</button>

	<div class="mb-4">
		<h3 class="text-center">Stations analysées</h3>
		<hr>
		<div class="row">
			<div class="col-md-6">
				<h4>Zone(s) géographique(s)</h4>
				<select name="Stations" id="Stations" class="form-select mb-3">
					<option value="">Liste des stations</option>
					<?php foreach ($stations as $station) : ?>
						<option value="<?php echo $station['id'] ?>">
							<?php echo htmlspecialchars($station['name']) ?>
						</option>
					<?php endforeach; ?>
				</select>
				<a href="#">Liste des ...</a>
			</div>

			<div class="col-md-6">
				<h4>Periode temporelle</h4>
				<div class="mb-3">
					<label for="start_date" class="form-label">Date début :</label>
					<input type="text" id="start_date" name="start_date" class="form-control" placeholder="JJ/MM/AAAA">
					<div class="form-check">
						<input type="checkbox" class="form-check-input" id="dynamic_start">
						<label class="form-check-label" for="dynamic_start">Dynamique</label>
					</div>
				</div>

				<div>
					<label for="end_date" class="form-label">Date fin :</label>
					<input type="text" id="end_date" name="end_date" class="form-control" placeholder="JJ/MM/AAAA">
					<div class="form-check">
						<input type="checkbox" class="form-check-input" id="dynamic_end">
						<label class="form-check-label" for="dynamic_end">Dynamique</label>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="mb-4">
		<h4 class="text-center">Analyses</h4>
		<div class="row">
			<div class="col-md-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Volume des précipitations moyennes par saison</h5>
						<p class="card-text">(rr3, camembert)</p>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Moyenne température</h5>
						<p class="card-text">(tc, donnée chiffrée)</p>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Évolution pression moyenne au cours de l'année</h5>
						<p class="card-text">(pres, courbe)</p>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="mb-4">
		<h4>Titre du composant</h4>
		<div class="row g-3">
			<div class="col-md-6">
				<label for="titre_composant" class="form-label">Titre :</label>
				<input type="text" id="titre_composant" name="titre_composant" class="form-control" placeholder="Moyenne Température">
			</div>

			<div class="col-md-6">
				<label for="visualization_type" class="form-label">Type de visualisation :</label>
				<select id="visualization_type" name="visualization_type" class="form-select">
					<option>Donnée chiffrée</option>
				</select>
			</div>
		</div>

		<div class="row g-3 mt-3">
			<div class="col-md-4">
				<label for="value_type" class="form-label">Valeur étudiée :</label>
				<select id="value_type" name="value_type" class="form-select">
					<option>Température Celsius (tc)</option>
				</select>
			</div>

			<div class="col-md-4">
				<label for="association" class="form-label">Association :</label>
				<select id="association" name="association" class="form-select">
					<option>Total</option>
				</select>
			</div>

			<div class="col-md-4">
				<label for="analysis" class="form-label">Analyse :</label>
				<select id="analysis" name="analysis" class="form-select">
					<option>Moyenne</option>
					<option>Minimum</option>
					<option>Maximum</option>
				</select>
			</div>
		</div>
	</div>

	<div class="mb-4">
		<h4>Commentaires</h4>
		<textarea name="comments" id="comments" class="form-control" rows="4" placeholder="Commentaires explicatifs de l'analyse"></textarea>
	</div>
</form>