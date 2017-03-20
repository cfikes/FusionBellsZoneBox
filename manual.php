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

/*
* Plays desired tone from the dashboard
*
* Christopher Fikes
* 03/03/2017
*/
function receiveManualBell() {
    //Check if valid POST Type
    if(is_null($_POST['tone'])){ die("NoType"); }
	
	//Get Address
	$cAddress = file_get_contents("config/ADDRESS");
	
    //Call System command with specified parameters
    $exec="./ffmpeg -re -i ./tones/$tone -filter_complex 'aresample=16000,asetnsamples=n=160' -acodec g722 -ac 1 -vn -f rtp udp://$address &"; 
    exec($exec);
}//End manualBell Function

if (!empty($_POST)) {
	receiveManualBell();
}