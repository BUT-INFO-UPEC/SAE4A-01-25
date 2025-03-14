<aside class="d-flex">
	<!-- Sidebar -->
	<div id="sidebar" class="sidebar">
		<div class="content">
			<h4 class="text-center"></h4>
			<a href="?controller=ControllerDashboard&action=browse&privatisation=private">Mes dashboard</a>
			<a href="?controller=ControllerGeneral&action=profile">Profil</a>
			<a href="?controller=ControllerGeneral&action=deconnexion">Déconnexion</a>
		</div>
	</div>

	<button class="btn btn-primary" id="toggleSidebar">
		&Chi;
	</button>

	<script>
		// Sélection des éléments
		const toggleButton = document.getElementById('toggleSidebar');
		const sidebar = document.getElementById('sidebar');

		// Vérifier l'état sauvegardé et l'appliquer
		if (localStorage.getItem('sidebarCollapsed') === 'true') {
			sidebar.classList.add('collapsed');
			toggleButton.innerHTML = '&#9776;'; // Icône menu hamburger (ouvrir)
		}

		// Gestion du clic sur le bouton de bascule
		toggleButton.addEventListener('click', () => {
			sidebar.classList.toggle('collapsed');

			// Sauvegarde de l'état dans localStorage
			localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));

			// Mise à jour du texte du bouton
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
		height: 25px;
		width: 25px;
		margin-top: 20px;
		margin-left: -5%;
	}
</style>
