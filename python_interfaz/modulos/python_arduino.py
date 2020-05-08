#!/usr/bin/env python
# -*- coding: utf-8 -*-

# Librerias
import serial

# Clase
class py_arduino:
    # Variables globales
    def __init__(self):
        self.ID_Device = ""
    
    def readArduino_Serial(self):
        #  Leer serial de Arduino, quitar comentarios cuando opere con dispositivo
        ser = serial.Serial('/dev/cu.usbmodem14101',115200)
        line = ser.readline().decode().replace('\r\n','')
        ser.close()
        arduino_data = (line.replace(';','')).split('?')
        self.ID_Device = arduino_data[0]
        ## Validar data
        if(arduino_data[0] == self.ID_Device) and (len(arduino_data) > 1):
            # print(arduino_data[1])
            str_req = arduino_data[1]
            return str_req
        else:
            return "No device", ""
    
    def writeArduino_Serial(self, str_Serial):
        #  Enviar por serial configuraciones a Arduino, quitar comentarios cuando opere con dispositivo
        ser = serial.Serial('/dev/cu.usbmodem14101',115200)
        ser.write((str_Serial+"\r\n").encode('ascii'))
        ser.close()