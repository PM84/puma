<?php

include($_SERVER['DOCUMENT_ROOT']."/config.php");
include($_SERVER['DOCUMENT_ROOT']."/php/folie.php");
include($_SERVER['DOCUMENT_ROOT']."/php/abgabe.php");

$fID=intval($_POST['fID']);
$istAnzahl=intval($_POST['istAnzahl']);



$zuFolienArr=Get_zugeordnete_Folien_join_master($fID,2);
$Punkte=array();
$Punkte_Durchschnitt=array();

$AnzahlBewertungen=0;

foreach($zuFolienArr as $folieRow){
	$fID_temp=$folieRow['fID'];
	$Punkte_Durchschnitt[$fID_temp]=array();
	$Anzahl[$fID_temp]=array();
	// 	var_dump($folieRow);
	// 	echo "<h2>{$folieRow['uID']}</h2>";
	$abgabeArr=getAbgabeInfos($fID_temp);

	$AnzahlBewertungen=$AnzahlBewertungen+count($abgabeArr);
}if($istAnzahl!=$AnzahlBewertungen){
	echo 1;
}else{
	echo 0;
}

