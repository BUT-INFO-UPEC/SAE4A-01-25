<img src=<?php echo $prefixe . "composants_balistiques_communs/account-icon.png" ?> alt="Menu" class="account-icon" id="accountIcon">
<div class="hidden-menu" id="hiddenMenu">
    <a href="#" data-bs-toggle="modal" data-bs-target="#signInModal">Sign in</a>
    <br>
    <a href="#" data-bs-toggle="modal" data-bs-target="#signUpModal">Sign up</a>
</div>
<script>
    const accountIcon = document.getElementById('accountIcon');
    const hiddenMenu = document.getElementById('hiddenMenu');
    accountIcon.addEventListener('click', () => {
        hiddenMenu.style.display = hiddenMenu.style.display === 'flex' ? 'none' : 'flex';
    });
    document.addEventListener('click', (event) => {
        if (!hiddenMenu.contains(event.target) && event.target !== accountIcon) {
            hiddenMenu.style.display = 'none';
        }
    });
</script>