<?php
session_start();
include($_SERVER['DOCUMENT_ROOT']."/config.php");
include_once($_SERVER['DOCUMENT_ROOT']."/module/mod_preasentation/praesentationseinstellungen.php");
$kursID=intval($_SESSION['k']);

$i=1;
foreach ($_POST['folie'] as $fID) {
	InsertOrderSetting($fID,$kursID,$i);
	$i++;
}
var_dump($_POST);