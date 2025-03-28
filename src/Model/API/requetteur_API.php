<?php

namespace Src\Model\API;

use Exception;
use Src\Config\Utils\MsgRepository;
use Src\Config\Utils\SessionManagement;

class Requetteur_API
{
	const LIMIT_API_DATA = 5000;

	public static function fetchData(Constructeur_Requette_API $requette, $keyValueSort = "", $keyTargetValue = "", $alias = null, $limit = Requetteur_API::LIMIT_API_DATA): array
	{
		$totalData = [];
		$APITotal = 1;
		try {
			while (sizeof($totalData) < $APITotal) {
				// Construire l'URL de la requête
				$url = $requette->formatUrl();

				$advance = (sizeof($totalData)/100) + 1 ." / ".(($APITotal == 1) ? " ? ":$APITotal/100);
				SessionManagement::get_curent_log_instance()->new_log("Requette $advance à l'API. url : ".$url);

				// Exécuter la requête avec CURL
				$response = self::executeCurl($url);
				if ($APITotal == 1) $APITotal = max(min(isset($response['total_count']) ? $response['total_count'] : 1, $limit), 1);

				if ($alias == 'total') {
					foreach ($response["results"] as $data) {
						$totalData['total'] = $data[$keyTargetValue];
					}
				} elseif ($keyValueSort != "") {
					foreach ($response["results"] as $data) {
						if ($keyTargetValue	!= '') {
							$totalData[$data[$keyValueSort]] = $data[$keyTargetValue];
						} else {
							$totalData[$data[$keyValueSort]] = $data;
						}
					}
				} else {
					// tout combiner
					$totalData = array_merge($totalData, $response['results'] ?? []);
				}
			}
		} catch (Exception $e) {
			MsgRepository::newError("Erreur lors de la requête API : ", $e->getMessage(), MsgRepository::NO_REDIRECT);
			return ["error" => $e->getMessage()];
		}
		return $totalData;
	}

	/**
	 * Exécute une requête CURL pour une URL donnée.
	 * @param string $url L'URL à appeler.
	 * @return array La réponse décodée.
	 * @throws Exception Si une erreur survient.
	 */
	private static function executeCurl(string $url): array
	{
		$ch = curl_init();
		// MsgRepository::Debug(var: $url);

		$options = [
			CURLOPT_URL							=> $url,
			CURLOPT_RETURNTRANSFER	=> true,
			CURLOPT_SSL_OPTIONS			=> CURLSSLOPT_NATIVE_CA,
			CURLOPT_TIMEOUT => 10,
		];
		curl_setopt_array($ch, $options);
		$response = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		// fermeture de la connexion
		curl_close($ch);

		if ($httpCode != 200) {
			MsgRepository::newError("Return code is {$httpCode}", curl_error($ch) . "<br/> $url");
		}
		// MsgRepository::newSuccess($response, "", MsgRepository::NO_REDIRECT);
		$decoded_response = json_decode($response, true);
		// MsgRepository::Debug($decoded_response);

		if (json_last_error() !== JSON_ERROR_NONE) {
			throw new Exception("Erreur de décodage JSON : " . json_last_error_msg());
		}

		return $decoded_response;
	}
}
