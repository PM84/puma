<?php

function insert_baustein_folie_match($fID,$bsArray){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$insertArr=array();
	foreach($bsArray as $key => $value){
		array_push($insertArr,"($fID,'$key','$value')");
	}
	$insertStr=join(",",$insertArr);
	$query="INSERT INTO baustein_folie_position_match (fID,blockID,bID) VALUES $insertStr on duplicate key update fID=VALUES(fID), blockID=VALUES(blockID), bID=VALUES(bID)";
	mysqli_query($verbindung,$query) or die($query." ==> ".mysqli_error($verbindung));
}

function get_bIDs_from_match($fID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$bsArray=array();
	$query="SELECT * FROM baustein_folie_position_match where fID=$fID";
	$ergebnis=mysqli_query($verbindung,$query) or die($query."==".mysqli_error($verbindung));
	while($row=mysqli_fetch_assoc($ergebnis)){
		array_push($bsArray,$row);
	}
	return $bsArray;
}

function getBausteineTypen($aktiv=1,$show=1){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$bsArray=array();
	$query="SELECT * FROM bausteine_typen where aktiv=$aktiv AND `show`=$show";
	$ergebnis=mysqli_query($verbindung,$query) or die($query."==".mysqli_error($verbindung));
	while($row=mysqli_fetch_assoc($ergebnis)){
		array_push($bsArray,$row);
	}
	return $bsArray;
}

function getBausteinTypInfo($bTypID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$bsArray=array();
	$query="SELECT * FROM bausteine_typen where aktiv=1 AND bTypID='$bTypID'";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$row=mysqli_fetch_assoc($ergebnis);
	return $row;
}

function getBausteinInfo($bID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT * FROM bausteine where bID='$bID'";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$row=mysqli_fetch_assoc($ergebnis);
	return $row;
}

function getBausteineListeInfos($uID,$gruppiert=1){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");

	$query="SELECT * FROM bausteine WHERE uID=$uID order by bID DESC";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$bsArray=array();
	while($row=mysqli_fetch_assoc($ergebnis)){
		$bID=$row['bID'];
		$bsInfo=getBausteinInfo($bID);
		// 		var_dump($bsInfo);
		if($gruppiert==1){
			// 			echo $bsInfo['bTypID'];
			if(count($bsArray)==0 || !isset($bsArray[$bsInfo['bTypID']])){$bsArray[$bsInfo['bTypID']]=array();}
			array_push($bsArray[$bsInfo['bTypID']],$bsInfo);
		}else{
			array_push($bsArray,$bsInfo);
		}
	}
	return $bsArray;
}

function insertBaustein($uID,$bTypID,$parameter){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="INSERT INTO bausteine (bTypID,uID,parameter) VALUES ('$bTypID','$uID','$parameter')";
	mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$bsID=mysqli_insert_id ( $verbindung );
	return $bsID;
}

function updateBaustein($bID,$parameter){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="UPDATE bausteine SET parameter='$parameter' WHERE bID='$bID'";
	mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
}
