<?php
use Src\Model\Repository\GeoRepository;
?>

<div>
    <h4>Zone(s) géographique(s)</h4>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="regions-tab" data-bs-toggle="tab" data-bs-target="#regions" type="button" role="tab" aria-controls="regions" aria-selected="true">
                Régions
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="depts-tab" data-bs-toggle="tab" data-bs-target="#depts" type="button" role="tab" aria-controls="depts" aria-selected="false">
                Départements
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="villes-tab" data-bs-toggle="tab" data-bs-target="#villes" type="button" role="tab" aria-controls="villes" aria-selected="false">
                Villes
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="stations-tab" data-bs-toggle="tab" data-bs-target="#stations" type="button" role="tab" aria-controls="stations" aria-selected="false">
                Stations
            </button>
        </li>
    </ul>

    <div class="tab-content scroll-list">
        <!-- Regions Tab -->
        <div class="tab-pane fade show active" id="regions" role="tabpanel" aria-labelledby="regions-tab">
            <div class="list-group check">
                <?php foreach (GeoRepository::getRegions() as $item) : ?>
                    <label class="list-group-item">
                        <input class="form-check-input scroll me-1"
                               type="checkbox"
                               name="regions[]"
                               value="<?= htmlspecialchars($item['id']) ?>"
                               <?= (in_array($item['id'], $defaultGeo['reg_id'] ?? []) ? 'checked' : '') ?> />
                        <?= htmlspecialchars($item['name']) ?>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Departments Tab -->
        <div class="tab-pane fade" id="depts" role="tabpanel" aria-labelledby="depts-tab">
            <div class="list-group check">
                <?php foreach (GeoRepository::getDepts() as $item) : ?>
                    <label class="list-group-item">
                        <input class="form-check-input scroll me-1"
                               type="checkbox"
                               name="depts[]"
                               value="<?= htmlspecialchars($item['id']) ?>"
                               <?= (in_array($item['id'], $defaultGeo['epci_id'] ?? []) ? 'checked' : '') ?> />
                        <?= htmlspecialchars($item['name']) ?>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Cities Tab -->
        <div class="tab-pane fade" id="villes" role="tabpanel" aria-labelledby="villes-tab">
            <div class="list-group check">
                <?php foreach (GeoRepository::getVilles() as $item) : ?>
                    <label class="list-group-item">
                        <input class="form-check-input scroll me-1"
                               type="checkbox"
                               name="villes[]"
                               value="<?= htmlspecialchars($item['id']) ?>"
                               <?= (in_array($item['id'], $defaultGeo['ville_id'] ?? []) ? 'checked' : '') ?> />
                        <?= htmlspecialchars($item['name']) ?>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Stations Tab -->
        <div class="tab-pane fade" id="stations" role="tabpanel" aria-labelledby="stations-tab">
            <div class="list-group check">
                <?php foreach (GeoRepository::getStations() as $item) : ?>
                    <label class="list-group-item">
                        <input class="form-check-input scroll me-1"
                               type="checkbox"
                               name="stations[]"
                               value="<?= htmlspecialchars($item['id']) ?>"
                               <?= (in_array($item['id'], $defaultGeo['numer_sta'] ?? []) ? 'checked' : '') ?> />
                        <?= htmlspecialchars($item['name']) ?>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
