<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/header_php.php");

$ausserhalbKurs=1;
// ========================
// ========================
// ====== VIDEOVERTONUNG - Feedback
// ========================
// ========================

include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/session_delay_token.php");
// include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/kursInfos.php");
// include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/Sessions.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/videos.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/folie.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/system.php");
// include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/module.php");
// include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/media.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/abgabe.php");
// include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/teilnehmer.php");
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");

// Teilnehmerliste laden:
// $TeilnehmerListe=getTeilnehmerListeInfos($_SESSION['kursID']);

$uID=$SessionInfos['uID'];
$kursID=intval($_SESSION['kursID']);
$abID=$_GET['abID'];
$FBInfoArr=getAbgabeInfoByAbID($abID); // abgegebenes Feedback
$AbgabeInfoRow=getAbgabeInfoByAbID($FBInfoArr['zu_abID']); // abgegebene Originalaufgabe
$token=$_SESSION['t'];

$abTyp=2; //Bewertung
$FB_fID=$FBInfoArr['fID'];
// $_SESSION['fID']=$FB_fID;
$FolieArr=getFolieInfo($FB_fID);

$Bew_fID=$FB_fID;
// $Bew_FolieArr=getFolieInfo($Bew_fID);
// echo "Hallo2<br>";
// $task_fID=$Bew_FolieArr['zu_fID'];
// $abID=getAbgabe_abID($task_fID);
// echo "Hallo3<br>";



?>

<html>
	<head>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/head_main.php");?>

		<script src="AudioRecorder/MediaStreamRecorder.js"></script>
		<script src="AudioRecorder/gumadapter.js"></script>
		<script>	
			Object.defineProperty(HTMLMediaElement.prototype, 'playing', {
				get: function(){
					return !!(this.currentTime > 0 && !this.paused && !this.ended && this.readyState > 2);
				}
			})
		</script>

	</head>
	<body>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/header_bar.php");?>

		<div class="container" style="padding-bottom:50px;">
			<?php  if($AbgabeInfoRow['token']!=$token){ ?>
			<div class="row" style='margin-top:0px;'>
				<div class="col-md-1"></div>
				<div class="col-md-10 alert alert-danger">Sie haben keinen Zugriff auf dieses Feedback!</div>
				<div class="col-md-1"></div>
			</div>
			<?php }else{ 

	// ========================
	// ====== ABGABE LADEN (Audio laden)
	// ========================
	$AbgabeInfo=json_decode($AbgabeInfoRow['parameter']);
	$audioArr=$AbgabeInfo->audioArr;
	foreach($audioArr as $audioTMP){
		if($audioTMP->abgegeben==1){
			$audio=$audioTMP;
		}
	}
	$audioID=uniqid();

	// ========================
	// ====== FOLIENDATEN LADEN (Video und Aufgabendaten laden)
	// ========================
	if($FB_fID>0){
		$AufgabeInfo=json_decode($FolieArr['parameter']);
		$_SESSION['vID']=$AufgabeInfo->vID;
		$videos=Get_Videos_Liste();
		$videoInfo=Get_VideoInfos_By_vID($videos,intval($_SESSION['vID']));
		$link_src=get_video_link($videoInfo,"sd");
	}

	// ========================
	// ====== KORREKTUREN LADEN
	// ========================
	// 	echo $abID;

	$abArrKor= get_zu_AbgabeInfoByAbID($abID,$Bew_fID);


			?>
			<div class="row" style='margin-top:0px;'>
				<div class="col-md-1"></div>
				<div class="col-md-5">
					<a href='<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/module/mod_videovertonung/show_aufgabe.php?f="<?php echo $FB_fID ?>' class='btn btn-success'>zurück</a><hr>
					<p class="lead">Feedback zu: <b><?php echo $videoInfo->titel; ?></b><br>
						Feedback von: <b><?php echo $FBInfoArr['name'].", ".$FBInfoArr['vname']; ?></b>
					</p>

					<div id="taskTXT" class="collapse in">
						<p class=""><?php echo html_entity_decode ($AufgabeInfo->beschreibung, ENT_QUOTES , "UTF-8"); ?></p>
					</div>	

					<input type="checkbox" class="read-more-state" id="rm1" data-toggle="collapse" data-target="#taskTXT"/>
					<label for="rm1" class="read-more-trigger"></label>

					<p class=""><?php echo $videoInfo->beschreibung; ?></p>
					<video poster="" id="video" class="video" preload="none" width="100%" data-setup="{}" muted style='background-color:gray;'>
						<source src="<?php echo $link_src; ?>" type='video/mp4'>
					</video>
					<audio id="audio" controls="" src="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/media/audio/<?php echo $audio->fileName;?>" style="display: none;"></audio>
					<br><br>
					<?php
					?>
					<div class="row" style="padding:0; padding-bottom:5px; padding-top:5px;">
						<div class="col-md-9" style="text-align:center;">
							<audio id="audio" controls="" src="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/media/audio/<?php echo $audio->fileName;?>" style="display: none;"></audio>
							<button type="button" class="glyphicon glyphicon-step-backward btn btn-default" onclick="StepBackwardAll('audio')"></button>
							<button type="button" class="glyphicon glyphicon-stop btn btn-default" onclick="StopAll('audio')"></button>
							<button type="button" class="glyphicon glyphicon-pause btn btn-default" onclick="PauseAll('audio')"></button>
							<button type="button" class="glyphicon glyphicon-play btn-success btn btn-default" onclick="PlayAll('audio')"></button>
							<button type="button" class="glyphicon glyphicon-step-forward btn btn-default" onclick="StepForwardAll('audio')"></button>
						</div>
						<div class="col-md-3" style="text-align:right;">
						</div>
					</div>
				</div>
				<div class="col-md-5">
					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#comment">Kommentar</a></li>
						<li><a data-toggle="tab" href="#marker">Marker</a></li>
					</ul>

					<div class="tab-content">

						<div id="comment" class="tab-pane fade  in active">
							<?php
	$parameter=json_decode($FBInfoArr['parameter']);
	if(isset($parameter->kommentar)){
		if(strlen($parameter->kommentar)>0){
							?>

							<div style='display:block; padding:10 0 10 0; width:100%;'><?php echo $parameter->kommentar; ?></div>
							<?php
		}
	} ?>
						</div>

						<div id="marker" class="tab-pane fade">
							<?php
	$parameter=json_decode($FBInfoArr['parameter']);
	if(isset($parameter->PosTxtArr) && isset($parameter->PosTimeArr)  ){
		$PosTxtArr=$parameter->PosTxtArr;
		$PosTimeArr=$parameter->PosTimeArr;

		for($iLauf=0;$iLauf<count($parameter->PosTxtArr);$iLauf++){
			if(intval($PosTimeArr[$iLauf])>0){
							?>

							<h4>Markierung bei <?php echo round($PosTimeArr[$iLauf]); ?>s</h4>
							<input type="button" value='Marker abspielen' class='btn btn-default' onclick='VideoPlayFromPos(" <?php echo $PosTimeArr[$iLauf]; ?>")'>
							<div style='display:block; padding:10 0 10 0; width:100%; vertical-align:middle; border-bottom: 1px solid gray;'><?php echo $PosTxtArr[$iLauf]; ?></div>

							<?php
			}
		}
	}
							?>
						</div>
					</div>	
				</div>
				<div class="col-md-1"></div>
			</div>
			<?php } ?>
		</div>
	</body>
	<script>
		function VideoPlayFromPos(vPosTime){
			var video = document.getElementById("video");
			video.currentTime=parseFloat(vPosTime)-3;
			var audio=document.getElementById("audio");
			audio.currentTime=parseFloat(vPosTime)-3;
			video.play();
			audio.play();
		}

		function StepBackwardAll(AudioID){
			PauseAll(AudioID);
			var audio=document.getElementById(AudioID);
			var video = document.getElementById("video");
			audio.currentTime=video.currentTime -5;
			video.currentTime=video.currentTime -5;
			PlayAll(AudioID);
		}

		function StepForwardAll(AudioID){
			PauseAll(AudioID);
			var audio=document.getElementById(AudioID);
			var video = document.getElementById("video");
			audio.currentTime=video.currentTime +5;
			video.currentTime=video.currentTime +5;
			PlayAll(AudioID);
		}

		function PlayAll(AudioID){
			StopAll(AudioID);
			var audio=document.getElementById(AudioID);
			var video = document.getElementById("video");
			audio.play();
			video.play();
		}

		function PlayVideo(){
			var video = document.getElementById("video");
			if(video.playing){ 
				video.pause();
				video.currentTime=0;
			}
		}

		function PauseAll(AudioID){
			var audio=document.getElementById(AudioID);
			var aStatus=0;
			var vStatus=0;
			if(audio.playing){ 
				audio.pause();
			}
			var video = document.getElementById("video");
			if(video.playing){ 
				video.pause();
			}
		}

		function StopAll(AudioID){
			var audio=document.getElementById(AudioID);
			var aStatus=0;
			var vStatus=0;
			if(audio.playing){ 
				audio.currentTime = 0;
				audio.pause();
			}
			var video = document.getElementById("video");
			if(video.playing){ 
				video.currentTime = 0;
				video.pause();
			}
		}
	</script>
</html>