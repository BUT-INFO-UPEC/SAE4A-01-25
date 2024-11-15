<?php
/**
 * Récupère les données de l'API selon les critères spécifiés
 * 
 * @param mixed $filtres Filtres des données a analysées (liste de station + encadrement temporel)
 * @param string $attribut La clé de l'attribut a analyser et donc requeter
 * @param string $aggregation La fonction analitique a apliquée sur les groupements de données
 * @param mixed $grouping Le critère de groupement des données pour  analyse
 * @return array La liste des données renvoyée par l'API
 */
function API_componant_data($filtres, $attribut, $aggregation, $grouping) {
    // réaliser l'oppération d'aggregation sur l'attribut demandé
    $request = "?select=". $aggregation."(".$attribut.")";

    $criteresGeo = "(";
    // filtrer uniquement les resultats correspondants aux critères de la météothèque
    foreach (array_keys($filtres["geo"]) as $criterGeo) {
        if (isset($filtres["geo"][$criterGeo])) {
            foreach ($filtres["geo"][$criterGeo] as $valeur) {
                $valeur = $criterGeo == "numer_sta" ? "%27".$valeur."%27" : $valeur ;
                $criteresGeo.=$criterGeo."=".$valeur." or ";
            }
        }
    }
    //retirer les deux car de $request car c'est un or
    $criteresGeo = substr($criteresGeo, 0, -4);
    $criteresGeo.=")%20and%20date%20>=%20%27".$filtres["dateDebut"]."%27%20and%20date%20<=%20%27".$filtres["dateFin"]."%27";

    $request.="&where=". $criteresGeo;

    // grouper par le critère séléctionner pour l'analyse
    // $request.=" &group_by=".$grouping;

    $request.="&limit=100";
    return API_request($request);
}
$str = "?select=avg(t)&where=(numer_sta=78925)%20and%20date%20>=%20%272024-11-14T00:00:00%27%20and%20date%20<=%20%272024-11-07T00:00:00%27&limit=100";

function API_request($request) {
    // URL de l'API
    $apiUrl = "https://public.opendatasoft.com/api/explore/v2.1/catalog/datasets/donnees-synop-essentielles-omm/records" . $request;

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

    // Décoder les données JSON
    $data = json_decode($response, true);

    // Vérifier si les données sont valides
    if (json_last_error() === JSON_ERROR_NONE) {
        return $data;
    } else {
        throw new Exception('Erreur de décodage JSON : ' . json_last_error_msg()); // Afficher le message d'erreur
    }
}
