<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT']."/php/system.php");

?>

<html>
	<head>
		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/head_main.php");?>
	</head>
	<body>
		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/header_bar.php");?>

		<div class="container">

			<div class="row" style='margin-top:50px;'>
				<div class="col-md-4"></div>
				<div class="col-md-4">
					<?php
					if(!isset($_SESSION['uID']) || intval($_SESSION['uID'])==0){
						include($_SERVER['DOCUMENT_ROOT']."/module/user/LoginForm.php");
					}
					if(isset($_SESSION['uID']) && intval($_SESSION['uID'])>0){
						include($_SERVER['DOCUMENT_ROOT']."/module/user/LogoutForm.php"); 
					}				echo '<br><br><p style="text-align:center">Version: '.get_siteInfo('CMS-Version').' vom '.get_siteInfo('CMS-DATUM').'</p>';

					?>
				</div>
				<div class="col-md-4"></div>
			</div>
		</div>

		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/bottom_main.php");?>
	</body>
</html>