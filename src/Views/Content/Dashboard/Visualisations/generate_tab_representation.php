<div class='dashboard-card' id='comp<?= htmlspecialchars($params['chartId']) ?>'>
    <h4><?= htmlspecialchars($params['titre']) ?></h4>

    <table border="1" style="border-collapse: collapse; width: 100%; text-align: center;">
        
        <tbody>
            <?php 
            $rowCount = count(reset($data)); 
            $validData = true;

            foreach ($data as $colonne => $valeurs) {
                if (count($valeurs) != $rowCount) {
                    $validData = false;
                    break;
                }
            }

            if ($validData):
                for ($i = 0; $i < $rowCount; $i++): ?>
                    <tr>
                        <?php foreach ($data as $colonne => $valeurs): ?>
                            <td style="padding: 8px;">
                                <?php 
                                $valeur = $valeurs[$i];
                                if (is_numeric($valeur) && floor($valeur) == $valeur) {
                                    echo (int) $valeur;
                                } else {
                                    echo is_numeric($valeur) ? number_format((float) $valeur, 2, '.', '') : htmlspecialchars($valeur);
                                }
                                ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endfor; ?>
            <?php else: ?>
                <tr><td colspan="<?= count($data) ?>" style="color: red; text-align: center;">Données inconsistantes : toutes les colonnes doivent avoir le même nombre de valeurs.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
