<?php
include($_SERVER['DOCUMENT_ROOT']."/includes/header_php.php");
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
// var_dump($_SESSION);
$ausserhalbKurs=1;
// ========================
// ========================
// ====== VIDEOANALYSE - Übersicht Abgaben
// ========================
// ========================

include_once($_SERVER['DOCUMENT_ROOT']."/includes/session_delay.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/kursInfos.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/Sessions.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/videos.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/folie.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/system.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/module.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/media.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/abgabe.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/teilnehmer.php");
include($_SERVER['DOCUMENT_ROOT']."/config.php");

// Teilnehmerliste laden:
// $TeilnehmerListe=getTeilnehmerListeInfos($_SESSION['kursID']);

$uID=$SessionInfos['uID'];
$Kurse=GetKursListeInfos($_SESSION['uID'],1,1);

if( (isset($_POST['action']) && $_POST['action']="SelKurs") ){
	$_SESSION['vt']['kID']=intval($_POST['kID']);
	$kursID=$_SESSION['vt']['kID'];
}elseif(isset($_SESSION['vt']['kID'])){
	$kursID=$_SESSION['vt']['kID'];
}

// $kursID=intval($_SESSION['kursID']);
// $token=$_SESSION['t'];
// $Dozenten=Check_if_TN_is_Dozent($kursID,$token);
// echo "==================";
?>


<html>
	<head>
		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/head_main.php");?>
		<?php //include($_SERVER['DOCUMENT_ROOT']."/includes/head_backend.php");?>
	</head>
	<body>
		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/header_bar.php");?>

		<div id="container" class="container" style="margin-bottom:150px;">
			<?php  if(!$Dozenten && !isset($SessionInfos['uID'])){ ?>
			<div class="row" style='margin-top:0px;'>
				<div class="col-md-1"></div>
				<div class="col-md-10 alert alert-danger">Sie haben keinen Zugriff auf diese Seite!</div>
				<div class="col-md-1"></div>
			</div>
			<?php }else{ 
	$FolienListe=getFolienListeInfos_by_kurs_modID($kursID,3);
	// 	$AbgabeFolieListe=getAbgabeListeOf_Modul($kursID,3);

			?>
			<div class="row">
				<!--<div class="col-md-1"></div>//-->
				<div class="col-md-12">
					<div class="row" style='margin-top:10px; text-align:center; background-color:lightgray; padding:10px; border-radius: 10px;'>
						<div class="col-md-1">
							<a href='<?php echo $_SESSION['last_shown_page'];?>' class='btn btn-success'>zurück zur letzten Folie</a>
						</div>
						<div class="col-md-8"><p class="lead" style='margin:0'>Videoanalyse - Übersicht</p></div>
						<div class="col-md-3">
							<form action method="post"><input type="hidden" name="action" value="SelKurs">
								<select class="form-control" name="kID" onchange="this.form.submit()" required>
									<option value="">Bitte Kurs auswählen</option>
									<?php
	foreach($Kurse as $kurs){
									?>
									<option value="<?php echo $kurs['kursID']; ?>" <?php if(isset($_SESSION['vt']['kID']) && $kurs['kursID']==$_SESSION['vt']['kID']){echo "selected";} ?>><?php echo $kurs['titel'] ?></option>
									<?php
	}
									?>

								</select>
							</form>
						</div>
					</div>
				</div>
				<!--<div class="col-md-1"></div>//-->
			</div>
			<div class="row">
				<div class="col-xs-1"></div>
				<div class="col-xs-10">
					<?php if(!isset($_SESSION['vt']['kID']) || intval($_SESSION['vt']['kID'])==0){echo "<div class='row' style='margin-top:15px;'><div class='alert alert-info'><b>Hinweis</b><br>Sie haben keinen Kurs ausgewählt!</div></div>";} ?>
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Video gehört zu:</th>
								<th class="hidden-xs">Aufgabe - Titel</th>
								<th>Link zur Bewertung</th>
							</tr>
						</thead>
						<?php foreach($FolienListe as $folie){
										// 										 										var_dump($folie);
										$folieParameter=json_decode($folie['FParameter'],true);
										$VideoArr=$folieParameter['videoArr'];
										$abgabeStatus=0;
										// 				var_dump($folieParameter);
										if(is_array($VideoArr)){
											foreach($VideoArr as $videoTMP){

												if($videoTMP['abgegeben']==1){
													$abgabeStatus=1;
												}
											}
										}
										$abToken=$folie['abToken'];
										$fID=$folie['fID'];
										$abIDTemp=$folie['abID'];
										// 				echo $folie['abID'];
										if($folie['abID']!=null){
											$BewerterToken=$_SESSION['t_own'];
											$query="SELECT * FROM abgabe WHERE fID='$fID' AND token='$BewerterToken' AND abTyp=1";
											$ergebnisAbgabe=mysqli_query($verbindung,$query);
										}else{
											unset($ergebnisAbgabe);
										}
										$TnListe=getTeilnehmerInfosByTnIDs($folieParameter['tnarr']);
										$tnNames=array();
										foreach($TnListe as $tnID => $tnInfo){
											array_push($tnNames,$tnInfo['name'].", ".$tnInfo['vname']);
										}

						?>
						<tr>
							<td><?php echo join("<br>",$tnNames);  ?></td>
							<td class="hidden-xs"><?php echo $folieParameter['titel']; ?></td>
							<td>
								<a href="/module/mod_videoanalyse/show_bewertung_videoanalyse.php?&fID=<?php echo $fID; ?>" target="_blank"><span class="glyphicon glyphicon-pencil" style="display:inline-block; width:25px;"></span></a> 
								<?php 
										if($abgabeStatus==0){ 
								?> 
								<i class="glyphicon glyphicon-hourglass" style="color:red;display:inline-block; width:25px;" data-toggle="tooltip" title="Noch kein Video für diese Folie ausgewählt!"> </i>
								<?php 
										}else{
								?> 
								<i class="glyphicon glyphicon-ok" style="color:green;display:inline-block; width:25px;" data-toggle="tooltip" title="Folie ist bereit fürs Feedback!"> </i>
								<?php 
										} 

										if(isset($ergebnisAbgabe) && mysqli_num_rows($ergebnisAbgabe)>0){ 
								?> 
								<span class="glyphicon glyphicon-ok" style="color:green;display:inline-block; width:25px;" data-toggle="tooltip" title="Sie haben bereits ein Feedback abgegeben!"> </span>
								<?php 
										}else{
								?> 
								<span class="glyphicon glyphicon-remove" style="color:red;display:inline-block; width:25px;" data-toggle="tooltip" title="Sie haben noch kein Feedback abgegeben!"> </span>
								<?php 
										}
								?>
							</td>
						</tr>

						<?php }	?>		
					</table>
				</div>
				<div class="col-xs-1"></div>
			</div>

			<?php } ?>
		</div>
		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/bottom_main.php");?>
	</body>
</html>