<?php
// Exemple d'affichage avec filtres pour les tableaux de bord

$region = $_GET['region'] ?? null;
$order = $_GET['order'] ?? 'recent'; // Valeurs possibles : recent, most_viewed
$dateFilter = $_GET['date'] ?? 'today'; 
$customStartDate = $_GET['start_date'] ?? null;
$customEndDate = $_GET['end_date'] ?? null;

// Filtrage des tableaux de bord
$filteredDashboards = array_filter($dashboards, function ($dash) use ($region, $dateFilter, $customStartDate, $customEndDate) {
    $passesRegionFilter = $region ? $dash->get_region() === $region : true;
    $passesDateFilter = true; 

    if ($dateFilter === 'yesterday') {
        $passesDateFilter = strtotime($dash->get_date()) >= strtotime('yesterday') && strtotime($dash->get_date()) < strtotime('today');
    } elseif ($dateFilter === 'today') {
        $passesDateFilter = strtotime($dash->get_date()) >= strtotime('today') && strtotime($dash->get_date()) < strtotime('tomorrow');
    } elseif ($dateFilter === 'this_week') {
        $passesDateFilter = strtotime($dash->get_date()) >= strtotime('monday this week') && strtotime($dash->get_date()) < strtotime('monday next week');
    } elseif ($dateFilter === 'custom' && $customStartDate && $customEndDate) {
        $passesDateFilter = strtotime($dash->get_date()) >= strtotime($customStartDate) && strtotime($dash->get_date()) <= strtotime($customEndDate);
    }

    return $passesRegionFilter && $passesDateFilter;
});

// Tri des tableaux de bord
usort($filteredDashboards, function ($a, $b) use ($order) {
    if ($order === 'most_viewed') {
        return $b->get_views() - $a->get_views();
    } else { // Default to 'recent'
        return strtotime($b->get_date()) - strtotime($a->get_date());
    }
});
?>

<!-- Interface utilisateur pour les filtres -->
<form method="GET" class="filters">
  <label for="region">Filtrer par région :</label>
  <select name="region" id="region">
    <option value="">Toutes les régions</option>
    <!-- Remplacer les options ci-dessous par des valeurs dynamiques -->
    <option value="Region1" <?= $region === 'Region1' ? 'selected' : '' ?>>Région 1</option>
    <option value="Region2" <?= $region === 'Region2' ? 'selected' : '' ?>>Région 2</option>
  </select>

  <label for="order">Trier par :</label>
  <select name="order" id="order">
    <option value="recent" <?= $order === 'recent' ? 'selected' : '' ?>>Plus récent</option>
    <option value="most_viewed" <?= $order === 'most_viewed' ? 'selected' : '' ?>>Plus vues</option>
  </select>

  <label for="date">Filtrer par date :</label>
  <select name="date" id="date">
    <option value="today" <?= $dateFilter === 'today' ? 'selected' : '' ?>>Aujourd'hui</option>
    <option value="yesterday" <?= $dateFilter === 'yesterday' ? 'selected' : '' ?>>Hier</option>
    <option value="this_week" <?= $dateFilter === 'this_week' ? 'selected' : '' ?>>Cette semaine</option>
    <option value="custom" <?= $dateFilter === 'custom' ? 'selected' : '' ?>>Personnalisé</option>
  </select>

  <div id="custom-dates" style="display: <?= $dateFilter === 'custom' ? 'block' : 'none' ?>;">
    <label for="start_date">Date de début :</label>
    <input type="date" name="start_date" id="start_date" value="<?= htmlspecialchars($customStartDate) ?>">

    <label for="end_date">Date de fin :</label>
    <input type="date" name="end_date" id="end_date" value="<?= htmlspecialchars($customEndDate) ?>">
  </div>

  <button type="submit">Appliquer</button>
</form>

<!-- Liste des tableaux de bord filtrés -->
<ul class="list-dash">
  <?php foreach ($filteredDashboards as $dash) : ?>
    <?php $lien = CONTROLLER_URL . "?action=visu_dashboard&dashId=" . $dash->get_id(); ?>
    <li class="card">
      <a href="<?= $lien ?>" class="card-body">
        <?= htmlspecialchars($dash->get_name()) ?>
      </a>
    </li>
  <?php endforeach; ?>
</ul>

<script>
// Affichage conditionnel des champs de date personnalisés
const dateSelect = document.getElementById('date');
const customDates = document.getElementById('custom-dates');
dateSelect.addEventListener('change', function () {
  customDates.style.display = this.value === 'custom' ? 'block' : 'none';
});
</script>
