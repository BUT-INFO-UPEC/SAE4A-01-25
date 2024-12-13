<div class="d-flex">
    <!-- Sidebar -->
    <div id="sidebar" class="sidebar">
        <button class="btn btn-primary" id="toggleSidebar">
            &#9776; <!-- Icône du menu hamburger -->
        </button>
        <div class="content">
            <h4 class="text-center">Sidebar</h4>
            <a href="#">Dashboard</a>
            <a href="#">Profile</a>
            <a href="#">Settings</a>
            <a href="#">Logout</a>
        </div>
        <!-- Le bouton se trouve ici quand la sidebar est ouverte -->
    </div>
</div>

<script>
    // JavaScript pour gérer la rétraction de la sidebar
    const toggleButton = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');

    toggleButton.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');

        // Change le texte du bouton en fonction de l'état de la sidebar
        if (sidebar.classList.contains('collapsed')) {
            toggleButton.innerHTML = '&#9776;'; // Icône menu hamburger (ouvrir)
        } else {
            toggleButton.innerHTML = '&Chi;'; // Icône croix (fermer)
        }
    });
</script>

<style>
    /* Style général de la sidebar */
    .sidebar {
        min-width: 250px;
        max-width: 250px;
        background-color: #343a40;
        color: white;
        transition: all 0.3s ease; /* Transition fluide */
        position: relative;
        padding-top: 10px;
    }

    /* Sidebar rétractée (collapsée) */
    .sidebar.collapsed {
        min-width: 0;
        max-width: 0;
        overflow: hidden;
        visibility: hidden; /* Masquer complètement la sidebar quand elle est rétractée */
        padding: 0;
    }

    /* Liens de la sidebar */
    .sidebar .content {
        display: block;
        transition: all 0.3s ease;
    }

    .sidebar a {
        color: white;
        text-decoration: none;
        padding: 10px 15px;
        display: block;
        transition: background-color 0.3s;
        font-size: 1rem;
    }

    .sidebar a:hover {
        background-color: #495057;
    }

    /* Style du bouton pour afficher/cacher la sidebar */
    #toggleSidebar {
        font-size: 1.5rem;
        z-index: 1;
        position: absolute;
        top: 10px; /* Position du bouton en haut */
        right: 10px; /* Le bouton est à droite de la sidebar */
        background-color: #007bff;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 5px;
        cursor: pointer;
    }

    /* Styles lorsque la sidebar est rétractée, le bouton prend sa place */
    .sidebar.collapsed #toggleSidebar {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 2; /* Le bouton est au-dessus de la barre latérale */
    }

    /* Styles pour afficher le bouton à l'extérieur de la sidebar lorsque elle est fermée */
    .sidebar.collapsed {
        min-width: 0;
        max-width: 0;
        overflow: hidden;
    }

    /* Styles de la sidebar quand rétractée pour les petites tailles d'écran */
    @media (max-width: 768px) {
        .sidebar {
            min-width: 0;
            max-width: 0;
        }

        .sidebar.collapsed {
            min-width: 200px;
            max-width: 200px;
        }

        #toggleSidebar {
            font-size: 1.2rem;
            padding: 8px 12px;
        }
    }
</style>
