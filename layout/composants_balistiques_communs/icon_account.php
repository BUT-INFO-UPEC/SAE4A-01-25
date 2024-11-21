<div class="dropdown position-absolute end-0">

    <img
        src="<?php echo $prefixe . '../database/images/account-icon.png'; ?>"
        alt="Menu"
        class="account-icon dropdown-toggle"
        id="accountDropdown"
        data-bs-toggle="dropdown"
        aria-expanded="false"
        style="cursor: pointer;">
    <ul class="dropdown-menu" aria-labelledby="accountDropdown">
        <li>
            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#signInModal">
                <img src="<?php echo $prefixe . '../database/images/signin-icon.png'; ?>"
                    alt="sign_in"
                    class="me-2"
                    style="width: 22px; height: 22px;">
                Se connecter
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#signUpModal">
                <img src="<?php echo $prefixe . '../database/images/signup-icon.png'; ?>"
                    alt="sign_up"
                    class="me-2"
                    style="width: 22px; height: 22px;">
                Inscription
            </a>
        </li>
    </ul>
</div>