<?php
/*
* Project Name:  FusionBells ZoneBOX
* 
* Description: WAN and cross campus offline supported
* broadcast point for Fusion Bells.
*
*
* Developer: FikesMedia.com 
* Contact: support@fikesmedia.com
* Copyright: Copyright 2017 FikesMedia All Right Reserved
*/




//Login Process
session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	 $dir = dirname(__FILE__);
	 $zonePass = file_get_contents("config/PASSWORD");
	 if( $_POST['inputPassword'] == $zonePass) {
		 $_SESSION['LOGIN_VALID'] = 1;
		 header("LOCATION: settings.php");
	 }
}

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Signin Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Page Styling -->
    <style>
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #fefefe;
      }

      .form-signin {
        max-width: 330px;
        padding: 15px;
        margin: 0 auto;
      }
      .form-signin .form-signin-heading {
        margin-bottom: 10px;
      }

      .form-signin .form-control {
        position: relative;
        height: auto;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        padding: 10px;
        font-size: 16px;
      }
      .form-signin .form-control:focus {
        z-index: 2;
      }
      .form-signin input[type="text"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
      }
      .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
      }
    </style>

  </head>

  <body>

    <div class="container">

      <form class="form-signin" method="post">
        <h2 class="form-signin-heading">Fusion Bells ZoneBox</h2>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" required>
        <button href="index.php" type="submit" class="btn btn-lg btn-primary btn-block">Sign in</button>
      </form>

    </div> <!-- /container -->

  </body>
</html>
