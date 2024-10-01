# -*- coding: utf-8 -*-
#####################################################################
# MODULES IMPORTATION
#####################################################################

import sqlite3
import requests
import json

#####################################################################
# STATICS
#####################################################################

URL_API = "https://public.opendatasoft.com/api/explore/v2.1/catalog/datasets/donnees-synop-essentielles-omm"
TYPE = "records"
PARAMS_LISTE_IDS_STATIONS = "?group_by=numer_sta"

NB_WRITE = 0
NB_EVITES = 0
DBPATH = "database/france.db"


#####################################################################
# API DATA GET
#####################################################################

def request(type = TYPE, parameters=""):
    """Permet de récupérer le résultat d'une requète spécifique a l'API Hub'eau

    Args:
        type (STR): "taxons", "indices" ou "stations_hydrobio", en fonction de quel requète doit ètre éfféctuée
        parameters (str, optional): Les paramètres de filtre a insérer dans la requète. Defaults to "".

    Returns:
        dict: Les donées renvoyées par l'API
    """
    url =  URL_API + "/" + type + "?" + parameters
    # print(url)
    response = requests.get(url)

    data = response.json()
    return data, response.status_code

def get_data(params):
    response, status = request(TYPE, params)
    # Check if the response is successful
    if status == 200:
        return response
    if status == 206:
        print("données incompletes")
        return response
    else:
        raise Exception(status)

def get_station_geo(station_id):
    return f"select=numer_sta,nom,libgeo,codegeo,nom_epci,code_epci,nom_dept,code_dept,nom_reg,code_reg&where=numer_sta={station_id}"

#####################################################################
# DATABASE ACCES FUNCTIONS
#####################################################################

def db_write(DBPATH, query, parameters):
    global NB_WRITE
    conn = sqlite3.connect(DBPATH)
    cursor = conn.cursor()

    cursor.execute(query, parameters)

    conn.commit()
    conn.close()
    NB_WRITE+=1

def db_read(DBPATH, query, parameters):
    conn = sqlite3.connect(DBPATH)
    cursor = conn.cursor()

    cursor.execute(query, parameters)
    db_raw = cursor.fetchall()

    conn.close()
    return db_raw

#####################################################################
# DATABASE FILLING FUNCTIONS
#####################################################################

def fill_DB():
    liste_ids = get_data(PARAMS_LISTE_IDS_STATIONS)
    for id in liste_ids:
        query = "SELECT COUNT(*) FROM stations WHERE id_station = ?"
        parameters = (id,)
        if db_read(DBPATH, query, parameters)[0][0] == 0:
            station = get_data(get_station_geo(id))

            # ajouter la ville dans la BDD
            query = """ INSERT OR IGNORE 
                    INTO ville (id, nomgeo, epci_id)
                    VALUES (?, ?, ?)"""
            parameters = (station["codegoe"],station["nomgoe"], station["code_epci"])
            db_write(DBPATH, query, parameters)

            # ajouter l'epci dans la BDD
            query = """ INSERT OR IGNORE 
                    INTO epci (id, nom_epci, dept_id)
                    VALUES (?, ?, ?)"""
            parameters = (station["code_epci"],station["nom_epci"], station["code_dept"])
            db_write(DBPATH, query, parameters)

            # ajouter le departement dans la BDD
            query = """ INSERT OR IGNORE 
                    INTO dept (id, nom_dept, reg_id)
                    VALUES (?, ?, ?)"""
            parameters = (station["code_dept"],station["nom_dept"], station["code_reg"])
            db_write(DBPATH, query, parameters)

            # ajouter la region dans la BDD
            query = """ INSERT OR IGNORE 
                    INTO epci (id, nom_reg)
                    VALUES (?, ?)"""
            parameters = (station["code_reg"],station["nom_reg"])
            db_write(DBPATH, query, parameters)

            query = """INSERT OR IGNORE 
                    INTO stations ()
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)"""
            parameters = (station["numer_sta"], station["nom"], station["latitude"], station["longitude"], station["codegeo"], station["code_epci"], station["code_dept"], station["code_reg"])
            db_write(DBPATH, query, parameters)

print(NB_WRITE)
print(NB_EVITES)