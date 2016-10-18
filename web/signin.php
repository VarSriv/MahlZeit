<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/appstruct/config.php');

$pagetitle='Mahlzeit - Sign in';
require_once('appstruct/sitetop.php');

if(isset($_POST) && count($_POST)>0){
  // error_log(print_r($_POST,true),4);//to console
  if(
    isset($_POST['emailid'])
    && strlen($_POST['emailid'])>5

    && isset($_POST['password'])
    && strlen($_POST['password'])>5
  ){
    if($user = loginUser($conn,$_POST)){
      $resultmessg = '
      <div class="successmessg">
        <p>Hello <strong>'. $user->name .'</strong>, you have signed in successfully!</p>
        <p>Your preferred cuisines are ' . $user->prefcuisines . '.</p>
        <p><a href="/">go to Home page</a></p>
      </div>';
    }else{
      $resultmessg = '<div class="errormessg">FAILED to sign in</div>';
    }
  }else{
    $resultmessg = '<div class="errormessg">Please provide proper input</div>';
  }
}else{
  if(isset($sessionuser)){
      $resultmessg = '<div class="errormessg">You are already signed in. <a href="/signout.php">Sign out</a>?</div>';
  }
}

require_once('appstruct/layoutsignin.php');
require_once('appstruct/sitebottom.php');

?>
