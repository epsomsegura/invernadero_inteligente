#!/usr/bin/env python
# -*- coding: utf-8 -*-

# Librerias
import json
import requests

# Clase
class py_api:
    target_host = "http://192.168.1.111/invernadero/public/api"
    # Variables globales
    def __init__(self):
        self.dict_Actuators={}

    # Leer token de API
    def readToken_API(self):
        ## Recuperar URL token
        respTken = requests.get('https://website.com/id',
            headers={'Authorization': 'access_token myToken'})
        myToken = '<token>'
        myUrl = '<website>'
        head = {'Authorization': 'token {}'.format(myToken)}
        response = requests.get(myUrl, headers=head)

    # Métodos
    # Leer datos desde API
    def readConfig_API(self,ID_Device):
        ##  Leer las configuraciones desde la app web
        aimURL = self.target_host+"/conf"
        params = {
            "id": ID_Device,
        }
        response = requests.post(url = aimURL, data = params)

        if(response.status_code==200):
            return (response.content).decode("utf-8")
        else:
            return "error"



    # Escribir datos de lectura de sensorea a la API
    def writeParams_API(self, ID_Device, str_Params):
        dict_Data = self.parseJSON(ID_Device, str_Params)
        ##  Enviar las lecturas de los sensores a la app web
        aimURL = self.target_host+"/sense"
        response = requests.post(url = aimURL, data = dict_Data) 
        response = response.content
    
    # Escribir datos de lectura de
    def writeActuators_API(self, ID_Device, str_Actuators):
        dict_Data = self.parseJSON(ID_Device, str_Actuators)
        if(self.dict_Actuators != dict_Data):
            self.dict_Actuators=dict_Data
            aimURL = self.target_host+"/sense"
            response = requests.post(url = aimURL, data = dict_Data) 
            response = response.content



    # Creación del objeto para parsear a JSON
    def parseJSON(self, ID_Device, str_Data):
        dict_Data = {}
        dict_Data["ID_Device"] = ID_Device

        str_chain = str_Data.split('|')

        for i in str_chain:
            arr_values = i.split(':')
            dict_Data[arr_values[0]]=arr_values[1]
        
        return dict_Data