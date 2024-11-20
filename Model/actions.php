<?php

require_once __DIR__ . '/../../Model/classes/User.php';

$action = $_GET["action"] ?? null;

switch ($action) {
    case "signIn":
        // Récupération des données du formulaire
        $password = $_POST['password'] ?? null;
        $email = $_POST['email'] ?? null;
        $username = $_POST['username'] ?? null;
        $passwordConfirm = $_POST['passwordConfirm'] ?? null;

        if (!empty($name) && !empty($email) && !empty($username) && !empty($password) && !empty($passwordConfirm)) {
            if ($password !== $passwordConfirm) {
                $_SESSION['error'] = "Les mots de passe ne correspondent pas.";
                break;
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "L'email n'est pas valide.";
                break;
            }

                        // Hachage du mot de passe avant de l'enregistrer
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Création d'un objet Utilisateur
            $user = new Utilisateur($name, $email, $username, $ami = []);

            // Tentative d'insertion de l'utilisateur dans la base de données
            try {
                $user->insertUser(
                    $user->getPseudo(),
                    $user->getEmail(),
                    $user->getPassword(),
                    $user->getAmis()
                );

                // Message de succès et redirection
                $_SESSION['success'] = "Utilisateur inscrit avec succès.";
                header("Location: success_page.php"); // Remplacez par la page de redirection
                exit();
            } catch (Exception $e) {
                // Message d'erreur en cas d'échec de l'insertion
                $_SESSION['error'] = "Erreur lors de l'insertion de l'utilisateur : " . $e->getMessage();
            }
        } else {
            // Message d'erreur si un champ est vide
            $_SESSION['error'] = "Tous les champs doivent être remplis.";
        }
        break;
}
