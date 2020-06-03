<?php
include($_SERVER['DOCUMENT_ROOT']."/includes/header_php.php");
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
include_once($_SERVER['DOCUMENT_ROOT']."/php/teilnehmer.php");
include($_SERVER['DOCUMENT_ROOT']."/config.php");

$TNListe=getTeilnehmerListeInfos($_SESSION['k']);

if(count($TNListe)==0){echo "<h2>Sie haben noch keine Teilnehmer eingetragen!</h2>"; exit;}

$template=file_get_contents($_SERVER['DOCUMENT_ROOT']."/vorlagen/tmpl_token_uebersicht.php");


?>

<html>
	<head>

	</head>
	<body>

		<?php 
		foreach($TNListe as $TN){
			$token=$TN['token'];
			$width = $height = 150;
			$url   = urlencode("$WorkshopUrl/index.php?t=$token");
			$error = "H"; // handle up to 30% data loss, or "L" (7%), "M" (15%), "Q" (25%)
			$qrCode="<img src=\"http://chart.googleapis.com/chart?"."chs={$width}x{$height}&cht=qr&chld=$error&chl=$url\" />";

			$template_tmp=str_replace ( "{name}" , $TN['vname']." ".$TN['name'] , $template);
			$template_tmp=str_replace ( "{token}" , $token , $template_tmp);
			$template_tmp=str_replace ( "{qrcode}" , $qrCode , $template_tmp);
			$template_tmp=str_replace ( "{url}" , $WorkshopUrl , $template_tmp);

			echo $template_tmp;
		}
		?>

	</body>
</html>