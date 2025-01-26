<?php

namespace Src\Model\Repository;

use Src\Model\DataObject\Utilisateur;
use Src\Model\Repository\BDD;

class UtilisateurRepository extends AbstractRepository
{
	/**
	 * Récupère un utilisateur par son email et son mot de passe.
	 *
	 * @param string $mail L'adresse email de l'utilisateur.
	 * @param string $mdp Le mot de passe de l'utilisateur.
	 * @return array|null Retourne un tableau associatif contenant les informations utilisateur ou null si aucun utilisateur n'est trouvé.
	 */
	public function getUserByMailMdp(string $mail, string $mdp): ?Utilisateur
	{
		$query = "SELECT * FROM utilisateur WHERE utilisateur_mail = :mail AND utilisateur_mdp = :mdp";
		$params = [
			":mail" => $mail,
			":mdp" => $mdp
		];
		$objet = DatabaseConnection::fetchOne($query, $params);
		return $objet == null ? $objet : $this->arrayConstructor($objet);
	}

	public function getUserById(int $idUtilisateur): ?Utilisateur
	{
		return $this->select($idUtilisateur);
	}

	public static function updateLastConn()
	{
		$query = "UPDATE utilisateur SET utilisateur_last_conn = :last_conn WHERE utilisateur_mail = :id";
		$params = [
			":last_conn" => date('Y-m-d H:i:s'),
			":id" => $_SESSION['user']->getId()
		];
		DatabaseConnection::executeQuery($query, $params);
	}

	public static function updateNbConn()
	{
		$query = "UPDATE utilisateur SET utilisateur_nb_conn = utilisateur_nb_conn + 1 WHERE utilisateur_mail = :id";
		$params = [
			":id" => $_SESSION['user']->getId()
		];
		return DatabaseConnection::executeQuery($query, $params);
	}

	public function insertUser(Utilisateur $objet, string $mdp): int
	{
		$values = $objet->formatTableau();
		$values[':utilisateur_mdp'] = $mdp;
		return (int) $this->create($objet, $values);
	}

	public function arrayConstructor(array $objetFormatTableau): Utilisateur
	{
		return new Utilisateur($objetFormatTableau['utilisateur_pseudo'], $objetFormatTableau['utilisateur_mail'], $objetFormatTableau['utilisateur_nom'], $objetFormatTableau['utilisateur_prenom'], $objetFormatTableau['utilisateur_id'], $objetFormatTableau['created_at']);
	}
	public function getNomClePrimaire(): string
	{
		return 'utilisateur_id';
	}
	public function getNomsColonnes(): array
	{
		return ['utilisateur_id', 'utilisateur_pseudo', "utilisateur_mail", "utilisateur_nom", "utilisateur_prenom", 'created_at', "utilisateur_mdp"];
	}
	public function getTableName(): string
	{
		return 'utilisateur';
	}
}
