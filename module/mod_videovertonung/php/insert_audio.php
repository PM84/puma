<?php
include($_SERVER['DOCUMENT_ROOT']."/config.php");

$tmp_filename=$_FILES["file"]["tmp_name"];
$ZielDateiname=htmlspecialchars($_POST["fileName"], ENT_QUOTES);
$token=htmlspecialchars($_POST['token'], ENT_QUOTES);
$fID=intval($_POST['fID']);
$uniqueID=htmlspecialchars($_POST['uniqueID'], ENT_QUOTES);
// $uniqid=uniqid();
// $ZielDateiname=$fID."_".$token."_".$uniqueID.".wav";
// echo "===$ZielDateiname===";
rename($tmp_filename,$_SERVER['DOCUMENT_ROOT']."/media/audio/$ZielDateiname");
chmod($_SERVER['DOCUMENT_ROOT']."/media/audio/$ZielDateiname",0755);

$audioArr=array();
$query="SELECT * FROM abgabe WHERE fID='$fID' and token='$token'";
$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
if(mysqli_num_rows($ergebnis)==1){
	$row=mysqli_fetch_assoc($ergebnis);
	$parameter=json_decode($row['parameter']);
	$audioArr=$parameter->audioArr;
	if($audioArr===NULL){
		$audioArr=array();
	}
}

array_push($audioArr,array('fileName'=>$ZielDateiname,'abgegeben'=>0));
$parameter->audioArr=$audioArr;
$parameter->fID=$fID;
$parameter->token=$token;
$parameter=json_encode($parameter);
$datum=date("Y-m-d H:i:s");
$query="INSERT INTO abgabe (fID,abTyp,token,parameter,datum) VALUES ('$fID',1,'$token','$parameter','$datum') on duplicate key update parameter='$parameter'";
$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));