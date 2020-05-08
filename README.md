# Invernadero inteligente

Proyecto basado en una aplicación web que monitoriza un pequeño invernadero mediante sensores y realiza acciones mediante actuadores de manera remota y con validaciones específicas según el tipo de planta y características de cada una de ellas. Se divide en tres módulos principales.

En este proyecto mis participaciones fueron en el módulo de interfaz Python, el Módulo Arduino por completo y dentro del módulo web participé en la administración de usuarios, autenticación y la comunicación con Python.

## Módulo Arduino
Mediante los microcontroladores Arduino se lleva a cabo la tarea de obtener datos desde las lecturas de los sensores y ejecutar tareas desde la activación/desactivación de los actuadores específicos. La comunicación con la aplicación central se lleva a cabo mediante una interfaz intermedia de comunicación serial.

## Módulo Python
Mediante este módulo se lleva a cabo la comunicación entre el módulo Arduino y la aplicación central, Python obtiene/envía la información desde/hacia Arduino mediante la comunicación serial. El microcontrolador debe estar conectado mediante el cable USB a una computadora/raspberry capáz de ejecutar Python 3 y contar con conexión a Internet para interactuar con el módulo central. Se encarga de hacer lectura del estado de los actuadores y actualizar la lectura de los sensores.

## Módulo web
Mediante este móodulo se lleva a cabo la presentación e interacción de la plataforma con el usuario, esta es la parte frontal y de negociación de los datos obtenidos desde los nodos de los módulos Arduino. 

