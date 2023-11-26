



void pirTimer(){


      const int DECTECT_AFTER = 10000;  // 10000 = 10 sec


     if (!presence) {


        unsigned long elapsedMillis = millis() - initial;
        if (elapsedMillis >= DECTECT_AFTER) { 
          


              counter = (!detectHumanPresence()) ? counter + 1 : 0;


              if(counter == 4){             // after we verify 4 times there's no human activity in the classroom    
                                                // the actuator is activated until the limit switch is pressed and we
                                                      // recieve a 0 logic in our LIMIT_SWT_PIN
                    counter = 0;  

                    while(LIMIT_SWT_PIN == 0){

                          Serial.println("Closing the classroom");
                          digitalWrite(ACTUATOR_PIN, HIGH);

                    }   
                    Serial.println("Door Closed.");
                     digitalWrite(ACTUATOR_PIN, LOW); 
                     counter = 0; 
                     delay(3000);                           
                }
              else if(counter >= 0 && counter < 3){
                    
                    
                    noPresenceSound();

                    
                    Serial.println("We haven't detected presence in the classroom. Please push the button RST to reset this terminal, and don't close this classroom.");
                    Serial.print("Time Left: ");

                    int timeLeft = 4 - counter;
                    Serial.print(timeLeft);

                    Serial.println("seconds.");
              }

        }
      }
      else{
        initial = millis();
        Serial.println("Activity detected");
        Serial.println(initial);
        presence = false;
      }  
}





bool detectHumanPresence(){

    int detectionCounter = 0;

    const int NUM_ITERATIONS = 50;
    const int MAX_DETECTION_COUNTER = 50;

      for(int i = 0; i < NUM_ITERATIONS; i++){
          sensorValue = digitalRead(PIR_PIN);

          if (sensorValue == HIGH) {
            Serial.println("Human presence detected!");
          } else {
            Serial.println("No presence detected.");
            detectionCounter++;
          }
        
      }

      if(detectionCounter == MAX_DETECTION_COUNTER){
              Serial.println("We have confirmed that no human presence has been detected in the classroom.");
              detectionCounter = 0;
              return false;
                
            }
      else{
                Serial.println("We've confirmed human presence in the classroom.");
                detectionCounter = 0;
                return true;   
      }  
}


void noPresenceSound(){
                  digitalWrite(BUZZER_PIN, HIGH);
                  delay(500);
                  digitalWrite(BUZZER_PIN, LOW);
                  delay(500);
                  digitalWrite(BUZZER_PIN, HIGH);
                  delay(500);
                  digitalWrite(BUZZER_PIN, LOW);
                  delay(500);
                  digitalWrite(BUZZER_PIN, HIGH);
                  delay(500);
                  digitalWrite(BUZZER_PIN, LOW);
                  delay(500);  
                  digitalWrite(BUZZER_PIN, HIGH);
                  delay(500);
                  digitalWrite(BUZZER_PIN, LOW);
}

