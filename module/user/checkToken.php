<?php

function CheckToken($token){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$token=mysqli_real_escape_string ($verbindung,  htmlentities ($token, ENT_QUOTES , "UTF-8"));
	$query="SELECT * FROM user_teilnehmer WHERE token='$token'";
	$ergebnis=mysqli_query($verbindung,$query);
	if(mysqli_num_rows($ergebnis)==1){
		return true;
	}else{
		return false;
	}
}