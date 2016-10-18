  var app={};
  app.helpers={};

  app.helpers.getJSON=function(url){
    //
    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
      // console.log(request.readyState);
      if (request.readyState === XMLHttpRequest.DONE) {
        // console.log(request.status);
        if (request.status === 200) {
          var responseJSON = JSON.parse(request.response);
          console.log(responseJSON);
        }
      } else {
        // do something
      }
    };
    request.open('GET', url);
    request.send();

  };

  app.helpers.loadHTML = function(url,element,data){
    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
      if (request.readyState === XMLHttpRequest.DONE) {
        if (request.status === 200){
          element.innerHTML = request.response;
          if(element.getElementsByTagName('script').length){
            // console.log(element.getElementsByTagName('script')[0].innerHTML);
            eval(element.getElementsByTagName('script')[0]);
          }
        }
      }
    }
    if(data){
      request.open('POST', url, true);
      request.send(data);
    }else{
      request.open('GET', url);
      request.send();
    }
  };
