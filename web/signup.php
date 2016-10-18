<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/appstruct/config.php');

$pagetitle='Mahlzeit - Signup';
require_once('appstruct/sitetop.php');

if(isset($_POST) && count($_POST)>0){
  // error_log(print_r($_POST,true),4);//to console
  if(
    isset($_POST['name'])
    && strlen($_POST['name'])>0

    && isset($_POST['emailid'])
    && strlen($_POST['emailid'])>0

    && isset($_POST['password'])
    && strlen($_POST['password'])>0

    && isset($_POST['confirmpassword'])
    && $_POST['confirmpassword'] == $_POST['confirmpassword']
  ){
    if(createUser($conn,$_POST)){
      if(mysqli_affected_rows($conn)==1){
        error_log(print_r('created user with dB id '.mysqli_insert_id($conn),true),4);//to console
        $resultmessg = '<div class="successmessg">User created with emailid '. mysqli_real_escape_string($conn,$_POST['emailid']) .'</div>';
      }else{
        $resultmessg = '<div class="errormessg">User NOT created!</div>';
      }        
    }else{
      $resultmessg = '<div class="errormessg">User already exists!</div>';
    }
  }else{
    $resultmessg = '<div class="errormessg">Please provide proper input</div>';
  }
}else{
  if(isset($sessionuser)){
      $resultmessg = '<div class="errormessg">You are already signed in. <a href="/signout.php">Sign out</a>?</div>';
  }
}

require_once('appstruct/layoutsignup.php');
require_once('appstruct/sitebottom.php');

?>
