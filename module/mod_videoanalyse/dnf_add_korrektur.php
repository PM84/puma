<?php
// ========================
// ========================
// ====== VIDEOANALYSE - KORREKTUR
// ========================
// ========================


session_start();
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
$modID=4; //Bewertungs/Korrektur-Folie

// ========================
// ====== FOLIE ZUM BEARBEITEN LADEN
// ========================
// echo "==".$_SESSION['kID']."==";
if(isset($_SESSION['kID'])){
	$FolieArr=getFolieInfo(intval($_SESSION['kID']));
	$AufgabeInfo=json_decode($FolieArr['parameter']);
	// 	$_SESSION['vID']=$AufgabeInfo->vID;
	if(!isset($AufgabeInfo->fArr)){$AufgabeInfo->fArr=[];}
	if(!isset($AufgabeInfo->fGroupsArr)){$AufgabeInfo->fGroupsArr=[];}
}

// ========================
// ====== Weiterleiten zur Feedbackfolien
// ========================

if(isset($_POST['FBID'])){
	$_SESSION['BewID']=$_SESSION['kID'];
	$_SESSION['kID']=intval($_POST['FBID']);
	echo "<script>window.location = '" . $_SESSION['DOCUMENT_ROOT_DIR']."/module/mod_videovertonung/add_feedback.php';</script>";
}


// ========================
// ====== AUFGABE EINTRAGEN
// ========================

if(isset($_POST['beschreibung'])){
	$aTyp=2; // Korrekturaufgabe

	$taskArr=[];
	$taskArr['titel']=$titel=mysqli_real_escape_string ($verbindung,  htmlentities (mynl2br($_POST['titel']), ENT_QUOTES , "UTF-8"));
	$taskArr['beschreibung']=mysqli_real_escape_string ($verbindung,  htmlentities (mynl2br($_POST['beschreibung']), ENT_QUOTES , "UTF-8"));
	// 	$tArr['KorrTask']=$KorrTask=intval($_POST['KorrTask']);
	// 	$taskArr['gehoertZu']=intval($_SESSION['fID']);
	$zu_fID=intval($_SESSION['fID']);
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
			$tnArr=[];
			foreach($tnArrTmp as $TN){
				array_push($tnArr,intval($TN));
			}
			$taskArr['tnarr']=$tnArr;
			break;
		case 1:
			break;
	}
	$fGroups=$_POST['fGroups'];
	$fGroupsArr=[];
	foreach($fGroups as $frageGruppeID){
		array_push($fGroupsArr,intval($frageGruppeID));
	}
	$taskArr['fGroupsArr']=$fGroupsArr;

	$FragenIDs=$_POST['fIDs'];
	$fArr=[];
	foreach($FragenIDs as $frageID){
		array_push($fArr,intval($frageID));
	}
	$taskArr['fArr']=$fArr;

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
		unset($_SESSION['kID']);
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
	</head>
	<body>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/header_bar.php");?>

		<div class="container" style="margin-bottom:150px;">

			<div class="row" style=''>
				<div class="col-md-1"></div>
				<div class="col-md-10">
					<div class="row" style='margin-top:10px; text-align:center; background-color:lightgray; padding:10px; border-radius: 10px;'>
				<div class="col-md-1"><a href='<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/module/mod_videovertonung/add_task.php' class='btn btn-success'>zurück</a></div>
				<div class="col-md-10"><p class="lead" style='margin:0'>Korrekturaufgabe zur Videovertonung hinzufügen</p></div>
				<div class="col-md-1"></div>
					</div>
				</div>
				<div class="col-md-1"></div>
			</div>
			<div class="row" style=''>
				<!--<div class="col-md-1"></div>//-->
				<div class="col-md-2">
				</div>
				<div class="col-md-6">
					<h2>Einstellungen</h2>
					<form action='' method="POST" style='margin:0;'>
						<input type="hidden" value='<?php if(isset($_SESSION['fID'])){echo intval($_SESSION['fID']);} ?>' name='fID'>
						<input type="hidden" value='<?php if(isset($_SESSION['kID'])){echo intval($_SESSION['kID']);} ?>' name='kID'>
						<p class="lead" style='margin-top:25px'>Allgemein</p>
						<div class="form-group">
							<label for="titel">Titel</label>
							<input id='titel' type="text" class="form-control" name="titel" placeholder="Titel der Aufgabe" required value='<?php if(isset($AufgabeInfo->titel)){echo html_entity_decode ($AufgabeInfo->titel, ENT_QUOTES , "UTF-8");} ?>'>
						</div>
						<div class="form-group">
							<label for="beschreibung">Beschreiben Sie die Aufgabe</label>
							<textarea class="form-control" id="beschreibung" name='beschreibung' rows="3"><?php if(isset($AufgabeInfo->beschreibung)){echo $AufgabeInfo->beschreibung;} ?></textarea>
						</div>
						<p class="lead" style='margin-top:25px'>Fragen</p>
						<div class="form-group">
							<label for="fGroups">Fragengruppe auswählen</label>
							<select class="form-control"  name="fGroups[]" id="fGroups"  multiple>
								<?php
								$fGruppen=Get_Fragen_Gruppen($uID);
								foreach($fGruppen as $fGruppe){
									$fGruppeParameter=json_decode($fGruppe['parameter']);
								?>
								<option value="<?php  echo $fGruppe['FGroupID']; ?>" <?php if(isset($AufgabeInfo)){if(is_array($AufgabeInfo->fGroupsArr)){if(in_array($fGruppe['FGroupID'],$AufgabeInfo->fGroupsArr)){echo "selected";} }}?>><?php echo html_entity_decode ($fGruppeParameter->GroupTitel, ENT_QUOTES , "UTF-8"); ?></option>
								<?php
								}
								?>
							</select>
						</div>
						<div class="form-group">
							<label for="fIDs">und/oder Fragen auswählen</label>
							<select class="form-control"  name="fIDs[]" id="fIDs"  multiple>
								<?php
								$fragen=getFragenByUser($uID);
								foreach($fragen as $frage){

									
									$frageParameter=json_decode($frage['parameter']);
								?>
								<option value="<?php echo $frage['FrageID']; ?>" <?php if(isset($AufgabeInfo)){if(is_array($AufgabeInfo->fArr)){if(in_array($frage['FrageID'],$AufgabeInfo->fArr)){echo "selected";} }}?>><?php echo html_entity_decode ($frageParameter->titel, ENT_QUOTES , "UTF-8"); ?></option>
								<?php
								}
								?>
							</select>
						</div>
<!--						<div class="checkbox">
							<label>
								<input name='FBTask'  type="checkbox" data-toggle="toggle" data-on="Ja" data-off="Nein" data-onstyle="success" data-offstyle="danger" value=1>
								Soll ein (weiteres) Feedback zu dieser Aufgabe erstellt werden?
							</label>
						</div>
//-->						<p class="lead" style='margin-top:25px'>Anzeige</p>
						<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/folieAnzeigeOptionen.php") ?>

						<input type="submit" class="btn btn-primary" style='' value="<?php if(isset($_SESSION['kID'])){echo "Aufgabe updaten";}else{echo "Aufgabe eintragen";}  ?>">
					</form>
				</div>

				<div class="col-md-3">
					<p class="lead" style='margin:0'>zugeordnete Feedbackfolien</p>
					<?php 
					if(isset($_SESSION['fID'])){
						$zu_folien_array=Get_zugeordnete_Folien_by_module(intval($_SESSION['kID']),5);
						foreach($zu_folien_array as $folie){
							$parameter=json_decode($folie['parameter']);
					?>
					<form action='' method="POST" style='margin:0;'>
						<input type=hidden value='<?php echo $folie['fID']; ?>' name='FBID'><input type="submit" class="btn btn-default" style='width:100%' value="<?php echo  html_entity_decode ($parameter->titel, ENT_QUOTES , "UTF-8"); ?>">
					</form>

					<?php
						}
					}else{
						echo "Keine zugeordneten Feedbackfolien vorhanden!";
					}
					?>
<br>
					<form action='' method="POST" style='margin:0;' accept-charset="UTF-8">
						<input type=hidden value='0' name='FBID'><button type="submit" class="btn btn-success" style='width:100%'><span class="glyphicon glyphicon-plus" ></span> Neue Korrekturfolie hinzufügen</button>
					</form>	

				</div>
				<div class="col-md-1"></div>
			</div>
		</div>

		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/bottom_main.php");?>
	</body>
</html>