<?php

namespace Src\Model\Repository;

use Exception;
use Src\Model\DataObject\Requette_API;

class Requetteur_API
{
	#region TEST REQUETTE API
	public static function formatRequest(string $url, array $params = [])
	{
		$queryString = http_build_query($params); // Génère une chaîne de requête à partir des paramètres
		if (!empty($queryString)) {
			$url .= "?" . $queryString;
		}
		return $url;
	}

	public static function fetchAll(?int $limit = null, array $params = [])
	{
		// URL de base de l'API
		$apiUrl = "https://public.opendatasoft.com/api/explore/v2.1/catalog/datasets/donnees-synop-essentielles-omm/records";

		// Ajout du paramètre 'limit' s'il est défini
		if ($limit !== null) {
			$params['limit'] = $limit;
		}
		foreach ($params as $key => $values) {
			if (is_array($values)) {
				// Si la valeur est un tableau, on join toute les valeur du tableau par une virgule
				$params[$key] = implode(",", $values);
			}
		}

		// Génération de l'URL avec les paramètres
		$formattedUrl = self::formatRequest($apiUrl, $params);

		// Initialisation de cURL
		$ch = curl_init($formattedUrl);

		// Configuration des options cURL
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Retourne la réponse sous forme de chaîne
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);         // Délai d'expiration
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Désactiver la vérification SSL

		// Exécution de la requête
		$response = curl_exec($ch);

		// Vérification des erreurs cURL
		if (curl_errno($ch)) {
			$errorMessage = 'Erreur cURL : ' . curl_error($ch);
			curl_close($ch);

			// Retourner une erreur formatée en JSON
			return json_encode(['success' => false, 'error' => $errorMessage]);
		}

		// Vérification du statut HTTP
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if ($httpCode !== 200) {
			curl_close($ch);

			// Retourner une erreur formatée en JSON
			return json_encode(['success' => false, 'httpCode' => $httpCode, 'response' => $response]);
		}

		// Fermeture de la session cURL
		curl_close($ch);

		// Décodage JSON de la réponse
		$data = json_decode($response, true);

		// Vérifier si le JSON est valide
		if (json_last_error() !== JSON_ERROR_NONE) {
			return json_encode(['success' => false, 'error' => 'Erreur de décodage JSON: ' . json_last_error_msg()]);
		}

		echo $formattedUrl;

		// Retourner les données formatées en JSON
		return json_encode(['success' => true, 'data' => $data]);
	}
}
