<div class="side">
    <button class="navbar-toggler" type="button" id="openBtn">
        X
    </button>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-header d-flex justify-content-between">
            <span class="text-white">Menu</span>
            <button class="btn btn-link text-white" id="closeBtn">X</button>
        </div>
        <div class="sidebar-content">
            <ul>
                <li><a href="#">Accueil</a></li>
                <li><a href="#">À propos</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </div>
    </div>
</div>

<style>
    .side {
        top: 0;
        left: 0;
        
        background-color: #333;
        transition: left 0.3s ease;  /* Smooth transition */
    }

    .sidebar {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .sidebar-header {
        padding: 10px;
        background-color: #444;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .sidebar-content ul {
        padding: 0;
        list-style: none;
        margin: 0;
        padding-left: 20px;
    }

    .sidebar-content ul li {
        margin: 10px 0;
    }

    .sidebar-content ul li a {
        color: white;
        text-decoration: none;
    }

    .navbar-toggler-icon {
        background-color: #fff;
        width: 30px;
        height: 3px;
        display: block;
        position: relative;
    }

    .navbar-toggler-icon:before,
    .navbar-toggler-icon:after {
        content: '';
        background-color: #fff;
        width: 30px;
        height: 3px;
        display: block;
        position: absolute;
        left: 0;
    }

    .navbar-toggler-icon:before {
        top: -10px;
    }

    .navbar-toggler-icon:after {
        bottom: -10px;
    }

    /* The "open" class makes the sidebar visible */
    .open {
        left: 0; /* Show sidebar */
    }
</style>

<script>
    // Get the elements
    const openBtn = document.getElementById('openBtn');
    const closeBtn = document.getElementById('closeBtn');
    const sidebar = document.getElementById('sidebar');

    // Open the sidebar
    openBtn.addEventListener('click', function() {
        sidebar.classList.add('open');
    });

    // Close the sidebar
    closeBtn.addEventListener('click', function() {
        sidebar.classList.remove('open');
    });
</script>
