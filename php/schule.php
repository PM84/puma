<?php

function getSchulInfo_by_SchulNr($SchulNr){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT * FROM schule_daten WHERE SchulNr=$SchulNr";
	$ergebnis=mysqli_query($verbindung,$query);
	$row=mysqli_fetch_assoc($ergebnis);
	return $row;
}

function getSchulen_Liste(){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT * FROM schule_daten";
	$ergebnis=mysqli_query($verbindung,$query);
	$retArr=[];
	while($row=mysqli_fetch_assoc($ergebnis)){
		array_push($retArr,$row);
	}
	return $retArr;
}