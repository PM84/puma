<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

include($_SERVER['DOCUMENT_ROOT']."/config.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/folie.php");

$tmp_filename=$_FILES["file"]["tmp_name"];
$ZielDateiname=$_POST["fileName"];
$fID=$_SESSION['va']['fID'];
$token=$_POST['VideoToken'];
$uniqid=$_POST['uniqid'];
$ZielDateiname=$_SESSION['uID']."_".$fID."_".$uniqid."_".$token.".webm";
// $ZielDateiname=$_SESSION['uID']."_".$fID."_".$uniqid."_".$token.".mp4";
// $ZielDateiname=$_SESSION['uID']."_".$fID."_".$uniqid."_".$token.".m4v";
// echo "===$ZielDateiname===";
rename($tmp_filename,$_SERVER['DOCUMENT_ROOT']."/media/video/$ZielDateiname");
chmod($_SERVER['DOCUMENT_ROOT']."/media/video/$ZielDateiname",0755);

$folieInfo=getFolieInfo($fID);
$parameterTEMP=json_decode($folieInfo['parameter'],true);
if(!isset($parameterTEMP['videoArr'])){
	$parameterTEMP['videoArr']=array();
}
$videoNeu=array('fileName'=>$ZielDateiname,"datetime"=>date("Y-m-d H:i:s"),'abgegeben'=>0);
array_push($parameterTEMP['videoArr'],$videoNeu);
$parameter=json_encode($parameterTEMP);
$folieDetails=create_inactive_folie($_SESSION['uID'],$_SESSION['va']['kID'],$parameter,$_SESSION['va']['modID'],$_SESSION['va']['viewTyp'],0,$fID);


$file=__DIR__."/../../tmp_video/exit_files.txt";
$content=file_get_contents($file);
$jsonArr=json_decode($content,true);
$jsonArr[$ZielDateiname]=array();
$json_string=json_encode($jsonArr);
$fp=fopen($file,"w")or die("Unable to open file!");;
fwrite($fp,$json_string);
fclose($fp);
// file_get_contents('https://jdev.pemasoft.de/convertWebmToMp4.php');
echo $ZielDateiname;


/* $audioArr=array();
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
 */
/* array_push($audioArr,array('fileName'=>$ZielDateiname,'abgegeben'=>0));
$parameter->audioArr=$audioArr;
$parameter->fID=$fID;
$parameter->token=$token;
$parameter=json_encode($parameter);
$datum=date("Y-m-d H:i:s");
$query="INSERT INTO abgabe (fID,abTyp,token,parameter,datum) VALUES ('$fID',1,'$token','$parameter','$datum') on duplicate key update parameter='$parameter'";
$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung)); */