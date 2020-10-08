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
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/system.php");

$abTyp=2; //Bewertung
$token=$_SESSION['t'];



// ========================
// ====== ABGABE LADEN
// ========================
if(intval($_GET['ab'])>0){
	$abID=intval($_GET['ab']);
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
}

// ========================
// ====== FOLIENDATEN LADEN
// ========================
if(intval($_GET['f'])>0){
	$zu_fID=intval($_GET['f']);
	$Bew_FolieArr=getFolieInfo($zu_fID);
	$fID=$Bew_FolieArr['zu_fID'];
	$_SESSION['fID']=$fID;
	$FolieArr=getFolieInfo($fID);
	// 	 	echo $FolieArr['parameter'];
	$AufgabeInfo=json_decode($FolieArr['parameter']);
	$_SESSION['vID']=$AufgabeInfo->vID;
	$videos=Get_Videos_Liste();
	$videoInfo=Get_VideoInfos_By_vID($videos,intval($_SESSION['vID']));
	// 	$link_src_arr=$videoInfo->link_src;
	$link_src=get_video_link($videoInfo,"sd");

	$Bew_parameter=json_decode($Bew_FolieArr['parameter']);
	$fGroupsArr=$Bew_parameter->fGroupsArr;

	$fArr=$Bew_parameter->fArr;
	foreach($fGroupsArr as $FGroupID){
		$FrageID_arr=getFragenByGroups($FGroupID);
		foreach($FrageID_arr as $FrageID_tmp){
			if(!in_array(intval($FrageID_tmp), $fArr, true)){
				array_push($fArr, intval($FrageID_tmp));
			}
		}
	}
}

// ========================
// ====== KORREKTUR SPEICHERN
// ========================
if(count($_POST)>0){
	$insertArr=[];
	$zu_token=$AbgabeInfoRow['token'];

	// ====== Fragen-Werte
	$FragenIDs=$_POST['FrageID'];
	$FragenArr=$_POST['FrageVal'];
	foreach ($FragenArr as $key => $input_arr) {
		$FragenArr[$key] = mysqli_real_escape_string ($verbindung,  htmlentities (mynl2br($input_arr), ENT_QUOTES , "UTF-8"));
	} 
	foreach ($FragenIDs as $key => $input_arr) {
		$FragenIDs[$key] =mysqli_real_escape_string ($verbindung,  htmlentities (mynl2br($input_arr), ENT_QUOTES , "UTF-8"));
	}
	$FrageArr2=[];
	$jLauf=0;
	foreach($FragenIDs as $FrageID){
		$FrageArr2[$FrageID]=$FragenArr[$jLauf];
		$jLauf++;
	}
	$insertArr['FragenWerte']=$FrageArr2;

	// ====== Kommentar
	// 	$korrektur=htmlspecialchars($_POST['kommentar'], ENT_QUOTES);
	$insertArr['kommentar']=mysqli_real_escape_string ($verbindung,  htmlentities (mynl2br($_POST['kommentar']), ENT_QUOTES , "UTF-8"));
	// 	$insertArr['kommentar']=$korrektur;

	// ====== Marker
	if(isset($_POST['pos_Time'])){
		$PosTimeArr=$_POST['pos_Time'];
		$PosTxtArr=$_POST['pos_TXT'];
		foreach ($PosTxtArr as $key => $input_arr) {
			$PosTxtArr[$key] =mysqli_real_escape_string ($verbindung,  htmlentities (mynl2br($input_arr), ENT_QUOTES , "UTF-8"));
		} 
		foreach ($PosTimeArr as $key => $input_arr) {
			$PosTimeArr[$key] =mysqli_real_escape_string ($verbindung,  htmlentities (mynl2br($input_arr), ENT_QUOTES , "UTF-8"));
		} 
	}else{
		$PosTimeArr=[];
		$PosTxtArr=[];

	}
	$insertArr['PosTimeArr']=$PosTimeArr;
	$insertArr['PosTxtArr']=$PosTxtArr;
	if(isset($_POST['btn_abgeben']) && intval($_POST['btn_abgeben'])==1){
		$insertArr['abgegeben']=1;
	}else{
		$insertArr['abgegeben']=0;
	}


	// ====== In DB schreiben
	$insertArr=json_encode($insertArr);
	$datum=date("Y-m-d H:i:s");

	$query="INSERT INTO abgabe (fID,abTyp,token,zu_abID,parameter,datum) VALUES ('$zu_fID','$abTyp','$token','$abID','$insertArr','$datum') ON DUPLICATE KEY UPDATE parameter='$insertArr'";
	mysqli_query($verbindung,$query);

	unset($_POST);
}

// ========================
// ====== KORREKTUR LADEN
// ========================
// echo "==$token,$abTyp,$zu_fID";

// $KorrekturRow=getAbgabeBy_abID_token_aTyp($token,$abTyp,$abID);
$KorrekturRow=getAbgabeBy_fID_token_aTyp($token,$abTyp,$zu_fID); //getAbgabeBy_abID_token_aTyp($token,$abTyp,$abID);
// $KorrekturRow=getAbgabeBy_abID_token_aTyp($abTyp);

if($KorrekturRow!==NULL && isset($KorrekturRow[0])){
	$KorrParameter=json_decode($KorrekturRow[0]['parameter'],true);
	$KorrFragenArr=$KorrParameter['FragenWerte'];
	$PosTimeArr=$KorrParameter['PosTimeArr'];
	$PosTxtArr=$KorrParameter['PosTxtArr'];

	if($KorrFragenArr===NULL){$KorrFragenArr=[];}
	if($PosTimeArr===NULL){$PosTimeArr=[];}
	if($PosTxtArr===NULL){$PosTxtArr=[];}

}else{
	$KorrFragenArr=[];
	$PosTimeArr=[];
	$PosTxtArr=[];
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

	</head>
	<body>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/header_bar.php");?>

		<div class="container">
			<div class="row" style='margin-top:0px;'>
				<!--<div class="col-md-1"></div>//-->
				<div class="col-md-6">
					<p class="lead"><?php echo $videoInfo->titel; ?></p>
					<p class=""><?php echo html_entity_decode ($videoInfo->beschreibung, ENT_QUOTES , "UTF-8"); ?></p>
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
							<button type="button" class="btn btn-warning"  onclick='StelleMarkieren()'>Stelle markieren</button>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<?php if(count($KorrekturRow)>0){?>
					<div class="alert alert-success">
						<strong>Bereits gespeichert!</strong> Deine Antworten wurden bereits gespeichert.
					</div>
					<?php }?>
					<form action="" method="post">
						<ul class="nav nav-tabs">
							<li class="active"><a data-toggle="tab" href="#fragen">Fragen</a></li>
							<li><a data-toggle="tab" href="#comment">Kommentar</a></li>
							<li><a data-toggle="tab" href="#marker">Marker</a></li>
						</ul>

						<div class="tab-content">
							<div id="fragen" class="tab-pane fade in active">
								<br>
								<?php 
								$iLauf=0;
								foreach($fArr as $FrageID){
									$FrageRow=getFrageInfo($FrageID);
									$FrageInfo=json_decode($FrageRow['parameter']);
								?>
								<div class="row" style="padding:0; padding-bottom:5px; padding-top:5px; <?php if($iLauf+1<count($fArr)){echo "border-bottom: 1px dotted gray"; $iLauf++;}else{$iLauf++;} ?>">
									<div class="col-md-8" style="text-align:left;">
										<?php echo $FrageInfo->FrageTXT; ?><br><span style="font-size:0.8em; font-style:italic;"><?php echo $FrageInfo->FrageTipp; ?></span>
									</div>
									<div class="col-md-4" style="text-align:center;">
										<input type=hidden name='FrageID[]' value='<?php echo $FrageID; ?>'>
										<input id="f<?php echo $FrageID; ?>" type="text" name="FrageVal[]" />
										<script>
											var slider = new Slider("#f<?php echo $FrageID; ?>", {
												step: 1,
												min: <?php echo intval($FrageInfo->FrageMin); ?>,
												max: <?php echo intval($FrageInfo->FrageMax); ?>,
												value: <?php if(array_key_exists($FrageID,$KorrFragenArr)){echo $KorrFragenArr[$FrageID];}else{echo (intval($FrageInfo->FrageMax)-intval($FrageInfo->FrageMin))/2+intval($FrageInfo->FrageMin) ;} ?>,
												ticks: [<?php echo intval($FrageInfo->FrageMin); ?>, <?php echo intval($FrageInfo->FrageMax); ?>],
												// 									ticks_positions: [0, 30, 60, 70, 90, 100],
												ticks_labels: ['<?php echo html_entity_decode ($FrageInfo->FrageLabMin, ENT_QUOTES , "UTF-8"); ?>', '<?php echo html_entity_decode ($FrageInfo->FrageLabMax, ENT_QUOTES , "UTF-8");  ?>'],
												ticks_snap_bounds: 0
											});
										</script>
									</div>
								</div>
								<?php } ?>

							</div>
							<div id="comment" class="tab-pane fade">
								<br>
								<div class="form-group">
									<label for="kommentar">Hinterlassen Sie einen Kommentar</label>
									<textarea id='KommentarFeld'  name='kommentar' class="form-control" id="kommentar" style='height:120px;'><?php if(isset($KorrParameter['kommentar'])){echo $KorrParameter['kommentar'];} ?></textarea>
								</div>
							</div>
							<div id="marker" class="tab-pane fade">
								<br>
								<div id="marker_box">
									<?php
									if(count($PosTimeArr)>0){
										$iLauf=0;
										foreach($PosTimeArr as $posTime){
									?>
									<h4>Markierung bei <?php echo round($posTime); ?>s</h4>
									<input value='Marker abspielen' class='btn btn-default' onclick='VideoPlayFromPos(" <?php echo $posTime; ?>")'>
									<input type='hidden' name='pos_Time[]' value=' <?php echo $posTime; ?>'>
									<textarea name='pos_TXT[]' style='width:100%; height:50px;'><?php echo $PosTxtArr[$iLauf]; ?></textarea>
									<?php
											$iLauf++;
										}									
									}
									?>
								</div>
							</div>
						</div>
						<hr>
						<input class="btn btn-primary" type="submit" value='Speichern'><button class="btn btn-success" style="margin-left:10px;" type="submit" name='btn_abgeben' value='1'>Speichern & abgeben</button>
					</form>
				</div>
			</div>
		</div>


		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/bottom_main.php");?>
	</body>
</html>

<script>

	function StelleMarkieren(){
		var video = document.getElementById("video");
		// 		alert(video.currentTime);
		var vPosTime=Math.round(video.currentTime);
		jQuery("#marker_box").append("<h4>Markierung bei "+vPosTime+"s</h4><input value='Marker abspielen' class='btn btn-default' onclick='VideoPlayFromPos("+vPosTime+")'><input type='hidden' name='pos_Time[]' value='"+video.currentTime+"'><textarea name='pos_TXT[]' style='width:100%; height:50px;'></textarea>");
		$('.nav-tabs a[href="#marker"]').tab('show')
		// 		SetTabActive(3, 3);
	}

	function VideoPlayFromPos(vPosTime){
		var video = document.getElementById("video");
		video.currentTime=vPosTime-3;
		var audio=document.getElementById("audio");
		audio.currentTime=vPosTime-3;
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