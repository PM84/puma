<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

if(isset($_POST['PostFktn'])){
	switch($_POST['PostFktn']){
		case 'add_file_to_kurs':
			$mediaID=intval($_POST['mediaID']);
			add_file_to_kurs($mediaID);
			break;
	}
}

function getFileList(){
	$uID=$_SESSION['uID'];
	// 	$uID=1;
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT * from media WHERE uID=$uID";
	$ergebnis=mysqli_query($verbindung,$query);
	$FileList=array();
	while($row=mysqli_fetch_assoc($ergebnis)){
		array_push($FileList,$row);
	}
	return $FileList;
}

function get_mediaIDs_by_kursID($kursID){
	$uID=$_SESSION['uID'];
	// 	$uID=1;
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT * from media_kurs_match WHERE kursID=$kursID";
	$ergebnis=mysqli_query($verbindung,$query);
	$mediaIDs=array();
	while($row=mysqli_fetch_assoc($ergebnis)){
		array_push($mediaIDs,$row['mediaID']);
	}
	return $FileList;
}
function setInsertButton($fileID){
	// 	return "<form method='post' action=''><input type='hidden' value='$fileID' name='fileID'><input type='submit' value='Verwenden' class='btn btn-success'></form>";
	return "<button class='btn btn-success verwenden' name='fileID' value='$fileID'>Verwenden</button>";
}


function add_file_to_db($dateiname,$size,$titel,$uID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	// 	$uID=$_SESSION['uID'];
	// 	$uID=1;
	$deleteDate=date("Y-m-d H:i:s");
	$query="INSERT INTO media (uID, titel, dateiname, inserted, size) VALUES ('$uID', '$titel', '$dateiname', '$deleteDate', '$size')";
	mysqli_query($verbindung,$query)or die($query." => ".mysqli_error($verbindung));;
	return mysqli_insert_id ( $verbindung );
	// d.h. return mediaID
}

function add_file_to_kurs($mediaID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$kursID=$_SESSION['k'];
	$uID=$_SESSION['uID'];
	$fID=$_SESSION[$ftoken]['fID'];
	$query="INSERT INTO media_kurs_match (uID, mediaID, kursID,fID) VALUES ('$uID', '$mediaID', '$kursID','$fID')";
	mysqli_query($verbindung,$query)or die($query." => ".mysqli_error($verbindung));;
}

function Update_fID_file_match($fID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$kursID=$_SESSION['k'];
	$uID=$_SESSION['uID'];
	$query="UPDATE media_kurs_match SET fID='$fID' WHERE  uID='$uID' AND fID=0 AND kursID='$kursID'";
	mysqli_query($verbindung,$query)or die($query." => ".mysqli_error($verbindung));;
}

function Insert_fID_file_match_single($mediaID,$fID,$kursID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$uID=$_SESSION['uID'];
	$query="INSERT IGNORE INTO media_kurs_match SET fID='$fID', mediaID='$mediaID', uID='$uID', kursID='$kursID'";
	mysqli_query($verbindung,$query)or die($query." => ".mysqli_error($verbindung));;
}

function remove_file_from_match_table($mediaID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$kursID=$_SESSION['k'];
	$uID=$_SESSION['uID'];
	$fID=$_SESSION[$ftoken]['fID'];
	$query="DELETE FROM media_kurs_match WHERE uID='$uID' AND mediaID='$mediaID' AND kursID='$kursID' AND fID='$fID'";
	mysqli_query($verbindung,$query)or die($query." => ".mysqli_error($verbindung));
}

function get_mediaInfo($mediaID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT * FROM media WHERE mediaID='$mediaID'";
	$ergebnis=mysqli_query($verbindung,$query)or die($query." => ".mysqli_error($verbindung));;
	return mysqli_fetch_assoc ( $ergebnis );

}

function loop_match_table($str){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$kursID=$_SESSION['k'];
	$uID=$_SESSION['uID'];
	$fID=$_SESSION[$ftoken]['edit_fID'];
	$query="SELECT * FROM media_kurs_match WHERE uID='$uID' AND kursID='$kursID' AND fID='$fID'";
	// 	echo $query;
	$ergebnis=mysqli_query($verbindung,$query)or die($query." => ".mysqli_error($verbindung));
	while($row=mysqli_fetch_assoc($ergebnis)){
		$mediaID=$row['mediaID'];
		// 		echo $mediaID."<br>";
		$mediaInfo=get_mediaInfo($mediaID);
		if(strpos ( $str , $mediaInfo['dateiname'] )===FALSE){
			// 			echo $mediaInfo['dateiname']." ist vorhanden <br>";
			remove_file_from_match_table($mediaID);
		}
	}
}

function searchMedia($filename){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$uID=$_SESSION['uID'];
	// 	$uID=1;
	$query="SELECT * FROM folien WHERE uID=$uID AND parameter LIKE '%$filename%'";
	$ergebnis=mysqli_query($verbindung,$query)or die($query." => ".mysqli_error($verbindung));
	$corr_fIDs=array();
	while($row=mysqli_fetch_assoc($ergebnis)){
		if(!in_array($row['fID'],$corr_fIDs)){
			array_push($corr_fIDs,$row['fID']);
		}
	}
	return $corr_fIDs;
}

function check_used_media(){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/folie.php");
	$mediaList=getFileList();
	foreach($mediaList as $media){
		$corr_fIDs=searchMedia($media['dateiname']);
		if(count($corr_fIDs)>0){
			foreach($corr_fIDs as $fID){
				$kursID=get_KursID_By_fID($fID);
				Insert_fID_file_match_single($media['mediaID'],$fID,$kursID);
			}
		}
	}
}

function get_mediaList_by_matchingKurs($KursID,$fID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT * FROM media_kurs_match WHERE kursID=$KursID and fID=$fID";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$mediaIDs=array();
	while($row=mysqli_fetch_assoc($ergebnis)){
		if(!in_array($row['mediaID'],$mediaIDs)){
			array_push($mediaIDs,$row['mediaID']);
		}
	}
	return $mediaIDs;
}

function update_media($mediaID_alt,$mediaID_neu){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="UPDATE media_kurs_match SET mediaID=$mediaID_neu WHERE mediaID=$mediaID_alt";
// 	echo $query."<br>";
	$ergebnis=mysqli_query($verbindung,$query) or die($query." => ".mysqli_error($verbindung));
}