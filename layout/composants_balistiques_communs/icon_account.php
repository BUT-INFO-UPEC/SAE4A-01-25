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
        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#signInModal">Sign in</a></li>
        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#signUpModal">Sign up</a></li>
    </ul>
</div>