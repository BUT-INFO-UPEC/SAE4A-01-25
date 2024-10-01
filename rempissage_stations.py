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
PARAMS_LISTE_IDS_STATIONS = "group_by=numer_sta"

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

def get_data(parameters="", type=TYPE):
    """Permet de récupérer tous les résultat d'une requète a l'API, sauf si une page est spécifiée

    Args:
        parameters (str, optional): Les paramètres de filtre a insérer dans la requète. Defaults to "".
         anciennement : type (STR): "taxons", "indices" ou "stations_hydrobio", en fonction de quelle requète doit ètre éfféctuée
         maintennant : une seule table (TYPE = "records")

    Returns:
        Full_data: Les donées renvoyées par l'API, dans un objet de gestion de ses données
    """
    full_data = []
    i=1

    # Initiate the page or return the specified one
    if "page=" in parameters:
        response, status = request(type, parameters)
        full_data.extend(response)
        return full_data, status
    elif parameters == "":
        parameters = f"?page={i}"
    else:
        parameters += f"&page={i}"

    # Loop to get all the data
    while True:
        response, status = request(type, parameters)
        # Check if the response is successful
        if status == 200:
            full_data.extend(response["results"])
            return full_data
        if status == 206:
            full_data.extend(response["results"])
            i+=1
        else:
            raise Exception(status)
        # print(i)
        print(i)

        # Change of page
        in_page = False
        post_parameters = ""
        for j in range(4, len(parameters)):
            if parameters[j-4] == "p" and parameters[j-3] == "a" and parameters[j-2] == "g" and parameters[j-1] == "e" and parameters[j]=="=":
                pre_parameters = parameters[:j+1]
                in_page = True
            if in_page and parameters[j] == "&":
                post_parameters = parameters[j:]
                break
        parameters = pre_parameters + str(i) + post_parameters

def get_station_infos(station_id):
    return f"select=numer_sta,nom,latitude,longitude,libgeo,codegeo,nom_epci,code_epci,nom_dept,code_dep,nom_reg,code_reg&where=numer_sta='{station_id}'"

#####################################################################
# DATABASE ACCES FUNCTIONS
#####################################################################

def db_write(DBPATH, query, parameters):
    conn = sqlite3.connect(DBPATH)
    cursor = conn.cursor()

    cursor.execute(query, parameters)

    conn.commit()
    conn.close()

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
    print(len(liste_ids))
    for sta in liste_ids:
        id = sta["numer_sta"]
        query = "SELECT COUNT(*) FROM stations WHERE id = ?"
        parameters = (id,)
        if db_read(DBPATH, query, parameters)[0][0] == 0:
            station = get_data(get_station_infos(id))[0]

            # ajouter la region dans la BDD
            query = """ INSERT OR IGNORE 
                    INTO regions (id, name)
                    VALUES (?, ?)"""
            parameters = (station["code_reg"],station["nom_reg"])
            db_write(DBPATH, query, parameters)

            # ajouter le departement dans la BDD
            query = """ INSERT OR IGNORE 
                    INTO depts (id, name, reg_id)
                    VALUES (?, ?, ?)"""
            parameters = (station["code_dep"],station["nom_dept"], station["code_reg"])
            db_write(DBPATH, query, parameters)

            # ajouter l'epci dans la BDD
            query = """ INSERT OR IGNORE 
                    INTO epcis (id, name, dept_id)
                    VALUES (?, ?, ?)"""
            parameters = (station["code_epci"],station["nom_epci"], station["code_dep"])
            db_write(DBPATH, query, parameters)

            # ajouter la ville dans la BDD
            query = """ INSERT OR IGNORE 
                    INTO villes (id, name, epci_id)
                    VALUES (?, ?, ?)"""
            parameters = (station["codegeo"],station["libgeo"], station["code_epci"])
            db_write(DBPATH, query, parameters)

            query = """INSERT OR IGNORE 
                    INTO stations (id, name, latitude, longitude, ville_id)
                    VALUES (?, ?, ?, ?, ?)"""
            parameters = (station["numer_sta"], station["nom"], station["latitude"], station["longitude"], station["codegeo"])
            db_write(DBPATH, query, parameters)

            print(id)

fill_DB()