<div class="d-flex">
    <!-- Sidebar -->
    <div id="sidebar" class="sidebar">
        <button id="toggleSidebar" class="btn">
            &#9776;
        </button>
        <h4 class="text-center mt-4">Sidebar</h4>
        <a href="#">Dashboard</a>
        <a href="#">Profile</a>
        <a href="#">Settings</a>
        <a href="#">Logout</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // JavaScript pour gérer la rétraction de la sidebar
    const toggleButton = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');

    toggleButton.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
    });
</script>

<style>
    .sidebar {
        min-width: 250px;
        max-width: 250px;
        background-color: #343a40;
        color: white;
        transition: all 0.3s;
        position: relative;
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

    #toggleSidebar {
        font-size: 1.5rem;
        z-index: 1;
        position: absolute;
        top: 0;
        right: 0;
        margin: 10px;
        background-color: #007bff;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 5px;
    }
</style>
