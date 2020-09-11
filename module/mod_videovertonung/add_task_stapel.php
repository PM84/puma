<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/header_php.php");
// var_dump($_SESSION);
$ausserhalbKurs=1;
// ========================
// ========================
// ====== VIDEOVERTONUNG - STAPELVERARBEITUNG
// ========================
// ========================

include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/session_delay.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/kursInfos.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/Sessions.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/videos.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/folie.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/system.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/module.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/media.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/teilnehmer.php");

include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");

$modTitel="Videovertonung";
$modID=getModIDFromTitel($modTitel);
$CopyToKursAllow=1;

// Teilnehmerliste laden:

$TeilnehmerListe=getTeilnehmerListeInfos($_SESSION['k']);
$videoArr=get_video_array_thema_video();
$uID=$SessionInfos['uID'];
$kursID=intval($_SESSION['k']);

// var_dump($videoArr);

// ==================================
// =========== Folien erstellen
// ==================================
if(isset($_POST['action']) && $_POST['action']=="save"){
	unset ($_POST['savePraes']);
	unset ($_POST['action']);
	$viewTyp=2; //nur der ausgewählte Teilnehmer hat Zugriff.
	$aTyp=1; // entspricht Aufgabe
	$zu_fID=0; //keiner anderen Folie zugeordnet
	// var_dump($_POST);
	foreach($_POST as $tnID=>$tnArr){

		$taskArr['vID']=intval($tnArr['vID']);
		$taskArr['titel']=mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($tnArr['name'].", ".$tnArr['vname']), ENT_QUOTES , "UTF-8")); //($_POST['titel'], ENT_QUOTES);
		$taskArr['beschreibung']=mysqli_real_escape_string ($verbindung,  htmlentities (mynl2br($tnArr['beschreibung']), ENT_QUOTES , "UTF-8"));
		$tnArr=array(intval($tnID));
		$taskArr['tnarr']=$tnArr;
		$parameter=json_encode($taskArr);
		$parameter=form_safe_json($parameter);
		$ftoken=uniqid();
		$query="INSERT INTO folien (uID,kursID,modID,parameter,viewTyp,aTyp,zu_fID,ftoken) VALUES ('$uID','$kursID','$modID','$parameter','$viewTyp','$aTyp','$zu_fID','$ftoken')";
		// 		echo $query;
		$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
		$fID=mysqli_insert_id ( $verbindung );
		$orderID=getMaxOrderID($kursID,0)+1;
		InsertOrderSetting($fID,$kursID,$OrderID);
	}
}

?>
<html>
	<head>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/head_main.php");?>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/head_backend.php");?>
		<script src="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/plugins/tinymce/js/tinymce/tinymce.min.js"></script>

		<script>
			// 			function resetTinyMCE(){
			tinymce.init({
				selector: 'textarea',
				language: 'de',
				height: 600,
				theme: 'modern',
				plugins: [
					'advlist autolink lists link image charmap print preview hr anchor pagebreak powerpaste',
					'searchreplace wordcount visualblocks visualchars code fullscreen',
					'insertdatetime media nonbreaking save table contextmenu directionality',
					'emoticons template textcolor colorpicker textpattern imagetools codesample toc jbimages'
				],
				toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
				toolbar2: 'print preview media | forecolor backcolor emoticons | codesample | jbimages',
				image_advtab: true,
				content_css: [
					'//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
					'//www.tinymce.com/css/codepen.min.css'
				],
				file_browser_callback_types: 'image',

				images_upload_handler: function (blobInfo, success, failure) {
					var xhr, formData;

					xhr = new XMLHttpRequest();
					xhr.withCredentials = false;
					xhr.open('POST', 'postAcceptor.php');

					xhr.onload = function() {
						var json;

						if (xhr.status != 200) {
							failure('HTTP Error: ' + xhr.status);
							return;
						}

						json = JSON.parse(xhr.responseText);

						if (!json || typeof json.location != 'string') {
							failure('Invalid JSON: ' + xhr.responseText);
							return;
						}

						success(json.location);
					};

					formData = new FormData();
					formData.append('file', blobInfo.blob(), blobInfo.filename());

					xhr.send(formData);
				}

			});
			// 			}
		</script>
		<style>

			.clickable{
				cursor: pointer;   
			}

			.panel-heading span {
				margin-top: -20px;
				font-size: 15px;
			}

			.noOverflow {
				white-space: normal;
				overflow: hidden;
				-ms-text-overflow: ellipsis;
				-o-text-overflow: ellipsis;
				text-overflow: ellipsis;
				max-height:3em;
				max-width:400px;
			}

		</style>
	</head>
	<body>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/header_bar.php");?>

		<div id="container" class="container" style="margin-bottom:150px;">
			<div class="row">
				<!--<div class="col-md-1"></div>//-->
				<div class="col-md-12">
					<div class="row" style='margin-top:10px; text-align:center; background-color:lightgray; padding:10px; border-radius: 10px;'>
						<div class="col-md-3">
							<a href='<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/module/admin/folie_erstellen.php' class='btn btn-success'>zurück</a>
							<a href='<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/module/mod_videovertonung/add_task.php?ft="<?php echo $ftoken; ?>' class='btn btn-info'>zur Einzelerstellung</a>
						</div>
						<div class="col-md-7"><p class="lead" style='margin:0'>Aufgabe zur Videovertonung hinzufügen</p></div>
						<div class="col-md-1"></div>
					</div>
				</div>
				<!--<div class="col-md-1"></div>//-->
			</div>
			<div class="col-xs-1"></div>
			<div class="col-xs-10">
				<form id="praesForm" method="post" action="">
					<input type="hidden" name="action" value="save">

					<table class="table table-striped">
						<thead>
							<tr>
								<th>Vorname</th>
								<th>Name</th>
								<th>Video</th>
								<th>Aufgabentext</th>

							</tr>
						</thead>

						<?php

						foreach($TeilnehmerListe as $TN){
						?>
						<tr class="tr_tn_<?php echo $TN['tnID']; ?>">
							<td>
								<?php echo $TN['vname']; ?><input type="hidden" name="<?php echo $TN['tnID'] ?>[vname]" value="<?php echo $TN['vname']; ?>">
							</td>
							<td>
								<?php echo $TN['name']; ?><input type="hidden" name="<?php echo $TN['tnID'] ?>[name]" value="<?php echo $TN['name']; ?>">
							</td>
							<td  style="max-width:300px;">
								<select class="form-control" name="<?php echo $TN['tnID'] ?>[vID]" required>
									<option value="">Video auswählen</option>
									<?php 
							foreach($videoArr as $thema=>$videoListe){
								foreach($videoListe as $video){
									?>
									<option value="<?php echo $video->vID;?>"><?php  echo $thema." - ".$video->titel; ?></option>
									<?php
								} 
							}
									?>
								</select>
							</td>
							<td>
								<span style="float:right;" data-options='{"tnID":"<?php  echo $TN['tnID']; ?>"}' class="glyphicon glyphicon-pencil editAufgabe"></span>
								<div id="tn_pre_<?php echo $TN['tnID'] ?>" class="tn_pre_all noOverflow">

								</div>
								<input name="<?php echo $TN['tnID'] ?>[beschreibung]" class="input_all input_sing_<?php  echo $TN['tnID']; ?>" type="hidden" required>
							</td>
						</tr>
						<?php
						}
						?>
					</table>
				</form>
				<div id="div_ta" class="hidden">
					<h2>Aufgabe/Beschreibung eingeben</h2>
					<div class="row" style="margin-bottom:10px;">
						<div class="col-xs-2"></div>
						<div class="col-xs-4"><span class="btn btn-warning btn-block saveAll">Für alle die gleiche Aufgabe speichern.</span></div>
						<div class="col-xs-4"><div id="btn_save_sing" class="btn btn-primary btn-block saveSingle" data-tnID="0">Einzeln Speichern</div></div>
						<div class="col-xs-2"></div>
					</div>
					<div>
						<textarea name='sectionContent_1' id='ta_beschreibung'></textarea>
					</div>
				</div>

			</div>
			<div class="col-xs-1"></div>
		</div>
	</body>

	<script>
		$(function() {
			$('.editAufgabe').click(function(){
				var tnID=$( this ).data( "options" ).tnID;
				$("#div_ta").removeClass( "hidden" );
				$("#span_tn_"+tnID).removeClass( "hidden" );
				$('#btn_save_sing').data('tnID',tnID);
				tinymce.get('ta_beschreibung').setContent($(".input_sing_"+tnID).val());
				//scroll to textarea
				goToByScroll("div_ta",70);
			});
		});

		$(function() {
			$('.saveAll').click(function(){
				$("#div_ta").addClass( "hidden" );
				tinyMCE.triggerSave();
				var ta_html=$("#ta_beschreibung").val();
				$(".tn_pre_all").html(ta_html)
				$(".input_all").val( ta_html );
				//scroll to textarea
				goToByScroll("container",70);
			});
		});

		$(function() {
			$('.saveSingle').click(function(){
				var tnID=$( this ).data( "tnID" );
				$("#div_ta").addClass( "hidden" );
				tinyMCE.triggerSave();
				var ta_html=$("#ta_beschreibung").val();
				$(".input_sing_"+tnID).val( ta_html );
				$("#tn_pre_"+tnID).html(ta_html)
				goToByScroll("tn_pre_"+tnID,70);
			});
		});

		function goToByScroll(id,offset) {
			// Remove "link" from the ID
			id = id.replace("link", "");
			// Scroll
			$('html,body').animate({
				scrollTop: $("#" + id).offset().top-offset
			}, 'slow');
		}
	</script>

</html>
