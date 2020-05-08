/*
  Universidad Veracruzana
  Maestría en Sistemas Interactivos Centrados en el Usuario
  Fundamentos de Seguridad
  Desarrollado por:     Epsom Enrique Segura Jaramillo
  Proyecto final:       Invernadero
  Descripción:          Módulo de interacción con el invernadero
                        -Envía un identificador del dispositivo para generar interaccón con la plataforma
                        web
                        -Obtiene datos mediante las mediciones de sensores y envía a interfaz Python
                        para alimentar software de plataforma web
                        -Recibe configuraciones desde la interfaz Python para parametrizar actuadores
                        -Recibe instrucciones desde la interfaz Python para activar actuadores
                        -Valida la activación de actuadores mediante datos de configuración
  Fecha:                04/Junio/2019

  Notas importantes
  Antes de implementar con la interfaz Python es necesario considerar las nomenclaturas siguientes para
  lograr una correcta comunicación con el mediador entre el hardware y la plataforma web:

  1. Prestar atención en la asignación de pines de entrada de los sensores y salida de actuadores,
     ya que la cantidad de sensores debe coincidir con los registrados para el dispositivo con el
     ID unico, al igual que los actuadores.
  2. La recepción de instrucciones desde la interfaz Python se debe recibir como una sola cadena,
     unicamente se reciben los parámetros de configuración y los estados de los actuadores para
     una ejecución manual. Un ejemplo para el caso de una cadena de recepción de la interfaz para
     un ambiente de dos sensores de temperatura y un actuador de ventilador seria como el siguiente:
            cnf?t0:min,max|t1:min,max;@act?v0:t;
     Donde se puede observar que:
        - "?" : Corresponde a un caracter especial para separar un tipo de petición de sus parámetros
        - "|" : Corresponde a un caracter especial para separar los parámetros por sensor o actuador
        - ":" : Corresponde a un caracter especial para separar la llave y los valores de los parámetros de un sensor
        - "t" : Corresponde a un caracter especial para indicar que un actuador es activado de forma manual
        - "f" : Corresponde a un caracter especial para indicar que un actuador es desactivado de forma manual
        - "cnf": Corresponde a una llave para identificar una petición de configuraciónes
        - "act": Corresponde a una llave para identificar una petición de actuadores
        - "tX": Corresponde al identificador de un sensor de temperatura, (X) es cambiado por un número
        - "hX": Corresponde al identificador de un sensor de humedad, (X) es cambiado por un número
        - "pX": Corresponde al identificador de un sensor de presencia, (X) es cambiado por un número
        - "fX": Corresponde al identificador de un sensor de fotoresistencia, (X) es cambiado por un número
        - "gX": Corresponde al identificador de un sensor de gas, (X) es cambiado por un número
        - "vX": Corresponde al identificador de un actuador de ventilador, (x) es cambiado por un número
        - "lX": Corresponde al identificador de un actuador de iluminación, (x) es cambiado por un número
   3. La transmisión de valores recuperados mediante el sistema se transfiere a la interfaz haciendo uso de un
      identificador que se le asigna al arduino, ademas se concatena la llave del sensor, seguida del valor 
      recuperado en el momento, un ejemplo de cadena de búsqueda sería como el siguiente:
          ID+"?h0:"+String(h1)+"|h1:"+String(h1)+"|t0:"+String(t1)+"|t1:"+String(t2)
*/

// Librerias
#include <DHT.h>

// Asignación de pines
#define DHTPIN1 7       //  sensor temp y hum 1
#define DHTPIN2 8       //  sensor temp y hum 2
int
  act0 = 6,             //  Pin actuador 1
  act1 = 5;             //  Pin actuador 2
  
//  Variables
boolean 
  b_cnf = false,      //  Bandera configuraciones
  b_act = false;      //  Bandera actuadores
String
  //  Variables de control
  cnf="",
  cnf_s="",
  act="",
  act_s="",
  //  ID del dispositivo
  ID="1",  //  Cambiar por el generado en la plataforma web
  //  Sensores
  //  Asignar el número(cantidad) de sensores en la variable nSens
  t0="",            // valor temperatura sensor 1
  t1="",            // valor temperatura sensor 2
  h0="",            // valor humedad sensor 1
  h1="",            // valor humedad sensor 2
  //  Actuadores
  //  Asignar el número(cantidad) de actuadores en la variable nAct
  v0="f",           // valor ventilador 1
  v1="f",           // valor ventilador 2 
  //  Estado de los actuadores 
  a_v0="f",         //  estado del cambio del actuador
  a_v1="f";         //  estado del cambio del actuador

// Número de sensores
int 
  nSens = 4,
  nAct = 2;

//  Parámetros
float
  t0_m=0,       //  temperatura mínima sensor 1
  t0_M=1000,    //  temperatura máxima sensor 1
  t1_m=0,       //  temperatura mínima sensor 2
  t1_M=1000,    //  temperatura máxima sensor 2
  h0_m=0,       //  humedad mínima sensor 1
  h0_M=1000,    //  humedad máxima sensor 1
  h1_m=0,       //  humedad mínima sensor 2
  h1_M=1000;    //  humedad máxima sensor 2


// Iniciar DHT11
#define DHTTYPE DHT11
DHT dht1(DHTPIN1, DHTTYPE);
DHT dht2(DHTPIN2, DHTTYPE);




/*****************************************************************************************/
//  SETUP
/*****************************************************************************************/
void setup() {
  //  Configurar pines
  pinMode(act0, OUTPUT);
  pinMode(act1, OUTPUT);
  
  // Iniciar serial
  Serial.begin(115200);
  // Iniciar DHT11s
  dht1.begin();
  dht2.begin();
  //  Iniciar configuraciones
  saveSerial();
  //  Iniciar actuación
  triggerAct();
}





/*****************************************************************************************/
//  LOOP
/*****************************************************************************************/
void loop() {
 loadSerial();
 if(b_cnf) getConfig();
 if(b_act) getActStatus();
 triggerAct();
 sendSerial();
 }





/*****************************************************************************************/
//    FUNCIONES SERIAL
/*****************************************************************************************/
//  Enviar ID del dispositivo a interfaz python
//  Guardar configuraciones
void saveSerial(){
  String ser=Serial.readString();
  cnf=splitValor(ser,'@',0);
  act=splitValor(ser,'@',1);
  cnf_s=splitValor(ser,'@',0);
  act_s=splitValor(ser,'@',1);
  Serial.println("Configuraciones cargadas");
}

//  Leer serial
void loadSerial(){
  String ser=Serial.readString();
  cnf=splitValor(ser,'@',0);
  act=splitValor(ser,'@',1);
  b_cnf=(cnf_s != cnf);
  b_act=(act_s != act);
}

//  Enviar serial
void sendSerial(){
  //  Leer humedad de los sensores
  float h0 = dht1.readHumidity();
  float h1 = dht2.readHumidity();

  //  Leer temperatura en grados centigrados
  float t0 = dht1.readTemperature();
  float t1 = dht2.readTemperature();

  t0 = dht1.computeHeatIndex(t0, h0, false);
  t1 = dht2.computeHeatIndex(t1, h1, false);

 
  // Buscar errores de lectura
  // Agregar a la cadena si el sensor está activo o no
  String s_h0 = (isnan(h0)) ? "error" : String(h0);
  String s_h1 = (isnan(h1)) ? "error" : String(h1);
  String s_t0 = (isnan(t0)) ? "error" : String(t0);
  String s_t1 = (isnan(t1)) ? "error" : String(t1);

  //  Imprimir cadena serial
  Serial.println(ID+"?h0:"+s_h0+"|h1:"+s_h1+"|t0:"+s_t0+"|t1:"+s_t1+"@"+"v0:"+a_v0+"|v1:"+a_v1);
}





/*****************************************************************************************/
//    FUNCIONES CONFIGURACIONES
/*****************************************************************************************/
//  Obtener configuraciónes
void getConfig(){
  cnf.replace(";","|");
  if(splitValor(cnf,'?',0)=="cnf"){
    //  Obtener parámetros de sensores
    String req = splitValor(cnf,'?',1);
    cnf.replace(";","");
    for(int i=0;i<nSens;i++){
      String params = splitValor(req,'|',i);
      String v = splitValor(params,':',1);
      if(splitValor(params,':',0)=="t0"){
        t0_m=splitValor(v,',',0).toFloat();
        t0_M=splitValor(v,',',1).toFloat();
      }
      else if(splitValor(params,':',0)=="t1"){
        t1_m=splitValor(v,',',0).toFloat();
        t1_M=splitValor(v,',',1).toFloat();
      }
      else if(splitValor(params,':',0)=="h0"){
        h0_m=splitValor(v,',',0).toFloat();
        h0_M=splitValor(v,',',1).toFloat();
      }
      else if(splitValor(params,':',0)=="h1"){
        h1_m=splitValor(v,',',0).toFloat();
        h1_M=splitValor(v,',',1).toFloat();
      }
    }
  }
}

//  Leer parámetros de actuadores
void getActStatus(){
  act.replace(';','|');
  if(splitValor(act,'?',0)=="act"){
    String req = splitValor(act,'?',1);
    for(int i=0;i<nAct+1;i++){
      String params = splitValor(req,'|',i);
      String v = splitValor(params,':',1);
      if(splitValor(params,':',0)=="v0"){
        v0=v;
      }
      else if(splitValor(params,':',0)=="v1"){
        v1=v;
      }
    }
  }
}





/*****************************************************************************************/
//    FUNCIONES ACTUADORES
/*****************************************************************************************/
//  Disparador de actuadores
//  Agregar una respuesta del estado del sensor
void triggerAct(){  
  act0_a();     //  Actuador ventilador 1
  act1_a();     //  Actuador ventilador 2
}

//  Actuador ventilador 1
void act0_a(){
  float t = dht1.readTemperature();
  float h = dht1.readHumidity();
  t = dht1.computeHeatIndex(t, h, false);
  //  Verificar que la temperatura detectada se encuentra dentro del rango permitido
  bool flag = t>=t0_M;

  //  Activación manual - Encencido
  if(v0 == "t"){
    //  Validación para activación manual
    if(flag){
      a_v0 = "f";
      digitalWrite(act0,LOW);
    }
    else{
      a_v0 = "t";
      digitalWrite(act0,HIGH);
    }
  }
  //  Activación manual - Apagado
  else if(v0 == "f"){
    //  Validación para activación manual
    if(flag){
      a_v0 = "t";
      digitalWrite(act0,HIGH);
    }
    else{
      a_v0 = "f";
      digitalWrite(act0,LOW);
    }
  }
  else{
    //  Validación para activación manual
    if(flag){
      a_v0 = "t";
      digitalWrite(act0,HIGH);
    }
    else{
      a_v0 = "f";
      digitalWrite(act0,LOW);
    }
  }
}

//  Actuador ventilador 2
void act1_a(){
  float t = dht2.readTemperature();
  float h = dht2.readHumidity();
  t = dht2.computeHeatIndex(t, h, false);
    //  Verificar que la temperatura detectada se encuentra dentro del rango permitido
  bool flag = t>=t1_M;
  
  //  Activación manual - Encencido
  if(v1 == "t"){
    //  Validación para activación manual
    if(flag){
      a_v1 = "f";
      digitalWrite(act1,LOW);
    }
    else{
      a_v1 = "t";
      digitalWrite(act1,HIGH);      
    }
  }
  //  Activación manual - Apagado
  else if(v1 == "f"){
    //  Validación para activación manual
    if(flag){
      a_v1 = "t";
      digitalWrite(act1,HIGH);
    }
    else{
      a_v1 = "f";
      digitalWrite(act1,LOW);
    }
  }
  else{
    //  Validación para activación manual
    if(flag){
      a_v1 = "t";
      digitalWrite(act1,HIGH);
    }
    else{
      a_v1 = "f";
      digitalWrite(act1,LOW);
    }
  }
}





/*****************************************************************************************/
//    FUNCIONES VARIAS
/*****************************************************************************************/
//  Split a un string
String splitValor(String txt, char separator, int ind){
  int found = 0;
  int strIndex[] = {0, -1};
  int maxIndex = txt.length()-1;
  for(int i=0; i<=maxIndex && found<=ind; i++){
    if(txt.charAt(i)==separator || i==maxIndex){
        found++;
        strIndex[0] = strIndex[1]+1;
        strIndex[1] = (i == maxIndex) ? i+1 : i;
    }
  }
  return found>ind ? txt.substring(strIndex[0], strIndex[1]) : "";
}
