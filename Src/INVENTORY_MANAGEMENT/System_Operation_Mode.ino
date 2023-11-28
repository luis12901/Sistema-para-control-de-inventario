void VerifyOperationMode(){

    if(changeMode_Pin == 1){
      if(!OperationMode){
          OperationMode = true;
      }
      else{
          OperationMode = false;
      }
    }
    
}

