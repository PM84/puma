<?php 
session_start();
include_once($_SERVER['DOCUMENT_ROOT']."/php/schule.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/system.php");
include_once($_SERVER['DOCUMENT_ROOT']."/module/mod_klassenbesuch/fkt_buchung.php");

?>
<html>
	<head>
		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/head_main.php");?>
	</head>
	<body>
		<div class="navmenu navmenu-default navmenu-fixed-left">
			<div style='width:100%; display:block;text-align:center;'>
				<img src="/images/PumaLMU_LS_Logo.png" alt="" height="50">
			</div>
			<ul class="nav navmenu-nav"  style='margin-top:10px;'></ul>
			<ul class="nav navmenu-nav"></ul>
		</div>

		<!--<div class="loginCanv navmenu-default navmenu-fixed-right ">
<?php 

?>
</div>//-->

		<div class="canvas" style="">
			<div class="navbar navbar-default navbar-fixed-top" style="width:100%">
				<div class='row'>
					<div class="col-sm-6" style="height: 55px;text-align:left;">
						<span style="font-size: 24px; font-family: inherit; text-align:left;"><img src="/images/LMU_Logo.png" style="margin:10px;"><span style="margin-top:10px;">Klassenbesuche</span></span>
					</div><div class="col-sm-6" style="text-align:center;">
					</div>

				</div>
			</div>
			<div class="container">
				<?php?>

				<?php 
				if(!isset($_SESSION['uID'])){
					$stayOnSite=1; 
					include($_SERVER['DOCUMENT_ROOT']."/module/user/LoginForm.php");
				}else{
					$TerminListe=getTerminListe();
					foreach($TerminListe as $Termin){
						$TerminID=$Termin['TerminID'];
						$BunchungsInfo=getBuchungen_by_TerminID($TerminID);
				?>
				<h2>
					<?php echo $Termin['titel']." - ".date("d.m.Y",strtotime ( $Termin['start'])). " um ". date("H:i",strtotime ( $Termin['start'])). " Uhr"; ?>
					<?php //echo $Termin['titel']." - ".date("d.m.Y",$Termin['start']). " um ". date("H:i",$Termin['start']). " Uhr"; ?>
				</h2>

				<?php
						if(count($BunchungsInfo)>0){

				?>
				<table class="table table-striped table-responsive">
					<tr><th>#</th><th>Name</th><th>Vorame</th><th>Schule</th><th>Email</th><th>Telefon</th></tr>
					<?php
							foreach($BunchungsInfo as $Buchung){
								
								?>
					<tr><th><?php echo $Buchung['BuchungsID']; ?></th><td><?php echo $Buchung['name']; ?></td><td><?php echo $Buchung['vname']; ?></td><td><?php $SchulInfo=getSchulInfo_by_SchulNr($Buchung['SchulNr']); echo $SchulInfo['Name']; ?></td><td><?php echo $Buchung['email']; ?></td><td><?php echo $Buchung['tel']; ?></td></tr>
					<?php
								}
					?>
				</table>

				<?php
						}else{
							?>
				<h3>
					bisher keine Buchung
				</h3>
				<?php
						}
					}
				}
				?>

			</div>
		</div>
	</body>
</html>