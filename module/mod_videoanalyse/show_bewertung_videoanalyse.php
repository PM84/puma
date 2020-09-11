<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/header_php.php");
// var_dump($_SESSION);
$ausserhalbKurs=1;
// ========================
// ========================
// ====== VIDEOANALYSE - BEWERTUNG
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
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/abgabe.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/teilnehmer.php");
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");

// Teilnehmerliste laden:
// $TeilnehmerListe=getTeilnehmerListeInfos($_SESSION['kursID']);
// var_dump($_SESSION);
$uID=$SessionInfos['uID'];
$kursID=intval($_SESSION['kursID']);
$fID=intval($_GET['fID']);
$abtoken=mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($_GET['abt']), ENT_QUOTES , "UTF-8"));
$token=$_SESSION['t'];
$abTyp=1; // Dies ist eine Abgabe-Folie


$FolieInfo=getFolieInfo($fID);
$folieParameter=json_decode($FolieInfo['parameter'],true);
$TnListe=getTeilnehmerInfosByTnIDs($folieParameter['tnarr']);
$tnNames=array();
foreach($TnListe as $tnID => $tnInfo){
	array_push($tnNames,$tnInfo['name'].", ".$tnInfo['vname']);
}
$VideoArr=$folieParameter['videoArr'];
$abgabeStatus=0;
// 				var_dump($folieParameter);
if(is_array($VideoArr)){
	foreach($VideoArr as $videoTMP){

		if($videoTMP['abgegeben']==1){
			$abgabeStatus=1;
			$video_src=$_SESSION['DOCUMENT_ROOT_DIR'] . "/media/video/".$videoTMP['fileName'];
		}
	}
}


// ========================
// ====== VIDEOANALYSE - BEWERTUNG SPEICHERN
// ========================
// var_dump($SessionInfos);

if(isset($_POST['action']) && $_POST['action']=="save"){
	// 	$zu_fID=$fID;
// 	echo $_SESSION['t_own'];

	// 	$abID=$AbgabeInfo['abID'];

	$insertArr=array();
	$zu_token=$abtoken;

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
		$PosTimeArr=array();
		$PosTxtArr=array();
	}
	$insertArr['PosTimeArr']=$PosTimeArr;
	$insertArr['PosTxtArr']=$PosTxtArr;
	$insertArr['abgegeben']=0;

	// ====== In DB schreiben
	$insertArr=json_encode($insertArr);
	$datum=date("Y-m-d H:i:s");

	$query="INSERT INTO abgabe (fID,abTyp,token,zu_abID,parameter,datum) VALUES ('$fID','$abTyp','{$_SESSION['t_own']}','$abID','$insertArr','$datum') ON DUPLICATE KEY UPDATE parameter='$insertArr'";
// 	echo $query;
	mysqli_query($verbindung,$query);
	// var_dump($_POST);
	if($_POST['saveBtn']==1){
		echo "<script>window.location = '" . $_SESSION['DOCUMENT_ROOT_DIR']."/module/mod_videoanalyse/show_abgabe_uebersicht.php';</script>";
	}

}

// ========================
// ====== KORREKTUR LADEN
// ========================

$Abgabe=get_all_Abgaben_of_fID_by_token($fID,$_SESSION['t_own']);
if(is_array($Abgabe[0])){
		$KorrParameter=json_decode($Abgabe[0]['parameter'],true);
		$KorrFragenArr=$KorrParameter['FragenWerte'];
		$PosTimeArr=$KorrParameter['PosTimeArr'];
		$PosTxtArr=$KorrParameter['PosTxtArr'];

		if($KorrFragenArr===NULL){$KorrFragenArr=array();}
		if($PosTimeArr===NULL){$PosTimeArr=array();}
		if($PosTxtArr===NULL){$PosTxtArr=array();}
}else{
	$KorrFragenArr=array();
	$PosTimeArr=array();
	$PosTxtArr=array();
}
?>
<html>
	<head>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/head_main.php");?>
		<?php //include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/head_backend.php");?>

		<style>
			.tab-pane.fade{
				display:none;
			}
			.tab-pane.fade.in{
				display:block;
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
						<div class="col-md-1">
							<a href='<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/module/mod_videoanalyse/show_abgabe_uebersicht.php' class='btn btn-success'>zurück</a>
						</div>
						<div class="col-md-10"><p class="lead" style='margin:0'>Videoanalyse für: <b><?php echo join($tnNames,"; "); ?></b></p>
						</div>
						<div class="col-md-1"></div>
					</div>
				</div>
				<!--<div class="col-md-1"></div>//-->
			</div>
			<div class="row" style="margin-top:15px;">

				<div class="col-md-1"></div>
				<div class="col-md-5">
					<video poster="" id="video" class="video" preload="none" width="100%" data-setup="{}" muted style='background-color:gray;'>
						<source src="<?php echo $video_src; ?>" type='video/mp4'>
					</video>
					<br><br>
					<?php
					?>
					<div class="row" style="padding:0; padding-bottom:5px; padding-top:5px;">
						<div class="col-md-9" style="text-align:center;">
							<button type="button" class="glyphicon glyphicon-step-backward btn btn-default" onclick="StepBackwardAll()"></button>
							<button type="button" class="glyphicon glyphicon-stop btn btn-default" onclick="StopAll()"></button>
							<button type="button" class="glyphicon glyphicon-pause btn btn-default" onclick="PauseAll()"></button>
							<button type="button" class="glyphicon glyphicon-play btn-success btn btn-default" onclick="PlayAll()"></button>
							<button type="button" class="glyphicon glyphicon-step-forward btn btn-default" onclick="StepForwardAll()"></button>
						</div>
						<div class="col-md-3" style="text-align:right;">
							<button type="button" class="btn btn-warning"  onclick='StelleMarkieren()'>Stelle markieren</button>
						</div>
					</div>

				</div>
				<div class="col-md-5">
					<form action="" method="post">
						<input type="hidden" name="action" value="save">
						<div class="row">
							<div class="col-md-6">
								<button class="btn btn-primary btn-block" type="submit" name="saveBtn" value='0'>Speichern</button>
							</div>
							<div class="col-md-6">
								<button class="btn btn-default btn-block" type="submit"  name="saveBtn" value='1'>Speichern und zurück zur Übersicht</button>
							</div>
						</div>
						<div class="row" style="margin-top:15px;">
							<div class="col-md-12">


								<ul class="nav nav-tabs">
									<li class="active"><a data-toggle="tab" href="#comment">Kommentar</a></li>
									<li><a data-toggle="tab" href="#marker">Marker</a></li>
								</ul>

								<div id="comment" class="tab-pane fade in active">
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
						</div>
					</form>
				</div>
				<div class="col-md-1"></div>
			</div>

		</div>
	</body>
	<script>

		function StelleMarkieren(){
			var video = document.getElementById("video");
			// 		alert(video.currentTime);
			var vPosTime=Math.round(video.currentTime);
			jQuery("#marker_box").append("<h4>Markierung bei "+vPosTime+"s</h4><input value='Marker abspielen' class='btn btn-default' onclick='VideoPlayFromPos("+vPosTime+")'><input type='text' name='pos_Time[]' value='"+video.currentTime+"'><textarea name='pos_TXT[]' style='width:100%; height:50px;'></textarea>");
			$('.nav-tabs a[href="#marker"]').tab('show');

			// 		SetTabActive(3, 3);
		}

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
			if(video.playing){ 
				video.pause();
			}
		}

		function StopAll(){
			var video = document.getElementById("video");
			if(video.playing){ 
				video.currentTime = 0;
				video.pause();
			}
		}
	</script>
</html>