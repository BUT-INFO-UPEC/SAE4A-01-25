<div class='dashboard-card' id='comp<?= $params['chartId'] ?>'>
	<h4><?= $params['titre'] ?></h4>

	<!-- <p><?= htmlspecialchars($data) ?></p> -->
	<!-- AJouter une mise en forme de $data en tableau -->
	<table>
    <thead>
        <tr>
            <?php foreach ($data as $header): ?>
                <th><?= htmlspecialchars($header) ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach($data as $donnee): ?>
            <tr>
                <?php foreach ($donnee as $value): ?>
                    <td><?= htmlspecialchars($value) ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</div>