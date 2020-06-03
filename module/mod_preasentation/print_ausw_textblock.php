<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
if(isset($_GET['b'])){
	$Block=$_GET['b'];

	if(isset($_GET['s'])){
?>

<style>
	.noPrint{
		display:none !important;
	}
	.pagebreak{
		page-break-after: always;
	}
</style>
<?php
	}
}

include_once($_SERVER['DOCUMENT_ROOT']."/php/abgabe.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/teilnehmer.php");

$abRows=getAbgabeInfos($_SESSION['fID']);
$ab_iLauf=0;
foreach($abRows as $abRow){
	// 		KoFra_Option_1
	$abInfo=json_decode($abRow['parameter'],true);
	$tnInfo=getTeilnehmerInfosByToken($abRow['token']);
	$token=$abRow['token'];
	$Name=$tnInfo['name'].", ".$tnInfo['vname'];
	echo "<div class='pagebreak'><h4>$Name ( $token )</h4>";
	echo html_entity_decode ($abInfo['txt_'.$Block], ENT_QUOTES , "UTF-8");
	$ab_iLauf++;
	if($ab_iLauf<count($abRows)){
		echo "<hr class='noPrint'>";
	}
	echo "</div>";
}