<?php
  require_once($_SERVER['DOCUMENT_ROOT'] . '/appstruct/config.php');

$countcuisines=0;
$countlocations=0;
$countbudget=0;

if(isset($_POST) && !empty($_POST)){
  error_log(print_r($_POST,true),4);//to console

  if(isset($_POST['cuisines']) && !empty($_POST['cuisines']))
    $countcuisines = count($_POST['cuisines']);
  if(isset($_POST['locations']) && !empty($_POST['locations']))
    $countlocations = count($_POST['locations']);
  if(isset($_POST['budget']) && !empty($_POST['budget']))
    $countbudget = 1;
}

?>
<h1>Find your mojo</h1>
<p>Search for THE restaurant of your choice</p>
<div class="">
  <form class="" action="/" method="post" onsubmit="return handlesearch(event)">

    <!-- <div class="searchfield searchlocations">
      <select class="" name="cuisines" multiple="multiple">
        <option value="si">South Indian</option>
        <option value="ni">North Indian</option>
        <option value="it">Italian</option>
        <option value="am">American</option>
        <option value="chi">Chinese</option>
        <option value="des">Desserts</option>
      </select>
    </div> -->

    <div class="searchfield searchcuisines">
        <h3>Cuisines</h3>
        <label><input type="checkbox" name="cuisines[southindian]"
          <?php if($countcuisines > 0 && isset($_POST['cuisines']['southindian']))echo 'checked'; ?>
          >South Indian</label>
        <br>
        <label><input type="checkbox" name="cuisines[northindian]"
          <?php if($countcuisines > 0 && isset($_POST['cuisines']['northindian']))echo 'checked'; ?>
          >North Indian</label>
        <br>
        <label><input type="checkbox" name="cuisines[american]"
          <?php if($countcuisines > 0 && isset($_POST['cuisines']['american']))echo 'checked'; ?>
          >American</label>
        <br>
        <label><input type="checkbox" name="cuisines[barbecue]"
          <?php if($countcuisines > 0 && isset($_POST['cuisines']['barbecue']))echo 'checked'; ?>
          >Barbecue</label>
        <br>
        <label><input type="checkbox" name="cuisines[chinese]"
          <?php if($countcuisines > 0 && isset($_POST['cuisines']['chinese']))echo 'checked'; ?>
          >Chinese</label>
        <br>
        <label><input type="checkbox" name="cuisines[italian]"
          <?php if($countcuisines > 0 && isset($_POST['cuisines']['italian']))echo 'checked'; ?>
          >Italian</label>
        <br>
        <label><input type="checkbox" name="cuisines[mexican]"
          <?php if($countcuisines > 0 && isset($_POST['cuisines']['mexican']))echo 'checked'; ?>
          >Mexican</label>
        <br>
        <label><input type="checkbox" name="cuisines[desserts]"
          <?php if($countcuisines > 0 && isset($_POST['cuisines']['desserts']))echo 'checked'; ?>
          >Desserts</label>
        <br>
    </div>

    <div class="searchfield searchlocations">
      <h3>Locations</h3>
      <label><input type="checkbox" name="locations[belroad]"
        <?php if($countlocations > 0 && isset($_POST['locations']['belroad']))echo 'checked'; ?>
        >BEL Road</label>
      <br>
      <label><input type="checkbox" name="locations[indiranagar]"
        <?php if($countlocations > 0 && isset($_POST['locations']['indiranagar']))echo 'checked'; ?>
        >Indira Nagar</label>
      <br>
      <label><input type="checkbox" name="locations[kamanahalli]"
        <?php if($countlocations > 0 && isset($_POST['locations']['kamanahalli']))echo 'checked'; ?>
        >Kammanahalli</label>
      <br>
      <label><input type="checkbox" name="locations[koramangala]"
        <?php if($countlocations > 0 && isset($_POST['locations']['koramangala']))echo 'checked'; ?>
        >Koramangala</label>
      <br>
      <label><input type="checkbox" name="locations[mgroad]"
        <?php if($countlocations > 0 && isset($_POST['locations']['mgroad']))echo 'checked'; ?>
        >MG Road</label>
      <br>
      <label><input type="checkbox" name="locations[marathahalli]"
        <?php if($countlocations > 0 && isset($_POST['locations']['marathahalli']))echo 'checked'; ?>
        >Marathahalli</label>
      <br>
    </div>

    <div class="searchfield searchbudget">
      <h3>Budget <small>(for two)</small></h3>
      <label><input type="radio" name="budget" value="any"
        <?php if( ($countbudget > 0 && $_POST['budget']=='any') || $countbudget == 0 )echo 'checked'; ?>
        >Any</label>
      <br>
      <label><input type="radio" name="budget" value="500"
        <?php if( $countbudget > 0 && $_POST['budget'] == '500' )echo 'checked'; ?>
        >within &#x20b9; 500</label>
      <br>
      <label><input type="radio" name="budget" value="1000"
        <?php if( $countbudget > 0 && $_POST['budget'] == '1000' )echo 'checked'; ?>
        >upto &#x20b9; 1,000</label>
      <br>
      <label><input type="radio" name="budget" value="1500"
        <?php if( $countbudget > 0 && $_POST['budget'] == '1500' )echo 'checked'; ?>
        >upto &#x20b9; 1,500</label>
      <br>
      <label><input type="radio" name="budget" value="2000"
        <?php if( $countbudget > 0 && $_POST['budget'] == '2000' )echo 'checked'; ?>
        >upto &#x20b9; 2,000</label>
      <br>
      <label><input type="radio" name="budget" value="morethan2000"
        <?php if( $countbudget > 0 && $_POST['budget'] == 'morethan2000' )echo 'checked'; ?>
        >beyond &#x20b9; 2,000</label>
      <br>
    </div>
    <br style="clear:both;">
    <div style="background:silver;padding:10px;">
      <span>Select at least one cuisine or location above, and then press Search</span>
      <button type="submit">Search</button>
    </div>
  </form>
</div>


<?php
  if(isset($_POST) && !empty($_POST)){
    if( ($countcuisines+$countlocations) > 0 && $countbudget > 0){
      $result = searchForRestaurants($conn,$_POST);
      // $resultArray = mysqli_fetch_array($result, MYSQLI_ASSOC);
      // error_log(print_r($result,true),4);//to console

      if(isset($result->num_rows) && $result->num_rows > 0){
                
        echo '
          <div>
          <h3>Found '.$result->num_rows.' restaurants, showing some:</h3>
        ';
        // print_r($_POST);

        $mapbudget = array(
          '1'=>'within ₹ 500',
          '2'=>'upto ₹ 1,000',
          '3'=>'upto ₹ 1,500',
          '4'=>'upto ₹ 2,000',
          '5'=>'beyond ₹ 2,000'
        );
        $recordlimit = 6;
        $recordcount = 0;
        
        while($record = mysqli_fetch_array($result, MYSQLI_ASSOC)){

          if($recordcount >= $recordlimit)break;

          // error_log(print_r($record,true),4);//to console
          // error_log(print_r($recordcount,true),4);//to console
          
          echo '<div class="smalllist">';
          echo '<h4>' . htmlspecialchars($record['name'],ENT_HTML5) . '</h4>';
          echo '<p>' . $record['cuisine'] . ' at ';
          echo '' . $record['locality'] . '</p>';
          // echo '<p>' . $record['avgrating'] . ' stars';
          echo '<p>budget ' . $mapbudget[$record['avgbudget']] . '</p>';
          echo '<div class="star">'. number_format($record['avgrating'],1) .'</div>';
          echo '</div>';
          $recordcount++;
        }
        echo '<br style="clear:both;">';
        if($result->num_rows > $recordlimit)echo '<p>when implemented, we will see <button>More...</button></p>';
        echo '</div>';
      }else{
          echo' <div><h3>No results found</h3></div>';
      }
    }else{
      echo '
        <div class="errormessg">
          <h3>Bad search</h3>
          <p>You must select at least one cuisine or location, and a budget</p>
        </div>
      ';
    }
  }
?>