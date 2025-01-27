<div class="col-md-6 card">
	<h4>Zone(s) géographique(s)</h4>
	<!-- Nav tabs -->
	<ul class="nav nav-tabs" id="myTab" role="tablist">
		<li class="nav-item" role="presentation">
			<button
				class="nav-link active"
				id="regions-tab"
				data-bs-toggle="tab"
				data-bs-target="#regions"
				type="button"
				role="tab"
				aria-controls="regions"
				aria-selected="true">
				Régions
			</button>
		</li>
		<li class="nav-item" role="presentation">
			<button
				class="nav-link"
				id="depts-tab"
				data-bs-toggle="tab"
				data-bs-target="#depts"
				type="button"
				role="tab"
				aria-controls="depts"
				aria-selected="false">
				Départements
			</button>
		</li>
		<li class="nav-item" role="presentation">
			<button
				class="nav-link"
				id="villes-tab"
				data-bs-toggle="tab"
				data-bs-target="#villes"
				type="button"
				role="tab"
				aria-controls="villes"
				aria-selected="false">
				Villes
			</button>
		</li>
		<li class="nav-item" role="presentation">
			<button
				class="nav-link"
				id="stations-tab"
				data-bs-toggle="tab"
				data-bs-target="#stations"
				type="button"
				role="tab"
				aria-controls="stations"
				aria-selected="false">
				Stations
			</button>
		</li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<div class="tab-pane active" id="regions" role="tabpanel" aria-labelledby="regions-tab">
			<div class="list-group check">
				<?php if (!empty($regions) && is_array($regions)) : ?>
					<?php foreach ($regions as $item) : ?>
						<label class="list-group-item">
							<input class="form-check-input scroll me-1" type="checkbox" value="<?= htmlspecialchars($item['id']) ?>" />
							<?= htmlspecialchars($item['name']) ?>
						</label>
					<?php endforeach; ?>
				<?php else : ?>
					<p>Aucune région disponible.</p>
				<?php endif; ?>
			</div>
		</div>

		<div class="tab-pane" id="depts" role="tabpanel" aria-labelledby="depts-tab">
			<div class="list-group check">
				<?php if (!empty($depts) && is_array($depts)) : ?>
					<?php foreach ($depts as $item) : ?>
						<label class="list-group-item">
							<input class="form-check-input scroll me-1" type="checkbox" value="<?= htmlspecialchars($item['id']) ?>" />
							<?= htmlspecialchars($item['name']) ?>
						</label>
					<?php endforeach; ?>
				<?php else : ?>
					<p>Aucun département disponible.</p>
				<?php endif; ?>
			</div>
		</div>

		<div class="tab-pane" id="villes" role="tabpanel" aria-labelledby="villes-tab">
			<div class="list-group check">
				<?php if (!empty($villes) && is_array($villes)) : ?>
					<?php foreach ($villes as $item) : ?>
						<label class="list-group-item">
							<input class="form-check-input scroll me-1" type="checkbox" value="<?= htmlspecialchars($item['id']) ?>" />
							<?= htmlspecialchars($item['name']) ?>
						</label>
					<?php endforeach; ?>
				<?php else : ?>
					<p>Aucune ville disponible.</p>
				<?php endif; ?>
			</div>
		</div>

		<div class="tab-pane" id="stations" role="tabpanel" aria-labelledby="stations-tab">
			<div class="list-group check">
				<?php if (!empty($stations) && is_array($stations)) : ?>
					<?php foreach ($stations as $item) : ?>
						<label class="list-group-item">
							<input class="form-check-input scroll me-1" type="checkbox" value="<?= htmlspecialchars($item['id']) ?>" />
							<?= htmlspecialchars($item['name']) ?>
						</label>
					<?php endforeach; ?>
				<?php else : ?>
					<p>Aucune station disponible.</p>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
