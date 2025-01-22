<aside class="d-flex">
	<!-- Sidebar -->
	<div id="sidebar" class="sidebar">
		<div class="content">
			<h4 class="text-center">Sidebar</h4>
			<a href="#">Dashboard</a>
			<a href="#">Profil</a>
			<a href="#">Paramètre</a>
			<a href="#">Déconnexion</a>
		</div>
	</div>

	<button class="btn btn-primary" id="toggleSidebar">
		&Chi;
	</button>

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
</aside>

<style>
	#toggleSidebar {
		height: 55px;
		margin-top: 20px;
		margin-left: -5%;
	}
</style>