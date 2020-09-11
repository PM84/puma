<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/header_php.php");

$ausserhalbKurs=1;

include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/session_delay.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/kursInfos.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/Sessions.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/bausteine.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/module.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/folie.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
$SessionInfos=Get_SessionInfos($_SESSION['s']);
$uID=$SessionInfos['uID'];
$_SESSION['uID']=$uID;
$modTitel="Bausteine";
$modID=getModIDFromTitel($modTitel);
$bsmodInfo=getModulInfos($modID);



unset($_SESSION['fID']);
// ========================
// ====== KURSID IN SESSION SCHREIBEN
// ========================

if(isset($_POST['k'])){
	$kursID=intval($_POST['k']);
	$_SESSION['kursID']=$kursID;
	unset($_POST['k']);
}

// ========================
// ====== bTypID IN SESSION SCHREIBEN UND WEITERLEITEN
// ========================

if(isset($_POST['ziel_bTypID'])){
	unset($_SESSION['edit_bID']);
	$_SESSION['edit_bTypID']=intval($_POST['ziel_bTypID']);
	if(isset($_POST['bID'])){$_SESSION['edit_bID']=$_POST['bID'];}
	echo "<script>window.location = '" . $_SESSION['DOCUMENT_ROOT_DIR']."/".$bsmodInfo['mod_dir']."/add_task.php';</script>";
}


/* 
if(isset($_POST['fID'])){
	$_SESSION['fID']=intval($_POST['fID']);
	unset($_POST['fID']);
	redirectTo_addTask(intval($_SESSION['fID']));
} */
?>
<html>
	<head>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/head_main.php");?>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/head_backend.php");?>
	</head>
	<body>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/header_bar.php");?>

		<div class="container">
			<div class="row">
				<div class="col-md-12" style='text-align:center;'><p class="lead" style='margin-bottom:5px;'>Bausteine sind standardmäßig in all Ihren Kursen verfügbar.</p></div>
			</div>
			<div class="row" style='margin-top:50px;'>
				<div class="col-md-2"></div>

				<div class="col-md-4">
					<p class="lead">Bausteintyp zum Hinzufügen auswählen</p>
					<?php
					$bsArrTyp=getBausteineTypen(1,1);
					foreach($bsArrTyp as $bs){
						if($bs['show']==0){continue;}
					?>
					<form action="" method="post" style='margin: 2 0 2 0'>
						<input type="hidden" name='ziel_bTypID' value="<?php echo $bs['bTypID']; ?>">
						<button class="btn btn-default"  style='width:100%'  type="submit"><?php echo $bs['titel']; ?></button>
					</form>
					<?php
					}
					?>
				</div>
				<div class="col-md-4">
					<p class="lead">Ihre Bausteine</p>
					<?php $Block=0; include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/module/mod_bausteine/baustein_auswahl_panel.php"); ?>
				</div>
				<div class="col-md-2"></div>
			</div>
		</div>

		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/bottom_main.php");?>
	</body>
</html>