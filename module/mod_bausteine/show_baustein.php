<?php
// ========================
// ========================
// ====== BAUSTEIN ANZEIGEN
// ========================
// ========================

include_once($_SERVER['DOCUMENT_ROOT']."/php/bausteine.php");

$bInfoRow=getBausteinInfo($bID);
$bInfo=json_decode($bInfoRow['parameter'],true);
$bsTypInfo=getBausteinTypInfo($bInfoRow['bTypID']);

include($_SERVER['DOCUMENT_ROOT']."/module/mod_bausteine/".$bsTypInfo['bs_show']);


/* switch($bInfoRow['bTypID']){
	case 1:
		// 		echo "Kontrollfragen";
		include($_SERVER['DOCUMENT_ROOT']."/module/mod_bausteine/show_kontrollfrage.php");
		break;

	case 2:
		include($_SERVER['DOCUMENT_ROOT']."/module/mod_bausteine/show_wordcloud.php");
		break;

	case 3:
		include($_SERVER['DOCUMENT_ROOT']."/module/mod_bausteine/show_abstimmung.php");
		break;

	case 4: //YouTube Videos
		include($_SERVER['DOCUMENT_ROOT']."/module/mod_bausteine/show_YouTube.php");
		break;

	case 5: //Evaluation
		include($_SERVER['DOCUMENT_ROOT']."/module/mod_bausteine/show_evaluation.php");
		break;


	case 6: //Webpage
		include($_SERVER['DOCUMENT_ROOT']."/module/mod_bausteine/show_webpage.php");
		break;
} */