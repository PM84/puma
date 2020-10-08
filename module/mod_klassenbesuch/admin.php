<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// ========================
// ========================
// ====== KLASSENBESUCHE
// ========================
// ========================
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/header_php.php");

$ausserhalbKurs=1;
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/session_delay.php");

// include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/kursInfos.php");
// include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/Sessions.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/system.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/module/mod_klassenbesuch/fkt_buchung.php");
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");


if(isset($_GET['tID'])){
	$Termin=getTermin_by_TerminID(intval($_GET['tID']));
	$TerminParam=json_decode($Termin['parameter'],true);
}

if(isset($_POST['action'])&&$_POST['action']=="save"){

	$token=mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($_POST['termin_token']), ENT_QUOTES , "UTF-8")); //($_POST['titel'], ENT_QUOTES);
	$titel=mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($_POST['titel']), ENT_QUOTES , "UTF-8")); //($_POST['titel'], ENT_QUOTES);
	$betreuer=mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($_POST['betreuer']), ENT_QUOTES , "UTF-8")); //($_POST['titel'], ENT_QUOTES);
	$betreuer_email=mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($_POST['betreuer_mail']), ENT_QUOTES , "UTF-8")); //($_POST['titel'], ENT_QUOTES);
	$start=mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($_POST['start']), ENT_QUOTES , "UTF-8")); //($_POST['titel'], ENT_QUOTES);
	$ende=mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($_POST['ende']), ENT_QUOTES , "UTF-8")); //($_POST['titel'], ENT_QUOTES);

	$jgstGymArr=[];
	$jgstRSArr=[];
	$jgstMSArr=[];
	$jgstGSArr=[];
	$jgStArr=array('GS'=>array(),'MS'=>array(),'RS'=>array(),'Gym'=>array());
	

	if(isset($_POST['JgSt_GS'])){
		foreach($_POST['JgSt_GS'] as $jgSt){
			array_push($jgstGSArr,intval($jgSt));
		}
		if(count($jgstGSArr)>0){$jgStArr['GS']=$jgstGSArr;}
	}
	if(isset($_POST['JgSt_MS'])){
		foreach($_POST['JgSt_MS'] as $jgSt){
			array_push($jgstMSArr,intval($jgSt));
		}
		if(count($jgstMSArr)>0){$jgStArr['MS']=$jgstMSArr;}
	}
	if(isset($_POST['JgSt_RS'])){
		foreach($_POST['JgSt_RS'] as $jgSt){
			array_push($jgstRSArr,intval($jgSt));
		}
		if(count($jgstRSArr)>0){$jgStArr['RS']=$jgstRSArr;}
	}
	if(isset($_POST['JgSt_Gym'])){
		
		foreach($_POST['JgSt_Gym'] as $jgSt){
			array_push($jgstGymArr,intval($jgSt));
		}
		if(count($jgstGymArr)>0){$jgStArr['Gym']=$jgstGymArr;}
	}

	$jgStArr['maxTN']=intval($_POST['maxTN']);
	$parameter=json_encode($jgStArr);
	if(strlen($token)==0){$token=uniqid();}
	$query="INSERT INTO z_klassenbesuche_termine (titel, betreuer, betreuer_mail, start, ende, parameter,termin_token) VALUES ('$titel','$betreuer','$betreuer_email','$start','$ende','$parameter','$token') ON DUPLICATE KEY UPDATE titel='$titel',betreuer='$betreuer', betreuer_mail='$betreuer_email', start='$start', ende='$ende', parameter='$parameter'";
	mysqli_query($verbindung,$query);
	echo "<script>window.location = '" . $_SESSION['DOCUMENT_ROOT_DIR']."admin.php';</script>";

}



$Terminliste=getTerminListe(1);

// $JgSten=array(1:"GS 1",2:"GS 2",3:"GS 3",4:"GS 4",5:"MS 5",6:"MS 6",7:"MS 7",8:"MS 8",9:"MS 9",10:"MS 10",11:"RS 5",12:"RS 6",13:"RS 7",14:"RS 8",15:"RS 9",16:"RS 10",17:"Gym 5",18:"Gym 6",19:"Gym 7",20:"Gym 8",21:"Gym 9",22:"Gym 10",23:"Gym Q11",24:"Gym Q12",25:"Gym Q13");


?>
<html>
	<head>
		<?php if(isset($FoliePath)){?>
		<script>
			var win = window.open('<?php echo $FoliePath; ?>', '_blank');
			if (win) {
				//Browser has allowed it to be opened
				win.focus();
			} else {
				//Browser has blocked it
				alert('Bitte erlauben Sie PopUps um direkt zur Vorschau zu gelangen!');
			}
		</script>
		<?php } ?>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/head_main.php");?>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/head_backend.php");?>

		<!--	<script src="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/plugins/ckeditor/ckeditor.js"></script>//-->

		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/plugins/tinymce/include/init_pfreferences_min.php");?>

		<style>

			.clickable{
				cursor: pointer;   
			}

			.panel-heading span {
				margin-top: -20px;
				font-size: 15px;
			}

			.btnColSel{
				/* 				width:100px; */
				/* 				height:100px; */
				/* 				border-radius:5px !important; */
				/* padding: 40px 0 40 0; */
				/* margin-right:15px; */
			}

		</style>
	</head>
	<body>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/header_bar.php");
		

		?>

		<div class="container" style="">

			<div class="row">
				<div class="col-md-1"></div>
				<div class="col-md-10">
					<div class="row" style=' text-align:center; background-color:lightgray; padding:10px; border-radius: 10px;'>
						<div class="col-md-1">
							<a href="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/kb" target="blank"  class='btn btn-primary'>Vorschau</a>
						</div>
						<div class="col-md-10">
							<p class="lead" style='margin:0'>Klassenbesuch Termin hinzufügen</p>
						</div>
						<div class="col-md-1"></div>
					</div>
				</div>
				<div class="col-md-1"></div>
			</div>
			<div class="row">
				<div class="col-md-1"></div>
				<div class="col-md-10">

					<div class="col-md-7">

						<form style="margin-top:20px;" method="post" action="">
							<input type="hidden" name="action" value="save">
							<input type="hidden" name="termin_token" value="<?php if(isset($Termin['termin_token'])){echo $Termin['termin_token'];}else{echo uniqid();} ?>">
							<div class="form-group">
								<label for="titel">Titel des Termins</label>
								<input id='titel' type="text" class="form-control" name="titel" placeholder="Titel des Termins" required value='<?php if(isset($Termin['titel'])){echo $Termin['titel'];} ?>'>
							</div>
							<div class="form-group">
								<label for="betreuer">Name des Betreuers</label>
								<input id='betreuer' type="text" class="form-control" name="betreuer" placeholder="Name des Betreuers" required value='<?php if(isset($Termin['betreuer'])){echo $Termin['betreuer'];} ?>'>
							</div>
							<div class="form-group">
								<label for="betreuer_mail">Email des Betreuer</label>
								<input id='betreuer_mail' type="email" class="form-control" name="betreuer_mail" placeholder="Email des Betreuer" required value='<?php if(isset($Termin['betreuer_mail'])){echo $Termin['betreuer_mail'];} ?>'>
							</div>
							<div class="form-group">
								<label for="start">Beginn des Termins</label>
								<input id='start' type="datetime-local" class="form-control" name="start" placeholder="Beginn des Termins" required value='<?php if(isset($Termin['start'])){echo str_replace ( " " , "T" ,  $Termin['start'] );} ?>'>
							</div>
							<div class="form-group">
								<label for="ende">Ende des Termins</label>
								<input id='ende' type="datetime-local" class="form-control" name="ende" placeholder="Ende des Termins" required value='<?php if(isset($Termin['ende'])){echo str_replace ( " " , "T" ,  $Termin['ende'] );} ?>'>
							</div>
							<div class="form-group">
								<label for="maxTN">Maximalanzahl der Teilnehmer</label>
								<input id='maxTN' type="number" class="form-control" name="maxTN" placeholder="Teilnehmer Maximum" required value='<?php if(isset($TerminParam['maxTN'])){echo $TerminParam['maxTN'];} ?>'>
							</div>

							<div class="form-group">
								<label for="JgStGS">Jahrgangsstufe(n) Grundschule auswählen</label>
								<select class="form-control" id="JgStGS" name='JgSt_GS[]' multiple size=4>
									<?php for($n=1;$n<=4;$n++){ ?>
									<option value="<?php echo $n; ?>" <?php if(isset($TerminParam['GS']) && in_array($n,$TerminParam['GS'])){echo "selected";} ?>>JgSt <?php echo $n; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group">
								<label for="JgStMS">Jahrgangsstufe(n) Mittelschule auswählen</label>
								<select class="form-control" id="JgStMS" name='JgSt_MS[]' multiple size=4>
									<?php for($n=5;$n<=10;$n++){ ?>
									<option value="<?php echo $n; ?>" <?php if(isset($TerminParam['MS']) && in_array($n,$TerminParam['MS'])){echo "selected";} ?>>JgSt <?php echo $n; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group">
								<label for="JgStRS">Jahrgangsstufe(n) Realschule auswählen</label>
								<select class="form-control" id="JgStRS" name='JgSt_RS[]' multiple size=4>
									<?php for($n=5;$n<=10;$n++){$TerminParam['RS'] ?>
									<option value="<?php echo $n; ?>" <?php if(isset($TerminParam['RS']) && in_array($n,$TerminParam['RS'])){echo "selected";}else{echo "notselected";} ?>>JgSt <?php echo $n; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group">
								<label for="JgStGym">Jahrgangsstufe(n) Gymnasium auswählen</label>
								<select class="form-control" id="JgStGym" name='JgSt_Gym[]' multiple size=4>
									<?php for($n=5;$n<14;$n++){ ?>
									<option value="<?php echo $n; ?>" <?php if(isset($TerminParam['Gym']) && in_array($n,$TerminParam['Gym'])){echo "selected";} ?>>JgSt <?php echo $n; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group">
								<input class="btn btn-primary" type="submit" value="Speichern">
							</div>

						</form>


					</div>
					<div class="col-md-5">
						<table class="table">
							<thead>
								<tr>
									<th>Titel</th>
									<th>Beginn</th>
									<th>Ende</th>
									<th style="width:100px;"></th>
								</tr>
							</thead>
							<?php

							foreach($Terminliste as $Termin){
								
							?>
							<tr>
								<td><?php echo $Termin['titel'] ?></td>
								<td><?php echo date("d.m.Y H:i",strtotime($Termin['start'])); ?> Uhr</td>
								<td><?php echo date("d.m.Y H:i",strtotime($Termin['ende'])); ?> Uhr</td>
								<td><a href="?tID="<?php echo  $Termin['TerminID']; ?>"><span class="glyphicon glyphicon-pencil"></span></a>
									<span id="TID_<?php echo $Termin['TerminID'] ?>" style="margin-left:10px;" class="showTermin glyphicon <?php if($Termin['aktiv']==1){echo "glyphicon-eye-open";}else{echo "glyphicon-eye-close";} ?>"></span>
									<span id="del_TID_<?php echo $Termin['TerminID'] ?>" style="margin-left:10px;" class="deleteTermin glyphicon glyphicon-trash"></span>
								</td>
							</tr>

							<?php
							}
							?>
						</table>

					</div>


				</div>
				<div class="col-md-1"></div>
			</div>
		</div>
		<script>
			$( ".showTermin" ).click(function(e) {
				var TerminID=e.target.id;
				jQuery.ajax({
					type: 'POST',
					url: '/module/mod_klassenbesuch/fkt_buchung.php',
					data: {
						fkt:"SetTerminStatus",
						TerminID:TerminID
					},
					dataType: 'text',
					success: function (data) {
						$("#"+TerminID).toggleClass("glyphicon-eye-open");
						$("#"+TerminID).toggleClass("glyphicon-eye-close");
					},
					async:true
				});
			});

			$( ".deleteTermin" ).click(function(e) {
				var TerminID=e.target.id;
				jQuery.ajax({
					type: 'POST',
					url: '/module/mod_klassenbesuch/fkt_buchung.php',
					data: {
						fkt:"DeleteTermin",
						TerminID:TerminID
					},
					dataType: 'text',
					success: function (data) {
						window.location.reload();
					},
					async:true
				});
			});

		</script>
	</body>
</html>
