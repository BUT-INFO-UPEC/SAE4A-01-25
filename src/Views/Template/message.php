<?php
if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert" id="alertMessage">' . $_SESSION['error'] . '</div>';
    unset($_SESSION['error']);
}

if (isset($_SESSION['success'])) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert" id="alertMessage">' . $_SESSION['success'] . '</div>';
    unset($_SESSION['success']);
}

if (isset($_SESSION['warning'])) {
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert" id="alertMessage">' . $_SESSION['warning'] . '</div>';
    unset($_SESSION['warning']);
}
?>
<script>
    // Attendre que la page soit chargée
    document.addEventListener('DOMContentLoaded', function() {
        // Sélectionner les alertes par leur ID
        const alertMessage = document.getElementById('alertMessage');

        // Vérifier si l'alerte existe
        if (alertMessage) {
            // Après 3 secondes (3000 ms), masquer l'alerte
            setTimeout(() => {
                alertMessage.classList.add('fade'); // Ajoute une transition de disparition
                setTimeout(() => alertMessage.remove(), 500); // Supprime complètement après 0.5s
            }, 10000);
        }
    });
</script>