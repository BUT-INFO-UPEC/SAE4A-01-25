<div class='dashboard-card test' id='comp<?= htmlspecialchars($params['chartId']) ?>'>
	<h4><?= htmlspecialchars($params['titre']) ?></h4>

	<style>
		.tab_div {
			overflow-x: scroll;
			max-width: 600px;
		}
	</style>
	<div class="tab_div">
		<table class="table table-bordered table-striped-columns table-responsive">

			<tbody>
				<?php
				// Obtenir le nombre de lignes (on suppose que toutes les colonnes ont le même nombre d'éléments)
				$rowCount = count(reset($data)); // Nombre de lignes dans la première colonne
				$validData = true;

				// Vérifier que toutes les colonnes ont le même nombre d'éléments
				foreach ($data as $colonne => $valeurs) {
					if (count($valeurs) != $rowCount) {
						$validData = false;
						break;
					}
				}

				if ($validData):
					// Boucler sur chaque ligne
					for ($i = 0; $i < $rowCount; $i++): ?>
						<tr>
							<?php foreach ($data as $colonne => $valeurs): ?>
								<td style="padding: 8px;">
									<?php
									$valeur = $valeurs[$i];
									// Vérifier si c'est une année (ou un entier sans décimales)
									if (is_numeric($valeur) && floor($valeur) == $valeur) {
										// Afficher sans décimales si c'est un entier (ex : année 2025)
										echo (int) $valeur;
									} else {
										// Sinon, formater avec 2 décimales
										echo is_numeric($valeur) ? number_format((float) $valeur, 2, '.', '') : htmlspecialchars($valeur);
									}
									?>
								</td>
							<?php endforeach; ?>
						</tr>
					<?php endfor; ?>
				<?php else: ?>
					<tr>
						<td colspan="<?= count($data) ?>" style="color: red; text-align: center;">Données inconsistantes : toutes les colonnes doivent avoir le même nombre de valeurs.</td>
					</tr>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>
