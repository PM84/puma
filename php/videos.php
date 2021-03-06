<?php

function Get_Videos_Liste()
{
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/php/system.php");
	//Quelle wird in der config.php Datei angegeben.
	// echo $index_video_path;
	$indexContet = file_get_contents_utf8($index_video_path);
	$Index = json_decode($indexContet);
	return $Index;
}



function get_video_array_thema_video()
{
	$videos = Get_Videos_Liste();
	$themen = Get_VideoThemen();

	$videoArr = [];
	foreach ($themen as $thema) {

		// 		if(!isset($videoArr[$thema])){}

		foreach ($videos as $video) {
			
			if (in_array($thema->themaID, $video->themen)) {
				if (!isset($videoArr[$thema->titel])) {
					$videoArr[$thema->titel] = [];
				}
				array_push($videoArr[$thema->titel], $video);
			}
		}
	}
	return $videoArr;
}



function Get_VideoThemen()
{
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/php/system.php");
	$indexContet = file_get_contents_utf8($index_themen_path);
	$Index = json_decode($indexContet);
	return $Index;
}

function Get_VideoInfos_By_vID($videosArr, $vID)
{
	// Eingabe: z.B. return value von Get_Videos_Liste
	foreach ($videosArr as $video) {
		if ($video->vID == $vID) {
			return $video;
		}
	}
}

function get_video_link($videoList, $preferedQual)
{
	include_once($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/php/system.php");
	
	// 	$retVal="";
	$url = "https://www2.didaktik.physik.uni-muenchen.de/expvid/" . $videoList->pfad . "/$preferedQual/" . $videoList->dateiname;
	if (!check_if_url_exists($url)) {
		switch ($preferedQual) {
			case "hd":
				$preferedQual = "sd";
				break;
			case "sd":
				$preferedQual = "hd";
				break;
		}
		$url = "https://www2.didaktik.physik.uni-muenchen.de/expvid/" . $videoList->pfad . "/$preferedQual/" . $videoList->dateiname;
	}


	/* 	foreach($videoList as $key => $videoSRC){


	}	
	foreach($videoList as $key => $videoSRC){
		if($key==$preferedQual && strlen($videoSRC)>0){
			$retVal=$videoSRC;
		}
	}

	if(strlen($retVal)==0){
		foreach($videoList as $key => $videoSRC){
			if(strlen($videoSRC)>0){
				$retVal=$videoSRC;
			}
		}
	}
 */
	return $url;
}

function Get_eigeneVideoInfos_By_vID_and_uID($uID, $eig_vID)
{
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/php/system.php");
	$query = "SELECT * FROM media WHERE uID=$uID AND mediaID=$eig_vID";
	$ergebnis = mysqli_query($verbindung, $query);
	$row = mysqli_fetch_assoc($ergebnis);
	$row['link_src'] = $_SESSION['DOCUMENT_ROOT_DIR'] . "/media/uploads/$uID/" . $row['dateiname'];
	return $row;
}
