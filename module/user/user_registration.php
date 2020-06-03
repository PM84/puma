<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT']."/php/user_login.php");

$UserListe=GetUserListLogin();

?>

<html>
	<head>
		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/head_main.php");?>
	</head>
	<body>
		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/header_bar.php");?>
		<div class="container">
			<div class="col-md-1"></div>
			<?php include($_SERVER['DOCUMENT_ROOT']."/module/user/user_registration_form.php");?>
			<div class="col-md-1"></div>
		</div>
		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/bottom_main.php");?>
	</body>
</html>