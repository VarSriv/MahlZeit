<?php

// echo 'config/config.php';
// echo "<br />".get_include_path();

//this is done so in the other phps, we do not have to write a long path name
set_include_path( get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT'] );
// echo "<br />".get_include_path();

session_start();
if(isset($_SESSION) && isset($_SESSION['username'])){
  $sessionuser = (object)[
    'name' => $_SESSION['username'],
    'emailid' => $_SESSION['useremailid'],
    'prefcuisines' => $_SESSION['userprefcuisines'],
  ];
}

if(strlen(getenv("CLEARDB_DATABASE_URL"))>0){//as is available in the heroku envt.
  $url = parse_url(getenv("CLEARDB_DATABASE_URL"));
  $server = $url["host"];
  $username = $url["user"];
  $password = $url["pass"];
  $db = substr($url["path"], 1);
}else{//for local dev envt, connecting to the same clearDB on heroku starter
  $server = 'us-cdbr-iron-east-04.cleardb.net';
  $username = 'b020b590e24ddb';
  $password = 'd5affdc9';
  $db = 'heroku_ea57684a56e6710';
}

// $conn = new mysqli($server, $username, $password, $db);
$conn = mysqli_connect($server, $username, $password, $db);
mysqli_set_charset($conn, 'utf8mb4');

// var_dump($conn);//to screen
// error_log(print_r($conn,true),4);//to console
// above, 0 - Default. Message is sent to PHP's system logger
// 4 - Message is sent directly to the SAPI logging handler

/*
//for error_log(message), can also send email..
if (!($foo = allocate_new_foo())) {
  error_log("Oh no! We are out of FOOs!", 1, "admin@example.com");
}
*/

function getTestData1($conn){
  $sql = "SELECT * FROM test_table";
  return mysqli_query($conn,$sql);
}


function searchForRestaurants($conn,$criteria){
  $sql = "SELECT name, cuisine, locality, avgbudget, avgrating";
  $sql .= " FROM restaurants";
  $sql .= " WHERE";
  $whereconditions = array();
  
  if(isset($criteria['cuisines']) && count($criteria['cuisines'])>0){
    $cuisines=array();
    foreach ($criteria['cuisines'] as $key => $value) {
      // error_log(print_r($key,true),4);//to console
      // error_log(print_r($value,true),4);//to console
      array_push($cuisines, "cuisine = '" . $key . "'");
    }
    array_push($whereconditions,implode(' OR ',$cuisines));
  }

  if(isset($criteria['locations']) && count($criteria['locations'])>0){
    $locations=array();
    foreach ($criteria['locations'] as $key => $value) {
      array_push($locations, "locality = '" . $key . "'");
    }
    array_push($whereconditions,implode(' OR ',$locations));
  }

  if(isset($criteria['budget']) && $criteria['budget']!='any'){
    $budgetmap=array(
      '500'=>'1',
      '1000'=>'2',
      '1500'=>'3',
      '2000'=>'4',
      'morethan2000'=>'5'
    );
    array_push($whereconditions,"avgbudget = '" . $budgetmap[$criteria['budget']] . "'");
  }

  $sql .= " (" . implode(') AND (',$whereconditions) . ") ORDER BY avgrating DESC";

  error_log(print_r($sql,true),4);//to console

  return mysqli_query($conn,$sql);
}

// SELECT name, locality, avgrating FROM restaurants WHERE (cuisines = 'northindian' OR cuisines = 'american' OR cuisines = 'italian' OR cuisines = 'desserts' AND locations = 'kamanahalli')
// Central Bangalore    21
// East Bangalore   29
// Kormangala   31
// North Bangalore  8
// South Bangalore  9
// West Bangalore   1


function createUser($conn,$userdata){
  $sql = "SELECT COUNT(*) AS howmany FROM users WHERE emailid = ";
  $sql .= "'" . mysqli_real_escape_string($conn,$userdata['emailid']) . "'";

  // error_log(print_r($sql,true),4);//to console
  // $result1 = mysqli_query($conn,$sql);
  // error_log(print_r($result1->num_rows,true),4);//to console
  // error_log(print_r(mysqli_fetch_object($result1)->howmany,true),4);//to console

  if(
    ($result = mysqli_query($conn,$sql))
    && ($howmany = mysqli_fetch_object($result)->howmany)
    && $howmany > 0
  ){
    // error_log(print_r($howmany,true),4);//to console
    return false;
  }else{
    $sql = "INSERT INTO users (`emailid`, `name`, `password`, `prefcuisines`, `created`)";
    $sql .= " VALUES";
    $sql .= " (";
    $sql .= "'" . mysqli_real_escape_string($conn,$userdata['emailid']) . "', ";
    $sql .= "'" . mysqli_real_escape_string($conn,$userdata['name']) . "', ";
    $sql .= "'" . mysqli_real_escape_string($conn,$userdata['password']) . "', ";
    if(isset($userdata['cuisines']) && count($userdata['cuisines']) > 0){
      $sql .= "'" . mysqli_real_escape_string($conn,implode(', ',array_keys($userdata['cuisines']))) . "', ";
    }else{
      $sql .= "NULL, ";
    }
    $sql .= "now()";
    $sql .= ")";

    error_log(print_r($sql,true),4);//to console

    if(mysqli_query($conn,$sql)){
      return true;
    }else{
      error_log(print_r("2nd false",true),4);//to console
      return false;
    }
  }
}

function loginUser($conn,$userdata){
  
  session_unset();
  session_regenerate_id();
  
  $sql = "SELECT COUNT(*) AS howmany, name, prefcuisines FROM users WHERE";
  $sql .= " emailid = '" . mysqli_real_escape_string($conn,$userdata['emailid']) . "'";
  $sql .= " AND password = '" . mysqli_real_escape_string($conn,$userdata['password']) . "'";

  if(
    ($result = mysqli_query($conn,$sql))
    && ($user = mysqli_fetch_object($result))
    && $user->howmany == 1
  ){
    // error_log(print_r($user,true),4);//to console
    $_SESSION['username']=$user->name;
    $_SESSION['useremailid']=mysqli_real_escape_string($conn,$userdata['emailid']);
    $_SESSION['userprefcuisines']=$user->prefcuisines;
    return $user;
  }else{
    return false;
  }
}


/*
  // example code below...

  require("_/inc/functions.php");

  //Constants
  define("FROM_EMAIL", "https://phpstarter.herokuapp.com/ <webform@https://phpstarter.herokuapp.com/>");
  
  //Setup Variable for tracking VirtualPageViews in analytics.
  $VirtualPageView = "";

  //Variables to store Site/URL information
  $ServerName = $_SERVER['SERVER_NAME'];
  $SiteSection = "";
  $SubSection = "";

  $RequestMethod = $_SERVER['REQUEST_METHOD'];
  $FormErrors = array();

  setSectionInfo();

  //SET SERVER SPECIFIC VARIABLES AND CONSTANTS
  switch ($ServerName) {
    case 'http://localhost/phpstarter/dist/':
      define("CONTACT_EMAIL", "");
      define("ANALYTICS_ID", "");
      break;
    
    case 'https://phpstarter.herokuapp.com/':
      define("CONTACT_EMAIL", "");
      define("ANALYTICS_ID", "");
      break;
  }
*/
?>