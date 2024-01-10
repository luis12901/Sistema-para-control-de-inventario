/*
   Project: Inventory Management 

   Description: This code configures pins for an Inventory Management system, setting up outputs for an LCD, RFID,
    Buzzer, and status indicators. It also initializes default states for these components.

   Author: Jose Luis Murillo Salas

   Creation Date: August 20, 2023

   Contact: joseluis.murillo2022@hotmail.com
*/



void pinConfig(){

  pinMode(LCD, OUTPUT);
  pinMode(RFID, OUTPUT);
  pinMode(BUZZER_PIN, OUTPUT);
  pinMode(CONNECTED, OUTPUT);
  pinMode(DISCONNECTED, OUTPUT);
  pinMode(CARD_DETECTED, OUTPUT);
  pinMode(changeMode_Pin, INPUT_PULLDOWN);


  digitalWrite(LCD, LOW);
  digitalWrite(RFID, LOW);
  digitalWrite(BUZZER_PIN, LOW);

  digitalWrite(CONNECTED, LOW);
  digitalWrite(DISCONNECTED, HIGH);
  digitalWrite(CARD_DETECTED, LOW);



}