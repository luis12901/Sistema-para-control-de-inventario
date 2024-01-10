/*
   Project: Inventory Management 

   Description: This code outlines prototype functions for an Inventory Management system, 
   covering WiFi and server connections, interface initialization, JSON data handling, card presence validation, and RFID data retrieval.

   Author: Jose Luis Murillo Salas

   Creation Date: August 20, 2023
   
   Contact: joseluis.murillo2022@hotmail.com
*/

void prototypeFunctions(){

  bool WifiConnected();

  bool ServerConnected();

  bool beginNetworking();

  void interfaceInit();

  void conexionURL(int counter, char* mensajeJSON, char* servidor, bool pruebas);

  void postJSONToServer();

  bool validateCardPresence();

  void getRFIDData();

}