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
if(!isset($_GET['ft'])){
	echo "<script>window.location = '" . $_SESSION['DOCUMENT_ROOT_DIR']."/module/mod_videoanalyse/RecordVideo.php';</script>";
}else{
	$ftoken=mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($_GET['ft']), ENT_QUOTES , "UTF-8")); //($_POST['titel'], ENT_QUOTES);
	$FolieArr=getFolieInfo_bytoken($ftoken);
	$_SESSION['edit_fID']=$FolieArr['fID'];
	$_SESSION['vae']['parameter']=$FolieArr['parameter'];
	$AufgabeInfo=json_decode($FolieArr['parameter']);
	$VideoArr=$AufgabeInfo->videoArr;
	$_SESSION['vae']['videoArr']=$VideoArr;
	if(is_array($VideoArr)){
		$abgabeStatus=0;
		$video_src=null;
		foreach($VideoArr as $videoTMP){

			if($videoTMP->abgegeben==1){
				$abgabeStatus=1;
				$video_src="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/media/video/".$videoTMP->fileName;
			}
		}
	}
}

// ========================
// ====== AUFGABE EINTRAGEN
// ========================
// var_dump($_SESSION['vae']['videoArr']);
if(isset($_POST['action']) && $_POST['action']=="save"){
	$taskArr['videoArr']=$_SESSION['vae']['videoArr'];
	$taskArr['titel']=mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($_POST['titel']), ENT_QUOTES , "UTF-8")); //($_POST['titel'], ENT_QUOTES);
	// 	$taskArr['beschreibung']=mysqli_real_escape_string ($verbindung,  htmlentities (mynl2br($_POST['beschreibung']), ENT_QUOTES , "UTF-8"));
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
				$tnArr=array();
				foreach($tnArrTmp as $TN){
					array_push($tnArr,intval($TN));
				}}else{
				$tnArr=array();
			}
			$taskArr['tnarr']=$tnArr;
			break;
		case 1:
			break;
	}

	/* 	$fGroups=$_POST['fGroups'];
	if(isset($_POST['fGroups'])){
		$fGroupsArr=array();
		foreach($fGroups as $frageGruppeID){
			array_push($fGroupsArr,intval($frageGruppeID));
		}
	}
	$taskArr['fGroupsArr']=$fGroupsArr;

	$fArr=array();
	if(isset($_POST['fIDs'])){
		$FragenIDs=$_POST['fIDs'];
		foreach($FragenIDs as $frageID){
			array_push($fArr,intval($frageID));
		}
	}
 	$taskArr['fArr']=$fArr;
*/

	$parameter=json_encode($taskArr);
	$parameter=form_safe_json($parameter);
	if(intval($taskArr['CopyToKursID'])>0){$CopyToKursID=$taskArr['CopyToKursID'];}else{$CopyToKursID=0;}
	$redirectStatus=add_folie($parameter,$modID,$viewTyp,$fID,$redirect,1,0,$CopyToKursID);
	unset($_SESSION['vae']);

	if($redirectStatus==1){
		// 		echo "<script>window.location = '" . $_SESSION['DOCUMENT_ROOT_DIR']."/module/mod_videovertonung/add_korrektur.php';</script>";
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
						<div class="col-md-10"><p class="lead" style='margin:0'>Videoanalyse - Aufgabe bearbeiten</p></div>
						<div class="col-md-1"></div>
					</div>
				</div>
				<!--<div class="col-md-1"></div>//-->
			</div>

			<div class="row" style='margin-top:10px;'>
				<!--<div class="col-md-1"></div>//-->
				<div class="col-md-1 hidden-xs"></div>

				<div class="col-md-10">

					<form action='' method="POST" style='margin:0;' accept-charset="UTF-8">
						<input type="hidden" name="action" value="save">
						<video width="100%" controls>
							<source src="<?php echo $video_src; ?>" type="video/mp4">
							Ihr Browser unterstützt den Video Tag nicht. Bitte aktualisieren Sie Ihren Browser.
						</video>
						<input type="hidden" value='<?php if(isset($_SESSION['edit_fID'])){echo intval($_SESSION['edit_fID']);} ?>' name='fID'>
						<br><br>
						<div class="form-group">
							<label for="titel">Titel</label>
							<input id='titel' type="text" class="form-control" name="titel" placeholder="Titel der Aufgabe" required value='<?php if(isset($AufgabeInfo->titel)){echo $AufgabeInfo->titel;} ?>'>
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

				</div>
				<div class="col-md-1 hidden-xs"></div>
				<!--<div class="col-md-1"></div>//-->
			</div>
		</div>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/bottom_main.php");?>
	</body>
</html>