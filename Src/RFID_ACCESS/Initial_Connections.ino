/*
   Project: RFID Access Control ()
   Description: 
   Author: Jose Luis Murillo Salas
   Creation Date: August 20, 2023
   Contact: joseluis.murillo2022@hotmail.com
*/

bool beginNetworking(){


  if(WifiConnected()){

      lcd.clear();
      lcd.setCursor(3,1);
      lcd.print("Connecting to");

      lcd.setCursor(5,3);
      lcd.print("server .....");

      if(ServerConnected()){

      digitalWrite(BUZZER_PIN, HIGH);
      delay(200);
      digitalWrite(BUZZER_PIN, LOW);
   
        Serial.println("Connected Successfully");

        lcd.clear();
        lcd.setCursor(5,1);
        lcd.print("Connected");
        lcd.setCursor(2,2);
        lcd.print("Successfully");
        return true;

      }
      else{

        Serial.println("Connection Error");

        lcd.clear();

        lcd.setCursor(0, 2);
        lcd.print("Server Connection");
        lcd.setCursor(0, 3);
        lcd.print("Failed");

        return false;

      }

  }
  else{

    Serial.println("Connection Error");

    lcd.clear();

    lcd.setCursor(0, 2);
    lcd.print("Wifi Connection");
    lcd.setCursor(0, 3);
    lcd.print("Failed");
    
    return false;

  }
}