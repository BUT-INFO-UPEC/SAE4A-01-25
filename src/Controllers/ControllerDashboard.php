<?php

namespace Src\Controllers;

use Src\Model\DataObject\Dashboard;
use Src\Model\Repository\Requetteur_BDD;

class ControllerDashboard extends AbstractController
{
    static public function default(): void
    {
        ControllerDashboard::browse();
    }

    static function getActionsList(): array
    {
        return array('Liste' => 'action=browse', 'Creation' => 'action=create');
    }

    // =======================
    //    ENTRY METHODS
    // =======================
    #region entry
    static public function browse(): void
    {
        // Récupération des filtres depuis la requête GET
        $region = $_GET['region'] ?? '';
        $order = $_GET['order'] ?? 'recent';
        $dateFilter = $_GET['date'] ?? 'today';
        $customStartDate = $_GET['start_date'] ?? '';
        $customEndDate = $_GET['end_date'] ?? '';

        // Récupération de tous les tableaux de bord
        $dashboards = Dashboard::get_dashboards();

        // Logique de filtrage des tableaux de bord
        $filteredDashboards = array_filter($dashboards, function ($dash) use ($region, $dateFilter, $customStartDate, $customEndDate) {
            $passesRegionFilter = $region ? $dash->get_region() === $region : true;
            $passesDateFilter = true;

            if ($dateFilter === 'yesterday') {
                $passesDateFilter = strtotime($dash->get_date()) >= strtotime('yesterday') && strtotime($dash->get_date()) < strtotime('today');
            } elseif ($dateFilter === 'today') {
                $passesDateFilter = strtotime($dash->get_date()) >= strtotime('today') && strtotime($dash->get_date()) < strtotime('tomorrow');
            } elseif ($dateFilter === 'this_week') {
                $passesDateFilter = strtotime($dash->get_date()) >= strtotime('monday this week') && strtotime($dash->get_date()) < strtotime('monday next week');
            } elseif ($dateFilter === 'custom' && $customStartDate && $customEndDate) {
                $passesDateFilter = strtotime($dash->get_date()) >= strtotime($customStartDate) && strtotime($dash->get_date()) <= strtotime($customEndDate);
            }

            return $passesRegionFilter && $passesDateFilter;
        });

        // Logique de tri des tableaux de bord
        usort($filteredDashboards, function ($a, $b) use ($order) {
            if ($order === 'most_viewed') {
                return $b->get_views() - $a->get_views();
            } else { // Par défaut : 'recent'
                return strtotime($b->get_date()) - strtotime($a->get_date());
            }
        });

        // Préparation des variables pour la vue
        $titrePage = "Liste Des Dashboards";
        $cheminVueBody = "browse.php";

        // Inclusion de la vue avec les données filtrées
        require('../src/Views/Template/views.php');
    }

    static function create(): void
    {
        $station = Requetteur_BDD::get_station();

        $titrePage = "Edition d'un Dashboard";
        $cheminVueBody = "create.php";
        require('../src/Views/Template/views.php');
    }
    #endregion entry

    // =======================
    //    GET METHODS
    // =======================
    #region get
    static public function visu_dashboard(): void
    {
        $dash = Dashboard::get_dashboard_by_id($_GET["dashId"]);

        $titrePage = "Visualisatoin du Dashboard";
        $cheminVueBody = "visu.php";
        require('../src/Views/Template/views.php');
    }
    #endregion get

    // =======================
    //    POST METHODS
    // =======================
    #region post
    #endregion post
}
