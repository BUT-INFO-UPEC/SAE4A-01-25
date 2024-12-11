<style>
    .sidebar {
        min-width: 250px;
        max-width: 250px;
        background-color: #343a40;
        color: white;
        transition: all 0.3s;
    }

    .sidebar.collapsed {
        min-width: 0;
        max-width: 0;
        overflow: hidden;
    }

    .sidebar a {
        color: white;
        text-decoration: none;
        padding: 10px 15px;
        display: block;
        transition: background-color 0.3s;
    }

    .sidebar a:hover {
        background-color: #495057;
    }

    .content {
        transition: margin-left 0.3s;
        padding: 20px;
    }

    .marquee {
        overflow: hidden;
        white-space: nowrap;
        box-sizing: border-box;
        animation: marquee 10s linear infinite;
        background-color: #495057;
        padding: 10px;
        color: white;
        text-align: center;
    }

    @keyframes marquee {
        from {
            transform: translateX(100%);
        }

        to {
            transform: translateX(-100%);
        }
    }

    #toggleSidebar {
        font-size: x-large;
        cursor: pointer;
        color: #343a40;
    }

    .like-section {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .like-section img {
        height: 20px;
        width: 20px;
    }
</style>
<div class="d-flex">
    <!-- Sidebar -->
    <div id="sidebar" class="sidebar">
        <h4 class="text-center">Tendence</h4>
        <div class="card">
            <marquee behavior="scroll" direction="left">
                Température en fonction des villes de l'Ariège
            </marquee>
            <div class="like-section">
                <span>12</span>
                <img src="<?php echo $prefixe . '../../database/Images/like.png'; ?>" alt="Like">
            </div>
        </div>
        <div>
            <h4 class="text-center">Plus liké</h4>
            <a href="#">Dashboard</a>
            <a href="#">Profile</a>
            <a href="#">Settings</a>
            <a href="#">Logout</a>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // JavaScript for toggling the sidebar
    const toggleButton = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');

    toggleButton.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        const isExpanded = sidebar.classList.contains('collapsed');
        toggleButton.setAttribute('aria-expanded', !isExpanded);
    });
</script>