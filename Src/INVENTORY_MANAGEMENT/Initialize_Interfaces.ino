/*
   Project: Inventory Management 

   Description: This function initializes the interface components for an Inventory
    Management system. It sets up serial communication, SPI, and initializes RFID (MFRC522) and LCD modules.

   Author: Jose Luis Murillo Salas

   Creation Date: August 20, 2023

   Contact: joseluis.murillo2022@hotmail.com
*/


void interfaceInit(){

    Serial.begin(115200);
    SPI.begin();       

    MFRC522 mfrc522(SS_PIN, RST_PIN);                                         
    mfrc522.PCD_Init();  
    lcd.begin();    
    lcd.backlight(); 

}