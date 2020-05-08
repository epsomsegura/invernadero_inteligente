#!/usr/bin/env python
# -*- coding: utf-8 -*-

# Librerias
from modulos.python_arduino import py_arduino as py_arduino
from modulos.python_api import py_api as py_api
import time

class main:
    #   Constructor
    def __init__(self):
        # Instancias a otras clases
        self.py_arduino = py_arduino()
        self.py_api = py_api()        

        # Variables globales
        self.n_Arduino_to_API = 60          # Segundos de espera para enviar lectura de sensores desde Arduino y enviarlas a la API
        self.n_contArduino=1                # Contador de segundos para lectura de sensores desde Arduino
        self.ID_Device=""                  # ID del dispositivo
        
        # Bucle infinito para interacción con Arduino
        while(True):
            # Leer el puerto serial de Arduino
            str_ReadArduino = self.py_arduino.readArduino_Serial()

            # Validar lectura de Arduino
            if str_ReadArduino.find('@') >= 0:
               str_Params = str_ReadArduino.split('@')[0]
               str_Alerts = str_ReadArduino.split('@')[1]
            else:
               str_Params = ""
               str_Alerts = ""

            #   Asignar el ID de arduino a una variable para identificar el dispositivo en la API
            if(self.ID_Device == "" or self.ID_Device == "No device"):
                self.ID_Device=self.py_arduino.ID_Device

            #   Iniciar las operaciones de los módulos
            else:
                #   Leer configuraciones de la API y enviarlas a Arduino
                str_ConfigArduino = self.py_api.readConfig_API(self.ID_Device)
                print(str_ConfigArduino)
                self.py_arduino.writeArduino_Serial(str_ConfigArduino)

                #   Enviar alertas capturadas desde Arduino a la API
                self.py_api.writeActuators_API(self.ID_Device, str_Alerts)
                     
                #   Enviar lectura de sensores de Arduino a la API
                if(self.n_contArduino >= self.n_Arduino_to_API):
                    self.py_api.writeParams_API(self.ID_Device, str_Params)
                    self.n_contArduino = 1

                # Aumentar contadores
                self.n_contArduino=self.n_contArduino+1

            # Retardo de un segundo
            time.sleep(3)

main()