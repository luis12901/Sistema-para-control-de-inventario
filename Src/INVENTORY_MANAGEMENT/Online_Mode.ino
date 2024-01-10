/*
   Project: Inventory Management 

   Description: This code defines functions for various operations in an Inventory Management system. 
   It includes functions for user credential retrieval, equipment delivery mode, online verification,
   RFID data retrieval, and posting JSON data to a server. Additionally, there are auxiliary functions 
   for LED blinking and connecting to a specified URL.

   Author: Jose Luis Murillo Salas

   Creation Date: August 20, 2023

   Contact: joseluis.murillo2022@hotmail.com
*/


void GetUserCredentials(){
    Serial.println("Current Operation Mode: Get User Credentials");

      printCentered(0,"Coloque su");
      printCentered(1,"tarjeta");
      while(true){

          if (digitalRead(changeMode_Pin) == HIGH) {
            OperationMode = false; 
            Serial.println("Operation mode changed !!!!");
            delay(500);
            break; 
          }
        

          getRFIDData();
          

          if(serialNumber.length() > 0){

                postJSONToServer(User_Search_Directory);
                serialNumber = "";
                break;
          }

          

      }
  
  }
  

  
void equipDeliveryMode(){

  Serial.println("Current Operation Mode: Equipment delivery");

  printCentered(0,"Coloque su");
  printCentered(1,"tarjeta");
  while(true){

      if (digitalRead(changeMode_Pin) == HIGH) {
        OperationMode = true; 
        Serial.println("Operation mode changed !!!!");
        delay(500);
        break; 
    }

      


      getRFIDData();
      

      if(serialNumber.length() > 0){

            postJSONToServer(phpDirectoryForEquipDelivery);
            serialNumber = "";
            break;
      }

      

  }
  
  }
  


bool onlineVerification(){

      if(ServerConnected()){
        
        Serial.println("Connected Successfully");
        digitalWrite(CONNECTED, 1);
        digitalWrite(DISCONNECTED, 0);
        digitalWrite(CARD_DETECTED, 0);
        return true;

      }
      else{
        digitalWrite(CONNECTED, 0);
        digitalWrite(DISCONNECTED, 1);
        digitalWrite(CARD_DETECTED, 0);
        Serial.println("Connection Error (Code: 002)");
        return false;

      }
  }
void getRFIDData(){

  if (mfrc522.PICC_IsNewCardPresent() && mfrc522.PICC_ReadCardSerial()) {
        digitalWrite(CONNECTED, 0); 
        digitalWrite(DISCONNECTED, 0);
        digitalWrite(CARD_DETECTED, 1);


      digitalWrite(BUZZER_PIN, HIGH);
      delay(200);
      digitalWrite(BUZZER_PIN, LOW);

      // confirmamos los avances que no se puedan inter
      Serial.println("Card Detected!");
      Serial.println("Please Wait .........");
      
      printCentered(0,"Espere ");
      printCentered(1,"Porfavor .....");

      
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

void postJSONToServer(char* php_directory){
      uint8_t counter = 0; 
      jsonMessage = json1 + serialNumber + json2;
      char completedJsonMessage[150];
      jsonMessage.toCharArray(completedJsonMessage, 150);
      conexionURL(counter, completedJsonMessage, php_directory, false);      

  }

/*
void postJSONToServer_2(){
      uint8_t counter = 0; 
      jsonMessage = json1 + serialNumber + json2;
      char completedJsonMessage[150];
      jsonMessage.toCharArray(completedJsonMessage, 150);
      conexionURL(counter, completedJsonMessage, phpDirectoryForEquipDelivery, false);


  
      digitalWrite(CONNECTED, 1);
      digitalWrite(DISCONNECTED, 0);
      digitalWrite(CARD_DETECTED, 0);
        

}
*/

void parpadearLed() {
  
  digitalWrite(DISCONNECTED, 0);
  digitalWrite(CARD_DETECTED, 0);
  digitalWrite(CONNECTED, 1);
  delay(100);
  digitalWrite(CONNECTED, 0);
  delay(100);
  digitalWrite(CONNECTED, 1);
  delay(100);
  digitalWrite(CONNECTED, 0);
  delay(100);
  digitalWrite(CONNECTED, 1);

  }
void neg_parpadear_Led() {
  
  digitalWrite(CONNECTED, 0);
  digitalWrite(CARD_DETECTED, 0);
  digitalWrite(DISCONNECTED, 1);
  delay(300);
  digitalWrite(DISCONNECTED, 0);
  delay(300);
  digitalWrite(DISCONNECTED, 1);
  delay(300);
  digitalWrite(DISCONNECTED, 0);
  delay(300);
  digitalWrite(DISCONNECTED, 1);
  digitalWrite(CONNECTED, 0);
  digitalWrite(CARD_DETECTED, 0);
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
    if(httpResponseCode == 200){
        parpadearLed();
    }
    else{
      neg_parpadear_Led();
    }


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