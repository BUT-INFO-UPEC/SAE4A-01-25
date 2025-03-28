<?php

namespace Src\Model\Repository;

use Src\Config\ServerConf\DatabaseConnection;

class GeoRepository
{
    /**
     * Récupère la liste des régions
     * @return array
     */
    public static function getRegions(): array
    {
        return DatabaseConnection::getTable('regions');
    }

    /**
     * Récupère la liste des départements
     * @return array
     */
    public static function getDepts(): array
    {
        return DatabaseConnection::getTable('depts');
    }

    /**
     * Récupère la liste des villes
     * @return array
     */
    public static function getVilles(): array
    {
        return DatabaseConnection::getTable('villes');
    }

    /**
     * Récupère la liste des stations
     * @return array
     */
    public static function getStations(): array
    {
        return DatabaseConnection::getTable('stations');
    }
}
