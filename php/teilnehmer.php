<?php
if(isset($_POST['PostFktn'])){
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	switch($_POST['PostFktn']){
		case 'changeTeacherStatus':
			$tnID=intval($_POST['tnID']);
			changeTeacherStatus($tnID);
			break;
	}
}

function getDozent_tnInfos($dozent=1){
	// liefert einer Array aller Dozenten eines Kurses
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$kursID=$_SESSION['kursID'];
	$query="SELECT * FROM user_teilnehmer_kurs_match tM INNER JOIN user_teilnehmer tT ON tT.tnID=tM.tnID WHERE tM.kursID=$kursID AND tM.dozent=$dozent";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$tnKursArr=[];
	while($row=mysqli_fetch_assoc($ergebnis)){
		array_push($tnKursArr,$row);
	}
	return $tnKursArr;	
}

function Check_if_TN_is_Dozent($kursID,$token){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT * FROM user_teilnehmer_kurs_match tM INNER JOIN user_teilnehmer tT ON tT.tnID=tM.tnID WHERE tM.kursID=$kursID AND tT.token='$token' AND tM.dozent=1";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	if(mysqli_num_rows($ergebnis)>0){
		return true;
	}else{
		return false;
	}
}

function changeTeacherStatus($tnID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$kursID=$_SESSION['k'];
	$query="UPDATE user_teilnehmer_kurs_match set dozent=IF(dozent=0,1,0) WHERE kursID=$kursID AND tnID=$tnID";
	$ergebnis=mysqli_query($verbindung,$query) or die($query."=>".mysqli_error($verbindung));
	$query="SELECT * FROM user_teilnehmer_kurs_match WHERE kursID=$kursID AND tnID=$tnID";
	$ergebnis=mysqli_query($verbindung,$query) or die($query."=>".mysqli_error($verbindung));
	$row=mysqli_fetch_assoc($ergebnis);
	if($row['dozent']==1){
		$retVal="<img src='".$_SESSION['DOCUMENT_ROOT_DIR']."/images/professor_green.svg' style='height:22px;' onclick='changeTeacherStatus(".$tn['tnID'].")'>";
	}else{
		$retVal="<img src='".$_SESSION['DOCUMENT_ROOT_DIR']."/images/professor_red.svg' style='height:22px;' onclick='changeTeacherStatus(".$tn['tnID'].")'>";
	}
	echo $retVal;
}

function getTeilnehmerInfos($tnID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT * FROM user_teilnehmer WHERE tnID='$tnID'";
	$ergebnis=mysqli_query($verbindung,$query); //or die(mysqli_error($verbindung));
	$row=mysqli_fetch_assoc($ergebnis);
	return $row;	
}

function getTeilnehmerInfosByTnIDs($tnArr=array()){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");

	$tnIDstr=join("' OR tnID='",$tnArr);

	$query="SELECT * FROM user_teilnehmer WHERE tnID='$tnIDstr'";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$tnInfos=[];
	while($row=mysqli_fetch_assoc($ergebnis)){
		$tnInfos[$row['tnID']]=$row;
	}
	return $tnInfos;	
}


function getTeilnehmerInfosByToken($token){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT * FROM user_teilnehmer WHERE token='$token'";
	$ergebnis=mysqli_query($verbindung,$query) or die($query." => ".mysqli_error($verbindung));
	$row=mysqli_fetch_assoc($ergebnis);
	return $row;	
}

function getKurseByTnID($tnID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT * FROM user_teilnehmer_kurs_match WHERE tnID=$tnID";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$tnKursArr=[];
	while($row=mysqli_fetch_assoc($ergebnis)){
		array_push($tnKursArr,$row);
	}
	return $tnKursArr;	
}

function getKursByTnID($tnID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT * FROM user_teilnehmer_kurs_match WHERE tnID=$tnID";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$row=mysqli_fetch_assoc($ergebnis);
	return $row;
}

function getAllTeilnehmerOfUser($uID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT * FROM user_teilnehmer WHERE uID='$uID'";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$tnArr=[];
	while($row=mysqli_fetch_assoc($ergebnis)){
		array_push($tnArr,$row);
	}
	return $tnArr;	
}


function getTeilnehmerListeInfos($kursID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$kursTNArr=getTnByKurs($kursID);
	$tnArray=[];
	foreach($kursTNArr as $tn){
		$tnID=$tn['tnID'];
		$row=getTeilnehmerInfos($tnID);
		$row['dozent']=$tn['dozent'];
		array_push($tnArray,$row);
	}
	
	return $tnArray;
}

function deleteTN($tnID,$kursID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="DELETE FROM user_teilnehmer_kurs_match WHERE tnID=$tnID AND kursID=$kursID";
	mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
}

function getTnByKurs($kursID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT * FROM user_teilnehmer_kurs_match WHERE kursID=$kursID";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$kursTNArr=[];
	while($row=mysqli_fetch_assoc($ergebnis)){
		array_push($kursTNArr,$row);
	}
	return $kursTNArr;
}

function AddTeilnehmer($geschlecht, $name, $vname, $email, $uID, $kursID,$preview=0){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$token=uniqid();
	if(strlen($email)<5){$email="$token@test.de";}
	$query="Insert INTO  user_teilnehmer (geschlecht,name,vname,email,uID,token,preview_account) VALUES ('$geschlecht', '$name', '$vname', '$email', '$uID', '$token','$preview')";
	mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$tnID=mysqli_insert_id($verbindung);
	AddTeilnehmerKursMatch($kursID,$tnID);
	return $token;
}

function AddTeilnehmerKursMatch($kursID,$tnID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="Insert INTO  user_teilnehmer_kurs_match (kursID,tnID) VALUES ('$kursID', '$tnID')";
	mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
}

function UpdateTeilnehmer($geschlecht, $name, $vname, $email,$tnID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="UPDATE user_teilnehmer SET geschlecht='$geschlecht', name='$name', vname='$vname', email='$email' WHERE tnID=$tnID";
	mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
}


function check_for_preview_teilnehmer($uID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT * FROM user_teilnehmer WHERE uID='$uID' AND preview_account=1";
	$ergebnis=mysqli_query($verbindung,$query);// or die(mysqli_error($verbindung));
	if(mysqli_num_rows($ergebnis)>0){
		$row=mysqli_fetch_assoc($ergebnis);
		return $row['tnID']; 
	}else{
		return false;
	}
}

function get_preview_teilnehmer_infos($uID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT * FROM user_teilnehmer WHERE uID='$uID' AND preview_account=1";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	if(mysqli_num_rows($ergebnis)>0){
		$row=mysqli_fetch_assoc($ergebnis);
		return $row; 
	}else{
		return false;
	}

}

function set_preview_teilnehmer_if_not_exist($kursID,$uID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/user_login.php");
	$tnID=check_for_preview_teilnehmer($uID);
	if(!$tnID){
		$userInfo=getUserInfos($uID);
		$preview=1;
		AddTeilnehmer($userInfo['geschlecht'],$userInfo['name'],$userInfo['vname'],$userInfo['email'], $uID, $kursID,$preview);
	}else{
		AddTeilnehmerKursMatch($kursID,$tnID);
	}
}

function get_preview_teilnehmer($uID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT * FROM user_teilnehmer WHERE uID='$uID' AND preview_account=1";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	return mysqli_fetch_assoc($ergebnis);
}