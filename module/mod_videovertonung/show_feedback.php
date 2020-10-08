<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/session_delay_token.php");
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/kursInfos.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/Sessions.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/videos.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/folie.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/abgabe.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/frage.php");

// echo "Hallo1=";

$abTyp=2; //Bewertung
$token=$_SESSION['t'];
$FB_fID=intval($_GET['f']);
// $fID=intval($_GET['f']);
$_SESSION['fID']=$FB_fID;

$FB_FolieArr=getFolieInfo($FB_fID);
// echo "Hallo2<br>";
$Bew_fID=$FB_FolieArr['zu_fID'];

$Bew_FolieArr=getFolieInfo($Bew_fID);
// echo "Hallo2<br>";
$task_fID=$Bew_FolieArr['zu_fID'];

$abID=getAbgabe_abID($task_fID);
// echo "Hallo3<br>";

// ========================
// ====== ABGABE LADEN
// ========================
// if(intval($_GET['ab'])>0){
// 	$abID=intval($_GET['ab']);
$AbgabeInfoRow=getAbgabeInfoByAbID($abID);
$AbgabeInfo=json_decode($AbgabeInfoRow['parameter']);

$audioArr=$AbgabeInfo->audioArr;
foreach($audioArr as $audioTMP){
	if($audioTMP->abgegeben==1){
		// 			$abgegeben=1;
		$audio=$audioTMP;
	}
}
$audioID=uniqid();
// }

// ========================
// ====== FOLIENDATEN LADEN
// ========================
if($FB_fID>0){

	$Bew_FolieArr=getFolieInfo($Bew_fID);
	$task_fID=$Bew_FolieArr['zu_fID'];
	$FolieArr=getFolieInfo($task_fID);
	
	// 	 	echo $FolieArr['parameter'];
	$AufgabeInfo=json_decode($FolieArr['parameter']);
	$_SESSION['vID']=$AufgabeInfo->vID;
	// 	echo $_SESSION['vID']."<hr>";
	$videos=Get_Videos_Liste();
	$videoInfo=Get_VideoInfos_By_vID($videos,intval($_SESSION['vID']));
	
	$link_src=get_video_link($videoInfo,"sd");
	// 	$link_src_arr=$videoInfo->link_src;
}
// echo "Hallo";

// ========================
// ====== KORREKTUREN LADEN
// ========================
// echo $abID;

$abArrKor= get_zu_AbgabeInfoByAbID($abID,$Bew_fID);

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

		<div class="container">
			<div class="row" style='margin-top:0px;'>
				<!--<div class="col-md-1"></div>//-->
				<div class="col-md-6">
					<p class="lead">Feedback - <?php echo $videoInfo->titel; ?></p>
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
							<button type="button" class="glyphicon glyphicon-step-backward" onclick="StepBackwardAll('audio')"></button>
							<button type="button" class="glyphicon glyphicon-stop" onclick="StopAll('audio')"></button>
							<button type="button" class="glyphicon glyphicon-pause" onclick="PauseAll('audio')"></button>
							<button type="button" class="glyphicon glyphicon-play btn-success" onclick="PlayAll('audio')"></button>
							<button type="button" class="glyphicon glyphicon-step-forward" onclick="StepForwardAll('audio')"></button>
						</div>
						<div class="col-md-3" style="text-align:right;">
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#fragen">Fragen</a></li>
						<li><a data-toggle="tab" href="#comment">Kommentar</a></li>
						<li><a data-toggle="tab" href="#marker">Marker</a></li>
					</ul>

					<div class="tab-content">

						<div id="fragen" class="tab-pane fade in active">
							<div id="fragenBox">
								<div class="row"><div class="col-sm-6 col-md-8"></div><div id='parent' class="col-sm-6 col-md-4"></div></div></div>
							<script>
								$( document ).ready(function() {GetFeedback();});
							</script>
						</div>

						<div id="comment" class="tab-pane fade">
							<?php
							
							foreach($abArrKor as $abgabeKor){

								
								$parameter=json_decode($abgabeKor['parameter']);
								if(isset($parameter->kommentar)){
									if(strlen($parameter->kommentar)>0){
							?>

							<div style='display:block; padding:10 0 10 0; width:100%; vertical-align:middle; border-bottom: 1px solid gray;'><?php echo $parameter->kommentar; ?></div>
							<?php
									}
								}
							}
							?>
						</div>

						<div id="marker" class="tab-pane fade">
							<?php
							foreach($abArrKor as $abgabeKor){
								$parameter=json_decode($abgabeKor['parameter']);
								if(isset($parameter->PosTxtArr) && isset($parameter->PosTimeArr)  ){
									$PosTxtArr=$parameter->PosTxtArr;
									$PosTimeArr=$parameter->PosTimeArr;

									for($iLauf=0;$iLauf<count($parameter->PosTxtArr);$iLauf++){
										if(intval($PosTimeArr[$iLauf])>0){
							?>

							<h4>Markierung bei <?php echo round($PosTimeArr[$iLauf]); ?>s</h4>
							<input value='Marker abspielen' class='btn btn-default' onclick='VideoPlayFromPos(" <?php echo $PosTimeArr[$iLauf]; ?>")'>
							<div style='display:block; padding:10 0 10 0; width:100%; vertical-align:middle; border-bottom: 1px solid gray;'><?php echo $PosTxtArr[$iLauf]; ?></div>

							<?php
										}
									}
								}
							}
							?>
						</div>
					</div>

				</div>
			</div>
		</div>

		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/bottom_main.php");?>

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


			// 				alert("Teast");
			function GetFeedback(){
				//  				alert("Hallo");
				// 										alert("F:"+FrageID+"& A:"+aufgabeID);
				jQuery.ajax({
					type: 'POST',
					url: '/php/statistik.php',
					data: {
						PostFktn:"GetKonfidentsChart",
						bew_fID:<?php echo $Bew_fID; ?>,
						abID:<?php echo $abID; ?>
					},
					dataType: 'json',
					success: function (data) {
						console.log(data);
						// 						alert(data);

						// 							for(var i in data)
						for(var i in data)
						{
							if (typeof data[i] != 'undefined'){
								var FrageID=data[i]['FrageID'];
								var n=data[i]['n'];
								var MW=data[i]['MW'];
								var StdAbw=data[i]['StdAbw'];
								var Varianz=data[i]['Varianz'];
								var FragenInfoArr=data[i]['FragenInfoArr'];
								var WidthCanvas=$("#parent").width();
								if (typeof data['own'] != 'undefined'){var own_values=data['own'];}else{own_values[FrageID]=0;}
								if (typeof FragenInfoArr[FrageID][0]['FrageMax'] != 'undefined'){var maxValue=FragenInfoArr[FrageID][0]['FrageMax'];}else{maxValue=100;}
								var MiddleLine=15;
								var canvas=document.createElement('canvas');
								canvas.setAttribute('Style','background: lightgray; border: 2px white; border-radius:5px;');
								canvas.setAttribute('width',WidthCanvas);
								canvas.setAttribute('height','60');

								var ctx = canvas.getContext("2d");
								ctx.font = "12px Arial";
								ctx.fillText("n="+n + "     E="+Math.round(MW*10)/10 +  "     s="+Math.round(StdAbw*10)/10,5,45);
								ctx.moveTo(0,MiddleLine);
								ctx.lineTo(WidthCanvas,MiddleLine);
								ctx.stroke();

								ctx.beginPath();
								ctx.arc(WidthCanvas/maxValue*MW,MiddleLine,5,0,2*Math.PI);
								ctx.fill();
								ctx.stroke();

								ctx.moveTo(WidthCanvas/maxValue*(MW-StdAbw),MiddleLine-5);
								ctx.lineTo(WidthCanvas/maxValue*(MW-StdAbw),MiddleLine+5);
								ctx.stroke();

								ctx.moveTo(WidthCanvas/maxValue*(MW+StdAbw),MiddleLine-5);
								ctx.lineTo(WidthCanvas/maxValue*(MW+StdAbw),MiddleLine+5);
								ctx.stroke();

								ctx.moveTo(WidthCanvas/maxValue*(MW-StdAbw),MiddleLine);
								ctx.lineTo(WidthCanvas/maxValue*(MW+StdAbw),MiddleLine);
								ctx.lineWidth = 5;
								ctx.stroke();
							}

							var row=document.createElement('div');
							row.setAttribute('class','row');
							row.setAttribute('style','width:100%; border-bottom: 1px lightgray solid;padding:5px;');

							var CellLeft=document.createElement('div');
							CellLeft.setAttribute('class','col-sm-6 col-md-8');
							CellLeft.innerHTML = FragenInfoArr[FrageID][0]['FrageTXT'];

							var CellRight=document.createElement('div');
							CellRight.id=FrageID;
							CellRight.setAttribute('class','col-sm-6 col-md-4');
							CellRight.appendChild(canvas);
							CellRight.setAttribute('Style','height:60px; min-width:'+WidthCanvas+'px;');

							var fBox=document.getElementById("fragenBox");
							row.appendChild(CellLeft);
							row.appendChild(CellRight);
							fBox.appendChild(row);

							if(own_values!=null){
								ctx.beginPath();
								ctx.arc(WidthCanvas/maxValue*own_values[FrageID],MiddleLine,2,0,2*Math.PI);
								ctx.fillStyle="lime";
								ctx.fill();
								ctx.strokeStyle="lime";
								ctx.stroke();
								ctx.fillStyle="black";
							}

							if (typeof data["dozent"][i] != 'undefined'){
								var FrageID=data["dozent"][i]['FrageID'];
								var n=data["dozent"][i]['n'];
								var MW=data["dozent"][i]['MW'];
								var StdAbw=data["dozent"][i]['StdAbw'];
								var Varianz=data["dozent"][i]['Varianz'];
								var FragenInfoArr=data["dozent"][i]['FragenInfoArr'];

								ctx.beginPath();
								ctx.arc(WidthCanvas/maxValue*MW,MiddleLine,2,0,2*Math.PI);
								ctx.fill();
								ctx.strokeStyle = '#ff0000';

								ctx.stroke();

								ctx.moveTo(WidthCanvas/maxValue*(MW-StdAbw),MiddleLine-5);
								ctx.lineTo(WidthCanvas/maxValue*(MW-StdAbw),MiddleLine+5);
								ctx.lineWidth = 2;
								ctx.strokeStyle = '#ff0000';
								ctx.stroke();

								ctx.moveTo(WidthCanvas/maxValue*(MW+StdAbw),MiddleLine-5);
								ctx.lineTo(WidthCanvas/maxValue*(MW+StdAbw),MiddleLine+5);
								ctx.lineWidth = 2;
								ctx.strokeStyle = '#ff0000';
								ctx.stroke();

								ctx.moveTo(WidthCanvas/maxValue*(MW-StdAbw),MiddleLine);
								ctx.lineTo(WidthCanvas/maxValue*(MW+StdAbw),MiddleLine);
								ctx.lineWidth = 2;
								ctx.strokeStyle = '#ff0000';
								ctx.stroke();
							}
						}
					},
					error:function(xhr, ajaxOptions, thrownError){
						alert(xhr);
						alert(thrownError);
					},
					async:true
				});
			}
		</script>

	</body>
</html>