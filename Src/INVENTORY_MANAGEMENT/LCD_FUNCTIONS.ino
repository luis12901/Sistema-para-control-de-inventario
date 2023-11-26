void printCentered(int row, String message) {
  int messageLength = message.length();
  int LCD_WIDTH = 16;
  int LCD_ROWS = 2;
  if (messageLength > LCD_WIDTH * LCD_ROWS) {
    lcd.clear();
    lcd.print("Message too long");
    return;
  }
  if(row == 0){
      if (messageLength <= LCD_WIDTH) {
        lcd.clear();
        int spaces = (LCD_WIDTH - messageLength) / 2;
        lcd.setCursor(spaces, 0);
        lcd.print(message);
      } 
  }
  else if(row == 1){
        if (messageLength <= LCD_WIDTH) {
        int spaces = (LCD_WIDTH - messageLength) / 2;
        lcd.setCursor(spaces, 1);
        lcd.print(message);
      } 
  }
  else{
        lcd.clear();
        lcd.setCursor(4, 0);
        lcd.print("This row");
        lcd.setCursor(1, 1);
        lcd.print("doesn't exist.");
        return;
  }
}