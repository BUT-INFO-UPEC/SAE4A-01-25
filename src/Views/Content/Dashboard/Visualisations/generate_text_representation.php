<div class='dashboard-card' id='comp<?= $params['chartId'] ?>'>
	<h4><?= $params['titre'] ?></h4>
	<?php var_dump($data); ?>

	<p><?= htmlspecialchars($data[$composant->get_keyTargetValue()]) ?></p>
</div>