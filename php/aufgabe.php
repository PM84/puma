<?php

function GetAufgabeInfos($kursID){
	include($_SERVER['DOCUMENT_ROOT']."/config.php");
	$kursID=intval($kursID);
	$query="SELECT * FROM kurs WHERE kursID=$kursID";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$row=mysqli_fetch_assoc($ergebnis);
	return $row;
}