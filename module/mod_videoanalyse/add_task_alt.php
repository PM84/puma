<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/header_php.php");
$ausserhalbKurs=3;
// ========================
// ========================
// ====== VIDEOANALYSE
// ========================
// ========================

include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/session_delay.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/kursInfos.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/Sessions.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/videos.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/folie.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/frage.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/system.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/module.php");
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");

$modTitel="Videoanalyse";
$modID=getModIDFromTitel($modTitel);
$CopyToKursAllow=1;

// ========================
// ====== Weiterleiten wenn ftoken nicht gesetzt
// ========================
if(isset($_POST['kID'])){
	$_SESSION['kID']=intval($_POST['kID']);
	echo "<script>window.location = '" . $_SESSION['DOCUMENT_ROOT_DIR']."/module/mod_videoanalyse/RecordVideo.php';</script>";
}

// ========================
// ====== eigenes Video auswählen
// ========================
if(isset($_POST['fileID'])){
	// 	echo $_POST['fileID']."<hr>";
	unset($_SESSION['vID']);
	unset($_SESSION['eig_vID']);
	$_SESSION['eig_vID']=intval($_POST['fileID']);
}


// ========================
// ====== Weiterleiten zur Feedbackfolien
// ========================
if(isset($_POST['kID'])){
	$_SESSION['kID']=intval($_POST['kID']);
	echo "<script>window.location = '" . $_SESSION['DOCUMENT_ROOT_DIR']."/module/mod_videoanalyse/add_feedback.php';</script>";
}

// ========================
// ====== FOLIE ZUM BEARBEITEN LADEN
// ========================
if(isset($_SESSION['edit_fID'])){
	unset($_SESSION['vID']);
	unset($_SESSION['eig_vID']);
	$FolieArr=getFolieInfo(intval($_SESSION['edit_fID']));
	$AufgabeInfo=json_decode($FolieArr['parameter']);
	if(isset($AufgabeInfo->vID)){$_SESSION['vID']=$AufgabeInfo->vID;}
	if(isset($AufgabeInfo->eig_vID)){$_SESSION['eig_vID']=$AufgabeInfo->eig_vID;}
}


// ========================
// ====== VIDEO AUSWÄHLEN
// ========================

if(isset($_POST['tem_vID'])){
	unset($_SESSION['eig_vID']);
	unset($_SESSION['vID']);
	// 	echo $_POST['tem_vID'];
	$_SESSION['vID']=intval($_POST['tem_vID']);
	unset($_POST['tem_vID']);
}

// ========================
// ====== VIDEO INFOS LADEN
// ========================

if(isset($_SESSION['vID'])){
	$videoInfo=Get_VideoInfos_By_vID($videos,intval($_SESSION['vID']));
	$link_src=get_video_link($videoInfo,"sd");

}

if(isset($_SESSION['eig_vID'])){
	$videoInfo=Get_eigeneVideoInfos_By_vID_and_uID($_SESSION['uID'],intval($_SESSION['eig_vID']));
	$link_src=$videoInfo['link_src'];
}

// echo $_SESSION['eig_vID']." => ".$link_src;



// ========================
// ====== AUFGABE EINTRAGEN
// ========================

if(isset($_POST['beschreibung'])){
	// 	echo intval($_POST['KorrTask']);
	
	$taskArr=[];
	// 	if(isset($_POST['vID']) &&intval($_POST['vID'])>0 ){
	// 		$taskArr['vID']=intval($_POST['vID']);
	// 	}else{
	if(isset($_SESSION['eig_vID'])){$taskArr['eig_vID']=intval($_SESSION['eig_vID']);}
	if(isset($_SESSION['vID'])){$taskArr['vID']=intval($_SESSION['vID']);}
	// 	}
	// 	if(intval($taskArr['vID'])==0){$taskArr['vID']=$_SESSION['vID'];}
	// 	$taskArr['titel']=addslashes(htmlentities( mynl2br($_POST['titel']), ENT_HTML5 , "UTF-8")); //($_POST['titel'], ENT_QUOTES);
	// 	$taskArr['beschreibung']=addslashes(htmlentities( mynl2br($_POST['beschreibung']), ENT_HTML5, "UTF-8")); //htmlspecialchars($_POST['beschreibung'], ENT_QUOTES);

	$taskArr['titel']=mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($_POST['titel']), ENT_QUOTES , "UTF-8")); //($_POST['titel'], ENT_QUOTES);
	$taskArr['beschreibung']=mysqli_real_escape_string ($verbindung,  htmlentities (mynl2br($_POST['beschreibung']), ENT_QUOTES , "UTF-8"));
	$taskArr['CopyToKursID']=intval($_POST['CopyToKursID']);
	//htmlspecialchars($_POST['beschreibung'], ENT_QUOTES);
	// 	$tArr['KorrTask']=$KorrTask=intval($_POST['KorrTask']);
	if(isset($_SESSION['edit_fID'])){
		$fID=intval($_SESSION['edit_fID']);
	}else{
		$fID=0;
	}
	$viewTyp=intval($_POST['viewTyp']);
	switch($viewTyp){
		default:
			if(isset($_POST['tnarr'])){
				$tnArrTmp=$_POST['tnarr'];
				$tnArr=[];
				foreach($tnArrTmp as $TN){
					array_push($tnArr,intval($TN));
				}}else{
				$tnArr=[];
			}
			$taskArr['tnarr']=$tnArr;
			break;
		case 1:
			break;
	}
	if(isset($_POST['KorrTask']) && intval($_POST['KorrTask'])==1){
		$redirect=1;
	}else{
		$redirect=0;
	}

	$fGroups=$_POST['fGroups'];
	if(isset($_POST['fGroups'])){
		$fGroupsArr=[];
		foreach($fGroups as $frageGruppeID){
			array_push($fGroupsArr,intval($frageGruppeID));
		}
	}
	$taskArr['fGroupsArr']=$fGroupsArr;

	$fArr=[];
	if(isset($_POST['fIDs'])){
		$FragenIDs=$_POST['fIDs'];
		foreach($FragenIDs as $frageID){
			array_push($fArr,intval($frageID));
		}
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


	// $taskArr=array_map('utf8_encode', $taskArr);
	$parameter=json_encode($taskArr);
	$parameter=form_safe_json($parameter);
	if(intval($taskArr['CopyToKursID'])>0){$CopyToKursID=$taskArr['CopyToKursID'];}else{$CopyToKursID=0;}
	$redirectStatus=add_folie($parameter,$modID,$viewTyp,$fID,$redirect,1,0,$CopyToKursID);

	if($redirectStatus==1){
		// 		echo "<script>window.location = '" . $_SESSION['DOCUMENT_ROOT_DIR']."/module/mod_videovertonung/add_korrektur.php';</script>";
	}else{
		unset($_SESSION['vID']);
		unset($_SESSION['eig_vID']);
	}
}


?>
<html>
	<head>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/head_main.php");?>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/head_backend.php");?>
		<script src="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/plugins/tinymce/js/tinymce/tinymce.min.js"></script>
		<script>
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
		</script>
		<style>

			.clickable{
				cursor: pointer;   
			}

			.panel-heading span {
				margin-top: -20px;
				font-size: 15px;
			}

		</style>
	</head>
	<body>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/header_bar.php");?>

		<div class="container" style="margin-bottom:150px;">
			<div class="row">
				<!--<div class="col-md-1"></div>//-->
				<div class="col-md-12">
					<div class="row" style='margin-top:10px; text-align:center; background-color:lightgray; padding:10px; border-radius: 10px;'>
						<div class="col-md-1"><a href='<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/module/admin/folie_erstellen.php' class='btn btn-success'>zurück</a></div>
						<div class="col-md-10"><p class="lead" style='margin:0'>Videoanalyse hinzufügen</p></div>
						<div class="col-md-1"></div>
					</div>
				</div>
				<!--<div class="col-md-1"></div>//-->
			</div>

			<div class="row" style=''>
				<!--<div class="col-md-1"></div>//-->
				<div class="col-md-4">
					<p class="lead" style='margin:0'>Video auswählen oder hochladen</p>
					<div class="panel-group" id="accordion">
						<div class="panel panel-default">
							<div class="panel-heading">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapse_upload" style='none'>
									<div>
										<h4 class="panel-title">Eigene Videos</h4>
									</div>
								</a>
							</div>
							<?php include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/fileExplorer.php"); ?>
						</div>
						<?php
						foreach($themen as $thema){
							$status=0;
						?>
						<div class="panel panel-default">
							<div class="panel-heading">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $thema->themaID;?>" style='none'>
									<div>
										<h4 class="panel-title">
											<?php echo $thema->titel;?>
											<!--<span class="pull-right clickable"  data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $thema->themaID;?>"><i class="glyphicon glyphicon-chevron-up"></i></span>//-->
										</h4>
									</div>
								</a>
							</div>
							<div id="collapse<?php echo $thema->themaID;?>" class="panel-collapse collapse">
								<div class="panel-body">
									<?php
							foreach($videos as $video){
								
								if(in_array($thema->themaID,$video->themen)){
									$status=1;
									?>
									<form action='' method="POST" style='margin:0;'>
										<input type=hidden value='<?php echo $video->vID; ?>' name='tem_vID'><input type="submit" class="btn btn-default" style='width:100%' value="<?php echo $video->titel; ?>">
									</form>

									<?php
								}
							}
							if($status==0){
								echo "Zu diesem Thema gibt es noch keine Videos.";
							}

									?>
								</div>
							</div>
						</div>
						<?php
						}

						?>

					</div>
				</div>

				<div class="col-md-5">
					<?php
					// 					echo $_SESSION['vID'];
					if((isset($_SESSION['vID']) && intval($_SESSION['vID'])>0) || isset($_SESSION['eig_vID']) && intval($_SESSION['eig_vID'])>0){
					?>
					<form action='' method="POST" style='margin:0;' accept-charset="UTF-8">
						<p class="lead" style='margin:0'>Allgemein</p>
						<h4>
							<span style='font-size:14px;'>gewähltes Video:</span> <?php 
						if(isset($_SESSION['eig_vID'])){echo $videoInfo['titel'];}
						if(isset($_SESSION['vID'])){echo $videoInfo->titel;}
						// 						echo $videoInfo->titel;


						// 						$link_src_arr=$videoInfo->link_src
							?>
						</h4>
						<video width="100%" muted controls>
							<source src="<?php echo $link_src; ?>" type="video/mp4">
							Ihr Browser unterstützt den Video Tag nicht. Bitte aktualisieren Sie Ihren Browser.
						</video>
						<input type="hidden" value='<?php if(isset($_SESSION['edit_fID'])){echo intval($_SESSION['edit_fID']);} ?>' name='fID'>
						<br><br>
						<div class="form-group">
							<label for="titel">Titel</label>
							<input id='titel' type="text" class="form-control" name="titel" placeholder="Titel der Aufgabe" required value='<?php if(isset($AufgabeInfo->titel)){echo $AufgabeInfo->titel;} ?>'>
						</div>
						<div class="form-group">
							<label for="beschreibung">Beschreiben Sie die Aufgabe</label>
							<textarea class="form-control" id="beschreibung" name='beschreibung'><?php if(isset($AufgabeInfo->beschreibung)){echo $AufgabeInfo->beschreibung;} ?></textarea>
						</div>

						<p class="lead" style='margin-top:25px'>Fragen</p>
						<div class="form-group">
							<label for="fGroups">Fragengruppe auswählen</label>
							<select class="form-control"  name="fGroups[]" id="fGroups"  multiple>
								<?php
						$fGruppen=Get_Fragen_Gruppen($_SESSION['uID']);
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
						$fragen=getFragenByUser($_SESSION['uID']);
						foreach($fragen as $frage){

							
							$frageParameter=json_decode($frage['parameter']);
								?>
								<option value="<?php echo $frage['FrageID']; ?>" <?php if(isset($AufgabeInfo)){if(is_array($AufgabeInfo->fArr)){if(in_array($frage['FrageID'],$AufgabeInfo->fArr)){echo "selected";} }}?>><?php echo html_entity_decode ($frageParameter->titel, ENT_QUOTES , "UTF-8"); ?></option>
								<?php
						}
								?>
							</select>
						</div>


						<p class="lead" style='margin-top:25px'>Anzeige</p>
						<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/folieAnzeigeOptionen.php") ?>

						<!--						<div class="checkbox">
<label>
<input name='KorrTask'  type="checkbox" data-toggle="toggle" data-on="Ja" data-off="Nein" data-onstyle="success" data-offstyle="danger" value=1>
Soll eine (weitere) Korrekturaufgabe zu dieser Aufgabe erstellt werden?
</label>

</div>//-->
						<input type="submit" class="btn btn-primary" style='' value="<?php if(isset($_SESSION['edit_fID'])){echo "Aufgabe updaten";}else{echo "Aufgabe eintragen";}  ?>">
					</form>
					<?php
					}
					?>
				</div>
				<div class="col-md-3">
					<p class="lead" style='margin:0'>zugeordnete Feedbackfolien</p>
					<?php 
					if(isset($_SESSION['edit_fID'])){
						$zu_folien_array=Get_zugeordnete_Folien_by_module(intval($_SESSION['edit_fID']),3);
						foreach($zu_folien_array as $folie){
							$parameter=json_decode($folie['parameter']);
					?>
					<form action='' method="POST" style='margin:0;' accept-charset="UTF-8">
						<input type=hidden value='<?php echo $folie['fID']; ?>' name='kID'><input type="submit" class="btn btn-default" style='width:100%' value="<?php echo  $parameter->titel;; ?>">
					</form>

					<?php
						}
					}else{
						echo "<span class='btn'>Keine zugeordneten Feedbackfolien vorhanden!</span>";
					}
					?>

					<br>
					<form action='' method="POST" style='margin:0;' accept-charset="UTF-8">
						<input type=hidden value='0' name='kID'><button type="submit" class="btn btn-success" style='width:100%'><span class="glyphicon glyphicon-plus" ></span> Neue Besprechungsfolie hinzufügen</button>
					</form>	
					<!--

<hr>


<p class="lead" style='margin:0'>zugeordnete Feedbackfolien</p>
<?php 
if(isset($_SESSION['edit_fID'])){
	$zu_folien_array=Get_zugeordnete_Folien_by_module(intval($_SESSION['edit_fID']),5);
	foreach($zu_folien_array as $folie){
		$parameter=json_decode($folie['parameter']);
?>
<form action='' method="POST" style='margin:0;' accept-charset="UTF-8">
<input type=hidden value='<?php echo $folie['fID']; ?>' name='FBID'><input type="submit" class="btn btn-default" style='width:100%' value="<?php echo  $parameter->titel;; ?>">
</form>

<?php
	}
}else{
	echo "<span class='btn'>Keine zugeordneten Feedbackfolie vorhanden!</span>";
	// 						echo "Keine zugeordneten Feedbackfolien vorhanden!";
}
?>
//-->

				</div>
				<!--<div class="col-md-1"></div>//-->
			</div>
		</div>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/bottom_main.php");?>
	</body>
</html>