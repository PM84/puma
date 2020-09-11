<?php

function addAGB($agb_txt,$valid_from,$id){

	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="INSERT INTO agb (agbID,text,valid_from) VALUES ($id,'$agb_txt','$valid_from') on duplicate key update text='$agb_txt', valid_from='$valid_from'";
	$ergebnis=mysqli_query($verbindung,$query)or die(mysqli_error($verbindung));

}

function get_AGB_versionsListe(){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT * FROM agb order by valid_from DESC";
	$ergebnis=mysqli_query($verbindung,$query)or die(mysqli_error($verbindung));
	return $ergebnis;
}

function loadAGB($agbID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT * FROM agb WHERE agbID='$agbID'";
	$ergebnis=mysqli_query($verbindung,$query)or die(mysqli_error($verbindung));
	return mysqli_fetch_assoc($ergebnis);
}

function load_actual_AGB(){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT * FROM agb tabAGB INNER JOIN agb_user_confirm tabConf on (tabAGB.agbID = tabConf.agbID) WHERE tabAGB.valid_from < NOW() ORDER BY valid_from DESC LIMIT 1";
	$ergebnis=mysqli_query($verbindung,$query)or die(mysqli_error($verbindung));
	if(mysqli_num_rows($ergebnis)==0){
		$query="SELECT * FROM agb WHERE valid_from < NOW() ORDER BY valid_from DESC LIMIT 1";
		$ergebnis=mysqli_query($verbindung,$query)or die(mysqli_error($verbindung));
	}
	return mysqli_fetch_assoc($ergebnis);
}

function check_confirmed_last_agb(){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$uID=$_SESSION['uID'];
	$query="SELECT * FROM agb tabAGB INNER JOIN agb_user_confirm tabConf on (tabAGB.agbID = tabConf.agbID) WHERE tabConf.uID='$uID' AND `valid_from` < NOW() ORDER BY `valid_from` DESC LIMIT 1";
	$ergebnis=mysqli_query($verbindung,$query)or die(mysqli_error($verbindung));
	return mysqli_fetch_assoc($ergebnis);
}

function set_confirm_status($status){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$uID=$_SESSION['uID'];
	$agbID=$_SESSION['agbID'];
	$query="INSERT INTO agb_user_confirm (agbID,uID,datum,status) VALUES ($agbID,$uID,NOW(),$status) on duplicate key update datum=NOW(),status=$status";
	$ergebnis=mysqli_query($verbindung,$query)or die(mysqli_error($verbindung));

}