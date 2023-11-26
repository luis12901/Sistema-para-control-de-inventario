/*
   Project: RFID Access Control (Offline Mode)
   Description: 
   Author: Jose Luis Murillo Salas
   Creation Date: August 20, 2023
   Contact: joseluis.murillo2022@hotmail.com
*/




void offline(){

        digitalWrite(CONNECTED, 0);
        digitalWrite(DISCONNECTED, 1);
        digitalWrite(CARD_DETECTED, 0);
  menu();
  
  waitForKeyPress();

  waitForPasswordPress();

  
}
void menu(){
  
  Serial.println(""); 
  Serial.println("Selecciona una opción:");
  Serial.println("1.- Ingresar al modo offline");
  Serial.println("2.- Intentar reconexion");
  printCentered(0,"Presione una");
  printCentered(1,"opcion");

}
void waitForKeyPress(){
          
  while(true){
  inactivityTimer();


      if(boton_1){
        interaccionOcurre = true;
          inactivityTimer();
          
          Serial.println("Offline mode selected");
          boton_1 = false; 
          break;

      }

    }
  
}
void waitForPasswordPress(){
         
    Serial.println("Please enter the password:");
    printCentered(0,"Ingrese la clave");
    printCentered(1,"de esta aula");
    String enteredPassword = "";
    int counter = 0;
    while(true){


        inactivityTimer(); 

        String correctPassword = "AAAAAA";

        key = keypad.getKey();

         
        if (key) {
          enteredPassword += key;
         
          Serial.println(key);
          uint8_t INITIAL_SPACES = 5;

          counter = enteredPassword.length();
          lcd.clear();
          for(int i = 0; i < counter; i++){
            
            lcd.setCursor(INITIAL_SPACES + i, 0);
            lcd.print("*");

          }

          interaccionOcurre = true;
          inactivityTimer(); 
       }


        if (counter == 6) {
          interaccionOcurre = true;
          inactivityTimer(); 
  
          if (enteredPassword == "333333" || enteredPassword == "AAAAAA") {

            

            Serial.println("Access granted"); 
            Serial.println("");
            printCentered(0,"Acceso");
            printCentered(1,"concedido");
            
            digitalWrite(LOCK_PIN, 0);
            delay(8000);
            digitalWrite(LOCK_PIN, 1);
            
            
          }

          else{

            Serial.println("Access denied. Incorrect password.");
            Serial.println("");

           printCentered(0,"Acceso");
            printCentered(1,"denegado");
            digitalWrite(LOCK_PIN, 1);

          }
          
          counter = 0;

          break;
         
        }
 
    }

} 
void IRAM_ATTR boton_1_isr() {
  boton_1 = true; 
}