<?php


function getModulListeInfos($kTyp=0){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	// 	$kursTNArr=getTnByKurs($kursID);
	$modArray=[];
	switch($kTyp){
		case 1:
			$query="SELECT * FROM module where aktiv=1";
			break;
		case 2:
			$query="SELECT * FROM module where aktiv=1 AND for_kTyp=2";
			break;
		default:
			$query="SELECT * FROM module where aktiv=1";
			break;
	}
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	while($row=mysqli_fetch_assoc($ergebnis)){
		array_push($modArray,$row);
	}
	return $modArray;
}

function getModulInfos($modID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT * FROM module WHERE modID='$modID' and aktiv=1";
	$ergebnis=mysqli_query($verbindung,$query)or die(mysqli_error($verbindung));
	$row=mysqli_fetch_assoc($ergebnis);
	return $row;
}

function getModIDFromTitel($titel){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT * FROM module WHERE mod_titel='$titel'";
	$ergebnis=mysqli_query($verbindung,$query)or die(mysqli_error($verbindung));
	$row=mysqli_fetch_assoc($ergebnis);
	return $row['modID'];
}