<?php
// ========================
// ========================
// ====== BAUSTEIN ANZEIGEN
// ========================
// ========================
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/bausteine.php");

$bInfoRow=getBausteinInfo($bID);
$bInfo=json_decode($bInfoRow['parameter'],true);

switch($bInfoRow['bTypID']){
	case 1:
		include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/module/mod_bausteine/show_kontrollfrage_loe.php");
		break;

	case 2:
		include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/module/mod_bausteine/show_wordcloud_loe.php");
		break;

	case 3:
		include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/module/mod_bausteine/show_abstimmung_loe.php");
		break;
		
	case 4: //YouTube Videos
		include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/module/mod_bausteine/show_YouTube.php");
		break;

	case 5: // Evaluation
		include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/module/mod_bausteine/show_evaluation_loe.php");
		break;

	case 6: // Webseiten
		include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/module/mod_bausteine/show_webpage.php");
		break;

	case 8: // Aussagen ordnen
// 		echo "TEST";
		include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/module/mod_bausteine/show_order_statements_loe.php");
		break;
}