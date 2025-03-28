-- ===============================
-- SCRIPT DE DÉPLOIEMENT GLOBAL
-- ===============================

-- Suppression de la base si elle existe
DROP DATABASE IF EXISTS dev_meteoscop;

-- Création de la base
CREATE DATABASE dev_meteoscop CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Sélection de la base
USE dev_meteoscop;

-- ===============================
-- IMPORT DES SCRIPTS EXTERNES
-- ===============================

-- Création des tables
SOURCE crea_tables.sql;

-- Insertion des données
SOURCE static_data.sql;
SOURCE parameters_data.sql;
SOURCE insertion_data.sql;

-- ===============================
-- Fin de l’instanciation
-- ===============================
