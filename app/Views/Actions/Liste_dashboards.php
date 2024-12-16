<?php

namespace App\Views\Actions;

require_once __DIR__ . "/../../Model/Classes/Dashboard.php";
require_once __DIR__ . "/../../Model/Entete.php";

use App\Model\Classes\Dashboard;

// Démarrer la mise en tampon pour capturer le contenu spécifique
ob_start();
?>

<div class="list-dash">
    <ul>
        <?php foreach (Dashboard::get_dashboards() as $dash) : ?>
            <?php $lien = dirname($_SERVER['PHP_SELF']) . "/visu_dashboard?dashId=" . $dash->get_id(); ?>
            <li class="card">
                <a href="<?= $lien ?>" class="card-body">
                    <?= htmlspecialchars($dash->get_name()) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<?php
// Récupération du contenu html/php
$main = ob_get_clean();

// Chargement du Layout APRES avoir Récupéré le contenu pour qu'il puisse le mettre en forme
include "../Layout.php";
