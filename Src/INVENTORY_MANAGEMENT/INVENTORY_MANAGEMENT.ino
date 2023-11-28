/*
   Project: RFID Access Control ()
   Description: 
   Author: Jose Luis Murillo Salas
   Creation Date: August 20, 2023
   Contact: joseluis.murillo2022@hotmail.com
*/


// Librerias

  #include <stdio.h>  /* printf, NULL */
  #include <stdlib.h> /* strtod */
  #include <esp_sleep.h>
  #include <SPI.h>
  #include <MFRC522.h>
  #include <LiquidCrystal_I2C.h>
  #include <ArduinoJson.h>
  #include <EEPROM.h>
  #include "esp_system.h"
  #include <Keypad.h>
  #include <WiFi.h>
  #include <HTTPClient.h>
  #include <WiFiClient.h>
  #include <ESPmDNS.h>
  #define LIMIT_SWT_PIN 33

bool OperationMode = false;



void setup() {
  pinConfig();
  interfaceInit();
  beginNetworking();
}

void loop() {
    VerifyOperationMode();
      
    inactivityTimer();
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




