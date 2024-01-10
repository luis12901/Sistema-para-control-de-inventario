/*
   Project: Inventory Management 

   Description: This code configures Wi-Fi and server parameters, 
   as well as peripheral pins for an Inventory Management system. It 
   sets up credentials for different Wi-Fi networks and server directories. 
   Additionally, it defines pin assignments for SS, RST, Buzzer, LCD, and RFID. 
   The code initializes an RFID reader, database-related variables, and LCD display variables.

   Author: Jose Luis Murillo Salas

   Creation Date: August 20, 2023

   Contact: joseluis.murillo2022@hotmail.com
*/

//  WIFI AND SERVER

  /*
      char ssid[100]     = "TP-LINK_2.4GHz_684D79";
    char password[100] = "80228240";
    const char* serverIP = "http://192.168.2.102";
    char* phpDirectory = "http://192.168.2.102/Modular/alta_esp32.php";

    
    char ssid[100]     = "INFINITUM8664_2.4";
    char password[100] = "7231669603";
    const char* serverIP = "http://192.168.1.64";
    char* phpDirectory = "http://192.168.1.64/Laboratorio/busqueda_usuario.php";
    char* phpDirectoryForEquipDelivery = "http://192.168.1.64/Laboratorio/equipment_delivery.php";


    char ssid[100]     = "RFID_2.4";
    char password[100] = "3333379426";
    const char* serverIP = "http://192.168.43.122";
    char* phpDirectory = "http://192.168.43.122/Modular/alta_esp32.php";
  */
    char ssid[100]     = "Casa_Murillo_Salas_2.4Gnormal";
    char password[100] = "Guadalajara129#";
    const char* serverIP = "http://192.168.100.146";
    char* User_Search_Directory = "http://192.168.100.146/Laboratorio/user_search.php";
    char* phpDirectoryForEquipDelivery = "http://192.168.100.146/Laboratorio/equipment_delivery.php";


// Peripheral_pins

  #define SS_PIN 5
  #define RST_PIN 35
  #define BUZZER_PIN 13
  #define LCD 25
  #define RFID 26


  #define CONNECTED 14
  #define DISCONNECTED 12
  #define CARD_DETECTED 27

  #define changeMode_Pin 34
  

// RFID CARD
  MFRC522 mfrc522(SS_PIN, RST_PIN);
  int readData[4];
  String serialNumber = "";


// Database
  String json1 = "{\"serialNumber\":\"";
  String json2 = "\"}";
  String jsonMessage;


  String currentLine = "";  
  long int tiempoConexionInicio = 0;
  bool finMensaje = false; 
  long int tiempoComparacion = 0;




  WiFiClient clienteServidor;


// LCD Variables
    int nombreLength = 0;
    int espaciosLibres = 0;
    int espaciosIzquierda = 0;


  LiquidCrystal_I2C lcd(0x27,10,4);



