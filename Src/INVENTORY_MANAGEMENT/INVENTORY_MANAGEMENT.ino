/*
   Project: Inventory Management 

   Description: This project encompasses an ESP32-based Inventory Management system,
   featuring RFID card authentication, user credential retrieval, and equipment delivery capabilities.
   Employing Arduino programming, the system utilizes Wi-Fi communication to connect with a designated server. 
   The code architecture emphasizes modularity, allowing flexible configuration of network and server parameters
   to accommodate various deployment environments. With integrated status indicators such as LEDs and a buzzer,
   the system provides real-time feedback on its operational state. The project aims 
   to streamline inventory processes through efficient and secure data handling.

   Author: Jose Luis Murillo Salas

   Creation Date: August 20, 2023

   Contact: joseluis.murillo2022@hotmail.com
*/


// Librerias

  #include <stdio.h>  /* printf, NULL */
  #include <stdlib.h> /* strtod */
  #include <SPI.h>
  #include <MFRC522.h>
  #include <LiquidCrystal_I2C.h>
  #include <ArduinoJson.h>
  #include <EEPROM.h>
  #include "esp_system.h"
  #include <WiFi.h>
  #include <HTTPClient.h>
  #include <WiFiClient.h>
  #include <ESPmDNS.h>

bool OperationMode = false;



void setup() {
  pinConfig();
  interfaceInit();
  beginNetworking();
}

void loop() {
      
    
    if(onlineVerification()){

        if(OperationMode){
          GetUserCredentials(); 
        }
        else{
          equipDeliveryMode();
        }
  
    }

    else{
      Serial.println("We've lost connection");
    } 
}




