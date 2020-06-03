<?php
include_once($_SERVER['DOCUMENT_ROOT']."/php/Sessions.php");
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
if(isset($_SESSION['s'])){
	$SessionInfos=Get_SessionInfos($_SESSION['s']);
	if($SessionInfos==null){
		session_destroy();
		echo "<script>window.location = '/module/user/login.php';</script>"; 
	};
}
// include_once($_SERVER['DOCUMENT_ROOT']."/php/agb.php");
// $checkConf=check_confirmed_last_agb();
// if(count($checkConf)==0 || $checkConf['status']==0 ){
// 	echo "<script>window.location = '/module/user/rules.php';</script>"; 
// }