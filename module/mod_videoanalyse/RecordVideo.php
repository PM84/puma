<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/header_php.php");
$ausserhalbKurs=3;
// ========================
// ========================
// ====== VIDEOANALYSE - Video aufzeichnen
// ========================
// ========================

include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/session_delay.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/kursInfos.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/Sessions.php");
// include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/videos.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/folie.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/teilnehmer.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/frage.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/system.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/module.php");
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");

$modTitel="Videoanalyse";
$modID=getModIDFromTitel($modTitel);
$_SESSION['va']['modID']=$modID;
$viewTyp=2; // Zugriffsbeschränkung auf Auswahl
$_SESSION['va']['viewTyp']=$viewTyp;
// $CopyToKursAllow=1;
// $themen=Get_VideoThemen();
// $videos=Get_Videos_Liste();

$Kurse=GetKursListeInfos($_SESSION['uID'],1,1);
$SessionInfos=Get_SessionInfos($_SESSION['s']);
$uID=$SessionInfos['uID'];

if(isset($_POST['action'])&&$_POST['action']=="newRecord"){
	unset($_SESSION['va']);
}


if(isset($_POST['action'])&&$_POST['action']=="kid"){
	$_SESSION['va']['kID']=intval($_POST['kID']);
}

if(isset($_POST['action'])&&$_POST['action']=="tnid"){
	if(isset($_SESSION['va']['fID']) && $_SESSION['va']['fID']>0){$fID=$_SESSION['va']['fID'];}else{$fID=0;}
	$_SESSION['va']['tnIDs']=array();
	foreach($_POST['tnIDs'] as $tnID){
		array_push($_SESSION['va']['tnIDs'],intval($tnID));
	}
	$parameterTEMP['tnarr']=$_SESSION['va']['tnIDs'];

	if(!isset($_SESSION['va']['VideoSize'])){$_SESSION['va']['VideoSize']=2;}
	if(!isset($_SESSION['va']['videoWidth'])){$_SESSION['va']['videoWidth']=640;}
	if(!isset($_SESSION['va']['videoHeight'])){$_SESSION['va']['videoHeight']=480;}
	if(!isset($_SESSION['va']['bitrate'])){$_SESSION['va']['bitrate']=512000;}

	$parameterTEMP['VideoSize']=$_SESSION['va']['VideoSize'];
	$parameterTEMP['videoWidth']=$_SESSION['va']['videoWidth'];
	$parameterTEMP['videoHeight']=$_SESSION['va']['videoHeight'];
	$parameterTEMP['bitrate']=$_SESSION['va']['bitrate'];
	$parameterTEMP['titel']="Videoanalyse";

	$parameter=json_encode($parameterTEMP);
	$kursID=$_SESSION['va']['kID'];
	$folieDetails=create_inactive_folie($uID,$kursID,$parameter,$modID,$viewTyp,0,$fID);
	$_SESSION['va']['fID']=$folieDetails['fID'];
	$_SESSION['va']['ftoken']=$folieDetails['ftoken'];
}


if(isset($_SESSION['va']['kID'])){
	$TeilnehmerListe=getTeilnehmerListeInfos($_SESSION['va']['kID']);
}


if(isset($_SESSION['va']['kID']) && isset($_POST['action']) && $_POST['action']=="videoSettings"){
	$folieInfo=getFolieInfo($_SESSION['va']['fID']);
	$parameterTEMP=json_decode($folieInfo['parameter'],true);

	$bitrate=intval($_POST['bitrate']);

	$_SESSION['va']['audioSource']=$_POST['audioSource'];
	$_SESSION['va']['audioOutput']=$_POST['audioOutput'];
	$_SESSION['va']['videoSource']=$_POST['videoSource'];
	$_SESSION['va']['SettingsPosted']=$_POST['SettingsPosted'];

	$_SESSION['va']['VideoSize']=intval($_POST['VideoSize']);
	switch($_POST['VideoSize']){
		case 1: 
			$videoWidth=320;
			$videoHeight=240;
			break;
		case 2: 
			$videoWidth=640;
			$videoHeight=480;
			break;
		case 3: 
			$videoWidth=1280;
			$videoHeight=720;
			break;
		default:
			$videoWidth=640;
			$videoHeight=480;
			break;

	}
	$_SESSION['va']['videoWidth']=$videoWidth;
	$_SESSION['va']['videoHeight']=$videoHeight;
	$_SESSION['va']['bitrate']=$bitrate;

	$parameterTEMP['VideoSize']=$_SESSION['va']['VideoSize'];
	$parameterTEMP['videoWidth']=$_SESSION['va']['videoWidth'];
	$parameterTEMP['videoHeight']=$_SESSION['va']['videoHeight'];
	$parameterTEMP['bitrate']=$_SESSION['va']['bitrate'];

	$parameterTEMP['audioSource']=$_SESSION['va']['audioSource'];
	$parameterTEMP['audioOutput']=$_SESSION['va']['audioOutput'];
	$parameterTEMP['videoSource']=$_SESSION['va']['videoSource'];


	$parameter=json_encode($parameterTEMP);

	$folieDetails=create_inactive_folie($uID,$_SESSION['va']['kID'],$parameter,$modID,$viewTyp,0,$_SESSION['va']['fID']);
}

if(isset($_SESSION['va']['kID']) && isset($_POST['action']) && $_POST['action']=="SelectVideo"){
	$folieInfo=getFolieInfo($_SESSION['va']['fID']);
	$parameterTEMP=json_decode($folieInfo['parameter'],true);
	$vidArr=$parameterTEMP['videoArr'];
	$filename=$_POST['videoID'];
	foreach($vidArr as $key=>$videoTemp){
		if($videoTemp['fileName']==$filename){
			$vidArr[$key]['abgegeben']=1;
		}else{
			$vidArr[$key]['abgegeben']=0;
		}
	}
	$parameterTEMP['videoArr']=$vidArr;
	$parameter=json_encode($parameterTEMP);
	$folieDetails=create_inactive_folie($uID,$_SESSION['va']['kID'],$parameter,$modID,$viewTyp,1,$_SESSION['va']['fID']);
	activate_folie($_SESSION['va']['fID'],1);
	unset($_POST);
}



// Folie-Details laden
// var_dump($_SESSION['va']['fID']);
if(isset($_SESSION['va']['fID']) && $_SESSION['va']['fID']>0){
	$folieInfo=getFolieInfo($_SESSION['va']['fID']);
	$TeilnehmerListe=getTeilnehmerListeInfos($_SESSION['va']['kID']);
	$_SESSION['va']['kID']=$folieInfo['kursID'];
	$_SESSION['va']['ftoken']=$folieInfo['ftoken'];

	$parameterTEMP=json_decode($folieInfo['parameter'],true);
	$_SESSION['va']['VideoSize']=$parameterTEMP['VideoSize'];
	$_SESSION['va']['videoWidth']=$parameterTEMP['videoWidth'];
	$_SESSION['va']['videoHeight']=$parameterTEMP['videoHeight'];
	$_SESSION['va']['bitrate']=$parameterTEMP['bitrate'];
	$_SESSION['va']['videoArr']=$parameterTEMP['videoArr'];
	$_SESSION['va']['audioSource']=$parameterTEMP['audioSource'];
	$_SESSION['va']['audioOutput']=$parameterTEMP['audioOutput'];
	$_SESSION['va']['videoSource']=$parameterTEMP['videoSource'];

}
// SelectVideo


?>
<html>
	<head>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/head_main.php");?>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/head_backend.php");?>
		<script src="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/plugins/tinymce/js/tinymce/tinymce.min.js"></script>

		<script>

			var videoHeight = <?php if(!isset($_SESSION['va']['videoHeight'])){echo 640;}else{echo $_SESSION['va']['videoHeight'];} ?>;
			var videoWidth = <?php if(!isset($_SESSION['va']['videoWidth'])){echo 480;}else{echo $_SESSION['va']['videoWidth'];} ?>;
			var videoBPS = <?php if(!isset($_SESSION['va']['bitrate'])){echo 512000;}else{echo $_SESSION['va']['bitrate'];} ?>;
			var VideoToken = '<?php echo uniqid(); ?>';

			$( document ).ready(function() {
				$("#menuTopRight").append('<input type="hidden" name="action" value="new"><button form="newRecord" class="btn btn-warning navbar_Button" style="float:right;" type="submit">Neue Aufnahme</button>');
			})
		</script>


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

		<div class="container" style="">
			<div class="row">
				<!--<div class="col-md-1"></div>//-->
				<div class="col-md-12" style="padding: 0 10 0 10">
					<div class="row" style='margin-top:10px; text-align:center; background-color:lightgray; padding:10px; border-radius: 10px;'>
						<div class="col-md-1"><a href='<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/module/admin/folie_erstellen.php' class='btn btn-success'>zurück</a></div>
						<div class="col-md-10"><p class="lead" style='margin:0'>Videoanalyse - Video aufzeichnen</p></div>
						<div class="col-md-1"><form id="newRecord" action method="post"><input type="hidden" name="action" value="newRecord"></form>
						</div>
					</div>
				</div>
				<!--<div class="col-md-1"></div>//-->
			</div>

			<div class="row" style=' margin-top:15px;'>
				<!--<div class="col-md-1"></div>//-->
				<div class="col-md-1"></div>
				<div class="col-md-3">
					<form action method="post">
						<input type="hidden" name="action" value="kid">
						<label>Bitte den Kurs auswählen zu dem die Aufzeichnung hinzugefügt werden soll:</label>
						<select class="form-control" name="kID" onchange="this.form.submit()" required>
							<option value="">Bitte auswählen</option>
							<?php
							foreach($Kurse as $kurs){
							?>
							<option value="<?php echo $kurs['kursID']; ?>" <?php if(isset($_SESSION['va']['kID']) && $kurs['kursID']==$_SESSION['va']['kID']){echo "selected";} ?>><?php echo $kurs['titel'] ?></option>
							<?php
							}
							?>
						</select>
					</form>
					<?php
					if(isset($_SESSION['va']['kID'])){
					?>
					<form action method="post">
						<input type="hidden" name="action" value="tnid">
						<label>Bitte den/die Teilnehmer auswählen, die auf dieses Video und das zugehörige Feedback Zugriff haben sollen:</label>
						<select class="form-control" name="tnIDs[]" required multiple size=8>
							<?php
						foreach($TeilnehmerListe as $Teilnehmer){
							?>
							<option value="<?php echo $Teilnehmer['tnID'] ?>" <?php if(isset($_SESSION['va']['tnIDs']) && in_array($Teilnehmer['tnID'],$_SESSION['va']['tnIDs'])){echo "selected";} ?>><?php echo $Teilnehmer['name'].", ".$Teilnehmer['vname'] ?></option>
							<?php
						}
							?>
						</select>
						<input class="btn btn-primary" type="submit" value="Auswählen" style="margin-top:10px;">
					</form>
					<?php
					}
					?>
				</div>
				<div class="col-md-7">


					<?php
					if(isset($_SESSION['va']['tnIDs'])&&is_array($_SESSION['va']['tnIDs'])){
					?>
					<div class="row">
						<form action method="post">
							<input type="hidden" name="action" value="videoSettings">
							<input type="hidden" name="SettingsPosted" value="1">
							<div class="col-md-4">
								<label for="bitrate">Bitrate in Bit/s eingeben:</label><input type=number value="<?php if(isset($_SESSION['va']['bitrate'] )){echo $_SESSION['va']['bitrate'];}else{echo "512000";} ?>" name="bitrate" class="form-control">
							</div>
							<div class="col-md-4">
								<label for="bitrate">Auflösung auswählen:</label><br>
								<div class="btn-group btn-group-toggle" data-toggle="buttons">
									<label class="btn btn-default <?php if(isset($_SESSION['va']['VideoSize'] ) && $_SESSION['va']['VideoSize']==3){echo "active";} ?>">
										<input type="radio" name="VideoSize" id="HD" autocomplete="off"  value="3" <?php if(isset($_SESSION['va']['VideoSize'] ) && $_SESSION['va']['VideoSize']==3){echo "checked";} ?> > HD
									</label>
									<label class="btn btn-default  <?php if(isset($_SESSION['va']['VideoSize'] ) && $_SESSION['va']['VideoSize']==2){echo "active";} ?>">
										<input type="radio" name="VideoSize" id="VGA" autocomplete="off" value="2"  <?php if(isset($_SESSION['va']['VideoSize'] ) && $_SESSION['va']['VideoSize']==2){echo "checked";} ?> > VGA
									</label>
									<label class="btn btn-default <?php if(isset($_SESSION['va']['VideoSize'] ) && $_SESSION['va']['VideoSize']==1){echo "active";} ?>">
										<input type="radio" name="VideoSize" id="QVGA" autocomplete="off" value="1"  <?php if(isset($_SESSION['va']['VideoSize'] ) && $_SESSION['va']['VideoSize']==1){echo "checked";} ?> > QVGA
									</label>
								</div>
							</div>
							<div class="col-md-4">
								<input class="btn btn-primary btn-block" type="submit" value="Einstellungen übernehmen">
							</div>
						</form>
					</div>
					<?php if(isset($_SESSION['va']['SettingsPosted'] ) && $_SESSION['va']['SettingsPosted']==1){ ?>
					<hr>
					<div class="row">
						<div class="col-md-6 select">
							<label for="audioSource">Audio Quellen: </label><select id="audioSource" class="form-control" name="audioSource"></select>
						</div>
						<div class="col-md-4 select" style="display:none;">
							<label for="audioOutput">Audio Ausgang: </label><select id="audioOutput" class="form-control" name="audioOutput" ></select>
						</div>
						<div class="col-md-6 select">
							<label for="videoSource">Video Quelle: </label><select id="videoSource" class="form-control" name="videoSource" ></select>
						</div>
					</div>
					<?php if(isset($_SESSION['va']['videoSource'])){ ?>
					<script>
						document.getElementById("audioSource").value = "<?php echo $_SESSION['va']['videoSource']; ?>";
						document.getElementById("audioOutput").value = "<?php echo $_SESSION['va']['audioOutput']; ?>";
						document.getElementById("videoSource").value = "<?php echo $_SESSION['va']['videoSource']; ?>";
					</script>
					<?php } ?>
					<hr>
					<div class="row">
						<div class="col-md-6" style="margin-bottom:10px;">
							<!-- 1. Include action buttons play/stop -->
							<button class="btn btn-primary" id="btn-start-recording">Aufnahme starten</button>
							<button class="btn btn-danger" id="btn-stop-recording" disabled="disabled">Aufnahme stoppen</button>
						</div>
						<div class="col-md-6" id="recordingslist">
							<?php if(isset($_SESSION['va']['videoArr']) && is_array($_SESSION['va']['videoArr'])){
						echo "<h3 style='margin-top:0; padding-top:0;'>Liste der Aufnahmen:</h3>";
						foreach($_SESSION['va']['videoArr'] as $Video){
							?>
							<div class="row">
								<div class="col-md-12">
									<form action method="post"  class="form-inline">
										<div class="form-group mb-12">

											<a style="height:34px;" class="btn btn-primary" href="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/media/video/<?php echo $Video['fileName']; ?>" download target="_blank"><i class="glyphicon glyphicon-download-alt"></i></a>
											<a style="height:34px;" class="btn btn-default" href="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/media/video/<?php echo $Video['fileName']; ?>" target="_blank"><i class="glyphicon glyphicon-play"></i></a>
											<input type="hidden" name="action" value="SelectVideo">
											<input type="hidden" value="<?php echo $Video['fileName']; ?>" name="videoID">
											<?php if($Video['abgegeben']==0){ ?>
											<button class="btn btn-default " type="submit">Use this</button>
											<?php }else{ ?>
											<button class="btn btn-success " type="submit">Used</button>
											<?php } ?>
										</div>
									</form>

								</div>
							</div>
							<?php
						}
					} ?>
						</div>
					</div>

					<!--
2. Include a video element that will display the current video stream
and as well to show the recorded video at the end.
-->
					<hr>
					<div>
						<video playsinline id="my-preview" controls autoplay style="max-width:100%;"></video>
					</div>


					<!-- 
3. Include the RecordRTC library and the latest adapter.
Note that you may want to host these scripts in your own server
-->
					<script src="https://cdn.webrtc-experiment.com/RecordRTC.js"></script>
					<script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
					<script src="webrtc.js" async></script>

					<?php
																											   }
					}
					?>

				</div>
				<div class="col-md-1"></div>
			</div>
		</div>
	</body>
	<div id="debugDiv" style="position:absolute; bottom:2px; right:2px;"></div>
	<script>
		if (typeof console  != "undefined") 
			if (typeof console.log != 'undefined')
				console.olog = console.log;
			else
				console.olog = function() {};

		console.log = function(message) {
			console.olog(message);
			$('#debugDiv').append('<p>' + message + '</p>');
		};
		console.error = console.debug = console.info =  console.log
	</script>
</html>