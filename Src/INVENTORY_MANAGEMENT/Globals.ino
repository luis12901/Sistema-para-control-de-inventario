/*
   Project: RFID Access Control ()
   Description: 
   Author: Jose Luis Murillo Salas
   Creation Date: August 20, 2023
   Contact: joseluis.murillo2022@hotmail.com
*/



// INACTIVITY TIMER
  static unsigned long startTime;
  bool interaccionOcurre = true;

// OFFLINE TIMER
  bool offlineInteraction = true;
  unsigned long starOfLoop = 0;
  unsigned long startTimeOffline = 0;

// PIR CONTROL
  int sensorValue = 0;
  bool presence = true;
  unsigned long initial;
  unsigned long elapsedmillis;
  int counter = 0;
  

//  WIFI AND SERVER
/*
 char ssid[100]     = "RFID_2.4";
  char password[100] = "3333379426";
  const char* serverIP = "http://192.168.43.122";
  char* phpDirectory = "http://192.168.43.122/Modular/alta_esp32.php";

char ssid[100]     = "Casa_Murillo_Salas_2.4Gnormal";
  char password[100] = "Guadalajara129#";
  const char* serverIP = "http://192.168.100.146";
  char* phpDirectory = "http://192.168.100.146/Laboratorio/busqueda_usuario.php";

    char ssid[100]     = "TP-LINK_2.4GHz_684D79";
  char password[100] = "80228240";
  const char* serverIP = "http://192.168.2.102";
  char* phpDirectory = "http://192.168.2.102/Modular/alta_esp32.php";*/

  
  char ssid[100]     = "INFINITUM8664_2.4";
  char password[100] = "7231669603";
  const char* serverIP = "http://192.168.1.64";
  char* phpDirectory = "http://192.168.1.64/Laboratorio/busqueda_usuario.php";
  char* phpDirectoryForEquipDelivery = "http://192.168.1.64/Laboratorio/equipment_delivery.php";



// Peripheral_pins

  #define SS_PIN 5
  #define RST_PIN 35
  #define BUZZER_PIN 13
  #define LOCK_PIN 32
  #define LCD 25
  #define RFID 26
  #define deepSleepPin 34
  #define ACTUATOR_PIN 26
  #define PIR_PIN 25
  #define DoorStatusPin 35

  #define CONNECTED 14
  #define DISCONNECTED 12
  #define CARD_DETECTED 27

  #define changeMode_Pin 15
  

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


  uint8_t acceso_nivel = 0;
  uint8_t acceso = 0;
  uint8_t estado = 0;
  String claveS;
  String nombreS;


  WiFiClient clienteServidor;


// LCD Variables
    int nombreLength = 0;
    int espaciosLibres = 0;
    int espaciosIzquierda = 0;

// Offline Mode
  //bool key_pressed = false;
  volatile bool boton_1 = false;

// Keyboard_&_LCD
  const uint8_t ROWS = 4;
  const uint8_t COLS = 4;

  char keys[ROWS][COLS] = {
    { '1', '2', '3', 'A' },
    { '4', '5', '6', 'B' },
    { '7', '8', '9', 'C' },
    { '*', '0', '#', 'D' }
  };

  uint8_t colPins[COLS] = { 16, 4, 2, 15 };
  uint8_t rowPins[ROWS] = { 19, 18, 5, 17 };

  Keypad keypad = Keypad(makeKeymap(keys), rowPins, colPins, ROWS, COLS);

  char key;

  LiquidCrystal_I2C lcd(0x27,10,4);



