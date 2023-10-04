

void inactivityTimer(){

  if (!interaccionOcurre) {
        static unsigned long startTime = millis();
        unsigned long elapsedTime = millis() - startTime;

        if (elapsedTime >= 15* 60 * 1000UL) {   // 1 minute of inactivity will make true this condition
          
          Serial.println();
          Serial.println("      Entering deep sleep mode ......");
          Serial.println();
          delay(100); 
           // Configure ESP32 to enter deep sleep and define no wake up time
          esp_sleep_enable_ext0_wakeup(GPIO_NUM_14, HIGH); 
          esp_deep_sleep_start();
        }
      }

}