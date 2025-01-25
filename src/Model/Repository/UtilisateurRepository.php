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
		$sql = "SELECT * FROM utilisateur";
		return DatabaseConnection::fetchAll($sql);
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
		$sql = "SELECT * FROM utilisateur WHERE utilisateur_mail = :mail AND utilisateur_mdp = :mdp";
		$params = [
			":mail" => $mail,
			":mdp" => $mdp
		];
		$stmt = DatabaseConnection::fetchOne($sql, $params);
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
		$query = "SELECT * FROM utilisateur WHERE utilisateur_mail = :mail AND utilisateur_mdp = :mdp";
		$params = [
			":mail" => $mail,
			":mdp" => $mdp
		];
		return DatabaseConnection::fetchOne($query, $params);
	}

	/**
	 * Récupère un utilisateur par son email et son mot de passe.
	 *
	 * @param string $mail L'adresse email de l'utilisateur.
	 * @return array Retourne un tableau associatif contenant les informations utilisateur ou null si aucun utilisateur n'est trouvé.
	 */
	public static function getUser(): ?array
	{
		$query = "SELECT * FROM utilisateur WHERE utilisateur_mail = :mail";
		$params = [
			":mail" => $_COOKIE['CurentMail'],
		];
		return DatabaseConnection::fetchOne($query, $params);
	}

	public static function updateLastConn()
	{
		$query = "UPDATE utilisateur SET utilisateur_last_conn = :last_conn WHERE utilisateur_mail = :mail";
		$params = [
			":last_conn" => date('Y-m-d H:i:s'),
			":mail" => $_COOKIE['CurentMail']
		];
		DatabaseConnection::executeQuery($query, $params);
	}

	public static function updateNbConn()
	{
		$query = "UPDATE utilisateur SET utilisateur_nb_conn = utilisateur_nb_conn + 1 WHERE utilisateur_mail = :mail";
		$params = [
			":mail" => $_COOKIE['CurentMail']
		];
		return DatabaseConnection::executeQuery($query, $params);
	}
}
