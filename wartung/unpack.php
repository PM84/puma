<?php

$zip = new ZipArchive;
$res = $zip->open('PHPMailer-master.zip');
if ($res === TRUE) {
	$zip->extractTo($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR'].'/includes/phpmailer');
}