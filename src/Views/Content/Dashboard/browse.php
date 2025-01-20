
<ul class="list-dash">
  <?php foreach ($dashboards as $dash) : ?>
    <?php $lien = CONTROLLER_URL . "?action=visu_dashboard&dashId=" . $dash->get_id(); ?>
    <li class="card">
      <a href="<?= $lien ?>" class="card-body">
        <?= htmlspecialchars($dash->get_name()) ?>
      </a>
    </li>
  <?php endforeach; ?>
</ul>
