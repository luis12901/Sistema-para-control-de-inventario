/*
   Project: RFID Access Control ()
   Description: 
   Author: Jose Luis Murillo Salas
   Creation Date: August 20, 2023
   Contact: joseluis.murillo2022@hotmail.com
*/



void pinConfig(){

  pinMode(deepSleepPin, INPUT_PULLDOWN);
  pinMode(LCD, OUTPUT);
  pinMode(RFID, OUTPUT);
  pinMode(BUZZER_PIN, OUTPUT);
  pinMode(LOCK_PIN, OUTPUT);
  pinMode(PIR_PIN, INPUT);
  pinMode(ACTUATOR_PIN, OUTPUT);
  pinMode(LIMIT_SWT_PIN, INPUT_PULLDOWN);
  pinMode(DoorStatusPin, OUTPUT);
  pinMode(CONNECTED, OUTPUT);
  pinMode(DISCONNECTED, OUTPUT);
  pinMode(CARD_DETECTED, OUTPUT);
  pinMode(changeMode_Pin, INPUT_PULLDOWN);


  digitalWrite(LCD, LOW);
  digitalWrite(RFID, LOW);
  digitalWrite(BUZZER_PIN, LOW);
  digitalWrite(LOCK_PIN, HIGH);
  digitalWrite(ACTUATOR_PIN, LOW);
  digitalWrite(DoorStatusPin, LOW);
  digitalWrite(CONNECTED, LOW);
  digitalWrite(DISCONNECTED, HIGH);
  digitalWrite(CARD_DETECTED, LOW);


  attachInterrupt(digitalPinToInterrupt(34), boton_1_isr, RISING);

  //attachInterrupt(digitalPinToInterrupt(deepSleepPin), boton_1_isr, RISING);          // Deepsleep Mode Pin || GND Permanently


}