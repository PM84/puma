<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/Sessions.php");
if(isset($_SESSION['s'])){
	$SessionInfos=Get_SessionInfos($_SESSION['s']);
	if($SessionInfos==null){
		session_destroy();
		echo "<script>window.location = '" . $_SESSION['DOCUMENT_ROOT_DIR']."/module/user/login.php';</script>"; 
	};
}
// include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/agb.php");
// $checkConf=check_confirmed_last_agb();
// if(count($checkConf)==0 || $checkConf['status']==0 ){
// 	echo "<script>window.location = '" . $_SESSION['DOCUMENT_ROOT_DIR']."/module/user/rules.php';</script>"; 
// }