<?php

namespace Src\Model\Repository;

use Src\Model\Repository\BDD;

class UtilisateurRepository
{
    /**
     * Récupère tous les utilisateurs.
     *
     * @return array Retourne une liste d'utilisateurs (tableau associatif).
     */
    public static function getAllUser(): array
    {
        $pdo = new BDD();
        $sql = "SELECT * FROM utilisateur";
        return $pdo->fetchAll($sql);
    }

    /**
     * Vérifie si un utilisateur existe avec le mail et le mot de passe fournis.
     *
     * @param string $mail L'adresse email de l'utilisateur.
     * @param string $mdp Le mot de passe de l'utilisateur.
     * @return bool Retourne true si l'utilisateur existe, false sinon.
     */
    public static function checkUserExist(string $mail, string $mdp): bool
    {
        $pdo = new BDD();
        $sql = "SELECT * FROM utilisateur WHERE utilisateur_mail = :mail AND utilisateur_mdp = :mdp";
        $params = [
            ":mail" => $mail,
            ":mdp" => $mdp
        ];
        $stmt = $pdo->fetchOne($sql, $params);
        return $stmt !== null;
    }

    /**
     * Récupère un utilisateur par son email et son mot de passe.
     *
     * @param string $mail L'adresse email de l'utilisateur.
     * @param string $mdp Le mot de passe de l'utilisateur.
     * @return array|null Retourne un tableau associatif contenant les informations utilisateur ou null si aucun utilisateur n'est trouvé.
     */
    public static function getUserByMailMdp(string $mail, string $mdp): ?array
    {
        $pdo = new BDD();
        $query = "SELECT * FROM utilisateur WHERE utilisateur_mail = :mail AND utilisateur_mdp = :mdp";
        $params = [
            ":mail" => $mail,
            ":mdp" => $mdp
        ];
        return $pdo->fetchOne($query, $params);
    }
}
