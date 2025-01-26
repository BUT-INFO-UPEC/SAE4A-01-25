<?php

namespace Src\Model\API;

use Exception;
use Src\Config\MsgRepository;

class Requetteur_API
{
    public static function fetchData(
        ?array $select = null,
        ?array $where = null,
        ?array $group_by = null,
        ?string $order_by = null,
        ?int $limit = null,
        ?int $offset = null,
        ?array $refine = null,
        ?array $exclude = null,
        ?string $time_zone = null
    ): array {
        try {
            // Créer une instance de RequeteAPI
            $requette = new Constructeur_Requette_API(
                $select,
                $where,
                $group_by,
                $order_by,
                $limit ?? 100,
                $offset ?? 0,
                $refine,
                $exclude,
                'fr', // Langue par défaut
                $time_zone ?? 'Europe/Paris' // Timezone par défaut
            );

            // Construire l'URL de la requête
            $url = $requette->formatUrl();

            // Exécuter la requête avec CURL
            $response = self::executeCurl($url);

            // Vérifier et retourner les résultats
            return $response['results'] ?? [];
        } catch (Exception $e) {
            MsgRepository::newError("Erreur lors de la requête API : " . $e->getMessage());
            return ["error" => $e->getMessage()];
        }
    }

    /**
     * Exécute une requête CURL pour une URL donnée.
     * @param string $url L'URL à appeler.
     * @return array La réponse décodée.
     * @throws Exception Si une erreur survient.
     */
    private static function executeCurl(string $url): array
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code !== 200) {
            throw new Exception("Erreur HTTP $http_code pour l'URL $url");
        }

        $decoded_response = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Erreur de décodage JSON : " . json_last_error_msg());
        }

        return $decoded_response;
    }
}
