/*
   Project: RFID Access Control ()
   Description: 
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