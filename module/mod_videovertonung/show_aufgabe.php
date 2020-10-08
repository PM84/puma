<?php
// if($_SERVER['HTTPS']!="On"){header("LOCATION: https://www.physik-workshop.de");}
if(isset($_SERVER['HTTPS'])){
}else{
	header("LOCATION: https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
}

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/session_delay_token.php");
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/kursInfos.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/Sessions.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/system.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/videos.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/folie.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/abgabe.php");

// echo $_SESSION['s'];

$fID=intval($_GET['f']);
$_SESSION['fID']=$fID;


// ========================
// ====== AUFNAHME ABGEBEN
// ========================

if(isset($_POST['fileName'])){
	$fID=intval($_POST['fID']);
	$fileName=mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($_POST['fileName']), ENT_QUOTES , "UTF-8"));
	// 	$token=mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($_POST['token']), ENT_QUOTES , "UTF-8"));
	$token=$_SESSION['t'];


	$query="SELECT * FROM abgabe WHERE fID='$fID' AND token='$token' AND abTyp=1";
	// 	echo "=>$query<=";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	if(mysqli_num_rows($ergebnis)==1){
		$row=mysqli_fetch_assoc($ergebnis);
		$parameter=json_decode($row['parameter']);
		$audioArr=$parameter->audioArr;
		if($audioArr===NULL){
			$audioArr=[];
		}
	}
	$tmpArr=[];
	foreach($parameter->audioArr as $audiofile){
		if($audiofile->fileName==$fileName){
			$audiofile->abgegeben=1;
			array_push($tmpArr,$audiofile);
		}else{
			$audiofile->abgegeben=0;
			array_push($tmpArr,$audiofile);
		}
	}
	$parameter->audioArr=$tmpArr;
	$parameter=json_encode($parameter);
	$query="UPDATE abgabe SET parameter='$parameter' WHERE fID='$fID' AND token='$token'";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	unset($_POST);
}


// ========================
// ====== FOLIE ZUM BEARBEITEN LADEN
// ========================
if(intval($_GET['f'])>0){
	// 	$fID=intval($_GET['f']);
	// 	$fID=62;
	// 	$_SESSION['fID']=$fID;
	//  	echo $_GET['f'];
	$FolieArr=getFolieInfo($_SESSION['fID']);
	//   	echo $FolieArr['parameter'];
	$AufgabeInfo=json_decode($FolieArr['parameter']);
	
	$_SESSION['vID']=$AufgabeInfo->vID;
	$videos=Get_Videos_Liste();
	$videoInfo=Get_VideoInfos_By_vID($videos,intval($_SESSION['vID']));
	$link_src=get_video_link($videoInfo,"sd");
	$link_src_hd=get_video_link($videoInfo,"hd");
}

// ========================
// ====== AUFNAHMEN LADEN
// ========================

if(intval($_GET['f'])>0){
	// 	$fID=intval($_GET['f']);
	//  	echo $_GET['f'];
	$token=$_SESSION['t'];
	$AbgabeArr=getAbgabeInfo($_SESSION['fID'],$token,1);
	
	if(isset($AbgabeArr['parameter'])){
		$AbgabeInfo=json_decode($AbgabeArr['parameter']);
		$audioArr=$AbgabeInfo->audioArr;
		$abgegeben=0;
		foreach($audioArr as $audio){
			if($audio->abgegeben==1){
				$abgegeben=1;
				break;
			}
		}
	}
}

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
		<style>

			.blink_object {
				animation: blinker 2s linear infinite;
			}

			@keyframes blinker {
				50% {
					opacity: 0;
				}
			}
		</style>

	</head>
	<body>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/header_bar.php");?>

		<div class="container" style="padding-bottom:50px;">
			<div class="row" style='margin-top:0px;'>
				<div class="col-md-2"></div>
				<div class="col-md-8">
					<?php 
					// 					echo "======{$AbgabeArr['abID']},$fID==========";
					if(count($AbgabeArr)>0){
						// 						echo "======".$AbgabeArr['abID']."======";
						$abID=$AbgabeArr['abID'];
						$FBArr=getAbgabeInfos_with_Feedback(intval($_GET['f']),$abID);
						if(count($FBArr)>0){
					?>
					<div class="alert alert-success"><h3>Feedback vorhanden:</h3>
						<?php
							$fbArr=[];
							foreach($FBArr as $Feedback){
								$FabID=$Feedback['F_abID'];
								$Name=$Feedback['name'].", ".$Feedback['vname'];
								array_push($fbArr,"<a href='".$_SESSION['DOCUMENT_ROOT_DIR']."/module/mod_videovertonung/show_feedback_vertonung.php?abID=$FabID' target='blank'>Feedback von: $Name</a>");
							}
							$fbLinks=join("<br>",$fbArr);
							echo $fbLinks;
						?>
					</div>
					<?php

						}else{
					?>
					<div class="alert alert-info"><h2>Aktuell ist noch kein Feedback vorhanden.</h2></div>
					<?php
						}
					}
					?>

					<p class="lead"><?php echo html_entity_decode ($AufgabeInfo->titel, ENT_QUOTES , "UTF-8"); ?></p>
					<div id="taskTXT" class="collapse in">
						<p class=""><?php echo html_entity_decode ($AufgabeInfo->beschreibung, ENT_QUOTES , "UTF-8"); ?></p>
					</div>				
					<input type="checkbox" class="read-more-state" id="rm1" data-toggle="collapse" data-target="#taskTXT"/>
					<label for="rm1" class="read-more-trigger"></label>
					<hr>
					<video poster="" id="video" class="video" controls preload="auto" width="100%" data-setup="{}" muted style='background-color:gray;'>
						<source src="<?php echo $link_src; ?>" type='video/mp4'>
					</video>

					<script>
						var videoElement = document.getElementById("video");
						// 						console.log(videoElement);
						videoElement.addEventListener("progress", bufferHandler);
						function bufferHandler(e)
						{
							if (videoElement && videoElement.buffered && videoElement.buffered.length > 0 && videoElement.buffered.end && videoElement.duration)
							{

								var buffered = e.target.buffered.end(0);
								var duration = e.target.duration;
								var buffered_percentage = (buffered / duration) * 100;
								console.log(buffered_percentage);
							}
						}
					</script>

					<br><br>
					<?php
					if(!isset($abgegeben)){$abgegeben=0;}
					switch($abgegeben){
						case 0:
					?>
					<button class="btn btn-primary" id="start-recording" onclick="startRecording()">Aufnahme beginnen</button>
					<button class="btn btn-default" id="stop-recording" onclick="stopRecording()">Aufnahme stoppen</button>
					<span class="alert alert-danger hidden blink_object" id="recInfo" style="padding:8px;">REC</span>
					<?php
							break;
					}
					?>					<hr>
					<h4>Liste meiner Aufnahmen:</h4>
					<div id="recordingslist">

						<?php

						if(isset($AbgabeArr['parameter'])){
							foreach($audioArr as $audio){

								switch($abgegeben){
									case 0:
										$id=uniqid();
						?>
						<div class="row" style="padding:0; border-bottom:solid lightgray 2px; padding-bottom:5px; padding-top:5px;">
							<div class="col-md-4" style="text-align:center; margin-bottom:5px;">
								<audio id="<?php echo $id;?>" controls="" src="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/media/audio/<?php echo $audio->fileName;?>" style="display: none;"></audio>
								<button type="button" class="glyphicon glyphicon-step-backward btn btn-default" onclick="StepBackwardAll('<?php echo $id;?>')"></button>
								<button type="button" class="glyphicon glyphicon-stop btn btn-default" onclick="StopAll('<?php echo $id;?>')"></button>
								<button type="button" class="glyphicon glyphicon-pause btn btn-default" onclick="PauseAll('<?php echo $id;?>')"></button>
								<button type="button" class="glyphicon glyphicon-play btn btn-default" onclick="PlayAll('<?php echo $id;?>')"></button>
								<button type="button" class="glyphicon glyphicon-step-forward btn btn-default" onclick="StepForwardAll('<?php echo $id;?>')"></button>
							</div>
							<div class="col-md-4" style="margin-bottom:5px;">
								<a href="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/media/audio/<?php echo $audio->fileName;?>" download="Diese Aufnahme downloaden" class="btn btn-default" style="width:100%;">Diese Aufnahme downloaden</a>
							</div>
							<div class="col-md-4"style="margin-bottom:5px;">
								<form method="post" action="" style='margin-bottom:0;'>
									<input type="hidden" name="fileName" value="<?php echo $audio->fileName;?>">
									<input type="hidden" name="fID" value="<?php echo $_SESSION['fID'];?>">
									<input type="hidden" name="token" value="<?php echo $token;?>">
									<input class="btn btn-success" value="Diese Aufnahme abgeben" type="submit" style="width:100%;">
								</form>
							</div>
						</div>

						<?php
										break;

									case 1:
										$id=uniqid();
										if($audio->abgegeben==1){
						?>

						<div class="row" style="padding:0">
							<div class="col-md-4" style="text-align:center;margin-bottom:5px;">
								<audio id="<?php echo $id;?>" controls="" src="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/media/audio/<?php echo $audio->fileName;?>" style="display: none;"></audio>
								<!--<div class="glyphicon glyphicon-stop" style="width:100%;" onclick="Video_Audio_Play('<?php echo $id;?>')">abspielen</div>//-->
								<button class="glyphicon glyphicon-step-backward btn btn-default" onclick="StepBackwardAll('<?php echo $id;?>')"></button>
								<button class="glyphicon glyphicon-stop btn btn-default" onclick="StopAll('<?php echo $id;?>')"></button>
								<button class="glyphicon glyphicon-pause btn btn-default" onclick="PauseAll('<?php echo $id;?>')"></button>
								<button class="glyphicon glyphicon-play btn btn-default" onclick="PlayAll('<?php echo $id;?>')"></button>
								<button class="glyphicon glyphicon-step-forward btn btn-default" onclick="StepForwardAll('<?php echo $id;?>')"></button>
								<!--<div class="glyphicon glyphicon-stop" style="width:100%;" onclick="Video_Audio_Play('<?php echo $id;?>')">abspielen</div>//-->
							</div>
							<div class="col-md-4" style="margin-bottom:5px;">
								<a href="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/media/audio/<?php echo $audio->fileName;?>" download="Diese Aufnahme downloaden" class="btn btn-default" style="width:100%;">Diese Aufnahme downloaden</a>
							</div>
							<div class="col-md-4" style="margin-bottom:5px;">
								<div class="btn btn-danger" value="" type="button" style="width:100%;">Bereits abgeben</div>
							</div>
						</div>
						<?php
											break;

										}
								}
							}
						}

						?>
					</div>
					<div id="record-audio"></div>
				</div>
				<div class="col-md-2">
				</div>
			</div>

		</div>
		<?php
		// 		if($abgegeben==0 ){
		include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/module/mod_videovertonung/modal_erklaerung.php");
		// 		}
		?>

		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/bottom_main.php");?>
	</body>

	<script>


		function show_RecInfo(){
			$( "#recInfo" ).removeClass( "hidden" )
		}
		function remove_RecInfo(){
			$( "#recInfo" ).addClass( "hidden" )
		}


		var uniqueID;


		function guid() {
			return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
				s4() + '-' + s4() + s4() + s4();
		}
		function s4() {
			return Math.floor((1 + Math.random()) * 0x10000)
				.toString(16)
				.substring(1);
		}

		function Start_Stop_Aufnahme(){
			var video = document.getElementById("video");
			// 		var button = document.getElementById("start_stop2");
			video.currentTime=0;

			if (video.paused) {
				video.load();
				video.play();
			}else {
				video.pause();
			}
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


		function Abgabe(fid,filename){
			var xhr=new XMLHttpRequest();
			xhr.onload=function(e) {
				if(this.readyState === 4) {
					console.log("Server returned: ",e.target.responseText);
				}
			};
			var fd=new FormData();
			fd.append("token", "<?php echo $_SESSION['t']; ?>");
			fd.append("fID",fid);
			fd.append("fileName",filename);
			xhr.open("POST","php/set_vertonung_abgabe.php",true);
			xhr.send(fd);
		}

		function upload(blob) {

			// 			alert(blob);
			var xhr=new XMLHttpRequest();
			xhr.onload=function(e) {
				if(this.readyState === 4) {
					console.log("Server returned: ",e.target.responseText);
				}
			};
			var fd=new FormData();
			fd.append("file",blob);
			fd.append("token", "<?php echo $_SESSION['t']; ?>");
			fd.append("fID","<?php echo  $_SESSION['fID']; ?>");
			fd.append("fileName","<?php echo  $_SESSION['fID']."_".$_SESSION['t']."_";?>"+uniqueID+".wav");
			fd.append("uniqueID",""+uniqueID+"");
			xhr.open("POST","php/insert_audio.php",true);
			xhr.send(fd);
		}

		function captureUserMedia(mediaConstraints, successCallback, errorCallback) {
			navigator.mediaDevices.getUserMedia(mediaConstraints).then(successCallback).catch(errorCallback);
		}

		var mediaConstraints = {
			audio: true
		};
// Triggert die Nachfrage zur Freigabe des Mikrofons beim Laden der Seite.
captureUserMedia(mediaConstraints);

		function startRecording(idx) {
			// 		vidplay();
			show_RecInfo();
			Start_Stop_Aufnahme();
			jQuery('#start-recording').disabled = true;
			// 		$('#start-recording').val()="Aufnahme Stoppen";
			audiosContainer = document.getElementById('audios-container');
			captureUserMedia(mediaConstraints, onMediaSuccess, onMediaError);
		};

		function stopRecording() {
			// 		vidplay();
			remove_RecInfo();
			Start_Stop_Aufnahme();
			jQuery('#start-recording').disabled = true;
			mediaRecorder.stop();
			mediaRecorder.stream.stop();
			jQuery('#start-recording').disabled = false;
		};

		var mediaRecorder;

		function onMediaSuccess(stream) {
			mediaRecorder = new MediaStreamRecorder(stream);
			mediaRecorder.stream = stream;
			mediaRecorder.mimeType = 'audio/wav';
			mediaRecorder.audioChannels = 1;
			mediaRecorder.ondataavailable = function(blob) {

				var url = URL.createObjectURL(blob);
				uniqueID=guid();
				upload(blob);

				var date = new Date();
				/* 			var day = date.getDay();
			var month = date.getMonth();
			var year = date.getFullYear();
			var hour=date.getHours();
			var minute=date.getMinutes();
			var second=date.getSeconds();
			var milli=date.getMilliseconds();
 */
				var rowDiv = document.createElement('div');
				rowDiv.setAttribute('class',"row");
				rowDiv.setAttribute('style',"width:100%;");
				rowDiv.setAttribute('style',"padding:0;");

				var n = date.getTime();
				var AudioID="play_"+n;
				var au = document.createElement("audio");
				au.id=""+AudioID+"";
				au.style.cssText = 'display:none;';
				au.controls = true;
				au.src = url;

				var innerDiv1 = document.createElement('div');
				innerDiv1.setAttribute('class',"col-md-4");

				var But_StepBW = document.createElement('button');
				But_StepBW.onclick=function(){StepBackwardAll(AudioID);};
				But_StepBW.setAttribute('class','glyphicon glyphicon-step-backward btn btn-default');
				innerDiv1.appendChild(But_StepBW);

				var But_Stop = document.createElement('button');
				But_Stop.onclick=function(){StopAll(AudioID);};
				But_Stop.setAttribute('class','glyphicon glyphicon-stop btn btn-default');
				innerDiv1.appendChild(But_Stop);

				var But_Pause = document.createElement('button');
				But_Pause.onclick=function(){PauseAll(AudioID);};
				But_Pause.setAttribute('class','glyphicon glyphicon-pause btn btn-default');
				innerDiv1.appendChild(But_Pause);

				var But_Play = document.createElement('button');
				But_Play.onclick=function(){PlayAll(AudioID);};
				But_Play.setAttribute('class','glyphicon glyphicon-play btn btn-default');
				innerDiv1.appendChild(But_Play);

				var But_StepFW = document.createElement('button');
				But_StepFW.onclick=function(){StepForwardAll(AudioID);};
				But_StepFW.setAttribute('class','glyphicon glyphicon-step-forward btn btn-default');
				innerDiv1.appendChild(But_StepFW);

				innerDiv1.appendChild(au);
				rowDiv.appendChild(innerDiv1);			


				var innerDiv2 = document.createElement('div');
				innerDiv2.setAttribute('class',"col-md-4");
				var DL = document.createElement('a'); 
				DL.href = url;
				DL.download = "Diese Aufnahme downloaden";
				DL.innerHTML = DL.download;
				DL.setAttribute('class',"btn btn-default");
				DL.setAttribute('style',"width:100%;");
				innerDiv2.appendChild(DL);
				rowDiv.appendChild(innerDiv2);


				var innerDiv3 = document.createElement('div');
				innerDiv3.setAttribute('class',"col-md-4");
				rowDiv.appendChild(innerDiv3);

				var f = document.createElement("form");
				f.setAttribute('method',"post");
				f.setAttribute('action',"");

				var inputhidden1 = document.createElement("input"); //input element, text
				inputhidden1.setAttribute('type',"hidden");
				inputhidden1.setAttribute('name',"fileName");
				inputhidden1.setAttribute('value',"<?php echo  $_SESSION['fID']."_".$_SESSION['t']."_";?>"+uniqueID+".wav");
				f.appendChild(inputhidden1);

				var inputhidden2 = document.createElement("input"); //input element, text
				inputhidden2.setAttribute('type',"hidden");
				inputhidden2.setAttribute('name',"fID");
				inputhidden2.setAttribute('value',"<?php echo  $_SESSION['fID'];?>");
				f.appendChild(inputhidden2);

				var inputhidden3 = document.createElement("input"); //input element, text
				inputhidden3.setAttribute('type',"hidden");
				inputhidden3.setAttribute('name',"token");
				inputhidden3.setAttribute('value',"<?php echo $_SESSION['t'];?>");
				f.appendChild(inputhidden3);


				var But1 = document.createElement('input'); 
				But1.setAttribute('class',"btn btn-success");
				But1.setAttribute('value',"Diese Aufnahme abgeben");
				But1.setAttribute('type',"submit");
				But1.setAttribute('style',"width:100%;");
				f.appendChild(But1);
				innerDiv3.appendChild(f);


				recordingslist.appendChild(rowDiv);
			};

			var timeInterval = 360 * 1000;

			mediaRecorder.start(timeInterval);
			jQuery('#stop-recording').disabled = false;
		}

		function onMediaError(e) {
			console.error('media error', e);
		}

		function bytesToSize(bytes) {
			var k = 1000;
			var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
			if (bytes === 0) return '0 Bytes';
			var i = parseInt(Math.floor(Math.log(bytes) / Math.log(k)), 10);
			return (bytes / Math.pow(k, i)).toPrecision(3) + ' ' + sizes[i];
		}

		function getTimeLength(milliseconds) {
			var data = new Date(milliseconds);
			return data.getUTCHours() + " hours, " + data.getUTCMinutes() + " minutes and " + data.getUTCSeconds() + " second(s)";
		}

		window.onbeforeunload = function() {
			jQuery('#start-recording').disabled = false;
		};

	</script>
</html>