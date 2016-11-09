<?php
  require_once($_SERVER['DOCUMENT_ROOT'] . '/appstruct/config.php');

  echo '<h1>Our best rated restaurant</h1>';

  $mapbudget = array(
          '1'=>'within ₹ 500',
          '2'=>'upto ₹ 1,000',
          '3'=>'upto ₹ 1,500',
          '4'=>'upto ₹ 2,000',
          '5'=>'beyond ₹ 2,000'
        );

        $maplocality = array(
          'northbangalore'=>'North Bangalore',
          'southbangalore'=>'South Bangalore',
          'eastbangalore'=>'East Bangalore',
          'centralbangalore'=>'Central Bangalore',
          'westbangalore'=>'West Bangalore',
          'koramangala'=>'Koramangala'
        );

        $mapcuisine = array(
          'american' =>'American',
          'barbecue'=>'Barbecue',
          'chinese' =>'Chinese',
          'desserts' =>'Desserts',
          'mexican' =>'Mexican',
          'southindian' =>'South Indian',
          'northindian' =>'North Indian',          
          'italian'=>'Italian' 
        );

  $result = showBestRatedRestaurant($conn);
  if($record = mysqli_fetch_array($result, MYSQLI_ASSOC)){
    error_log("in while loop");
    error_log(print_r($record,true),4);
          
    echo '<div class="longlist">';
    echo '<h4>' . htmlspecialchars($record['name'],ENT_HTML5) . '</h4>';
    echo '<p>' . $mapcuisine[$record['cuisine']] . ' at ';
    echo '' . $maplocality[$record['locality']] . '</p>';
    echo '<p>Address:' . $record['address'] . ' </p>';
    echo '<p> Phone Numbers:' . $record['phonenumbers'] . '<p>';
    if(isset($record['website']))
      echo '<p> Website: '. $record['website']. '<p>';
    echo '<p>Budget: ' . $mapbudget[$record['avgbudget']] . '</p>';
    echo '<div class="star">'. number_format($record['avgrating'],1) .'</div>';
    echo '</div>';      
  } 

  if(isset($sessionuser) && isset($_SESSION['userprefcuisines']))
  {
      echo '<h2>Highest Rated Restaurants</h2>';
      echo '<h3>based on your preferences for cuisine</h3>';
      $criteria = explode(",", $_SESSION['userprefcuisines']);
      error_log(print_r($criteria,true),4);

      //foreach ($criteria as $value) { 
        //echo($value);
        $result=showPersonalRecommendations($conn,$criteria[0]);
        if($record = mysqli_fetch_array($result, MYSQLI_ASSOC)){
          error_log("in isset_sessionuser:");
          error_log(print_r($record,true),4);
              
          echo '<div class="longlist">';
          echo '<h4>' . htmlspecialchars($record['name'],ENT_HTML5) . '</h4>';
          echo '<p>' . $mapcuisine[$record['cuisine']] . ' at ';
          echo '' . $maplocality[$record['locality']] . '</p>';
          echo '<p> Address:' . $record['address'] . ' </p>';
          echo '<p> Phone Numbers:' . $record['phonenumbers'] . '<p>';
          echo '<p> Website: '. $record['website']. '<p>';
          echo '<p>Budget: ' . $mapbudget[$record['avgbudget']] . '</p>';
          echo '<div class="star">'. number_format($record['avgrating'],1) .'</div>';
          echo '</div>';          
        }
     // }

  }
  //	echo '<div class="errormessg">Oops!Something went wrong</div>';
?> 