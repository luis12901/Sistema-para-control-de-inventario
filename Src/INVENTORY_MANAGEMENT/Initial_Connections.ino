/*
   Project: Inventory Management 

   Description: This function initiates networking for an Inventory Management system. It first checks and establishes 
   a WiFi connection, then verifies the server connection. If both connections succeed, it activates a buzzer, prints a success message on the LCD, and returns true. 
   If there are connection errors, it activates the buzzer and prints an error message on the LCD before returning false.

   Author: Jose Luis Murillo Salas

   Creation Date: August 20, 2023

   Contact: joseluis.murillo2022@hotmail.com
*/
bool beginNetworking(){


  if(WifiConnected()){

      
      printCentered(0,"Conectando....");
      printCentered(1,"Porfavor espere");
      
        delay(200);

      if(ServerConnected()){
        
        digitalWrite(BUZZER_PIN, HIGH);
        delay(200);
        digitalWrite(BUZZER_PIN, LOW);
        printCentered(0,"Conectado");
        Serial.println("Connected Successfully");       
        return true;

      }
      else{


        digitalWrite(BUZZER_PIN, HIGH);
        delay(2000);
        digitalWrite(BUZZER_PIN, LOW);
        delay(2000);  
        digitalWrite(BUZZER_PIN, HIGH);
        delay(2000);
        digitalWrite(BUZZER_PIN, LOW);

        Serial.println("Connection Error");

        printCentered(0,"Error de");
        printCentered(1,"conexion 02");
        delay(2000);
        return false;

      }

  }
  else{

    digitalWrite(BUZZER_PIN, HIGH);
    delay(2000);
    digitalWrite(BUZZER_PIN, LOW);
    delay(200);  
    digitalWrite(BUZZER_PIN, HIGH);
    delay(2000);
    digitalWrite(BUZZER_PIN, LOW);
    
    Serial.println("Connection Error");

    printCentered(0,"Error de");
    printCentered(1,"conexion 01");
    delay(2000);
    return false;

  }
}