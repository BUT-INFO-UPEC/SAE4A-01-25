<div class='dashboard-card' id='comp<?= $params['chartId'] ?>'>
    <h4><?= $params['titre'] ?></h4>

    <!-- AJouter une mise en forme de $data en tableau -->
    <table>
        <thead>
            <tr>
                <?php foreach ($data as $header): ?>
                    <th><?= htmlspecialchars($header[0]) ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <tr>
                <?php foreach ($data as $donnee): ?>
                    <td><?= htmlspecialchars($donnee[1]) ?></td>
                <?php endforeach; ?>
            </tr>
        </tbody>
    </table>

</div>