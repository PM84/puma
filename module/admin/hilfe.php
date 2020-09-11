<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/header_php.php");
$ausserhalbKurs=1;

include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/session_delay.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/user_login.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/mail.php");
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");

if(isset($_POST['action']) && $_POST['action']=="sendMessage"){
	$userInfo=getUserInfos($_SESSION["uID"]);
	email_versenden($imap_user_name,array($support_email,$userInfo['email']),$_POST['betreff'],$_POST['message']);
}

?>
<html>
	<head>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/head_main.php");?>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/head_backend.php");?>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/plugins/tinymce/include/init_preferences_mail.php");?>
	</head>
	<body>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/header_bar.php");?>

		<div class="container">
			<div class="row" >
				<div class="col-md-3"></div>
				<div class="col-md-6">
					<h2>Support-Anfrage</h2>
					<p>Sollte bei Ihnen ein technisches Problem auftreten, für das sich in der Anleitung keine Lösung findet, können Sie mit nachfolgendem Formular Kontakt mit uns aufnehmen.</p><p>Bitte beschreiben Sie dann das Problem möglichst exakt. Sehr hilfreich sind auch Details, unter welchen Umständen das Problem aufgetreten ist.</p><p style="font-size:9px;">Sie erhalten die Nachricht auch zur Bestätigung per Email!<br>Wir werden uns dann baldmöglichst bei Ihnen melden!</p>
					<form action method="post">
						<input type="hidden" name="action" value="sendMessage">
						<div class="form-group">
							<label>Betreff</label>
							<input type="text" class="form-control" name="betreff">
						</div>
						<div class="form-group">
							<label>Nachricht</label>
							<textarea class="form-control" name="message"></textarea>
						</div>
						<button type="submit">Anfrage absenden!</button>
					</form>
				</div>
				<div class="col-md-3"></div>
			</div>
		</div>

		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/bottom_main.php");?>
	</body>
</html>