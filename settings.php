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
session_start();

/*
* Loop Through JSON and present Schedule
*
* Christopher Fikes
* 03/09/2017
*/
function getScheduleCache(){
    //Get Local Cache
    $Schedule = json_decode(file_get_contents('ScheduleCache.json'));
    //Fail gracefully if no cache
    if (is_null($Schedule) || $Schedule == ""){
        echo "<tr><td>No Schedule Cache</td><td></td></tr>\n";
    } else {
        //Create Table Row for Each
        foreach ($Schedule as $Bell) {
            $Time = $Bell->Time;
            $Tone = $Bell->Tone;
            echo "<tr><td>$Time</td><td>$Tone</td></tr>\n";
        }
    }
}//End getScheduleCache Function


/*
* Loop Through JSON and present Schedule
*
* Christopher Fikes
* 03/09/2017
*/
function getLastSync(){
    $ScheduleCache = 'ScheduleCache.json';
    if (file_exists($ScheduleCache)) {
        echo "Last Sync: " . date ("Y-m-d H:i", filemtime($ScheduleCache));
    } else {
        echo "Last Sync: ERROR";
    }
}//End getLastSync Function


//Check for valid login
if ( $_SESSION['LOGIN_VALID'] != 1 ) {
	error_log("SESSION VALUE " .  $_SESSION['LOGIN_VALID']);
	 header("LOCATION: index.php");
}

//Process Saving Settings
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	 $dir = dirname(__FILE__);

	 // Save the settings and update page

     //Update ZoneBOX Password
     $zonePass = fopen("$dir/config/PASSWORD","w") or die ("Cannot write PASSWORD");
     $value = $_POST['inputZonePass'];
     fwrite($zonePass, $value);
     fclose($zonePass);

     //Update Master
     $master = fopen("$dir/config/MASTER","w") or die ("Cannot write MASTER");
     $value = $_POST['inputZoneMaster'];
     fwrite($master, $value);
     fclose($master);

     //Update Address
     $address = fopen("$dir/config/ADDRESS","w") or die ("Cannot write MASTER");
     $value = $_POST['inputZoneAddress'];
     fwrite($address, $value);
     fclose($address);
	 
     //Update Sync key
     $syncKey = fopen("$dir/config/KEY","w") or die ("Cannot write KEY");
     $value = $_POST['inputSyncKey'];
     fwrite($syncKey,$value);
     fclose($syncKey);

     //Update Sync User
     $syncUser = fopen("$dir/config/SYNCUSER","w") or die ("Cannot write SYNCUSER");
     $value = $_POST['inputSyncUser'];
     fwrite($syncUser,$value);
     fclose($syncUser);

     //Update Sync Pass
     $syncPass = fopen("$dir/config/SYNCPASS","w") or die ("Cannot write SYNCPASS");
     $value = $_POST['inputSyncPass'];
     fwrite($syncPass,$value);
     fclose($syncPass);

    /*
    * Get settings and set global vars
    *
    * Christopher Fikes
    * 03/09/2017
    */
    $cZonePass = file_get_contents("config/PASSWORD");
    $cMaster = file_get_contents("config/MASTER");
	$cAddress = file_get_contents("config/ADDRESS");
    $cSyncKey = file_get_contents("config/KEY");
    $cSyncPass = file_get_contents("config/SYNCPASS");
    $cSyncUser = file_get_contents("config/SYNCUSER");


} else {
    /*
    * Get settings and set global vars
    *
    * Christopher Fikes
    * 03/09/2017
    */
    $cZonePass = file_get_contents("config/PASSWORD");
    $cMaster = file_get_contents("config/MASTER");
	$cAddress = file_get_contents("config/ADDRESS");	
    $cSyncKey = file_get_contents("config/KEY");
    $cSyncPass = file_get_contents("config/SYNCPASS");
    $cSyncUser = file_get_contents("config/SYNCUSER");
}

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>ZoneBox</title>

        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Page Styling -->
        <style>
            body {
                padding-top: 55px;
            }
        </style>

    </head>

    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <a class="navbar-brand">
                   Fusion Bells ZoneBox
                </a>
                <a class="navbar-brand navbar-right">
                    <!-- Get Last Sync Time -->
                    <?php getLastSync(); ?>
                </a>
            </div>
        </nav>

        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h3>Settings</h3>
                    <form action="settings.php" method="post">
                        <div class="form-group">
                            <label for="inputZonePass">ZoneBox Password</label>
                            <input type="password" class="form-control" id="inputZonePass" name="inputZonePass" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;" required value="<?php echo $cZonePass; ?>">
                        </div>
                        <div class="form-group">
                            <label for="inputZoneMaster">Zone Master</label>
                            <input type="text" class="form-control" id="inputZoneMaster" name="inputZoneMaster" placeholder="192.168.0.1" required value="<?php echo $cMaster; ?>">
                        </div>
                        <div class="form-group">
                            <label for="inputZoneAddress">Zone Address</label>
                            <input type="text" class="form-control" id="inputZoneAddress" name="inputZoneAddress" placeholder="239.255.0.1:2000" required value="<?php echo $cAddress; ?>">
                        </div>						
                        <div class="form-group">
                            <label for="inputSyncKey">Sync Key</label>
                            <input type="text" class="form-control" id="inputSyncKey" name="inputSyncKey" placeholder="1234567890" required value="<?php echo $cSyncKey; ?>">
                        </div>
                        <div class="form-group">
                            <label for="inputSyncUser">Sync User</label>
                            <input type="text" class="form-control" id="inputSyncUser" name="inputSyncUser" placeholder="root" required value="<?php echo $cSyncUser; ?>">
                        </div>
                        <div class="form-group">
                            <label for="inputSyncPass">Sync Password</label>
                            <input type="password" class="form-control" id="inputSyncPass" name="inputSyncPass" placeholder="root" required value="<?php echo $cSyncUser; ?>">
                        </div>
                
                        <button type="submit" class="btn btn-primary btn-lg">Save Settings</button>
                    </form>
                </div>
                <div class="col-md-4">
                    <h3>Cached Schedule</h3>
                    <table class="table table-striped table-condensed" id="cachedSchedule">
                        <thead>
                            <th>Time</th><th>Tone</th>
                        </thead>
                        <tbody>
                            <!-- Get And Process Schedule Cache -->
                            <?php getScheduleCache(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>

</html>