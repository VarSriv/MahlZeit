<img src="/images/northindian1.jpeg" class="img">
<img src="/images/mexican1.jpeg" class="img">
<img src="/images/chinese1.jpeg" class="img">
<img src="/images/chinese2.jpeg" class="img">
<img src="/images/northindian2.jpeg" class="img">
<img src="/images/mexican2.jpeg" class="img">
<section>
  <div class="image">
    <img src="/images/italian1.jpeg" width="250px">
    <img src="images/southindian1.jpeg" width="250px">
    <img src="images/dessert1.jpeg" width="250px">
    <img src="images/dessert2.jpeg" width="250px">
    <img src="images/american1.jpeg" width="250px">
  </div>


  <div class="container2">
    <div class="panel" id="recommendations">
      <h1>Latest updates</h1>
      <p>Showing best rated restaurants</p>
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

  <br style="clear: left;"/>

</section>


<script>
  window.onload = function(){
    app.helpers.loadHTML("/parts/mainsearchpanel.php",document.getElementById("mainsearch"),undefined);
    app.helpers.loadHTML("/parts/recommendations.php",document.getElementById("recommendations"),undefined);
  };

  var handlesearch = function(event){
    // console.log(event.target);
    event.preventDefault();
    var formelement = event.target;
    var cuisines = formelement.querySelector('.searchcuisines').querySelectorAll('input[type=checkbox]:checked');
    var locations = formelement.querySelector('.searchlocations').querySelectorAll('input[type=checkbox]:checked');
    if((cuisines.length + locations.length) > 0){
      var data = new FormData(formelement);
      console.log("logging data in handlesearch");
      console.log(data);
      app.helpers.loadHTML("/parts/mainsearchpanel.php",document.getElementById("mainsearch"),data);
    }else{
      alert('Please select at least one cuisine or location');
    }
    return false;
  };

</script>
