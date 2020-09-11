<?php
// ========================
// ========================
// ====== FOTOWETTBEWERB erstellen
// ========================
// ========================
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/header_php.php");
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
$ausserhalbKurs=1;
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/session_delay.php");

// include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/kursInfos.php");
// include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/Sessions.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/system.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/videos.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/simulationen.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/folie.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/kursInfos.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/teilnehmer.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/module.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/media.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/bausteine.php");


// ========================
// ====== SESSION VARIABLEN LEEREN und ZURÜCK
// ========================
if(isset($_POST['btn_back']) && intval($_POST['btn_back'])==1){
	echo "<script>window.location = '" . $_SESSION['DOCUMENT_ROOT_DIR']."/module/admin/folie_erstellen.php';</script>";
	exit;
}

// ========================
// ====== EINSTELLUNGEN LADEN
// ========================

$KursListe=GetKursListeInfos($_SESSION['uID'],1,1);
$Bs_ListeInfos=getBausteineListeInfos($_SESSION['uID'],1);
$modTitel="Fotowettbewerb";
$modID=getModIDFromTitel($modTitel);



// ========================
// ====== AUFGABE EINTRAGEN
// ========================
if(isset($_POST['titel']) && strlen($_POST['titel'])>0){
	$insertArr=array();
	$bsArr=array();
	foreach($_POST as $key => $value){
		$Tempkey=mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($key), ENT_QUOTES , "UTF-8"));
		$Tempvalue=mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($value), ENT_QUOTES , "UTF-8"));
		$insertArr[$Tempkey]=$Tempvalue;
	}
	$viewTyp=intval($_POST['viewTyp']);
	switch($viewTyp){
		default:
			if(isset($_POST['tnarr'])){
				$tnArrTmp=$_POST['tnarr'];
				$tnArr=array();
				foreach($tnArrTmp as $TN){
					array_push($tnArr,intval($TN));
				}
			}else{
				$tnArr=array();
			}
			$insertArr['tnarr']=$tnArr;
			break;
		case 1:
			break;
	}
	$parameter=json_encode($insertArr);

	// 	$redirect=0; // KEIN BESONDERER REDIRECT NÖTIG!
	$redirect=intval($_POST['savePraes']);
	if(isset($insertArr['CopyToKursID']) && intval($insertArr['CopyToKursID'])>0){$CopyToKursID=$insertArr['CopyToKursID'];}else{$CopyToKursID=0;}

	loop_match_table($parameter);
	$redirectStatus=add_folie($parameter,$modID,$viewTyp,$_SESSION['edit_fID'],$redirect,1,0,$CopyToKursID,$bsArr);
	// echo $redirectStatus;
	if($redirectStatus==2){
		echo "<script>window.location = '" . $_SESSION['DOCUMENT_ROOT_DIR']."/module/admin/folie_erstellen.php';</script>";
	}elseif($redirectStatus==3){
		$preview_tnInfo=get_preview_teilnehmer($_SESSION['uID']);
		$_SESSION['t']=$preview_tnInfo['token'];
		$KursInfos=GetKursInfos(intval($_SESSION['k']));
		$_SESSION['kTyp']=$KursInfos['kTyp'];
		$FolieInfo=getFolieInfo($_SESSION['edit_fID']);
		$parameterFolie=json_decode($FolieInfo['parameter']);
		$modID=$FolieInfo['modID'];
		$modInfo=getModulInfos($modID);
		$_SESSION['kursID']=$_SESSION['k'];
		$FoliePath="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/".$modInfo['mod_dir']."/".$modInfo['mod_show']."?f=".$_SESSION['edit_fID'];

?>
<script>
	var win = window.open('<?php echo $FoliePath; ?>', '_blank');
	if (win) {
		//Browser has allowed it to be opened
		win.focus();
	} else {
		//Browser has blocked it
		alert('Bitte erlauben Sie PopUps um direkt zur Vorschau zu gelangen!');
	}
</script>
<?php
	}
}


// ========================
// ====== FOLIE ZUM BEARBEITEN LADEN
// ========================
if($_SESSION['edit_fID']>0){
	// 	echo "Folie wird geladen";

	$FolieArr=getFolieInfo(intval($_SESSION['edit_fID']));
	$AufgabeInfo=json_decode($FolieArr['parameter'],true);
	// 	echo "==".$_SESSION['bereitsgeladen']."==";
/* 	if(!isset($_SESSION['bereitsgeladen'])){
		// echo "Folie wird geladen";
		$_SESSION['DesignTyp']=$AufgabeInfo['DesignTyp'];

		// Einstellungen Allgemein laden
		if(isset($AufgabeInfo["Baustein_top"])){
			$_SESSION['Baustein_top']=$AufgabeInfo["Baustein_top"];
		}
		if(isset($AufgabeInfo["Baustein_bottom"])){
			$_SESSION['Baustein_bottom']=$AufgabeInfo["Baustein_bottom"];
		}
		for($iLauf=1;$iLauf<=$_SESSION['DesignTyp'];$iLauf++){
			if(isset($AufgabeInfo['Baustein_'.$iLauf])){
				$_SESSION['Baustein_'.$iLauf]=$AufgabeInfo['Baustein_'.$iLauf];
			}else{$_SESSION['Baustein_'.$iLauf]="";}
		}

		// Einstellungen Video laden
		if(isset($AufgabeInfo["tem_vID_top"])){
			$_SESSION['tem_vID_top']=$AufgabeInfo["tem_vID_top"];
		}else{$_SESSION['tem_vID_top']="";}

		for($iLauf=1;$iLauf<=$_SESSION['DesignTyp'];$iLauf++){
			if(isset($AufgabeInfo['tem_vID_'.$iLauf])){
				$_SESSION['tem_vID_'.$iLauf]=$AufgabeInfo['tem_vID_'.$iLauf];
			}else{$_SESSION['tem_vID_'.$iLauf]="";}
		}

		if(isset($AufgabeInfo["tem_vID_bottom"])){
			$_SESSION['tem_vID_bottom']=$AufgabeInfo["tem_vID_bottom"];
		}else{$_SESSION['tem_vID_bottom']="";}


		// Einstellungen Simulation laden
		if(isset($AufgabeInfo["tem_simID_top"])){
			$_SESSION['tem_simID_top']=$AufgabeInfo["tem_simID_top"];
		}else{$_SESSION['tem_simID_top']="";}

		for($iLauf=1;$iLauf<=$_SESSION['DesignTyp'];$iLauf++){
			if(isset($AufgabeInfo['tem_simID_'.$iLauf])){
				$_SESSION['tem_simID_'.$iLauf]=$AufgabeInfo['tem_simID_'.$iLauf];
			}else{$_SESSION['tem_simID_'.$iLauf]="";}
		}

		if(isset($AufgabeInfo["tem_simID_bottom"])){
			$_SESSION['tem_simID_bottom']=$AufgabeInfo["tem_simID_bottom"];
		}else{$_SESSION['tem_simID_bottom']="";}

		// Einstellungen Bausteine laden (Wordcloud Kontrollfragen Umfragen etc.)
		for($iLauf=1;$iLauf<=$_SESSION['DesignTyp'];$iLauf++){
			if(isset($AufgabeInfo['bID_'.$iLauf])){
				$_SESSION['bID_'.$iLauf]=$AufgabeInfo['bID_'.$iLauf];
			}else{$_SESSION['bID_'.$iLauf]="";}
		}

		$_SESSION['bereitsgeladen']=1;
	} */
}
?>

<html>
	<head>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/head_main.php");?>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/head_backend.php");?>
		<script src="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/plugins/tinymce/js/tinymce/tinymce.min.js"></script>
	</head>
	<body>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/header_bar.php");?>
		<div class="container">
			<div class="row">
				<div class="col-md-1"></div>
				<div class="col-md-10">
					<div class="row" style=' text-align:center; background-color:lightgray; padding:10px; border-radius: 10px;'>
						<div class="col-md-1">
							<form id="backForm" action="" method="POST" style="margin:0;">
								<button type=submit  class='btn btn-success hidden-xs hidden-sm' name="btn_back" value=1>zurück</button>
							</form>
							<!--							<a href='<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/module/admin/folie_erstellen.php' class='btn btn-success'>zurück</a>//-->
						</div>
						<div class="col-md-10"><p class="lead" style='margin:0'>Fotowettbewerb hinzufügen</p></div>
						<div class="col-md-1"></div>
					</div>
				</div>
				<div class="col-md-1"></div>
			</div>
			<div class="row" style="margin-top:25px;">
				<div class="col-md-3"></div>
				<div class="col-md-6">
					<form id="backForm" action="" method="POST" style="margin:0;">
						<div class="form-group">
							<label for="titel">Titel</label>
							<input id='titel' type="text" class="form-control" name="titel" placeholder="Titel der Folie" required value='<?php if(isset($AufgabeInfo["titel"])){echo html_entity_decode ($AufgabeInfo["titel"], ENT_QUOTES , "UTF-8");} ?>'>
						</div>
						<div class="form-group">
							<label for="viewTyp">Durch jede Abgabe eines Fotos wird eine neue Folie zur Bewertung erstellt.<br> Wählen Sie den Kurs aus, zu dem die Bewertungsfolie hinzugefügt werden soll:</label>
							<select class="form-control" id="addToKurs" name='addToKurs' required>
								<option value="">Bitte auswählen</option>
								<?php 
	foreach($KursListe as $Kurs){
								?>
								<option value='<?php echo $Kurs['kursID'];?>' <?php if(isset($AufgabeInfo['addToKurs'])){if($AufgabeInfo['addToKurs']==$Kurs['kursID']){echo "selected";}} ?>><?php echo $Kurs['titel'];?></option>
								<?php
	}
								?>
							</select>
						</div>

						<div class="form-group">
							<label for="viewTyp">Wählen Sie den Evaluationsbaustein aus, der den Bewertenden, neben den Bildern der Schüler angezeigt werden soll:</label>
							<select class="form-control" id="add_baustein" name='add_baustein' required>
								<option value="">Bitte auswählen</option>
								<?php 
	foreach($Bs_ListeInfos[5] as $baustein){
		$bs_Info=json_decode($baustein['parameter'],true);
								?>
								<option value='<?php echo $baustein['bID'];?>' <?php if(isset($AufgabeInfo['add_baustein'])){if($AufgabeInfo['add_baustein']==$baustein['bID']){echo "selected";}} ?>><?php echo $bs_Info['titel'];?></option>
								<?php
	}
								?>
							</select>
						</div>
						<div>
							<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/folieAnzeigeOptionen.php") ?>
						</div>

						<button type=submit  class='btn btn-default' name="savePraes" value='2' >Speichern & Schließen</button>
						<button type=submit  class='btn btn-primary' name="savePraes" value='1' >Speichern</button>
					</form>
				</div>
				<div class="col-md-3"></div>
			</div>
		</div>
	</body>
</html>