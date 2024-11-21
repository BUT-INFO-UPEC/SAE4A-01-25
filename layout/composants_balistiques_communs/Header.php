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
        <a href="<?php echo $prefixe . '../Vues/visu_dashboard.php'; ?>">visualisation</a>
        <a href="<?php echo $prefixe . '../Vues/crea_dashboard.php'; ?>">creation</a>
        <a href="<?php echo $prefixe . '../Vues/jsp_1.php'; ?>">jsp 1</a>
    </nav>
    <br>
    <hr>
</header>