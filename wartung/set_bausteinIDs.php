<?php
session_start();
include($_SERVER['DOCUMENT_ROOT']."/config.php");

$query="SELECT * FROM folien WHERE parameter LIKE '%bID_%'";
$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
$tempArr=array();
while($row=mysqli_fetch_assoc($ergebnis)){
	$parameter=json_decode($row['parameter'],true);
	$fID=$row['fID'];
	foreach($parameter as $key => $value){
		if(strpos($key,"bID_")!==FALSE){
			array_push($tempArr,"($fID,'$key',$value)");
		}
	}
}

if(count($tempArr)>0){
	$insertStr=join(",",$tempArr);
	$query="INSERT INTO baustein_folie_position_match (fID,blockID,bID) VALUES $insertStr on duplicate key update fID=VALUES(fID), blockID=VALUES(blockID), bID=VALUES(bID)";
	mysqli_query($verbindung,$query) or die($query." ==> ".mysqli_error($verbindung));
}

$query="SELECT * FROM kurs WHERE kursToken=''";
$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
while($row=mysqli_fetch_assoc($ergebnis)){
	$kursToken=uniqid();
	$kursID=$row['kursID'];
	$query2="UPDATE kurs SET kursToken='$kursToken' WHERE kursID=$kursID";
// 	echo "<br>$query2";
	mysqli_query($verbindung,$query2) or die($query." ==> ".mysqli_error($verbindung));
}
