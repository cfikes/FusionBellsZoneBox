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
$dateNow = date("Y-m-d");
$timeNow = date("H:i");
$Address = file_get_contents("/var/www/html/config/ADDRESS");
$Schedule = json_decode(file_get_contents("/var/www/html/ScheduleCache.json"));
//Fail gracefully if no cache
if (is_null($Schedule) || $Schedule == ""){
    error_log("No Schedule Loaded when checked on $dateNow at $timeNow");
} else {
    //Create Table Row for Each
    foreach ($Schedule as $Bell) {
        $Time = $Bell->Time;
        $Tone = $Bell->Tone;
        if($Time == $timeNow) {
            //Call System command with specified parameters
            $exec="./ffmpeg -re -i ./tones/$Tone -filter_complex 'aresample=16000,asetnsamples=n=160' -acodec g722 -ac 1 -vn -f rtp udp://$Address &"; 
            exec($exec);
        }
    }
}
?>
