

void inactivityTimer(){

  if (!interaccionOcurre) {
        unsigned long elapsedTime = millis() - startTime;

        if (elapsedTime >= 600000) { // If the user is not using this terminal for 10 minutes, we switch to deepSleep mode   
          
          Serial.println();
          Serial.println("      Entering deep sleep mode ......");
          Serial.println();


          printCentered(0,"Accediendo al");
          printCentered(1,"modo AE");

          delay(5000); 
          lcd.clear();
          esp_sleep_enable_ext0_wakeup(GPIO_NUM_14, HIGH); 
          esp_deep_sleep_start();
        }
      }
      else{
        startTime = millis();
        Serial.println("Activity detected, deep sleep timer reset");
        Serial.println(startTime);
        interaccionOcurre = false;
      }  

}
