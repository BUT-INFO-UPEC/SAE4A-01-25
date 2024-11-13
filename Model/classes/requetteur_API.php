<?php
$apiUrl = "https://public.opendatasoft.com/api/explore/v2.1/catalog/datasets/donnees-synop-essentielles-omm/records";

/**
 * Récupère les données de l'API selon les critères spécifiés
 * 
 * @param mixed $filtres Filtres des données a analysées (liste de station + encadrement temporel)
 * @param string $attribut La clé de l'attribut a analyser et donc requeter
 * @param string $aggregation La fonction analitique a apliquée sur les groupements de données
 * @param mixed $grouping Le critère de groupement des données pour  analyse
 * @return array La liste des données renvoyée par l'API
 */
function API_request($filtres, $attribut, $aggregation, $grouping) {}
