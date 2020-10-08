<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/session_delay_token.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/frage.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/system.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/abgabe.php");
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
$Block=mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($_GET['Block']), ENT_QUOTES , "UTF-8"));
header('Content-Encoding: UTF-8');
header('Content-type: text/csv; charset=UTF-8');
header("Content-Disposition: attachment; filename=Export_".$_SESSION['fID']."_$Block.csv");
echo "\xEF\xBB\xBF"; // UTF-8 BOM

$abgabeArr=getAbgabeInfos($_SESSION['fID']);


$iLauf=0;
foreach($abgabeArr as $abgabeRow){
	$parameter=json_decode($abgabeRow['parameter'],true);
	if(isset($parameter['FragenWerte_'.$Block])){
		if($iLauf==0){
			$FrageID_Arr=array("token");
			$FrageValue_Arr=[];
			foreach($parameter['FragenWerte_'.$Block] as $key => $value){
				$FrageInfo=getFrageInfo($key);
				$FrageParameter=json_decode($FrageInfo['parameter'],true);
				array_push($FrageID_Arr,$FrageParameter['titel']);
			}
		}
		$FrageValue_Arr[$iLauf]=array($abgabeRow['token']);
		foreach($parameter['FragenWerte_'.$Block] as $key => $value){
			array_push($FrageValue_Arr[$iLauf],$value);
		}
		$iLauf++;
	}
}

echo join(";",$FrageID_Arr);
foreach($FrageValue_Arr as $FrageValue_Arr_row){
	echo "\r\n";
	echo join(";",$FrageValue_Arr_row);
}