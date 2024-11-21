<div class="dropdown position-absolute end-0 bonjour">

    <img
        src="<?php echo $prefixe . '../database/Images/account-icon.png'; ?>"
        alt="Menu"
        class="account-icon dropdown-toggle"
        id="accountDropdown"
        data-bs-toggle="dropdown"
        aria-expanded="false"
        style="cursor: pointer;">
    <ul class="dropdown-menu" aria-labelledby="accountDropdown">
        <li>
            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#signInModal">
                <img src="<?php echo $prefixe . '../database/Images/signin-icon.png'; ?>" alt="sign_in" class="me-2">
                Se connecter
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#signUpModal">
                <img src="<?php echo $prefixe . '../database/Images/signup-icon.png'; ?>" alt="sign_up" class="me-2">
                Inscription
            </a>
        </li>
    </ul>
</div>

<style>
    .bonjour .dropdown-menu img {
        width: 23px;
        height: 23px;
    }
</style>