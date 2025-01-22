<div class="dropdown position-relative">
	<img
		src="<?= BASE_URL . 'assets/img/account-icon.png'; ?>"
		alt="Menu"
		class="account-icon dropdown-toggle"
		id="accountDropdown"
		data-bs-toggle="dropdown"
		aria-expanded="false"
		style="cursor: pointer; width: 70px; height: 70px;">

	<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountDropdown">
		<li>
			<a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#signInModal">
				<img src="<?= BASE_URL . 'assets/img/signin-icon.png'; ?>" alt="Sign In" class="me-2" style="width: 20px; height: 20px;">
				Se connecter
			</a>
		</li>
		<li>
			<a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#signUpModal">
				<img src="<?= BASE_URL . 'assets/img/signup-icon.png'; ?>" alt="Sign Up" class="me-2" style="width: 20px; height: 20px;">
				Inscription
			</a>
		</li>
		<li>
			<a class="dropdown-item d-flex align-items-center" href="<?= BASE_URL . '../Actions/Profil.php'; ?>">
				<img src="<?= BASE_URL . 'assets/img/account-icon.png'; ?>" alt="Profil" class="me-2" style="width: 20px; height: 20px;">
				Profil
			</a>
		</li>
		<li>
			<a class="dropdown-item d-flex align-items-center" href="<?= BASE_URL . 'deconnexion.php'; ?>">
				<img src="<?= BASE_URL . 'assets/img/deconnexion-icon.png'; ?>" alt="Deconnexion" class="me-2" style="width: 20px; height: 20px;">
				Déconnexion
			</a>
		</li>
	</ul>
</div>