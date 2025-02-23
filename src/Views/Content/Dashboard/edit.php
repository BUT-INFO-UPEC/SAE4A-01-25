<form method="POST" action="?action=save&upload=false" class="container-fluid mt-4">
	<div id="edit-btns" style="position: sticky; top: 0; z-index: 100;">
		<?php

		use Src\Config\SessionManagement;
		use Src\Model\DataObject\Composant;

		if (SessionManagement::getUser() != null && SessionManagement::getUser()->getId() == $dash->get_createur()) : ?>
			<input type="submit" class="btn btn-primary mb-4" value="Sauvegarder">
		<?php endif;

		if (SessionManagement::getUser() != null) : ?>
			<input type="submit" class="btn btn-primary mb-4" formaction="?action=save&duplicate=true" value="Dupliquer">
		<?php endif; ?>
		<?php if (SessionManagement::getUser() != null && SessionManagement::getUser()->getId() == $dash->get_createur()) : ?>
			<input type="submit" class="btn btn-danger mb-4" formaction="?action=delete&dash_id=<?= $dashid ?>" value="Supprimer">
		<?php endif; ?>

		<input type="submit" class="btn btn-primary mb-4" value="Visualiser" />

	</div>

	<div class="row mb-4">
		<div class="col-md-6">
			<label for="nom_meteotheque" class="form-label">Nom météothèque :</label>
			<input type="text" id="nom_meteotheque" name="nom_meteotheque" class="form-control" placeholder="Titre" value="<?= htmlspecialchars($dash_name) ?>" required>
		</div>
		<div class="col-md-6 text-end">
			<label for="visibility" class="form-label">Visibilité :</label>
			<select id="visibility" name="visibility" class="form-select" required>
				<option value="0" <?= $dash_private == "publique" ? 'selected' : '' ?>>Publique</option>
				<option value="1" <?= $dash_private == "privé" ? 'selected' : '' ?>>Privée</option>
			</select>
		</div>
	</div>

	<div class="card">
		<div class="mb-4 card-header">
			<h3 class="text-center">
				Stations analysées
			</h3>
			<hr>
			<div class="row">
				<div class="col-md-6 card">
					<?php include __DIR__ . '/../../Plugins/listElements.php'; ?>
				</div>

				<div class="col-md-6">
					<h4>Période temporelle</h4>
					<div class="mb-3">
						<label for="start_date" class="form-label">Date début :</label>
						<input type="text" id="start_date" name="start_date" class="form-control" placeholder="JJ/MM/AAAA" value="<?= htmlspecialchars($dash_date_debut) ?>" required>
						<div class="form-check">
							<input type="checkbox" class="form-check-input" id="dynamic_start" name="dynamic_start" <?= $dash_date_debut_r ? 'checked' : '' ?>>
							<label class="form-check-label" for="dynamic_start">Dynamique</label>
						</div>
					</div>
					<div>
						<label for="end_date" class="form-label">Date fin :</label>
						<input type="text" id="end_date" name="end_date" class="form-control" placeholder="JJ/MM/AAAA" value="<?= htmlspecialchars($dash_date_fin) ?>" required>
						<div class="form-check">
							<input type="checkbox" class="form-check-input" id="dynamic_end" name="dynamic_end" <?= $dash_date_fin_r ? 'checked' : '' ?>>
							<label class="form-check-label" for="dynamic_end">Dynamique</label>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div ng-app="myApp" ng-controller="myCtrl">
			<ul class="nav nav-tabs onglet">
				<li>
					<a ng-click="addTab()">Ajouter un onglet</a>
				</li>
				<li ng-repeat="tab in tabs" ng-class="{'active': tab.active}">
					<a ng-click="selectTab($index)">{{tab.name}}</a>
					<span ng-click="removeTab($index)" class="glyphicon glyphicon-remove" style="cursor: pointer;">&times;</span>
				</li>
			</ul>

			<div ng-repeat="tab in tabs" ng-show="tab.active">
				<div class="mb-4">
					<h4>Titre du composant</h4>
					<div class="row g-3">
						<div class="col-md-6">
							<label class="form-label">Titre :</label>
							<input type="text"
								name="titre_composant_{{tab.id}}"
								ng-model="tab.name"
								placeholder="Nom de l'onglet"
								class="form-control" required>
						</div>

						<div class="col-md-6">
							<label for="visu_type_{{tab.id}}" class="form-label">Type de visualisation :</label>
							<select id="visu_type_{{tab.id}}"
								name="visu_type_{{tab.id}}"
								class="form-select"
								ng-model="tab.selectedVisu"
								required>
								<?php if (!empty($represtation)) : ?>
									<?php foreach ($represtation as $item) : ?>
										<option value="<?= htmlspecialchars($item->get_id()) ?>">
											<?= htmlspecialchars($item->get_nom()) ?>
										</option>
									<?php endforeach; ?>
								<?php else : ?>
									<option value="">--</option>
								<?php endif; ?>
							</select>
						</div>
					</div>

					<div class="row g-3">
						<div class="col-md-6">
							<label for="value_type_{{tab.id}}" class="form-label">Valeur étudiée :</label>
							<select id="value_type_{{tab.id}}"
								name="value_type_{{tab.id}}"
								class="form-select"
								ng-model="tab.selectedValue"
								required>
								<?php if (!empty($valeurs)) : ?>
									<?php foreach ($valeurs as $item) : ?>
										<option value="<?= htmlspecialchars($item->get_id()) ?>">
											<?= htmlspecialchars($item->get_nom()) ?>
										</option>
									<?php endforeach; ?>
								<?php else : ?>
									<option value="">--</option>
								<?php endif; ?>
							</select>
						</div>

						<div class="col-md-6">
							<label for="association_{{tab.id}}" class="form-label">Association :</label>
							<select id="association_{{tab.id}}"
								name="association_{{tab.id}}"
								class="form-select"
								ng-model="tab.selectedGroup"
								required>
								<?php if (!empty($association)) : ?>
									<?php foreach ($association as $item) : ?>
										<option value="<?= htmlspecialchars($item->get_id()) ?>">
											<?= htmlspecialchars($item->get_nom()) ?>
										</option>
									<?php endforeach; ?>
								<?php else : ?>
									<option value="">--</option>
								<?php endif; ?>
							</select>
						</div>

						<div class="col-md-6">
							<label for="analysis_{{tab.id}}" class="form-label">Analyse :</label>
							<select id="analysis_{{tab.id}}"
								name="analysis_{{tab.id}}"
								class="form-select"
								ng-model="tab.selectedAggreg"
								required>
								<?php if (!empty($analysis)) : ?>
									<?php foreach ($analysis as $item) : ?>
										<option value="<?= htmlspecialchars($item->get_id()) ?>">
											<?= htmlspecialchars($item->get_nom()) ?>
										</option>
									<?php endforeach; ?>
								<?php else : ?>
									<option value="">--</option>
								<?php endif; ?>
							</select>
						</div>
					</div>
				</div>
			</div>

			<input type="hidden" id="comp_count" name="comp_count" value="{{comp_count}}">
		</div>

		<div class="mb-4">
			<h4>Commentaires</h4>
			<textarea name="comments" id="comments" class="form-control" rows="4" placeholder="Commentaires explicatifs de l'analyse"><?= $dash->get_comment(); ?></textarea>
		</div>
	</div>
</form>

<script>
	// Ton code JS pour la gestion des onglets et des données
	angular.module('myApp', [])
		.controller('myCtrl', function($scope) {
			$scope.tabs = <?= json_encode(array_map(function ($composant, $index) {
								return [
									"id" => $index,
									"name" => htmlspecialchars($composant->get_params()["titre"]),
									"active" => $index === 0,
									"selectedVisu" => (string)$composant->get_representation()->get_id(),
									"selectedAggreg" => (string)$composant->get_aggregation()->get_id(),
									"selectedGroup" => (string)$composant->get_grouping()->get_id(),
									"selectedValue" => (string)$composant->get_attribut()->get_id(),
								];
							}, $composants, array_keys($composants))); ?>;

			$scope.comp_count = $scope.tabs.length; // Initialisation du compteur d'onglets

			$scope.addTab = function() {
				var newTabIndex = $scope.tabs.length;
				$scope.tabs.push({
					id: newTabIndex,
					name: 'Onglet ' + newTabIndex,
					active: false,
					selectedVisu: "1",
					selectedAggreg: "1",
					selectedGroup: "1",
					selectedValue: "1"
				});
				$scope.comp_count = $scope.tabs.length; // Mise à jour du compteur d'onglets
			};

			$scope.selectTab = function(index) {
				$scope.tabs.forEach(function(tab, i) {
					tab.active = (i === index);
				});
			};

			$scope.removeTab = function(index) {
				$scope.tabs.splice(index, 1);

				// Recalculer et renuméroter les onglets
				$scope.tabs.forEach(function(tab, i) {
					tab.id = i; // Déplacer les indices des onglets (id = i + 1)
				});

				if ($scope.tabs.length === 0) {
					$scope.addTab(); // Ajouter un nouvel onglet si tout est supprimé
				}

				$scope.comp_count = $scope.tabs.length; // Mise à jour du compteur d'onglets
			};
		});
</script>
