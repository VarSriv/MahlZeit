<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="an academic project on food review">
  <meta name="theme-color" content="#1B2A7D">

  <title><?php echo $pagetitle; ?></title>

  <link rel="apple-touch-icon" href="apple-touch-icon.png">
  <link rel="stylesheet" type="text/css" href="/stylesheets/main.css" />
</head>
<body>
  <div class="brand">
    <a href='/'>
      <div class="brandname">
          <p>Mahlzeit</p>
          <p style="font-size:20px;margin-top:-60px;">The best dining options, really!</p>
      </div>
    </a>
  </div>
  <div class="mainnav">
    <div class="container">
      <p>Latest Reviews | 
        <?php
          if(isset($sessionuser)){
            echo '<span title="'
             . $sessionuser->emailid
             . "\n"
             . $sessionuser->prefcuisines
             . '">Hello <strong>'
             . $sessionuser->name
             . '</strong></span> | <a href="/signout.php" title="Sign out from Mahlzeit">Sign Out</a>';
          }else{
            echo '<a href="/signup.php" title="Register with Mahlzeit">Sign Up</a> | <a href="/signin.php" title="Login to Mahlzeit">Sign In</a>';
          }
        ?>
      </p>
    </div>
  </div>
