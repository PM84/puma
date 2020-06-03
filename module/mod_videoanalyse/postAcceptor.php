<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT']."/php/system.php");
include($_SERVER['DOCUMENT_ROOT']."/config.php");


// $titel=mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($_POST['titel']), ENT_QUOTES , "UTF-8")); //($_POST['titel'], ENT_QUOTES);

/*******************************************************
   * Only these origins will be allowed to upload images *
   ******************************************************/
$accepted_origins = array("localhost", "www.jdev-pemasoft.de", "www.physik-workshop.de",$_SERVER['HTTP_HOST']);

/*********************************************
   * Change this line to set the upload folder *
   *********************************************/
//   $imageFolder = "images/".$_SESSION['uID']."/";

if(isset($_SESSION['uID'])){
	$uID=$_SESSION['uID'];
}else{
	$uID=1;
}

$imageFolder = $_SERVER['DOCUMENT_ROOT']."/media/uploads/";
// echo $imageFolder;
if(!is_dir ( $imageFolder )){mkdir($imageFolder);}

// var_dump($_FILES['userfile']['error']);
// var_dump($_FILES);
reset ($_FILES);
$temp = current($_FILES);
// var_dump($temp);
if (is_uploaded_file($temp['tmp_name'])){
	if (isset($_SERVER['HTTP_HOST'])) {
		// same-origin requests won't set an origin. If the origin is set, it must be valid.
		if (in_array($_SERVER['HTTP_HOST'], $accepted_origins)) {
			header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_HOST']);
		} else {
			header("HTTP/1.0 403 Origin Denied ".$_SERVER['HTTP_HOST']);
			return;
		}
	}

	$path_parts = pathinfo($temp['name']);

	// Sanitize input
	if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])) {
		header("HTTP/1.0 504 Dateiname enthält ungültige Zeichen.");
		return;
	}

	// Verify extension
	if (!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("mp4", "mov", "mv4", "avi", "jpg", "png", "gif"))) {
		header("HTTP/1.0 503 Falsches Dateiformat.");
		return;
	}
	if ($_FILES['userfile']['size']>50*1024*1024*1024) {
		header("HTTP/1.0 502 Die Datei ist gößer als 50MB.");
		return;
	}

	$extension=pathinfo($temp['name'], PATHINFO_EXTENSION);
	$titel=$temp['name'];
	$uniqid=uniqid();
	// Accept upload if there was no origin, or if it is an accepted origin
	$new_file_name=$uID."_".$uniqid.".".$extension;
	$filetowrite = $imageFolder . $new_file_name;
	move_uploaded_file($temp['tmp_name'], $filetowrite);

	//saveFileInfoToDB
	$fileID=add_file_to_db($new_file_name,$_FILES['userfile']['size'],$titel,$uID);
	// Respond to the successful upload with JSON.
// 	echo json_encode(array('location' => $filetowrite, 'fileID' => $fileID));
	// 	  exit;
	header("LOCATION: ".$_SESSION['lastPage']);
} else {
	// Notify editor that the upload failed
	header("HTTP/1.0 501 Server Error - Fehler bei der Übertragung, Bitte erneut versuchen!");
}

function add_file_to_db($dateiname,$size,$titel,$uID){
	include($_SERVER['DOCUMENT_ROOT']."/config.php");
	// 	$uID=$_SESSION['uID'];
	// 	$uID=1;
	$deleteDate=date("Y-m-d H:i:s");
	$query="INSERT INTO media (uID, titel, dateiname, inserted, size) VALUES ('$uID', '$titel', '$dateiname', '$deleteDate', '$size')";
	mysqli_query($verbindung,$query)or die($query." => ".mysqli_error($verbindung));;
	return mysqli_insert_id ( $verbindung );
}

?>