<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <span>Menu</span>
        <button class="toggle-btn" id="toggleBtn">☰</button>
    </div>
    <div class="sidebar-menu">
        <a href="#"><i class="icon">🏠</i> <span>Accueil</span></a>
        <a href="#"><i class="icon">🛠️</i> <span>Services</span></a>
        <a href="#"><i class="icon">ℹ️</i> <span>À propos</span></a>
        <a href="#"><i class="icon">📞</i> <span>Contact</span></a>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const sidebar = document.getElementById("sidebar");
        const toggleBtn = document.getElementById("toggleBtn");

        toggleBtn.addEventListener("click", () => {
            sidebar.classList.toggle("collapsed");
        });
    });
</script>

<style>
    /* Sidebar dans style_layout.css */
    #sidebar {
        width: 10%;
        /* Largeur ivwnitiale de la sidebar */
        background-color: #343a40;
        color: white;
        transition: width 0.3s ease;
        overflow: hidden;
    }

    .sidebar.collapsed {
        display: none;
        transition: ease 5s;
        /* Largeur réduite lorsqu'elle est rétractée */
    }

    .sidebar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px;
        background-color: #495057;
        font-size: 1.5rem;
    }

    .sidebar-menu {
        margin-top: 10px;
    }

    .sidebar-menu a {
        display: flex;
        align-items: center;
        padding: 10px 20px;
        color: #adb5bd;
        text-decoration: none;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .sidebar-menu a:hover {
        background-color: #6c757d;
        color: white;
    }

    .sidebar-menu .icon {
        margin-right: 10px;
        font-size: 1.5rem;
    }

    .sidebar.collapsed .sidebar-menu a span {
        display: none;
        /* Cacher le texte des liens en mode rétracté */
    }

    .sidebar.collapsed .sidebar-menu .icon {
        margin: 0 auto;
    }

    .toggle-btn {
        background-color: #495057;
        border: none;
        color: white;
        cursor: pointer;
        padding: 5px 10px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .toggle-btn:hover {
        background-color: #6c757d;
    }

    /* Style pour le contenu principal */
    main>div {
        flex-grow: 1;
        padding: 20px;
        transition: margin-left 0.3s ease;
    }

    .sidebar.collapsed~div {
        margin-left: 60px;
        /* Ajustement du contenu principal quand la sidebar est rétractée */
    }
</style>