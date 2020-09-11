<?php
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");

$query="SELECT * from folien WHERE ftoken=''";
$ergebnis=mysqli_query($verbindung,$query);
while($row=mysqli_fetch_assoc($ergebnis)){
	$fID=$row['fID'];
	$ftoken=uniqid();
	$query2="UPDATE folien SET ftoken='$ftoken' WHERE fID=$fID";
	$ergebnis2=mysqli_query($verbindung,$query2);
}