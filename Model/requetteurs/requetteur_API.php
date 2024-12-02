<?php
require_once __DIR__ . "/requetteur_BDD.php";
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
function API_componant_data($filtres, $attribut, $aggregation, $grouping) {
    // réaliser l'oppération d'aggregation sur l'attribut demandé
    $request = "?select=". $aggregation."(".$attribut.")";

    $criteresGeo = "";
    // filtrer uniquement les resultats correspondants aux critères de la météothèque
    if (isset($filtres["geo"]) && !empty($filtres["geo"])){
        $criteresGeo.= "(";
        foreach (array_keys($filtres["geo"]) as $criterGeo) {
            if (isset($filtres["geo"][$criterGeo])) {
                foreach ($filtres["geo"][$criterGeo] as $valeur) {
                    $valeur = $criterGeo == "numer_sta" ? "%27".$valeur."%27" : $valeur ; // "%27" = char espace encodé pour l'url
                    $criteresGeo.=$criterGeo."=".$valeur."%20or%20";
                }
                //retirer les huix derniers char de $request car c'est un or et deux espaces encodés
                $criteresGeo = substr($criteresGeo, 0, -8);
                $criteresGeo.= ")%20and%20";
            } 
        } 
    }

    $criteresGeo.="date%20>=%20%27".$filtres["dateDebut"]."%27%20and%20date%20<=%20%27".$filtres["dateFin"]."%27"; // "%20" = char guillemets encodé pour l'url

    $request.="&where=". $criteresGeo;

    // grouper par le critère séléctionner pour l'analyse
    $request.= get_BDD_grouping_key($grouping);

    $request.="&limit=100";
    return get_API_data($request);
}

/**
 * Récupère et mets en forme toutes la totalité des données
 * 
 * @param string $donnees_ciblees Le morceau de la requette selectionnant les données et les filtrants
 * 
 * @return array La liste des données renvoyée pour cette requette
 */
function get_API_data($donnees_ciblees) {
    // faire une boucle pour récupérer les données
    $response = API_request($donnees_ciblees);

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
function API_request($request) {
    // URL de l'API
    $apiUrl = "https://public.opendatasoft.com/api/explore/v2.1/catalog/datasets/donnees-synop-essentielles-omm/records" . $request;

    out("<p>$apiUrl</p>");

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