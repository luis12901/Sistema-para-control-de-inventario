# Inventory Management System

This repository contains the source code for an Inventory Management System implemented on an ESP32 microcontroller using Arduino. The system integrates with a server to facilitate RFID card authentication, user credential retrieval, and equipment delivery functionalities. Additionally, a web interface allows end-users to monitor and register materials.

## Table of Contents

- [Overview](#overview)
- [Project Structure](#project-structure)
- [Arduino Code](#arduino-code)
- [Server Files](#server-files)
- [Web Interface](#web-interface)
- [Contributing](#contributing)
- [License](#license)

## Overview

The Inventory Management System is designed to streamline the tracking and delivery of materials within a controlled environment. The system employs RFID card authentication for user identification and equipment transactions. A web interface provides an intuitive platform for end-users to interact with the system, monitor transactions, and register materials.

## Project Structure

The project is organized into two main folders:

- **INVENTORY_MANAGEMENT**: Contains the Arduino source code for the ESP32 microcontroller.
- **SERVER FILES**: Houses server-side files, including PHP scripts for handling communication with the ESP32 and the web interface components.

## Arduino Code

The "INVENTORY_MANAGEMENT" folder includes the Arduino code responsible for the ESP32 microcontroller's functionality. Key features include Wi-Fi communication, RFID card authentication, and equipment delivery handling.

### Dependencies

- [ArduinoJson](https://arduinojson.org/): A library to handle JSON data.
- [MFRC522](https://github.com/miguelbalboa/rfid): Library for interfacing with RFID cards.
- [LiquidCrystal_I2C](https://github.com/johnrickman/LiquidCrystal_I2C): Library for I2C LCD displays.
- [WiFi](https://www.arduino.cc/en/Reference/WiFi): Arduino built-in library for Wi-Fi functionality.
- [HTTPClient](https://github.com/espressif/arduino-esp32/tree/master/libraries/HTTPClient): Library for making HTTP requests.

## Server Files

The "SERVER FILES" folder encompasses server-side components. This includes PHP scripts handling communication with the ESP32 and the web interface.

### PHP Scripts

- **equipment_delivery.php**: Manages equipment delivery transactions, updating the database and equipment states.
- **user_search.php**: Searches for users based on RFID card serial numbers and registers them for equipment transactions.

### Web Interface

The web interface is organized into subfolders within "SERVER FILES." Notable components include:

- **JS**: Contains JavaScript scripts for dynamic web interactions.
- **CSS**: Holds stylesheets for the web interface.
- **HTML**: Houses HTML files defining the structure of web pages.

## License

This project is licensed under the [MIT License](LICENSE).

