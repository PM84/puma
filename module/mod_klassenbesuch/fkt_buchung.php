<?php 

if(isset($_POST['fkt'])){
	$FKT=$_POST['fkt'];
	switch($FKT){
		case "SetTerminStatus":
			// 			$TerminArr=explode($_POST['TerminID'],"_");
			$TerminID=intval(str_replace ( "TID_" , "" , $_POST['TerminID']));
			echo SetTerminStatus($TerminID);
			break;
		case "DeleteTermin";
			$TerminID=intval(str_replace ( "del_TID_" , "" , $_POST['TerminID']));
			DeleteTermin($TerminID);
			break;
	}
}

function DeleteTermin($TerminID){
	include($_SERVER['DOCUMENT_ROOT']."/config.php");
	$query="DELETE FROM z_klassenbesuche_termine WHERE TerminID=$TerminID";
	$ergebnis=mysqli_query($verbindung,$query);
	$query="DELETE FROM z_klassenbesuch_buchung WHERE TerminID=$TerminID";
	$ergebnis=mysqli_query($verbindung,$query);
}

function SetTerminStatus($TerminID){
	include($_SERVER['DOCUMENT_ROOT']."/config.php");
	$query="UPDATE z_klassenbesuche_termine SET aktiv=IF(aktiv = 0 , 1, 0) WHERE TerminID=$TerminID";
	// 	echo $query;
	$ergebnis=mysqli_query($verbindung,$query);
	$TerminInfo=getTermin_by_TerminID($TerminID);
	return $TerminInfo['aktiv'];
}

function getTerminListe($all=0){
	include($_SERVER['DOCUMENT_ROOT']."/config.php");
	switch($all){
		case 1:
			$query="SELECT * FROM z_klassenbesuche_termine";
			break;
		default:
			$query="SELECT * FROM z_klassenbesuche_termine WHERE aktiv='1'";
			break;
	}
	$ergebnis=mysqli_query($verbindung,$query);
	$retArr=array();
	while($row=mysqli_fetch_assoc($ergebnis)){
		array_push($retArr,$row);
	}
	return $retArr;
}



function getBuchungen_by_TerminID($TerminID){
	include($_SERVER['DOCUMENT_ROOT']."/config.php");
	$query="SELECT * FROM z_klassenbesuch_buchung WHERE TerminID=$TerminID ORDER BY BuchungsID ASC";
	// 	 	echo $query;
	$ergebnis=mysqli_query($verbindung,$query);
	$retArr=array();
	while($row=mysqli_fetch_assoc($ergebnis)){
		array_push($retArr,$row);
	}
	return $retArr;
}

function getTermin_by_TerminID($TerminID){
	include($_SERVER['DOCUMENT_ROOT']."/config.php");
	$query="SELECT * FROM z_klassenbesuche_termine WHERE TerminID=$TerminID";
	$ergebnis=mysqli_query($verbindung,$query);
	$row=mysqli_fetch_assoc($ergebnis);
	return $row;

}

function emailSenden($from,$to_arr,$subject,$message){
	include_once($_SERVER['DOCUMENT_ROOT']."/php/mail.php");
	$MessageArray['from']['EmailFrom']=$from;
	$MessageArray['to']=array("EmailTo" => $to_arr,"EmailToBCC" => $from); // $to_arr=array("ex1@test.de", "ex2@test.de")
	$MessageArray['betreff']=$subject;
	$MessageArray['nachricht']=$message;
	sentMail($MessageArray);
}