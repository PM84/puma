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

include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/folie.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/abgabe.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/bausteine.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/teilnehmer.php");

$FolieInfos=getFolieInfo($_SESSION['fID']);
$parameter=json_decode($FolieInfos['parameter'],true);
$bID=$parameter["bID_$Block"];
$bsInfo=getBausteinInfo($bID);
$bInfo=json_decode($bsInfo['parameter'],true);

$abRows=getAbgabeInfos($_SESSION['fID']);
$ab_iLauf=0;
foreach($abRows as $abRow){
	// 		KoFra_Option_1
	$abInfo=json_decode($abRow['parameter'],true);
	$tnInfo=getTeilnehmerInfosByToken($abRow['token']);
	$token=$abRow['token'];
	$Name=$tnInfo['name'].", ".$tnInfo['vname'];
	$abst_arr=$abInfo['abstOption_'.$Block];
	echo "<div class='pagebreak'><h4>$Name ( $token )</h4><ul>";
	foreach($abst_arr as $optionID){
// 		$options=get_abstimmung_options($bID,$Block);
		echo "<li>".html_entity_decode ($bInfo["abstOption"][$optionID], ENT_QUOTES , "UTF-8");
		echo "</li>";
	}
	$ab_iLauf++;
	echo "</ul>";
	if($ab_iLauf<count($abRows)){
		echo "<hr class='noPrint'>";
	}
	echo "</div>";
}