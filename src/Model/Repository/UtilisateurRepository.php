<?php

namespace Src\Model\Repository;

class UtilisateurRepository
{
	public static function getUserByMailMdp(string $email, string $mdp)
	{
		$pdo = new BDD();
		$sql = "SELECT * FROM utilisateur where utilisateur_mdp = ? and utilisateur_mail = ?";
		return $pdo->fetchAll($sql, [$mdp, $email]);
	}

	public static function checkUserMailMdp(string $mail, string $mdp)
	{
		// On récupère l'instance PDO depuis la classe BaseDeDonnees
		$pdo = new BDD();
		// Préparation de la requête SQL
		$sql = "SELECT utilisateur_mdp FROM utilisateur WHERE utilisateur_mail = ? limit 1";
		// Exécution de la requête avec les paramètres
		$result = $pdo->fetchOne($sql, [$mail]);
		// Si le résultat est trouvé, on compare le mot de passe
		if ($result && $mdp == $result) {
			return true;
		} else {
			return false;
		}
	}
}
