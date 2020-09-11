<?php
// ========================
// ========================
// ====== VIDEOANALYSE - FEEDBACK
// ========================
// ========================


if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/header_php.php");
$ausserhalbKurs=1;

include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/session_delay.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/kursInfos.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/Sessions.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/videos.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/folie.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/frage.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/system.php");
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");

$SessionInfos=Get_SessionInfos($_SESSION['s']);
$uID=$SessionInfos['uID'];
$modID=5; //Feedback-Folie

// ========================
// ====== FOLIE ZUM BEARBEITEN LADEN
// ========================
if(isset($_SESSION['kID'])){
	$FolieArr=getFolieInfo(intval($_SESSION['kID']));
	$AufgabeInfo=json_decode($FolieArr['parameter']);
	// 	$_SESSION['vID']=$AufgabeInfo->vID;
}



// ========================
// ====== AUFGABE EINTRAGEN
// ========================

if(isset($_POST['beschreibung'])){
	$aTyp=3; // Feedbackaufgabe

	$taskArr=array();
	$taskArr['titel']=mysqli_real_escape_string ($verbindung,  htmlentities (mynl2br($_POST['titel']), ENT_QUOTES , "UTF-8"));
	$taskArr['beschreibung']=mysqli_real_escape_string ($verbindung,  htmlentities (mynl2br($_POST['beschreibung']), ENT_QUOTES , "UTF-8"));
	// 	$tArr['KorrTask']=$KorrTask=intval($_POST['KorrTask']);
	// 	$taskArr['gehoertZu']=intval($_SESSION['edit_fID']);
	$zu_fID=intval($_SESSION['BewID']);
	if(isset($_SESSION['kID'])){
		$kID=intval($_SESSION['kID']);
	}else{
		$kID=0;
	}
	$fID=0;
	$viewTyp=intval($_POST['viewTyp']);
	switch($viewTyp){
		default:
			$tnArrTmp=$_POST['tnarr'];
			$tnArr=array();
			foreach($tnArrTmp as $TN){
				array_push($tnArr,intval($TN));
			}
			$taskArr['tnarr']=$tnArr;
			break;
		case 1:
			break;
	}

	if(isset($_POST['FBTask'])){
		if(intval($_POST['FBTask'])==1){
			$redirect=1;
		}else{
			$redirect=0;
		}
	}else{
		$redirect=0;
	}
	$parameter=json_encode($taskArr);
	$redirectStatus=add_folie($parameter,$modID,$viewTyp,$kID,$redirect,$aTyp,$zu_fID,0);
	if($redirectStatus==1){
		echo "<script>window.location = '" . $_SESSION['DOCUMENT_ROOT_DIR']."/module/mod_videovertonung/add_feedback.php';</script>";
	}else{
		unset($_SESSION['kID']);
		echo "<script>window.location = '" . $_SESSION['DOCUMENT_ROOT_DIR']."/module/mod_videovertonung/add_task.php';</script>";
	}
}

?>

<html>
	<head>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/head_main.php");?>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/head_backend.php");?>
	</head>
	<body>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/header_bar.php");?>

		<div class="container" style="margin-bottom:150px;">

			<div class="row" style=''>
				<div class="col-md-1"></div>
				<div class="col-md-10">
					<div class="row" style='margin-top:10px; text-align:center; background-color:lightgray; padding:10px; border-radius: 10px;'>
						<div class="col-md-1"><a href='<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/module/mod_videovertonung/add_task.php' class='btn btn-success'>zurück</a></div>
						<div class="col-md-10"><p class="lead" style='margin:0'>Feedback zur Videovertonung hinzufügen</p></div>
						<div class="col-md-1"></div>
					</div>
				</div>
				<div class="col-md-1"></div>
			</div>
			<div class="row" style=''>
				<!--<div class="col-md-1"></div>//-->
				<div class="col-md-3">
				</div>
				<div class="col-md-6">
					<h2>Einstellungen</h2>
					<form action='' method="POST" style='margin:0;'>
						<input type="hidden" value='<?php if(isset($_SESSION['edit_fID'])){echo intval($_SESSION['edit_fID']);} ?>' name='fID'>
						<input type="hidden" value='<?php if(isset($_SESSION['kID'])){echo intval($_SESSION['kID']);} ?>' name='kID'>
						<p class="lead" style='margin-top:25px'>Allgemein</p>
						<div class="form-group">
							<label for="titel">Titel</label>
							<input id='titel' type="text" class="form-control" name="titel" placeholder="Titel der Aufgabe" required value='<?php if(isset($AufgabeInfo->titel)){echo  html_entity_decode ($AufgabeInfo->titel, ENT_QUOTES , "UTF-8");} ?>'>
						</div>
						<div class="form-group">
							<label for="beschreibung">Beschreiben Sie die Aufgabe</label>
							<textarea class="form-control" id="beschreibung" name='beschreibung' rows="3"><?php if(isset($AufgabeInfo->beschreibung)){echo html_entity_decode ($AufgabeInfo->beschreibung, ENT_QUOTES , "UTF-8");} ?></textarea>
						</div>
						<p class="lead" style='margin-top:25px'>Anzeige</p>
						<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/folieAnzeigeOptionen.php") ?>

						<input type="submit" class="btn btn-primary" style='' value="<?php if(isset($_SESSION['kID'])){echo "Aufgabe updaten";}else{echo "Aufgabe eintragen";}  ?>">
					</form>
					<div class="col-md-3">
					</div>
				</div>
			</div>
		</div>

		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/bottom_main.php");?>
	</body>
</html>