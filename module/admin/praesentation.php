<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/header_php.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/session_delay.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/kursInfos.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/Sessions.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/module.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/folie.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/module/mod_preasentation/praesentationseinstellungen.php");
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");

$ausserhalbKurs=1;

$SessionInfos=Get_SessionInfos($_SESSION['s']);
$uID=$SessionInfos['uID'];
unset($_SESSION['fID']);

// ========================
// ====== KURSID IN SESSION SCHREIBEN
// ========================

if(isset($_POST['k'])){
	unset($_SESSION['fID_praes']);
	$kursID=intval($_POST['k']);
	$_SESSION['k']=$kursID;
	unset($_POST['k']);
}

// ========================
// ====== fID IN SESSION SCHREIBEN UND WEITERLEITEN
// ========================

if(isset($_POST['fID'])){
	$_SESSION['edit_fID']=intval($_POST['fID']);
	unset($_POST['fID']);
	redirectTo_addTask(intval($_SESSION['fID']));
}



// ========================
// ====== PRÄSENTATIONSEINSTELLUNGEN SPEICHERN
// ========================

if(isset($_POST['saved'])){
	if(!isset($_POST['show_beginn'])){$_POST['show_beginn']=0;}
	if(!isset($_POST['show_aktiv'])){$_POST['show_aktiv']=0;}
	if(!isset($_POST['show_freigabe'])){$_POST['show_freigabe']=0;}
	if(!isset($_POST['show_nach_bearb'])){$_POST['show_nach_bearb']=0;}
	if(!isset($_POST['show_auto'])){$_POST['show_auto']=0;}

	$parameterArr=array(
		'show_beginn'=>intval($_POST['show_beginn']),
		'show_aktiv'=>intval($_POST['show_aktiv']),
		'show_freigabe'=>intval($_POST['show_freigabe']),
		'show_nach_bearb'=>intval($_POST['show_nach_bearb']),
		'show_auto'=>intval($_POST['show_auto']),
	);
	save_einstellungen($parameterArr);
	unset($_SESSION['fID_praes']);
}


// ========================
// ====== PRÄSENTATIONSEINSTELLUNGEN LADEN
// ========================
// var_dump($_POST);
if(isset($_POST['action']) && $_POST['action']=="edit"){
	// isset($_POST['fID_praes']) &&
	$_SESSION['fID_praes']=intval($_POST['fID_praes']);
	$PraesentationsRow=load_einstellungen($_SESSION['fID_praes'],$_SESSION['k']);
	$PraesentationsSetting=json_decode($PraesentationsRow['parameter']);
	unset($_POST['fID_praes']);
}

// ========================
// ====== FOLIE LÖSCHEN
// ========================
// var_dump($_POST);
if(isset($_POST['action']) && $_POST['action']=="delete"){
	// isset($_POST['fID_praes']) &&
	$del_fID=intval($_POST['fID_praes']);
	delete_folie($del_fID);
	unset($_POST);
}


// ========================
// ====== FOLIE AUSBLENDEN
// ========================

if(isset($_POST['action']) && $_POST['action']=="aktivStatus"){
	changeAktivStatus(intval($_POST['fID_praes']));
}

?>

<html>
	<head>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/head_main.php");?>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/head_backend.php");?>
		<link rel="stylesheet" type="text/css" href="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/js/jqueryUI/jquery-ui.css">
		<script src="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/js/jqueryUI/jquery-ui.min.js"></script>

	</head>
	<body>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/header_bar.php");?>

		<div class="container">
			<div class="row" style='margin-top:50px;'>
				<div class="col-md-1"></div>
				<div class="col-md-3">
					<p class="lead">Ihre Kurse mit Präsentationen</p>
					<?php
					$Kurse=GetKursListeInfos($uID,2,1);
					foreach($Kurse as $KursInfo){
					?>
					<form action='' method="POST" style='margin:0;' accept-charset="UTF-8">
						<input type=hidden value='<?php  echo $KursInfo['kursID']; ?>' name='k'>
						<input type="submit" class="btn <?php if(isset($_SESSION['k']) && $_SESSION['k']==$KursInfo['kursID']){echo "btn-primary";}else{echo "btn-default";}?>" style='width:100%' value="<?php echo $KursInfo['titel']; ?>">
					</form>
					<?php
					}
					?>
				</div>
				<div class="col-md-4">
					<p class="lead">Ablauf des Kurses steuern</p>
					<?php
					if(isset($_SESSION['k'])){
						$KursInfo=GetKursInfos(intval($_SESSION['k']));
						$_SESSION['kTyp']=$KursInfo['kTyp'];
						$FolienListe=getFolienListeInfos_ORDER_all(intval($_SESSION['k']));
						$FolienListe=drop_aTyp($FolienListe,2);
						$FolienListe=drop_aTyp($FolienListe,3);
					?>
					<!--					<p class="" style='margin-bottom:5px;;'>ausgewählter Kurs: <b style='font-size:20px;'><?php echo $KursInfo['titel']; ?></b></p>//-->

					<style>
						.placeholder {
							border: 1px solid green;
							background-color: white;
							-webkit-box-shadow: 0px 0px 10px #888;
							-moz-box-shadow: 0px 0px 10px #888;
							box-shadow: 0px 0px 10px #888;
						}
						.tile {
							padding:15px;
							min-height: 50px;
						}
						.grid {
							margin-top: 5px;
						}
						.totWidth{
							width:100%;
						}
						.well{
							margin-bottom:5px;
						}

						-webkit-appearance: none;
						outline: 0;
						}
						input[type=checkbox]:checked {
							background-image: url('/images/on_off32.png');
						}
						input[type=checkbox]:not(:checked) {
							background-image: url('/images/on_off32.png');
							background-position:-32px 50%;
						} */

					</style>
					<script>
						$(function () {
							$(".grid").sortable({
								tolerance: 'pointer',
								revert: 'invalid',
								placeholder: 'totWidth well placeholder tile',
								forceHelperSize: true,
								update: function (event, ui) {
									var data = $(this).sortable('serialize');
									$.ajax({
										data: data,
										type: 'POST',
										url: 'praesentation_order.php',
										dataType: 'text',
										success:function(data2) {
											console.log(data2);
										}
									}); 
								}
							});
						});

					</script>

					<div class="row grid totWidth" style=margin-left:0>
						<?php
						// 						var_dump($FolienListe);
						foreach($FolienListe as $folie){
							// 							var_dump($folie);
							$parameter=json_decode($folie['parameter']);
							if(isset($folie['noOrder'])){

								// Änderungen der default Parameter müssen auch in der Datei praesentation_order.php vorgenommen werden.
								$defaultParameter='{"show_beginn":1,"show_aktiv":1,"show_freigabe":0,"show_nach_bearb":1,"show_auto":0}';
								// 								$noOrder=" noOrder";
								// 								$toolTip=" data-toggle='tooltip' data-placement='top' title='Diese Folie wurde noch nicht einsortiert. Bitte sortieren Sie die Folien und laden Sie die Seite erneut.'";
								insertFolieToMaster($folie['fID'],$_SESSION['k'],$defaultParameter);
							}else{
								$noOrder="";
								$toolTip="";
							}

						?>
						<div id="folie-<?php echo $folie['fID']; ?>" class="well totWidth tile <?php 
							if($_SESSION['fID_praes']==$folie['fID']){ echo "FolieSelected";}
							echo $noOrder ." ". $toolTip; ?>">
							<b><?php echo $parameter->titel; ?></b>
							<span style='float:right;' class="glyphicon glyphicon-option-vertical"></span>

							<?php if($_SESSION['kTyp']==2){ ?>
							<form action="" method="post" style='float:right;'>
								<input type="hidden" name="action" value="edit">
								<input type='hidden' name='fID_praes' value="<?php echo  $folie['fID']; ?>">
								<button type="submit" class="FolieButton"><span class="glyphicon glyphicon-edit"></span></button>
							</form>
							<?php } ?>


							<form id="form_<?php echo $folie['fID']; ?>_delete" action="" method="post" style='float:right;' onsubmit="return confirm('Bitte bestätigen Sie das unwiderrufliche Löschen der Folie und all seiner Verknüpfungen!');">
								<input type="hidden" name="action" value="delete">
								<input type='hidden' name='fID_praes' value="<?php echo  $folie['fID']; ?>">
								<button type="submit" class="FolieButton"><span class="glyphicon glyphicon-trash"></span></button>
							</form>




							<form id="form_<?php echo $folie['fID']; ?>_aktivStatus" action="" method="post" style='float:right;'>
								<button style="width: 16px; margin-right: 5px;border: none; background:none;" type="submit"> 
									<span style="cursor:pointer; display: inline-block; background-size: cover; background-repeat: no-repeat;background-image: url('/images/on_off32.png'); width:16px; height:16px; <?php $AblaufInfo=load_einstellungen($folie['fID'],$_SESSION['k']); if(isset($AblaufInfo['aktiv']) && $AblaufInfo['aktiv']==0){echo "background-position:-16px;";}?>" <?php if(isset($AblaufInfo['aktiv']) && $AblaufInfo['aktiv']==0){echo " data-toggle='tooltip' data-placement='top' title='Folie ist für Teilnehmer nicht sichtbar.'";}else{echo " data-toggle='tooltip' data-placement='top' title='Klicken um Folie zu verstecken.'";}  ?>></span>
								</button>
								<input type="hidden" name="action" value="aktivStatus">
								<input type='hidden' name='fID_praes' value="<?php echo  $folie['fID']; ?>">
							</form>

							<span style='float:right;'><?php echo  "(id: ".$folie['fID'].")" ?></span>

						</div>
						<?php } ?>
					</div>


					<?php

					}
					?>
				</div>
				<div class="col-md-3">
					<p class="lead">Einstellungen vornehmen</p>
					<?php

					if(isset($_SESSION['fID_praes'])){
					?>
					<form action='' method="POST" style='margin:0;' accept-charset="UTF-8">
						<input type="hidden" value=1 name="saved">
						<div class="checkbox">
							<label>
								<input name='show_beginn'  type="hidden" value=0>
								<input name='show_beginn'  type="checkbox" data-toggle="toggle" data-on="Ja" data-off="Nein" data-onstyle="success" data-offstyle="danger" value=1 <?php if(isset($PraesentationsSetting->show_beginn) && $PraesentationsSetting->show_beginn==1){echo "checked";} ?>>Folie im Menü sichtbar
							</label>
						</div>
						<!--						<div class="checkbox">
<label>
<input name='show_aktiv'  type="checkbox" data-toggle="toggle" data-on="Ja" data-off="Nein" data-onstyle="success" data-offstyle="danger" value=1 <?php if(isset($PraesentationsSetting->show_aktiv) && $PraesentationsSetting->show_aktiv){echo "checked";} ?> class='red-tooltip'>Folie im Menü aktiv
</label>
</div>//-->
						<div class="checkbox">
							<label>
								<input name='show_auto'  type="hidden" value=0>
								<input name='show_auto'  type="checkbox" data-toggle="toggle" data-on="Ja" data-off="Nein" data-onstyle="success" data-offstyle="danger" value=1 <?php if(isset($PraesentationsSetting->show_auto) && $PraesentationsSetting->show_auto){echo "checked";} ?>>Folie im Menü aktiv schalten, wenn vorausgehende Folie bearbeitet wurde.
							</label>
						</div>

						<div class="checkbox">
							<label>
								<input name='show_nach_bearb'  type="hidden" value=0>
								<input name='show_nach_bearb'  type="checkbox" data-toggle="toggle" data-on="Ja" data-off="Nein" data-onstyle="success" data-offstyle="danger" value=1 <?php if(isset($PraesentationsSetting->show_nach_bearb) && $PraesentationsSetting->show_nach_bearb){echo "checked";} ?>>Folie nach der Bearbeitung sichtbar
							</label>
						</div>

						<div class="checkbox">
							<label>
								<input name='show_freigabe'  type="hidden" value=0>
								<input name='show_freigabe'  type="checkbox" data-toggle="toggle" data-on="Ja" data-off="Nein" data-onstyle="success" data-offstyle="danger" value=1 <?php if(isset($PraesentationsSetting->show_freigabe) && $PraesentationsSetting->show_freigabe){echo "checked";} ?>>Freigabe durch Lehrkraft abwarten
							</label>
						</div>



						<input type="SUBMIT" value="Speichern" class="btn btn-primary" style="width:100%;">
					</form>


					<?php
					}else{
						echo "Bitte zunächst eine Folie zum bearbeiten auswählen!";
					}

					?>
				</div>
				<div class="col-md-1"></div>
			</div>
		</div>

		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/bottom_main.php");?>

		<script>
			$(document).ready(function(){
				$('[data-toggle="tooltip"]').tooltip(); 
			});




		</script>
	</body>
</html>