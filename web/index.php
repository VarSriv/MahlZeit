<?php
  // phpinfo();

  //a fast loading home page without much processing involved

  require_once($_SERVER['DOCUMENT_ROOT'] . '/appstruct/config.php');
  $pagetitle='Mahlzeit - Home';
  require_once('appstruct/sitetop.php');
  require_once('appstruct/layouthome.php');
  require_once('appstruct/sitebottom.php');

  // if(isset($_POST))
  //  error_log(print_r($_POST,true),4);//to console

?>
