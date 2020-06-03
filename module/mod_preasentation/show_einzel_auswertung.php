<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT']."/includes/session_delay_token.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/kursInfos.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/Sessions.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/folie.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/videos.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/simulationen.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/abgabe.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/system.php");
include($_SERVER['DOCUMENT_ROOT']."/config.php");
// $_SESSION['fID']=intval($_GET['f']);
$token=$_SESSION['t'];
$abgabeErforderlich=0; // Definition der Variable auf Standardwert 0 -> kein "Ich bin fertig" Button wird angezeigt, falls er nicht von der Folieneinstellung geforfert wird.
$fID=$_SESSION['fID'];
$FolieInfo=getFolieInfo($fID);
$abgegeben=2;  // NUR für Auswertungsseite
?>

<html>
	<head>
		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/head_main.php");?>
		<script type="text/javascript" src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS_HTML"></script>
	</head>
	<body>
		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/header_bar.php");?>
		<div class="container">
			<div class="row">
				<div class="col-xs-1"></div>
				<div class="col-xs-10">


					<?php switch($FolieInfo['modID']){
	case 9:
		include($_SERVER['DOCUMENT_ROOT']."/module/mod_fotowettbewerb/show_fw_loe.php");
		break;
}
					?>
				</div>
				<div class="col-xs-1"></div>
			</div>
		</div>
		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/bottom_main.php");?>
	</body>
</html>