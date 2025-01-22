<form action="/?action=crea_dasbord" methods="POST">
	<div class="dropdown" style="position: absolute; right: 0;">
		<label>Visibilité :</label>

		<select>
			<option>Public</option>
		</select>
	</div>

	<button style="position: absolute; left: 0;" type="submit">
		Sauvegarder
	</button>

	<h1 class="centered">
		<label for="nom_meteotheque"> Nom météothèque : </label>
		<input type="text" placeholder="Titre">
	</h1>

	<div class="container">
		<h3 class="centered"> Stations analysées </h3>

		<hr />

		<div class="flex">
			<div class="container">
				<h3> Zone(s) géographique(s) </h3>

				<div class="zone_geo">
					<select name="Stations" id="Stations" class="form-control">
						<option value="">Liste des stations</option>
						<?php foreach ($stations as $station) : ?>
							<option value="<?php echo  $station['id'] ?>"><?php echo htmlspecialchars($station['name']) ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<a href="">liste des ...</a>
			</div>

			<div class="container">
				<h3 style="flex-grow: 1"> Periode temporelle </h3>

				<div>
					<label>Date début :</label>
					<input type="text" placeholder="JJ/MM/AAAA">

					<input type="checkbox"> Dynamique <button class="btn indice"> ? </button>
				</div>

				<div>
					<label>Date fin :</label>
					<input type="text" placeholder="JJ/MM/AAAA">

					<input type="checkbox"> Dynamique <button class="btn indice"> ? </button>
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="flex">
			<div class="container">
				Volume des précipitations moyennes par saison (rr3, camambert)
			</div>

			<div class="container">
				Moyenne température (tc, donnée chiffrée)
			</div>

			<div class="container">
				Evolution pression moyenne au cours de l'année (pres, courbe)
			</div>
		</div>

		<hr>

		<div class="visualization-settings">
			<div class="flex">
				<div>
					<h3>
						<label for="titre_composant"> Titre du composant: </label>
						<input type="text" placeholder="Moyenne Température">
					</h3>

					<div class="dropdown">
						<label>Type de visualisation : </label>

						<select>
							<option>Donnée chiffrée</option>
						</select>
					</div>
				</div>

				<div>
					<div class="dropdown">
						<label>Valeur étudiée :</label>

						<select>
							<option>Température Celsius (tc)</option>
						</select>
					</div>

					<div class="dropdown">
						<label>Association :</label>

						<select>
							<option>Total</option>
						</select>
					</div>

					<div class="analysis-options">
						<label>Analyse :</label>

						<select>
							<option>Moyenne</option>
							<option>Minimum</option>
							<option>Maximum</option>
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<h3> Commentaires </h3>

		<textarea class="changing"> commentaires explicatifs de l'analyse </textarea>
	</div>

</form>