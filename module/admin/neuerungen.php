<?php
// ========================
// ========================
// ====== NEUERUNGEN
// ========================
// ========================
include($_SERVER['DOCUMENT_ROOT']."/includes/header_php.php");
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
$ausserhalbKurs=1;
include_once($_SERVER['DOCUMENT_ROOT']."/includes/session_delay.php");
include($_SERVER['DOCUMENT_ROOT']."/config.php");

?>


<html>
	<head>
		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/head_main.php");?>
		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/head_backend.php");?>
		<?php include($_SERVER['DOCUMENT_ROOT']."/plugins/tinymce/include/init_pfreferences_min.php");?>
	</head>
	<body>
		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/header_bar.php");?>
		<div class="container">
			<h4>14.07.2017 (Version 2.032)</h4>
			<p>
				Mit dieser Version werden auch der Internet Explorer (IE) sowie der Edge Browser von Microsoft beim speichern und abgeben unterstützt!
			</p>
		</div>
	</body>
</html>