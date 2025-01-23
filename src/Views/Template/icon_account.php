<div class="dropdown position-relative">
  <img
    src="<?= BASE_URL . 'assets/img/account-icon2.webp'; ?>"
    alt="Menu"
    class="account-icon dropdown-toggle"
    id="accountDropdown"
    data-bs-toggle="dropdown"
    aria-expanded="false"
    style="cursor:pointer; width: 70px; height: 70px;">

  <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountDropdown">
    <?php if (!isset($_COOKIE['CurentMail'])) : ?>
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
    <?php else : ?>
      <li>
        <a class="dropdown-item d-flex align-items-center" href="<?= CONTROLLER_URL . '?controller=ControllerGeneral&action=profile'; ?>">
          <img src="<?= BASE_URL . 'assets/img/account-icon1.png'; ?>" alt="Profil" class="me-2" style="width: 20px; height: 20px;">
          Profil
        </a>
      </li>
      <li>
        <a class="dropdown-item d-flex align-items-center" href="?action=deconnexion&controller=ControllerGeneral">
          <img src="<?= BASE_URL . 'assets/img/deconnexion-icon.png'; ?>" alt="Deconnexion" class="me-2" style="width: 20px; height: 20px;">
          Déconnexion
        </a>
      </li>
    <?php endif; ?>
  </ul>
</div>