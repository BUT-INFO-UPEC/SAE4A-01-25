<?php
require_once __DIR__ . "/../DataObject/Requette_API.php";
require_once __DIR__ . "/requetteur_BDD.php";

class Requetteur_API
{
    /**
     * Récupère les données de l'API selon les critères spécifiés
     * 
     * @param mixed $filtres Filtres des données a analysées (liste de station + encadrement temporel)
     * @param string $attribut La clé de l'attribut a analyser et donc requeter
     * @param string $aggregation La fonction analitique a apliquée sur les groupements de données
     * @param mixed $grouping Le critère de groupement des données pour  analyse
     * 
     * @return array La liste des données renvoyée pour cette requette
     */
    public static function API_componant_data($filtres, $attribut, $aggregation, $grouping)
    {
        $request = new Requette_API();

        // réaliser l'oppération d'aggregation sur l'attribut demandé
        $request->addSelect($attribut, $aggregation);

        // constyuit le tableau de conditions a passer en argument a buildConditions()
        // filtrer uniquement les resultats correspondants aux critères de la météothèque
        if (isset($filtres["geo"]) && !empty($filtres["geo"])) {
            //initialiser le tableau structuré
            $criteresGeo = ["or", []];

            // parcourir les différentes clés du tableau (les différents attributs géographiques a constraindres)
            foreach (array_keys($filtres["geo"]) as $criterGeo) {
                // initialiser le sous sous tableau
                $tab = [];

                // parcourir les valeurs a constraindre pour chaque attribut et les ajouter a la liste
                foreach ($filtres["geo"][$criterGeo] as $valeur) {
                    array_push($tab, $valeur);
                }

                // ajouter le critère structuré aux critères géographiques
                array_push($criteresGeo[1], ["or",  [[$criterGeo, "=", $tab]]]);
            }
        }

        // out($criteresGeo);

        $tab = ["and", [
            $criteresGeo,
            ["date", ">=", "\"" . $filtres["dateDebut"] . "\""],
            ["date", "<=", "\"" . $filtres["dateFin"] . "\""]
        ]];
        // out(json_encode($criteresGeo));

        $request->setConditions($tab);

        $r = $request->buildRequest();

        // grouper par le critère séléctionner pour l'analyse
        $r .= Requetteur_BDD::get_BDD_grouping_key($grouping);

        $r .= "&limit=100";
        return self::get_API_data($r);
    }

    /**
     * Récupère et mets en forme toutes la totalité des données
     * 
     * @param string $donnees_ciblees Le morceau de la requette selectionnant les données et les filtrants
     * 
     * @return array La liste des données renvoyée pour cette requette
     */
    public static function get_API_data($donnees_ciblees)
    {
        // faire une boucle pour récupérer les données
        $response = self::API_request($donnees_ciblees);

        // mettre en forme les données
        // Décoder les données JSON
        $data = json_decode($response, true);
        // out(json_encode($data));

        // Vérifier si les données sont valides
        if (json_last_error() === JSON_ERROR_NONE) {
            return $data["results"];
        } else {
            throw new Exception('Erreur de décodage JSON : ' . json_last_error_msg()); // Afficher le message d'erreur
        }
    }

    /**
     * Effectue une requette a l'API SYNOP
     * 
     * @param string $request La chane de caractère commancant par "?" qui paramètre l'API
     * 
     * @return string le fichier json renvoyé par l'API
     */
    public static function API_request($request)
    {
        // URL de l'API
        $apiUrl = "https://public.opendatasoft.com/api/explore/v2.1/catalog/datasets/donnees-synop-essentielles-omm/records" . $request;

        // $entete = new Entete();
        // $entete->out($apiUrl);

        // Initialiser une session cURL
        $ch = curl_init();

        // Configurer les options de cURL
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Désactiver la vérification SSL pour le test
        $response = curl_exec($ch);
        // Vérifier si une erreur s'est produite
        if (curl_errno($ch)) {
            echo 'Erreur cURL: ' . curl_error($ch);
            curl_close($ch);
            exit;
        }
        // Fermer la session cURL
        curl_close($ch);

        return $response;
    }
}
