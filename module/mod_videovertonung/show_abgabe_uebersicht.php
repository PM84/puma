<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/header_php.php");
// var_dump($_SESSION);
$ausserhalbKurs=1;
// ========================
// ========================
// ====== VIDEOVERTONUNG - Übersicht Abgaben
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
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/head_main.php");?>
		<?php //include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/head_backend.php");?>
	</head>
	<body>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/header_bar.php");?>

		<div id="container" class="container" style="margin-bottom:150px;">
			<?php  if(!$Dozenten && !isset($SessionInfos['uID'])){ ?>
			<div class="row" style='margin-top:0px;'>
				<div class="col-md-1"></div>
				<div class="col-md-10 alert alert-danger">Sie haben keinen Zugriff auf diese Seite!</div>
				<div class="col-md-1"></div>
			</div>
			<?php }else{ 
	$AbgabeFolieListe=getAbgabeListeOf_Modul($kursID,1);

			?>
			<div class="row">
				<!--<div class="col-md-1"></div>//-->
				<div class="col-md-12">
					<div class="row" style='margin-top:10px; text-align:center; background-color:lightgray; padding:10px; border-radius: 10px;'>
						<div class="col-md-1">
							<a href='<?php echo $_SESSION['last_shown_page'];?>' class='btn btn-success'>zurück zur letzten Folie</a>
						</div>
						<div class="col-md-8"><p class="lead" style='margin:0'>Abgegebene Vertonungen</p></div>
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
								<th>Abgabe von</th>
								<th class="hidden-xs">Aufgabe</th>
								<th class="hidden-xs">abgegeben</th>
								<th>Link zur Bewertung</th>
							</tr>
						</thead>
						<?php foreach($AbgabeFolieListe as $folie){
										$folieParameter=json_decode($folie['FParameter'],true);
										$AbgabeParameter=json_decode($folie['AParameter'],true);
										$AudioArr=$AbgabeParameter['audioArr'];
										$audioStatus=0;
										// 				var_dump($folieParameter);
										if(is_array($AudioArr)){
											foreach($AudioArr as $audioTMP){

												if($audioTMP['abgegeben']==1){
													$audioStatus=1;
												}
											}
										}
										$abToken=$folie['abToken'];
										$fID=$folie['fID'];
										$abIDTemp=$folie['abID'];
										// 				echo $folie['abID'];
										if($folie['abID']!=null){
											$BewerterToken=$_SESSION['t_own'];
											$query="SELECT * FROM abgabe WHERE fID='$fID' AND zu_abID='$abIDTemp' AND token='$BewerterToken' AND abTyp=2";
											$ergebnis=mysqli_query($verbindung,$query);
										}else{
											unset($ergebnis);
										}
						?>
						<tr>
							<td><?php if($folie['abID']==null){echo "keine Abgabe";}else{echo $folie['name'].", ".$folie['vname'];}  ?></td>
							<td class="hidden-xs"><?php echo $folieParameter['titel'] ?></td>
							<td class="hidden-xs"><?php if($folie['abID']==null){echo "keine Abgabe";}else{echo date('d.m.Y H:i',strtotime ( $folie['datum']));} ?></td>
							<td>
								<?php if($folie['abID']==null){}else{?> <a href="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/module/mod_videovertonung/show_bewertung_vertonung.php?abt="<?php echo $abToken; ?>&fID="<?php echo $fID; ?>" target="_blank"><span class="glyphicon glyphicon-pencil" style="display:inline-block; width:25px;"></span></a> <?php 
																	 if($audioStatus==0){ 
								?> 
								<i class="glyphicon glyphicon-hourglass" style="color:red;display:inline-block; width:25px;" data-toggle="tooltip" title="Noch keine endgültige Abgabe!"> </i>
								<?php 
																	 }else{
								?> 
								<i class="glyphicon glyphicon-ok" style="color:green;display:inline-block; width:25px;" data-toggle="tooltip" title="Endgültige Abgabe vorhanden!"> </i>
								<?php 
																	 } 

																	 if(mysqli_num_rows($ergebnis)>0){ 
								?> 
								<span class="glyphicon glyphicon-ok" style="color:green;display:inline-block; width:25px;" data-toggle="tooltip" title="Sie haben bereits ein Feedback abgegeben!"> </span>
								<?php 
																	 }else{
								?> 
								<span class="glyphicon glyphicon-remove" style="color:red;display:inline-block; width:25px;" data-toggle="tooltip" title="Sie haben noch kein Feedback abgegeben!"> </span>
								<?php 
																	 }
																	} ?>
							</td>
						</tr>

						<?php }	?>		
					</table>
				</div>
				<div class="col-xs-1"></div>
			</div>

			<?php } ?>
		</div>
		</div>
	</body>
</html>
