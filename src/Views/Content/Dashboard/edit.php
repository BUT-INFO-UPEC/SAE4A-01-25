<?php

use Src\Model\DataObject\Representation;
use Src\Model\DataObject\Attribut;
use Src\Model\DataObject\Aggregation;
use Src\Model\DataObject\Groupping;
?>
<form method="POST" action="?action=save" class="container-fluid mt-4">
	<div id="edit-btns" style="position: sticky;">
		<?php

		use Src\Config\UserManagement;

		if (UserManagement::getUser() != null && UserManagement::getUser()->getId() == $dash->get_createur()) : ?>
			<input type="submit" class="btn btn-primary mb-4" formaction="?action=save" value="Sauvegarder">
		<?php endif; ?>

		<input type="submit" class="btn btn-primary mb-4" formaction="?action=save&upload=false" value="visualiser" />

	</div>

	<div class="row mb-4">
		<div class="col-md-6">
			<label for="nom_meteotheque" class="form-label">Nom météothèque :</label>
			<input type="text" id="nom_meteotheque" name="nom_meteotheque" class="form-control" placeholder="Titre" value="<?= htmlspecialchars($dash_name) ?>" required>
		</div>
		<div class="col-md-6 text-end">
			<label for="visibility" class="form-label">Visibilité :</label>
			<select id="visibility" name="visibility" class="form-select" required>
				<option value="0" <?= $dash_private == "0" ? 'checked' : '' ?>>Publique</option>
				<option value="1" <?= $dash_private == "1" ? 'checked' : '' ?>>Privée</option>
			</select>
		</div>
	</div>
	<!-- input hidden pour donner le compte total des onglets -->
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
							<label class="form-check-label" for="dynamic_end" >Dynamique</label>
						</div>
					</div>
				</div>
			</div>
		</div>
		<input type="hidden" name="count_id" ng-value="count_id">
		<div ng-app="myApp" ng-controller="myCtrl">
			<ul class="nav nav-tabs onglet">
				<li>
					<a href="#" ng-click="addTab()">Ajouter un onglet</a>
				</li>
				<li ng-repeat="tab in tabs" ng-class="{'active': tab.active}">
					<a href="#" ng-click="selectTab($index)">{{tab.name}}</a>
					<span ng-click="removeTab($index)" class="glyphicon glyphicon-remove" style="cursor: pointer;"></span>
				</li>
			</ul>
			<div ng-repeat="tab in tabs" ng-show="tab.active">
				<div class="mb-4">
					<h4>Titre du composant</h4>
					<div class="row g-3">
						<div ng-include="tab.content"></div>
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
								class="form-select" required>
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
								class="form-select" required>
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
								class="form-select" required>
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
								class="form-select" required>
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

			<div class="mb-4">
				<h4>Commentaires</h4>
				<textarea name="comments_{{tab.id}}" id="comments_{{tab.id}}" class="form-control" rows="4" placeholder="Commentaires explicatifs de l'analyse"></textarea>
			</div>
		</div>
	</div>

	<input type="hidden" name="count_id" ng-value="count_id">
</form>


<script>

</script>