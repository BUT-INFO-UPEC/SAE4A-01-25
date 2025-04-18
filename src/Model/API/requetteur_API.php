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
		SessionManagement::get_curent_log_instance()->new_log("Requette API.");
		try {
			while (sizeof($totalData) < $APITotal) {
				// Construire l'URL de la requête
				$url = $requette->formatUrl();

				$advance = (sizeof($totalData) / 100) + 1 . " / " . (($APITotal == 1) ? " ? " : $APITotal / 100);
				SessionManagement::get_curent_log_instance()->new_log("Requette $advance à l'API. url : " . $url);

				// Exécuter la requête avec CURL
				$response = self::executeCurl($url);
				// Si l'API retourne un tableau vide, on arrête proprement
				if (empty($response['results'])) {
					SessionManagement::get_curent_log_instance()->new_log("Aucune donnée retournée par l'API.");
					return [$keyValueSort => 0];
				} else {
					if ($APITotal == 1) $APITotal = max(min(isset($response['total_count']) ? $response['total_count'] : 1, $limit), 1);
	
					SessionManagement::get_curent_log_instance()->new_log($APITotal);
					SessionManagement::get_curent_log_instance()->new_log(var_export($response, true));
	
					if ($alias == 'total') {
						foreach ($response["results"] as $data) {
							$totalData['total'] = $data[$keyTargetValue];
						}
					} elseif ($keyValueSort != "") {
						foreach ($response["results"] as $data) {
							if ($keyTargetValue	!= '') {
								$key_list = explode(',', preg_replace('/\s*,\s*/', ',', trim($keyValueSort)));
								$key_value = [];
								foreach ($key_list as $key) {
									$key_value[] = $data[$key];
								}
								$totalData[implode("/", $key_value)] = $data[$keyTargetValue];
							} else {
								$totalData[$data[$keyValueSort]] = $data;
							}
						}
					} else {
						// tout combiner
						$totalData = array_merge($totalData, $response['results'] ?? []);
					}

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
			CURLOPT_URL	=> $url,
			CURLOPT_RETURNTRANSFER	=> true,
			CURLOPT_SSL_OPTIONS	=> CURLSSLOPT_NATIVE_CA,
			CURLOPT_TIMEOUT => 10,
			CURLOPT_CONNECTTIMEOUT => 10,
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
