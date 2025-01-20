<div class="dropdown position-absolute end-0 bonjour">
  <img
    src="<?= BASE_URL . 'assets/img/account-icon.png'; ?>"
    alt="Menu"
    class="account-icon dropdown-toggle"
    id="accountDropdown"
    data-bs-toggle="dropdown"
    aria-expanded="false"
    style="cursor: pointer; width: 70px; height: 70px;">

  <ul class="dropdown-menu" aria-labelledby="accountDropdown">
    <li>
      <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#signInModal">
        <img src="<?= BASE_URL . 'assets/img/signin-icon.png'; ?>" alt="sign_in" class="me-2">
        Se connecter
      </a>
    </li>

    <li>
      <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#signUpModal">
        <img src="<?= BASE_URL . 'assets/img/signup-icon.png'; ?>" alt="sign_up" class="me-2">
        Inscription
      </a>
    </li>

    <li>
      <a class="dropdown-item" href="<?= BASE_URL . '../Actions/Profil.php'; ?>">
        <img src="<?= BASE_URL . 'assets/img/account-icon.png'; ?>" alt="profil" class="me-2">
        Profil
      </a>
    </li>

    <li>
      <a class="dropdown-item" href="<?= BASE_URL . 'deconnexion.php'; ?>">
        <img src="<?= BASE_URL . 'assets/img/deconnexion-icon.png'; ?>" alt="deconnexion" class="me-2">
        Déconnexion
      </a>
    </li>
  </ul>
</div>