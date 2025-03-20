-- ===============================
-- SCRIPT DE DÉPLOIEMENT GLOBAL
-- ===============================

-- Suppression de la base si elle existe
DROP DATABASE IF EXISTS ma_base;

-- Création de la base
CREATE DATABASE ma_base CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Sélection de la base
USE ma_base;

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
