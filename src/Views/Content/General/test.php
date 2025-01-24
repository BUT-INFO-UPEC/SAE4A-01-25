<?php
// Afficher $data pour débogage
echo '<pre>';
print_r($data);
echo '</pre>';

// Décoder $data en tableau associatif
$dataDecoded = json_decode($data, true);

if ($dataDecoded && isset($dataDecoded['data']['results'])): ?>
    <div class="col-md-4">
        <?php foreach ($dataDecoded['data']['results'] as $result): ?>
            <div class="card">
                <p><strong>Température moyenne :</strong> <?= $result['min(t)'] ?> </p>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>Aucune donnée trouvée.</p>
<?php endif; ?>
