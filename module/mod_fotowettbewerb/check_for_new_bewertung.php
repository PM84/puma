<?php

include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/folie.php");
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/abgabe.php");

$fID=intval($_POST['fID']);
$istAnzahl=intval($_POST['istAnzahl']);



$zuFolienArr=Get_zugeordnete_Folien_join_master($fID,2);
$Punkte=[];
$Punkte_Durchschnitt=[];

$AnzahlBewertungen=0;

foreach($zuFolienArr as $folieRow){
	$fID_temp=$folieRow['fID'];
	$Punkte_Durchschnitt[$fID_temp]=[];
	$Anzahl[$fID_temp]=[];
	
	// 	echo "<h2>{$folieRow['uID']}</h2>";
	$abgabeArr=getAbgabeInfos($fID_temp);

	$AnzahlBewertungen=$AnzahlBewertungen+count($abgabeArr);
}if($istAnzahl!=$AnzahlBewertungen){
	echo 1;
}else{
	echo 0;
}
