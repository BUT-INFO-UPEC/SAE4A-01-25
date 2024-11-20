<div class="modal fade" id="signInModal" tabindex="-1" aria-labelledby="signInModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- En-tête du modal -->
            <div class="modal-header">
                <h5 class="modal-title" id="signInModalLabel">Connexion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>

            <!-- Contenu du modal -->
            <div class="modal-body">
                <form action="?action=signIn" method="post">
                    <div class="mb-3">
                        <label for="pseudo" class="form-label">Pseudo :</label>
                        <input type="text" name="pseudo" id="pseudo" class="form-control" minlength="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="mail" class="form-label">Mail :</label>
                        <input type="email" name="mail" id="mail" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="mdp" class="form-label">Mot de Passe :</label>
                        <input type="password" name="mdp" id="mdp" class="form-control" minlength="1" required>
                    </div>
                    <!-- Boutons du modal -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Se Connecter</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="signUpModal" tabindex="-1" aria-labelledby="signUpModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- En-tête du modal -->
            <div class="modal-header">
                <h5 class="modal-title" id="signUpModalLabel">Créer un compte</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>

            <!-- Contenu du modal -->
            <div class="modal-body">
                <form action="?action=signUp" method="post">
                    <div class="mb-3">
                        <label for="signup-pseudo" class="form-label">Pseudo :</label>
                        <input type="text" name="pseudo" id="signup-pseudo" class="form-control" minlength="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="signup-mail" class="form-label">Mail :</label>
                        <input type="email" name="mail" id="signup-mail" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="signup-mdp" class="form-label">Mot de Passe :</label>
                        <input type="password" name="mdp" id="signup-mdp" class="form-control" minlength="1" required>
                    </div>
                    <!-- Boutons du modal -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Créer un compte</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>