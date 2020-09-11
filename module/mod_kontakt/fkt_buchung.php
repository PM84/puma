<?php 

function getTerminListe(){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT * FROM studie_termine WHERE aktiv=1";
	$ergebnis=mysqli_query($verbindung,$query);
	$retArr=array();
	while($row=mysqli_fetch_assoc($ergebnis)){
		array_push($retArr,$row);
	}
	return $retArr;
}



function getBuchungen_by_TerminID($TerminID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT * FROM studie_buchung WHERE TerminID=$TerminID";
	$ergebnis=mysqli_query($verbindung,$query);
	$retArr=array();
	while($row=mysqli_fetch_assoc($ergebnis)){
		array_push($retArr,$row);
	}
	return $retArr;
}

function getTermin_by_TerminID($TerminID){
		include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT * FROM studie_termine WHERE TerminID=$TerminID";
	$ergebnis=mysqli_query($verbindung,$query);
	$row=mysqli_fetch_assoc($ergebnis);
	return $row;

}

function emailSenden($from,$to_arr,$subject,$message){
	include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/mail.php");
$MessageArray['from']['EmailFrom']=$from;
// 	$MessageArray['from']=array("FromEmail"=> $from);
	$MessageArray['to']=array("EmailTo" => $to_arr); // $to_arr=array("ex1@test.de", "ex2@test.de")
	$MessageArray['betreff']=$subject;
	$MessageArray['nachricht']=$message;
	sentMail($MessageArray);

}