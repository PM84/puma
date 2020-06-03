<?php
// ========================
// ========================
// ====== BAUSTEIN AUSWERTUNG ANZEIGEN
// ========================
// ========================
include_once($_SERVER['DOCUMENT_ROOT']."/php/bausteine.php");

$bInfoRow=getBausteinInfo($bID);
$bInfo=json_decode($bInfoRow['parameter'],true);

switch($bInfoRow['bTypID']){
	case 1:
		include($_SERVER['DOCUMENT_ROOT']."/module/mod_bausteine/show_kontrollfrage_ausw.php");
		break;

	case 2:
		include($_SERVER['DOCUMENT_ROOT']."/module/mod_bausteine/show_wordcloud_ausw.php");
		break;

	case 3:
		include($_SERVER['DOCUMENT_ROOT']."/module/mod_bausteine/show_abstimmung_ausw.php");
		break;
		
	case 4: //YouTube Videos
		include($_SERVER['DOCUMENT_ROOT']."/module/mod_bausteine/show_YouTube.php");
		break;

	case 5: // Evaluation
		include($_SERVER['DOCUMENT_ROOT']."/module/mod_bausteine/show_evaluation_loe.php");
		break;
	case 6: // Webpage einblenden
		include($_SERVER['DOCUMENT_ROOT']."/module/mod_bausteine/show_webpage.php");
		break;
	case 8: // Aussagen ordnen
 		echo "TEST";
		include($_SERVER['DOCUMENT_ROOT']."/module/mod_bausteine/show_order_statements_ausw.php");
		break;
}