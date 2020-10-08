<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/session_delay_token.php");
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/kursInfos.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/Sessions.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/videos.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/folie.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/abgabe.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/media.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/frage.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/system.php");

$abTyp=2; //Bewertung
$token=$_SESSION['t'];





// ========================
// ====== FOLIENDATEN LADEN
// ========================
if(intval($_GET['f'])>0){
	$fID=intval($_GET['f']);
	$_SESSION['fID']=$fID;
	$FolieArr=getFolieInfo($fID);
	$parameter=json_decode($FolieArr['parameter'],true);
	$videoArr=$parameter['videoArr'];
	$video=null;
	if(is_array($videoArr)){
	foreach($videoArr as $videoTemp){
		if($videoTemp['abgegeben']==1){
			$video=$videoTemp;
		}
	}
	}
}

// ========================
// ====== ABGABE LADEN
// ========================

$FBInfoArr=getAbgabeInfos($fID);


?>
<html>
	<head>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/head_main.php");?>
	</head>
	<body>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/header_bar.php");?>

		<div class="container">
			<div class="row" style='margin-top:0px;'>
				<!--<div class="col-md-1"></div>//-->
				<div class="col-md-6">
					<p class="lead"><?php
						if(isset($_SESSION['eig_vID'])){echo $videoInfo['titel'];}
						if(isset($_SESSION['vID'])){echo $videoInfo->titel;}

						?></p>
					<?php if($video!==null){ ?>
					<video poster="" id="video" class="video" preload="auto" width="100%" data-setup="{}" controls style='background-color:gray;'>
						<source src="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/media/video/<?php echo $video['fileName']; ?>" playsinline controls="true" type='video/webm'>
						<source src="https://jdev.pemasoft.de/tmp_video/<?php echo basename($video['fileName'], '.webm'); ?>.mp4" playsinline controls="true" type='video/mp4'>
					</video>
<!--					<a class="btn btn-default btn-block" style="margin-top:15px;" href="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/media/video/<?php echo $video['fileName']; ?>" download target="blank">Video downloaden</a>//-->
					<br><br>
					<?php } ?>
					<div class="row" style="padding:0; padding-bottom:5px; padding-top:5px;">
						<div class="col-md-9" style="text-align:center;">
							<button type="button" class="btn btn-default glyphicon glyphicon-step-backward" onclick="StepBackwardAll()"></button>
							<button type="button" class="btn btn-default glyphicon glyphicon-stop" onclick="StopAll()"></button>
							<button type="button" class="btn btn-default glyphicon glyphicon-pause" onclick="PauseAll()"></button>
							<button type="button" class="btn btn-success glyphicon glyphicon-play" onclick="PlayAll()"></button>
							<button type="button" class="btn btn-default glyphicon glyphicon-step-forward" onclick="StepForwardAll()"></button>
						</div>
						<div class="col-md-3" style="text-align:right;">
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<?php if(count($FBInfoArr)==0){ ?>
					<div class="alert alert-info">
						Aktuell ist noch kein Feedback vorhanden!
					</div>
					<?php }else{ ?>
					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#comment">Kommentar</a></li>
						<li><a data-toggle="tab" href="#marker">Marker</a></li>
					</ul>

					<div class="tab-content">

						<div id="comment" class="tab-pane fade  in active">
							<?php
	$parameter_fb=json_decode($FBInfoArr[0]['parameter']);

	if(isset($parameter_fb->kommentar)){
		if(strlen($parameter_fb->kommentar)>0){
							?>

							<div style='display:block; padding:10 0 10 0; width:100%;'><?php echo $parameter_fb->kommentar; ?></div>
							<?php
		}
	} ?>
						</div>

						<div id="marker" class="tab-pane fade">
							<?php
// 	$parameter_fb=json_decode($FBInfoArr[0]['parameter']);
	if(isset($parameter_fb->PosTxtArr) && isset($parameter_fb->PosTimeArr)  ){
		$PosTxtArr=$parameter_fb->PosTxtArr;
		$PosTimeArr=$parameter_fb->PosTimeArr;

		for($iLauf=0;$iLauf<count($parameter_fb->PosTxtArr);$iLauf++){
			if(intval($PosTimeArr[$iLauf])>0){
							?>

							<h4>Markierung bei <?php echo round($PosTimeArr[$iLauf]); ?>s</h4>
							<input  type="button" value='Marker abspielen' class='btn btn-default' onclick='VideoPlayFromPos(" <?php echo $PosTimeArr[$iLauf]; ?>")'>
							<div style='display:block; padding:10 0 10 0; width:100%; vertical-align:middle; border-bottom: 1px solid gray;'><?php echo $PosTxtArr[$iLauf]; ?></div>

							<?php
			}
		}
	}
							?>
						</div>
					</div>	
					<?php } ?>
				</div>
			</div>
		</div>


		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/bottom_main.php");?>
	</body>
</html>

<script>

	function VideoPlayFromPos(vPosTime){
		var video = document.getElementById("video");
		video.currentTime=vPosTime-3;
		video.play();
	}

	function StepBackwardAll(){
		PauseAll();
		var video = document.getElementById("video");
		video.currentTime=video.currentTime -5;
		PlayAll();
	}

	function StepForwardAll(){
		PauseAll();
		var video = document.getElementById("video");
		video.currentTime=video.currentTime +5;
		PlayAll();
	}

	function PlayAll(){
		StopAll();
		var video = document.getElementById("video");
		video.play();
	}

	function PlayVideo(){
		var video = document.getElementById("video");
		if(video.playing){ 
			video.pause();
			video.currentTime=0;
		}
	}

	function PauseAll(){
		var video = document.getElementById("video");
		// 		if(video.playing){ 
		video.pause();
		// 		}
	}

	function StopAll(){
		var vStatus=0;
		var video = document.getElementById("video");
		if(video.playing){ 
			video.currentTime = 0;
			video.pause();
		}
	}
</script>