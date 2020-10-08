<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/header_php.php");
$ausserhalbKurs=1;
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/session_delay.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/kursInfos.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/Sessions.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/system.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/folie.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/videos.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/media.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/media.php");


include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/module.php");
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");

$modTitel="Videoarchiv";
$modID=getModIDFromTitel($modTitel);
$CopyToKursAllow=1;
// ========================
// ====== FOLIE ZUM BEARBEITEN LADEN
// ========================
if(isset($_SESSION['edit_fID'])){
	// 	echo "<h3>fID ausgelöst</h3>";
	$FolieArr=getFolieInfo(intval($_SESSION['edit_fID']));
	$AufgabeInfo=json_decode($FolieArr['parameter']);
	if(array_key_exists('vID', $AufgabeInfo)){
		$_SESSION['vID']=$AufgabeInfo->vID;
	}elseif(array_key_exists('ytID', $AufgabeInfo)){
		$_SESSION['vidTyp']='YT';
	}

}

// ========================
// ====== VIDEO (QUELLE) AUSWÄHLEN
// ========================

if(isset($_POST['vidTyp'])){
	// 	echo "<h3>vidTyp ausgelöst</h3>";
	$vidTyp=htmlspecialchars($_POST['vidTyp'], ENT_QUOTES);
	$_SESSION['vidTyp']=$vidTyp;
	if(isset($_POST['vID'])){
		$_SESSION['vID']=intval($_POST['vID']);
	}
	unset($_POST['vidTyp']);
	unset($_POST['vID']);
}

// ========================
// ====== AUFGABE EINTRAGEN
// ========================

if(isset($_POST['titel']) && isset($_POST['beschreibung'])){
	$AufgabeInfo=[];
	if(isset($_POST['ytlink'])){
		preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $_POST['ytlink'], $matches);
		$ytID = mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($matches[1]), ENT_QUOTES , "UTF-8"));
		$AufgabeInfo['ytID']=$ytID;
		$AufgabeInfo['ytlink']=mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($_POST['ytlink']), ENT_QUOTES , "UTF-8"));
	}
	if(isset($_SESSION['vID'])){
		preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $_POST['ytlink'], $matches);
		$vID = intval($_SESSION['vID']);
		$AufgabeInfo['vID']=$vID;
	}
	$fID=intval($_POST['fID']);
	$AufgabeInfo['titel']=mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($_POST['titel']), ENT_QUOTES , "UTF-8"));
	$AufgabeInfo['beschreibung']=mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($_POST['beschreibung']), ENT_QUOTES , "UTF-8"));
	$AufgabeInfo['CopyToKursID']=intval($_POST['CopyToKursID']);
	$AufgabeInfo['aktivStatus']=1;
	$tnarr=[];
	if(isset($_POST['tnarr'])){
		$tnarr=$_POST['tnarr'];
		if($tnarr===NULL){
			$tnarr=[];
		}
	}
	/* 	array_walk_recursive($tnarr, function($value, $key) {
		include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
		$value=intval($value);
	});
 */	$AufgabeInfo['tnarr']=$tnarr;
	$AufgabeInfoJson=json_encode($AufgabeInfo);
	$viewTyp=intval($_POST['viewTyp']);
	if(intval($AufgabeInfo['CopyToKursID'])>0){$CopyToKursID=$AufgabeInfo['CopyToKursID'];}else{$CopyToKursID=0;}
	add_folie($AufgabeInfoJson,$modID,$viewTyp,$fID,0,1,0,$CopyToKursID);
}

?>
<html>
	<head>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/head_main.php");?>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/head_backend.php");?>
	</head>
	<body>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/header_bar.php");?>

		<div class="container">
			<div class="row">
				<div class="col-md-1"></div>
				<div class="col-md-10">
					<div class="row" style='margin-top:20px; text-align:center; background-color:lightgray; padding:10px; border-radius: 10px;'>
						<div class="col-md-1"><a href='<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/module/admin/folie_erstellen.php' class='btn btn-success'>zurück</a></div>
						<div class="col-md-10"><p class="lead" style='margin:0'>Videoarchiv</p></div>
						<div class="col-md-1"></div>
					</div>
				</div>
				<div class="col-md-1"></div>
			</div>

			<div class="row" style='margin-top:20px; margin-bottom:50px;'>
				<div class="col-md-1"></div>
				<div class="col-md-3">
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
										<input type="hidden" name=vidTyp value='LMUcast'>
										<input type=hidden value='<?php echo $video->vID; ?>' name='vID'><input type="submit" class="btn btn-default" style='width:100%' value="<?php echo $video->titel; ?>">
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


					<form action='' method="POST" style='margin:0;'>
						<input type=hidden value='YT' name='vidTyp'><input type="submit" class="btn btn-default" style='width:100%' value="YouTube">
					</form>
				</div>
				<div class="col-md-7">
					<p class="lead" style='margin:0'>Einstellungen</p>
					<?php
					if(isset($_SESSION['vidTyp'])){
						if(htmlspecialchars($_SESSION['vidTyp'], ENT_QUOTES)=="YT"){
					?>
					<form action='' method="POST" style='margin:0;'>
						<input type="hidden" value='<?php if(isset($_SESSION['edit_fID'])){echo intval($_SESSION['edit_fID']);} ?>' name='fID'>
						<input type="hidden" value='<?php if(isset($_SESSION['vID'])){echo intval($_SESSION['vID']);} ?>' name='vID'>
						<div class="form-group">
							<label for="vname">Titel</label>
							<input id='vname' type="text" class="form-control" name="titel" placeholder="Titel der Aufgabe" required value='<?php if(isset($AufgabeInfo->titel)){echo $AufgabeInfo->titel;} ?>'>
						</div>
						<div class="form-group">
							<label for="beschreibung">Beschreiben Sie die Aufgabe</label>
							<textarea class="form-control" id="beschreibung" name='beschreibung' rows="3"><?php if(isset($AufgabeInfo->beschreibung)){echo $AufgabeInfo->beschreibung;} ?></textarea>
						</div>
						<div class="form-group">
							<label for="YTLink">YouTube Link</label>
							<input id='YTLink' type="text" class="form-control" name="ytlink" placeholder="YouTube Link / URL" required value='<?php if(isset($AufgabeInfo->ytlink)){echo $AufgabeInfo->ytlink;} ?>'>
							<small id="YTLinkHelp" class="form-text text-muted">Kopieren Sie in das Textfeld die URL des jeweiligen YouTube-Videos.</small>
						</div>
						<hr>
						<p class="lead" style='margin-top:25px'>Anzeige - Einstellungen</p>
						<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/folieAnzeigeOptionen.php") ?>
						<input type="submit" class="btn btn-primary" style='' value="<?php if(isset($_SESSION['edit_fID'])){echo "Aufgabe updaten";}else{echo "Aufgabe eintragen";}  ?>">
					</form>

					<?php
						}

						if(htmlspecialchars($_SESSION['vidTyp'], ENT_QUOTES)=="LMUcast"){
					?>
					<form action='' method="POST" style='margin:0;'>
						<h4>
							<span style='font-size:14px;'>gewähltes Video:</span> <?php 
							$videoInfo=Get_VideoInfos_By_vID($videos,intval($_SESSION['vID']));
							echo $videoInfo->titel;
							$link_src=get_video_link($videoInfo,"sd");
							?>
						</h4>
						<video width="100%" muted controls style='margin-bottom:30px;'>
							<source src="<?php echo $link_src; ?>" type="video/mp4">
							Ihr Browser unterstützt den Video Tag nicht. Bitte aktualisieren Sie Ihren Browser.
						</video>
						<input type="hidden" value='<?php if(isset($_SESSION['edit_fID'])){echo intval($_SESSION['edit_fID']);} ?>' name='fID'>
						<div class="form-group">
							<label for="vname">Titel</label>
							<input id='vname' type="text" class="form-control" name="titel" placeholder="Titel der Aufgabe" required value='<?php if(isset($AufgabeInfo->titel)){echo $AufgabeInfo->titel;} ?>'>
						</div>
						<div class="form-group">
							<label for="beschreibung">Beschreiben Sie die Aufgabe</label>
							<textarea class="form-control" id="beschreibung" name='beschreibung' rows="3"><?php if(isset($AufgabeInfo->beschreibung)){echo $AufgabeInfo->beschreibung;} ?></textarea>
						</div>
						<hr>
						<p class="lead" style='margin-top:25px'>Anzeige - Einstellungen</p>
						<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/folieAnzeigeOptionen.php") ?>
						<input type="submit" class="btn btn-primary" style='' value="<?php if(isset($_SESSION['edit_fID'])){echo "Aufgabe updaten";}else{echo "Aufgabe eintragen";}  ?>">
					</form>

					<?php
						}
					}
					?>
				</div>
				<div class="col-md-1"></div>
			</div>
		</div>

		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/bottom_main.php");?>
	</body>
</html>