<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/header_php.php");
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/teilnehmer.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/system.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/mail.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/user_login.php");

$TNListe=getTeilnehmerListeInfos($_SESSION['k']);


if(count($TNListe)==0){
			echo "<script>window.location = '" . $_SESSION['DOCUMENT_ROOT_DIR']."/module/admin/teilnehmer_eintragen.php?m=2';</script>";
	exit;
}
$userInfo=getUserInfos($_SESSION['uID']);
$template=file_get_contents($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/vorlagen/tmpl_token_email.php");
$message=mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($_POST['email_TXT']), ENT_QUOTES , "UTF-8"));
$retval=true;

foreach($TNListe as $TN){

	switch($TN['geschlecht']){
		case "m":
			$Anrede = "Sehr geehrter Herr ";
			break;

		case "w":
			$Anrede = "Sehr geehrte Frau ";
			break;
	}
	
	$briefanrede=$Anrede.$TN['name'];
	$template_conv=str_replace ( "{BRIEFANREDE}", $briefanrede , $template);
	$template_conv=str_replace ( "{NACHRICHT}", html_entity_decode ($message, ENT_QUOTES , "UTF-8"), $template_conv);
	$Link=$WorkshopUrl."?t=".$TN['token'];
	$template_conv=str_replace ( "{LINK}", $Link , $template_conv);

	$subject="Sie wurden zu einem Kurs hinzugefügt!";
	$to_arr=array($TN['email']);
	$toCC_arr=array($userInfo['email']);
	$retval=$retval*email_versenden($userInfo['email'],$to_arr,$subject,$template_conv,$toCC_arr);
}

 if($retval==true){
		echo "<script>window.location = '" . $_SESSION['DOCUMENT_ROOT_DIR']."/module/admin/teilnehmer_eintragen.php?m=1';</script>";
 }else{
		echo "<script>window.location = '" . $_SESSION['DOCUMENT_ROOT_DIR']."/module/admin/teilnehmer_eintragen.php?m=0';</script>";
 }