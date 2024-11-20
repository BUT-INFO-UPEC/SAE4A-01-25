<div class="modal fade" id="signInModal" tabindex="-1" aria-labelledby="signInModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
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
                        <input type="text" name="pseudo" id="pseudo" class="form-control" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="mail">Mail :</label>
                        <input type="text" name="mail" id="mail" class="form-control" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="mdp">Mot de Passe :</label>
                        <input type="text" name="mdp" id="mdp" class="form-control" min="1" required>
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
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- En-tête du modal -->
            <div class="modal-header">
                <h5 class="modal-title" id="signInModalLabel">Creer un compte</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>

            <!-- Contenu du modal -->
            <div class="modal-body">
                <form action="?action=signIn" method="post">
                    <div class="mb-3">
                        <label for="pseudo" class="form-label">Pseudo :</label>
                        <input type="text" name="pseudo" id="pseudo" class="form-control" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="mail">Mail :</label>
                        <input type="text" name="mail" id="mail" class="form-control" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="mdp">Mot de Passe :</label>
                        <input type="text" name="mdp" id="mdp" class="form-control" min="1" required>
                    </div>
                    <!-- Boutons du modal -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Creer un compte</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>