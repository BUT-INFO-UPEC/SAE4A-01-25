<header>
    <div class="d-flex align-items-center justify-content-between position-relative">
        <!-- Titre centré -->
        <h1 class="titre-header text-center w-100 fw-bold">Nom Du Site</h1>
        <!-- Icône alignée à droite -->
        <?php include "icon_account.php"; ?>

    </div>
    <br>
    <hr>
    <nav class="header-menu">
        <a href="<?php echo $prefixe . '../index.php'; ?>">Accueil</a>
        <a href="<?php echo $prefixe . '../Actions/visu_dashboard.php'; ?>">Visualisation</a>
        <a href="<?php echo $prefixe . '../Actions/crea_dashboard.php'; ?>">Creation</a>
        <a href="<?php echo $prefixe . '../Actions/Liste_dashboards.php'; ?>">Liste</a>
        <a href="<?php echo $prefixe . '../Actions/recherche_dashboard.php'; ?>">Recherche Dashboard</a>
    </nav>
    <br>
    <hr>
</header>