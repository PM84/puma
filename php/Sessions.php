<?php
// session_start();

function Set_Session_Token($uID,$userGroups=array()){
	Delete_Obsolete_Session();
	$userGroups=json_encode($userGroups);
	include($_SERVER['DOCUMENT_ROOT']."/config.php");
	$SessionID=hash("sha224",uniqid());
	$query="INSERT INTO Sessions (uID,SessionID,uGroupIDs) VALUES ('$uID','$SessionID','$userGroups') on duplicate key UPDATE SessionID='$SessionID', uGroupIDs='$userGroups'";
	$ergebnis=mysqli_query($verbindung,$query);
	$_SESSION['s']=$SessionID;
	return $SessionID;
}

function Delete_Obsolete_Session(){
	include($_SERVER['DOCUMENT_ROOT']."/config.php");
	$query="DELETE FROM Sessions WHERE DATEADD(hour, 2, SessionStart) < NOW()";
	$ergebnis=mysqli_query($verbindung,$query);
}

function Get_SessionInfos($SessionID){
	include($_SERVER['DOCUMENT_ROOT']."/config.php");
	$query="SELECT * FROM Sessions WHERE SessionID='$SessionID'";
	$ergebnis=mysqli_query($verbindung,$query)or die(mysqli_error($verbindung));
	$row=mysqli_fetch_assoc($ergebnis);
	return $row;
}