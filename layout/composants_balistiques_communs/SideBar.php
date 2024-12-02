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


    #toggleSidebar {
        font-size: x-large;
    }
</style>
<div class="d-flex">
    <!-- Sidebar -->
    <div id="sidebar" class="sidebar">
        <h4 class="text-center">Sidebar</h4>
        <a href="#">Dashboard</a>
        <a href="#">Profile</a>
        <a href="#">Settings</a>
        <a href="#">Logout</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // JavaScript for toggling the sidebar
    const toggleButton = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');

    toggleButton.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
    });
</script>