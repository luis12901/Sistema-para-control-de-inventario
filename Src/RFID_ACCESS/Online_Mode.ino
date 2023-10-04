/*
   Project: RFID Access Control (Online functions)
   Description: This code controls an access system using RFID tags.
   Author: Jose Luis Murillo Salas
   Creation Date: August 20, 2023
   Contact: joseluis.murillo2022@hotmail.com
*/





void online(){

  unsigned long startTime = 0;

  while(true){

      if (startTime == 0) {

            startTime = millis();

      }


      getRFIDData();
      

      if(serialNumber.length() > 0){

            postJSONToServer();
            getJSONFromServer();
            break;

      }

      unsigned long currentTime = millis();

      if (currentTime - startTime > 60000) {break;}

  }

}
bool onlineVerification(){

      if(ServerConnected()){
        
        Serial.println("Connected Successfully");
        return true;

      }
      else{

        Serial.println("Connection Error (Code: 002)");
        return false;

      }
}
void getRFIDData(){

  if (mfrc522.PICC_IsNewCardPresent() && mfrc522.PICC_ReadCardSerial()) {

      digitalWrite(BUZZER_PIN, HIGH);
      delay(200);
      digitalWrite(BUZZER_PIN, LOW);
      

      Serial.println("Card Detected!");
      Serial.println("Please Wait .........");

      
      for (int i = 0; i < 4; i++) {

        readData[i] = mfrc522.uid.uidByte[i];

      }

      
      for (int i = 0; i < 4; i++) {

        String decimalByte = String(readData[i]);
        serialNumber += decimalByte;

      }

      if (serialNumber.length() > 0) {

          Serial.print("Serial number: ");
          Serial.println(serialNumber);
         
      
      }
      

  }

}

void postJSONToServer(){
      uint8_t counter = 0; 
      jsonMessage = json1 + serialNumber + json2;
      char completedJsonMessage[150];
      jsonMessage.toCharArray(completedJsonMessage, 150);
      conexionURL(counter, completedJsonMessage, phpDirectory, false);

}
void getJSONFromServer(){

    // Get all JSON message in currentLine global vaiable

    clienteServidor = servidor.available();
    finMensaje = false;

    if (clienteServidor) {
          tiempoConexionInicio = xTaskGetTickCount();
          while (clienteServidor.connected()){
            if (clienteServidor.available() > 0) {
              char c = clienteServidor.read();
              
              if (c == '}') {
                finMensaje = true;
              }
              if (c == '\n') {
                if (currentLine.length() == 0) {
                 

                } else {  
                  currentLine = "";
                }
              } else if (c != '\r') { 
                currentLine += c;     
              }

              
              // Verify variable "finMensaje" is true that means "currentLine" has all JSON parameters 
                        // if that's the case we deserialize all JSON data from "currentLine"
             
              if (finMensaje) {

                String mensajeJSON = currentLine;
                StaticJsonDocument<200> doc;
                DeserializationError error = deserializeJson(doc, mensajeJSON);

                if (error){

                  Serial.print(F("deserializeJson() failed: "));
                  Serial.println(error.f_str());

                } 
                else{
                    
                    
                    // Save all JSON deserialized parameter in different variables
                          uint8_t securityLevel = doc["acceso_nivel"];
                          acceso_nivel = securityLevel;

                          uint8_t accessType = doc["acceso"];
                          acceso = accessType;

                          uint8_t userFound = doc["estado"];
                          estado = userFound;

                          const char* clave = doc["clave"];
                          const char* nombre = doc["nombre"];

                          String claveJsonMsg(clave);
                          claveS = claveJsonMsg;

                          String userName(nombre);
                          nombreS = userName; 


                          applyJsonLogic();
                    

                }
          }
          else{
            
            // Server error, Couldn't save all the JSON Data

          }

          // JSOP Message recieved
          tiempoComparacion = xTaskGetTickCount();
          if (tiempoComparacion > (tiempoConexionInicio + 3000)) {

                Serial.println("Error timeout");
                break;

          }
       }
    }
    clienteServidor.stop();
  }
  //  Clear all characters within serialNumber for the next time we read a new RFID Tag
  serialNumber = "";
}

void applyJsonLogic() {
        if (claveS == "1234"){    

              // Add Meta data

              if (estado == 1) {

                    if (acceso_nivel == 1) {

                          if (acceso == 1) {

                                registerUserEntry();

                          } 
                          else {

                                registerUserExit();

                          }
                    } 
                    else {

                      NoSufficientLevel();

                    }
              } 
              else {

                noUserFoundAction();

              }

        }
        else {

            accessDenied();

        }
}

void registerUserEntry(){

        // Unlock the lock
        digitalWrite(LOCK_PIN, 0);

        // Serial printing
        Serial.println("Estuadiante capturado: ");
        Serial.print(nombreS);

        // LCD screen configuration and manipulation
        ////lcd.clear();
        ////lcd.setCursor(5, 0);
        ////lcd.print("Welcome,");

        nombreLength = nombreS.length();
        espaciosLibres = 20 - nombreLength;
        espaciosIzquierda = espaciosLibres / 2;

        ////lcd.setCursor(espaciosIzquierda, 1);
        ////lcd.print(nombreS);
        ////lcd.setCursor(2, 2);
        ////lcd.print("has been registered");
        ////lcd.setCursor(5, 3);
        ////lcd.print("your entry.");

        // Sending HTTP headers
        clienteServidor.println("HTTP/1.1 200 OK");
        clienteServidor.println("Content-type: text/html");
        clienteServidor.println();

        // Sending a JSON message as response
        clienteServidor.print("{\"respuesta\":\"ok\",\"nombre\":\"");
        clienteServidor.print(nombreS);
        clienteServidor.println();

        // Wait before continuing
        delay(8000);

        // Lock the lock after a certain time
        digitalWrite(LOCK_PIN, 1);

        // Clearing the LCD screen
        ////lcd.clear();

        // Restarting the ESP32
       // esp_restart();
    

}
void registerUserExit(){

      //lcd.clear();
      
      Serial.println(nombreS);
      
       
      //lcd.setCursor(0,0);
      //lcd.print("Se ha registrado su");


      //lcd.setCursor(6,1);
      //lcd.print("salida");

      nombreLength = nombreS.length();
      espaciosLibres = 20 - nombreLength;
      espaciosIzquierda = espaciosLibres / 2;
                       
      //lcd.setCursor(espaciosIzquierda,2);
      //lcd.print(nombreS);
                      
      digitalWrite(LOCK_PIN, 1);


      clienteServidor.println("HTTP/1.1 200 OK");
      clienteServidor.println("Content-type:text/html");
      clienteServidor.println("\"}");
      clienteServidor.println();
      clienteServidor.print("{\"respuesta\":\"ok\",\"nombre\":\"");
      clienteServidor.print(nombreS);
      clienteServidor.println();


      delay(5000);
      //lcd.clear();
      

      // REINICIO DE LA ESP32
          //esp_restart();


}
void noUserFoundAction(){

      //lcd.clear();


      //lcd.setCursor(5,0);
      //lcd.print("Lo sentimos,");

      //lcd.setCursor(1,1);
      //lcd.print("no se ha encontrado");

      //lcd.setCursor(4,2);
      //lcd.print("su usuario.");


      digitalWrite(LOCK_PIN, 1);


      clienteServidor.println("HTTP/1.1 200 OK");
      clienteServidor.println("Content-type:text/html");
      clienteServidor.println();
      clienteServidor.println("{\"Respuesta\":\"Coudln't found this user\"}");
      clienteServidor.println();


      Serial.println("Lo sentimos, no se ha encontrado su usuario en nuestra base de datos.");


      delay(5000);
      //lcd.clear();

}
void NoSufficientLevel(){

        digitalWrite(LOCK_PIN, 1);

        //lcd.clear();


        //lcd.setCursor(3, 0);
        //lcd.print("Lo sentimos,");

        //lcd.setCursor(2, 1);
        //lcd.print("no tiene acceso");

        //lcd.setCursor(4, 2);
        //lcd.print("a esta aula.");

        clienteServidor.println("HTTP/1.1 200 OK");
        clienteServidor.println("Content-type:text/html");
        clienteServidor.println();
        clienteServidor.println("{\"Respuesta\":\"User with no Sufficient Level\"}");
        clienteServidor.println();


        Serial.println("NO SE HA ENCONTRADO MATERIAL A ENTREGAR O RECIBIR.");


        delay(5000);
        //lcd.clear();

}
void accessDenied(){

        //lcd.clear();

        //lcd.setCursor(3, 1);
        //lcd.print("Acceso denegado.");

        clienteServidor.println("HTTP/1.1 200 OK");
        clienteServidor.println("Content-type:text/html");
        clienteServidor.println();
        clienteServidor.println("{\"respuesta\":\"errorClave\"}");
        clienteServidor.println();

        Serial.println("Acceso denegado.");

}
void conexionURL(int counter, char* mensajeJSON, char* servidor, bool pruebas) {
  char temporal[50];
  char mensajeHTML[400];
  char Usuario[10] = "bot33";
  char urlVar[10] = "/";
  int j = 0;

  memset(mensajeHTML, NULL, sizeof(mensajeHTML));
  memset(temporal, NULL, sizeof(temporal));


  int cuantosBytes = strlen(mensajeJSON);
  sprintf(temporal, "POST %s HTTP/1.0\r\n", urlVar);
  strcat(mensajeHTML, temporal);

  sprintf(temporal, "Host: %s \r\n", servidor);
  strcat(mensajeHTML, temporal);

  sprintf(temporal, "User-Agent: %s \r\n", Usuario);
  strcat(mensajeHTML, temporal);

  sprintf(temporal, "Content-Length: %i \r\n", cuantosBytes);
  strcat(mensajeHTML, temporal);

  strcat(mensajeHTML, "Content-Type: application/json\r\n");
  strcat(mensajeHTML, "\r\n");
  strcat(mensajeHTML, mensajeJSON);



  int cuantosMensaje = strlen(mensajeHTML);
  if (pruebas == false) {
    WiFiClient client;
    HTTPClient http;
    http.begin(client, servidor);
    http.addHeader("Content-Type", "application/json");
    int httpResponseCode = http.POST(mensajeJSON);
    Serial.print("Codigo HTTP de respuesta: ");
    Serial.println(httpResponseCode);
    http.end();


  } else {
    Serial.println("Bytes para transmitir: ");
    Serial.println("");
    Serial.println(cuantosMensaje);
    for (j = 0; j <= cuantosMensaje - 1; j++) {
      Serial.print(mensajeHTML[j]);
    }
    Serial.println(" ");
  }
}