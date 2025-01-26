<?php

namespace Src\Model\Repository;

use Exception;
use Src\Model\DataObject\Requette_API;

class Requetteur_API
{
    public static function fetchData(
        array $select = [],
        array $where = [],
        array $group_by = [],
        array $order_by = [],
        ?int $limit = null,
        ?int $offset = null,
        ?array $refine = null, // Renommé pour correspondre à l'argument refine dans Requette_API
        ?array $exclude = null, // Renommé pour correspondre à l'argument exclude dans Requette_API
        ?string $time_zone = null
    ): array {
        try {
            // Créer l'instance de Requette_API
            $requette = new Requette_API();

            // Configurer les paramètres de la requête
            if (!empty($select)) {
                $requette->select($select);
            }
            if (!empty($where)) {
                $requette->where($where);
            }
            if (!empty($group_by)) {
                $requette->groupBy($group_by);
            }
            if (!empty($order_by)) {
                $requette->orderBy($order_by);
            }
            if ($limit !== null) {
                $requette->limit($limit);
            }
            if ($offset !== null) {
                $requette->offset($offset);
            }
            if (!empty($refine)) {
                $requette->refine($refine);
            }
            if (!empty($exclude)) {
                $requette->exclude($exclude);
            }
            if ($time_zone !== null) {
                $requette->timezone($time_zone);
            }

            // Construire l'URL de la requête
            $url = $requette->buildUrl();

            // Initialiser cURL pour effectuer la requête
            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_FAILONERROR => true,
            ]);

            // Exécuter la requête cURL
            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            if (curl_errno($ch)) {
                $error_message = curl_error($ch);
                curl_close($ch);
                return ["error" => "Erreur cURL : $error_message"];
            }

            curl_close($ch);

            // Vérifier le code HTTP de la réponse
            if ($http_code !== 200) {
                return ["error" => "Erreur HTTP : Code $http_code pour l'URL $url"];
            }

            // Décoder la réponse JSON
            $decoded_response = json_decode($response, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return ["error" => "Erreur lors du décodage JSON : " . json_last_error_msg()];
            }

            // Retourner les données décodées
            return $decoded_response['records'] ?? []; // Retourner les enregistrements si présents
        } catch (Exception $e) {
            MsgRepository::newError("Erreur lors de l'exécution de la requête API : " . $e->getMessage());
        }
    }
}
