<div class="dropdown position-absolute end-0">

    <img
        src="<?php echo $prefixe . 'composants_balistiques_communs/images/account-icon.png'; ?>"
        alt="Menu"
        class="account-icon dropdown-toggle"
        id="accountDropdown"
        data-bs-toggle="dropdown"
        aria-expanded="false"
        style="cursor: pointer;">
    <ul class="dropdown-menu" aria-labelledby="accountDropdown">
        <li>
            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#signInModal">
                <img src="<?php echo $prefixe . 'composants_balistiques_communs/images/signin-icon.png'; ?>"
                    alt="Se connecter"
                    class="me-2"
                    style="
                        width: 22px;
                        height: 22px;
                    ">
                Se connecter
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#signUpModal">
                <img src="<?php echo $prefixe . 'composants_balistiques_communs/images/signup-icon.png'; ?>"
                    alt="Inscription"
                    class="me-2"
                    style="width: 16px; height: 16px;">
                Inscription
            </a>
        </li>
    </ul>
</div>