<button?php
use Src\Model\DataObject\Representation;
use Src\Model\DataObject\Attribut;
use Src\Model\DataObject\Aggregation;
use Src\Model\DataObject\Groupping;
?>
<form action="?action=save" method="POST" class="container-fluid mt-4">
	<div id="edit-btns" style="position: sticky;">
		<?php use Src\Config\UserManagement;
		if (UserManagement::getUser() != null) : ?>
			<button type="submit" class="btn btn-primary mb-4">Sauvegarder</button>
		<?php endif; ?>

		<button type="submit" class="btn btn-primary mb-4" formaction="?action=save&upload=false">
			visualiser
		</button>
	</div>

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

	<div class="card">
		<div class="mb-4 card-header">
			<h3 class="text-center">
				Stations analysées
			</h3>
			<hr>
			<div class="row">
				<!-- à prendre -->
				<?php include __DIR__ . '/../../Plugins/listElements.php'; ?>
				<!-- fin à prendre -->

				<div class="col-md-6">
					<h4>Periode temporelle</h4>
					<div class="mb-3">
						<label for="start_date" class="form-label">Date début :</label>
						<input type="text" id="start_date" name="start_date" class="form-control" placeholder="JJ/MM/AAAA">
						<div class="form-check">
							<input type="checkbox" class="form-check-input" id="dynamic_start" name="dynamic_start">
							<label class="form-check-label" for="dynamic_start">Dynamique</label>
						</div>
					</div>

					<div>
						<label for="end_date" class="form-label">Date fin :</label>
						<input type="text" id="end_date" name="end_date" class="form-control" placeholder="JJ/MM/AAAA">
						<div class="form-check">
							<input type="checkbox" class="form-check-input" id="dynamic_end" name="dynamic_end">
							<label class="form-check-label" for="dynamic_end">Dynamique</label>
						</div>
					</div>
				</div>

			</div>
		</div>

		<div ng-app="myApp" ng-controller="myCtrl">
			<ul class="nav nav-tabs">
				<li>
					<a href="#" ng-click="addTab()">Ajouter un onglet</a>
				</li>
				<li ng-repeat="tab in tabs" ng-class="{'active': tab.active}">
					<a href="#" ng-click="selectTab($index)">{{tab.name}}</a>
					<span ng-click="removeTab($index)" class="glyphicon glyphicon-remove" style="cursor: pointer;"></span>
				</li>
			</ul>
			<div class="mb-4">
				<h4 class="text-center">Analyses</h4>
				<div ng-repeat="tab in tabs" ng-show="tab.active">
					<div class="mb-4">
						<h4>Titre du composant</h4>
						<div class="row g-3">
							<div ng-include="tab.content"></div>
							<div class="col-md-6">
								<label for="titre_composant_{{ tab.id }}" class="form-label">Titre :</label>
								<input type="text" name="titre_composant_{{ tab.id }}" ng-model="tab.name" placeholder="Nom de l'onglet" class="form-control">
							</div>

							<p class="col-md-6">
								<label for="visu_type_{{tab.id}}" class="form-label">Type de visualisation :</label>
								<select id="visu_type_{{tab.id}}" name="visu_type_{{tab.id}}" class="form-select">
									<?php if (!empty($visu)): ?>
										<?php foreach ($visu as $item) : ?>
											<option value="<?= htmlspecialchars($item->get_id()) ?>"> <?= htmlspecialchars($item->get_nom()) ?></option>
										<?php endforeach; ?>
									<?php else: ?>
										<option value="">--</option>
									<?php endif; ?>
								</select>
							</p>
						</div>
					</div>

					<div class="row g-3 mt-3">
						<div class="col-md-4">
							<label for="value_type_{{tab.id}}" class="form-label">Valeur étudiée :</label>
							<select id="value_type_{{tab.id}}" name="value_type_{{tab.id}}" class="form-select">
								<?php if (!empty($attributs)): ?>
									<?php foreach ($attributs as $item) : ?>
										<option value="<?= htmlspecialchars($item->get_id()) ?>"><?= htmlspecialchars($item->get_nom()) ?></option>
									<?php endforeach; ?>
								<?php else: ?>
									<option value="">--</option>
								<?php endif; ?>
							</select>
						</div>

						<div class="col-md-4">
							<label for="association_{{tab.id}}" class="form-label">Association :</label>
							<select id="association_{{tab.id}}" name="association_{{tab.id}}" class="form-select">
								<?php if (!empty($grouping)): ?>
									<?php foreach ($grouping as $item) : ?>
										<option value="<?= htmlspecialchars($item->get_id()) ?>"><?= htmlspecialchars($item->get_nom()) ?></option>
									<?php endforeach; ?>
								<?php else: ?>
									<option value="">--</option>
								<?php endif; ?>
							</select>
						</div>

						<div class="col-md-4">
							<label for="analysis_{{tab.id}}" class="form-label">Analyse :</label>
							<select id="analysis_{{tab.id}}" name="analysis_{{tab.id}}" class="form-select">
								<?php if (!empty($aggregations)): ?>
									<?php foreach ($aggregations as $item) : ?>
										<option value="<?= htmlspecialchars($item->get_id()) ?>"><?= htmlspecialchars($item->get_nom()) ?></option>
									<?php endforeach; ?>
								<?php else: ?>
									<option value="">--</option>
								<?php endif; ?>
							</select>
						</div>
					</div>
				</div>

				<div class="mb-4">
					<h4>Commentaires</h4>
					<textarea name="comments_{{tab.id}}" id="comments_{{tab.id}}" class="form-control" rows="4" placeholder="Commentaires explicatifs de l'analyse"></textarea>
				</div>

			</div>
		</div>
	</div>
</form>