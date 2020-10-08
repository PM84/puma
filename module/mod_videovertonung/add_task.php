<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/header_php.php");

$ausserhalbKurs=1;
// ========================
// ========================
// ====== VIDEOVERTONUNG
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

include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");

$modTitel="Videovertonung";
$modID=getModIDFromTitel($modTitel);
$CopyToKursAllow=1;

// ========================
// ====== FOLIE TOKEN SETZEN FALLS FOLIE BEREITS GEPOSTET
// ========================

if(isset($_GET['f'])){

	$folInfo=getFolieInfo(intval($_GET['f']));
	$ftoken=$folInfo['ftoken'];
}else{
	$ftoken=mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($_GET['ft']), ENT_QUOTES , "UTF-8"));
	if(strlen($_GET['ft'])==0){
		$ftoken=uniqid();
		echo "<script>window.location = '" . $_SESSION['DOCUMENT_ROOT_DIR']."?ft=$ftoken';</script>";
	}
}

// echo $ftoken;
// ========================
// ====== AUFGABE EINTRAGEN
// ========================

if(isset($_POST['beschreibung'])){
	// 	echo intval($_POST['KorrTask']);
	
	$taskArr=[];
	// 	if(isset($_POST['vID']) &&intval($_POST['vID'])>0 ){
	// 		$taskArr['vID']=intval($_POST['vID']);
	// 	}else{
	$taskArr['vID']=intval($_SESSION['vID']);
	// 	}
	// 	if(intval($taskArr['vID'])==0){$taskArr['vID']=$_SESSION['vID'];}
	// 	$taskArr['titel']=addslashes(htmlentities( mynl2br($_POST['titel']), ENT_HTML5 , "UTF-8")); //($_POST['titel'], ENT_QUOTES);
	// 	$taskArr['beschreibung']=addslashes(htmlentities( mynl2br($_POST['beschreibung']), ENT_HTML5, "UTF-8")); //htmlspecialchars($_POST['beschreibung'], ENT_QUOTES);

	$taskArr['titel']=mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($_POST['titel']), ENT_QUOTES , "UTF-8")); //($_POST['titel'], ENT_QUOTES);
	$taskArr['ftoken']=$ftoken;;
	$taskArr['beschreibung']=mysqli_real_escape_string ($verbindung,  htmlentities (mynl2br($_POST['beschreibung']), ENT_QUOTES , "UTF-8"));
	$taskArr['hinweis']=mysqli_real_escape_string ($verbindung,  htmlentities (mynl2br($_POST['hinweis']), ENT_QUOTES , "UTF-8"));
	$taskArr['CopyToKursID']=intval($_POST['CopyToKursID']);
	//htmlspecialchars($_POST['beschreibung'], ENT_QUOTES);
	// 	$tArr['KorrTask']=$KorrTask=intval($_POST['KorrTask']);
	if(isset($_SESSION[$ftoken]['edit_fID'])){
		$fID=intval($_SESSION[$ftoken]['edit_fID']);
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
				}
			}else{
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
	// $taskArr=array_map('utf8_encode', $taskArr);
	$parameter=json_encode($taskArr);
	$parameter=form_safe_json($parameter);
	if(intval($taskArr['CopyToKursID'])>0){$CopyToKursID=$taskArr['CopyToKursID'];}else{$CopyToKursID=0;}
	$redirectStatus=add_folie($parameter,$modID,$viewTyp,$fID,$redirect,1,0,$CopyToKursID);
	$fID=mysqli_insert_id ( $verbindung );
	$orderID=getMaxOrderID($kursID,0)+1;
	InsertOrderSetting($fID,$kursID,$OrderID);

	// 	break;
	// 	                add_folie($parameter,$modID,$viewTyp,$_SESSION[$ftoken]['edit_fID'],$redirect,1,0,$CopyToKursID,$bsArr)

	if($redirectStatus==1){
		// 		echo "<script>window.location = '" . $_SESSION['DOCUMENT_ROOT_DIR']."/module/mod_videovertonung/add_korrektur.php';</script>";
	}else{
		unset($_SESSION['vID']);
	}
}

// ========================
// ====== Weiterleiten zur Korrekturaufgabe
// ========================
if(isset($_POST['kID'])){
	$_SESSION['kID']=intval($_POST['kID']);
	echo "<script>window.location = '" . $_SESSION['DOCUMENT_ROOT_DIR']."/module/mod_videovertonung/add_korrektur.php';</script>";
}

// ========================
// ====== Weiterleiten zur Feedbackfolien
// ========================

if(isset($_POST['FBID'])){
	$_SESSION['kID']=intval($_POST['FBID']);
	echo "<script>window.location = '" . $_SESSION['DOCUMENT_ROOT_DIR']."/module/mod_videovertonung/add_feedback.php';</script>";
} 


// ========================
// ====== FOLIE ZUM BEARBEITEN LADEN
// ========================

$FolieArr=getFolieInfo_bytoken($ftoken);
$_SESSION[$ftoken]['edit_fID']=$FolieArr['fID'];

if(isset($_SESSION[$ftoken]['edit_fID'])){
	$FolieArr=getFolieInfo(intval($_SESSION[$ftoken]['edit_fID']));
	$AufgabeInfo=json_decode($FolieArr['parameter']);
	
	if(isset($AufgabeInfo->vID)){$_SESSION['vID']=$AufgabeInfo->vID;}
}

// ========================
// ====== VIDEO AUSWÄHLEN
// ========================

if(isset($_POST['tem_vID'])){
	// 	echo $_POST['tem_vID'];
	$_SESSION['vID']=intval($_POST['tem_vID']);
	unset($_POST['tem_vID']);
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
				<div class="col-md-12">
					<div class="row" style='margin-top:10px; text-align:center; background-color:lightgray; padding:10px; border-radius: 10px;'>
						<div class="col-md-3">
							<a href='<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/module/admin/folie_erstellen.php' class='btn btn-success'>zurück</a>
							<a href='<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/module/mod_videovertonung/add_task_stapel.php?ft="<?php echo $ftoken; ?>' class='btn btn-info'>zur Stapelverarbeitung</a>
						</div>
						<div class="col-md-7"><p class="lead" style='margin:0'>Aufgabe zur Videovertonung hinzufügen</p></div>
						<div class="col-md-1"></div>
					</div>
				</div>
			</div>

			<div class="row" style=''>
				<div class="col-md-4">
					<p class="lead" style='margin:0'>Video auswählen</p>
					<div class="panel-group" id="accordion">
						<?php
						$themen=Get_VideoThemen();
						$videos=Get_Videos_Liste();
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

				<div class="col-md-7">
					<?php
					// 					echo $_SESSION['vID'];
					if(isset($_SESSION['vID']) && intval($_SESSION['vID'])>0){
					?>
					<form  id="praesForm" action='' method="POST" style='margin:0;' accept-charset="UTF-8">
						<p class="lead" style='margin:0'>Allgemein</p>
						<input type="hidden" name="vID" value="<?php echo intval($_SESSION['vID']);?>">
						<h4>
							<span style='font-size:14px;'>gewähltes Video:</span> <?php 
						$videoInfo=Get_VideoInfos_By_vID($videos,intval($_SESSION['vID']));
						echo $videoInfo->titel;

						$link_src=get_video_link($videoInfo,"sd");

						// 						$link_src_arr=$videoInfo->link_src
							?>
						</h4>
						<video width="100%" muted controls>
							<source src="<?php echo $link_src; ?>" type="video/mp4">
							Ihr Browser unterstützt den Video Tag nicht. Bitte aktualisieren Sie Ihren Browser.
						</video>
						<input type="hidden" value='<?php if(isset($_SESSION['edit_fID'])){echo intval($_SESSION['edit_fID']);} ?>' name='edit_fID'>
						<br><br>
						<div class="form-group">
							<label for="titel">Titel</label>
							<input id='titel' type="text" class="form-control" name="titel" placeholder="Titel der Aufgabe" required value='<?php if(isset($AufgabeInfo->titel)){echo $AufgabeInfo->titel;} ?>'>
						</div>
						<div class="form-group">
							<label for="beschreibung">Beschreiben Sie die Aufgabe</label>
							<textarea class="form-control" id="beschreibung" name='beschreibung'><?php if(isset($AufgabeInfo->beschreibung)){echo $AufgabeInfo->beschreibung;} ?></textarea>
						</div>
						<div class="form-group">
							<label for="modalBox">Hinweis zur Bearbeitung der Aufgabe in einer Modal-Box (PopUp)</label>
							<textarea class="form-control" id="hinweis" name='hinweis'><?php if(isset($AufgabeInfo->hinweis)){echo $AufgabeInfo->hinweis;} ?></textarea>
						</div>
						<p class="lead" style='margin-top:25px'>Anzeige</p>
						<?php //include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/folieAnzeigeOptionen_singleTN.php") ?>
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
				<div class="col-md-1"><?php /* 

					<p class="lead" style='margin:0'>zugeordnete Korrekturfolien</p>
					<?php 
					if(isset($_SESSION['edit_fID'])){
						$zu_folien_array=Get_zugeordnete_Folien_by_module(intval($_SESSION['edit_fID']),4);
						foreach($zu_folien_array as $folie){
							$parameter=json_decode($folie['parameter']);
					?>
					<form action='' method="POST" style='margin:0;' accept-charset="UTF-8">
						<input type=hidden value='<?php echo $folie['edit_fID']; ?>' name='kID'><input type="submit" class="btn btn-default" style='width:100%' value="<?php echo  $parameter->titel;; ?>">
					</form>

					<?php
						}
					}else{
						echo "<span class='btn'>Keine zugeordneten Korrekturfolien vorhanden!</span>";
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
<input type=hidden value='<?php echo $folie['edit_fID']; ?>' name='FBID'><input type="submit" class="btn btn-default" style='width:100%' value="<?php echo  $parameter->titel;; ?>">
</form>

<?php
	}
}else{
	echo "<span class='btn'>Keine zugeordneten Feedbackfolie vorhanden!</span>";
	// 						echo "Keine zugeordneten Feedbackfolien vorhanden!";
}
					?>
//-->

				 */ ?></div>
				<!--<div class="col-md-1"></div>//-->
			</div>
		</div>

		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/bottom_main.php");?>
	</body>
</html>