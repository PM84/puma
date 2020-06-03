<?php
include($_SERVER['DOCUMENT_ROOT']."/config.php");
$fID=intval($_POST['fID']);
$token=htmlspecialchars($_POST['token'], ENT_QUOTES);
$query="SELECT * FROM abgabe WHERE fID='$fID'";
$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
if(mysqli_num_rows($ergebnis)==1){
	$row=mysqli_fetch_assoc($ergebnis);
	$parameter=json_decode($row['parameter']);
	$audioArr=$parameter->audioArr;
	if($audioArr===NULL){
		$audioArr=array();
	}
}
$fileName=htmlspecialchars($_POST['fileName'], ENT_QUOTES);
$tmpArr=array();
foreach($parameter->audioArr as $audiofile){
	if($audiofile->fileName==$fileName){
		array_push($tmpArr,array('filename'=>$fileName,'abgegeben' => 1));
	}else{
		$audiofile->abgegeben=0;
		array_push($tmpArr,$audiofile);
	}
}
$parameter->audioArr=$tmpArr;
$parameter=json_encode($parameter);
$query="UPDATE abgabe SET parameter='$parameter' WHERE fID='$fID' AND token='$token'";
$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));