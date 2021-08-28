function base64Reader(file, callback) {
    var reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = function () {
      if(callback != null){
        callback(reader.result)
      }
    };
    reader.onerror = function (error) {
      console.log('Error: ', error);
    };
 }