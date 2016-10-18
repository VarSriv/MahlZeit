<div class="container">
  <div class="panel">
    <h1>Latest updates</h1>
    <p>Little cards showing best rated, newest rated restaurants by cuisine or location</p>
  </div>
  <div class="panel" id="mainsearch">
    <p>Loading...</p>
  </div>
  <div class="panel">
    <h1>We love Fooding</h1>
    <p>Our passion for good food</p>
    <p>We want to let everyone find great new places and enjoy to the most</p>
  </div>
</div>
<script>
  window.onload = function(){
    // app.helpers.getJSON("/test/check.php");
    app.helpers.loadHTML("/parts/mainsearchpanel.php",document.getElementById("mainsearch"),undefined);
  };

  var handlesearch = function(event){
    // console.log(event.target);
    event.preventDefault();
    var formelement = event.target;
    var cuisines = formelement.querySelector('.searchcuisines').querySelectorAll('input[type=checkbox]:checked');
    var locations = formelement.querySelector('.searchlocations').querySelectorAll('input[type=checkbox]:checked');
    // var budget = formelement.querySelector('.searchbudget').querySelector('input[type=radio]:checked');
    // alert('You chose '+cuisines.length+' cuisines and '+locations.length+' locations');
    if((cuisines.length + locations.length) > 0){
      // alert('cuisines='+cuisines.toString()+'&locations='+locations+'&budget='+budget);
      var data = new FormData(formelement);
      console.log(data);
      app.helpers.loadHTML("/parts/mainsearchpanel.php",document.getElementById("mainsearch"),data);
    }else{
      alert('Please select at least one cuisine or location');
    }
    return false;
  };
</script>
