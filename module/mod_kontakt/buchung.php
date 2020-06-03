<?php 
session_start();
$_SESSION['TerminID']=intval($_POST['TerminID']);
include($_SERVER['DOCUMENT_ROOT']."/config.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/schule.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/system.php");
include_once($_SERVER['DOCUMENT_ROOT']."/module/mod_kontakt/fkt_buchung.php");


$TerminInfo=getTermin_by_TerminID($_SESSION['TerminID']);
// var_dump($TerminInfo);

$Buchungen=getBuchungen_by_TerminID($_SESSION['TerminID']);
$from="pe.mayer@lmu.de";


if(isset($_POST['BuchungsID'])){
// 	var_dump($_POST);
	$insertArr=array();
	foreach($_POST as $key => $value){
		$Tempkey=mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($key), ENT_QUOTES , "UTF-8"));
		$Tempvalue=mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($value), ENT_QUOTES , "UTF-8"));
		$insertArr[$Tempkey]=$Tempvalue;
	}

	$insertArr['SchulNr']=intval($insertArr['SchulNr']);
	if($insertArr['SchulNr']==0){$insertArr['SchulNr']=intval($_POST['SchulName']);}

	$insertArr['ende']=date("Y-m-d",strtotime($TerminInfo['start']))." ".date("H:i:s", strtotime("+120 minutes", strtotime($insertArr['start'])));
	$insertArr['start']=date("Y-m-d",strtotime($TerminInfo['start']))." ".date("H:i:s", strtotime($insertArr['start']));

	$parameter=array();
	$parameter['bem']=$insertArr['bem'];

	$parameter_insert=json_encode($parameter);


	$query="INSERT INTO studie_buchung (TerminID,start,ende,SchulNr,name,vname,email,tel,anzKollegen,parameter) VALUES ('".$insertArr['TerminID']."','".$insertArr['start']."','".$insertArr['ende']."','".$insertArr['SchulNr']."','".$insertArr['name']."','".$insertArr['vname']."','".$insertArr['email']."','".$insertArr['tel']."','".$insertArr['anzKollegen']."','".$parameter_insert."') ON DUPLICATE KEY UPDATE start=0";
// 	echo $query;
	mysqli_query($verbindung,$query)or die($query." => ".mysqli_error($verbindung));

		if(count($Buchungen)==0){
		//BUCHUNG
		$subject="Anmeldung zur SchILF - EINGANGSBESTÄTIGUNG";
		$message="
		<html>
		<head>
		<meta charset='utf-8'>
		<meta http-equiv=\'Content-Type\' content=\'text/html; charset=utf-8\' />
		</head>
		<body>
		<h3>Anmeldung zur SchILF - EINGANGSBESTÄTIGUNG</h3>
		<p>Hallo,</p><p>Sie haben sich eben für eine SchILF am ".date("d.m.Y \u\m H:i",strtotime($insertArr['start']))." Uhr angemeldet. Dies ist eine automatisch generierte Bestätigung, dass Ihre Buchung bei uns eingegangen ist.<br><br>Ich werde mich in Kürze bei Ihnen melden um weitere Details zu klären.<br><br>Für allgemeine Fragen stehe ich Ihnen natürlich gerne zur Verfügung!</p>
			<p>Viele Grüße</p>
			<p style='font-weight:bold;'>StR Peter Mayer</p>
			<p>pe.mayer@lmu.de</p>
			</body>
			</html>";
	}else{
		//WARTELISTE
		$subject="Anmeldung zur SchILF - WARTELISTE";
		$message="
		<html>
		<head>
		<meta charset='utf-8'>
		<meta http-equiv=\'Content-Type\' content=\'text/html; charset=utf-8\' />
		</head>
		<body>
		<h3>Anmeldung zur SchILF - Warteliste</h3>
		<p>Hallo,</p><p>Sie haben sich eben für eine SchILF am ".date("d.m.Y \u\m H:i",strtotime($insertArr['start']))." Uhr angemeldet. Dies ist eine automatisch generierte Bestätigung dafür, dass Sie in die Warteliste eingetragen wurden.<br><br>Sollte der Termin frei werden, dann werde ich mich schnellstmöglich bei Ihnen melden um Details zu besprechen.<br><br>Für Fragen stehe ich Ihnen natürlich gerne zur Verfügung!</p>
			<p>Viele Grüße</p>
			<p style='font-weight:bold;'>StR Peter Mayer</p>
			<p>pe.mayer@lmu.de</p>
			</body>
			</html>";
	}

	emailSenden($imap_user_name,array($insertArr['email'],$imap_user_name),$subject, $message);
// 	emailSenden($imap_user_name,array($insertArr['email']),$subject, $message);

	$SchulInfo=getSchulInfo_by_SchulNr($insertArr['SchulNr']);
// 	var_dump($SchulInfo);
		if(count($Buchungen)==0){
	$subject_dozent="Anmeldung SchILF - HINWEISE FÜR DOZENTEN";
	$message_dozent="
		<html>
		<head>
		<meta charset='utf-8'>
		<meta http-equiv=\'Content-Type\' content=\'text/html; charset=utf-8\' />
		</head>
		<body>
		<h3>Details zur Anmeldung von ".$insertArr['vname'] .$insertArr['name']."</h3>
		<p>Hallo,</p>
		<p>für Ihre Veranstaltung ist eine Anmeldung eingegangen. Im Folgenden finden Sie die Details zur Buchung:</p>
		<table>
		<tr><td style='color:red; font-weight:bold;'>Termin: </td><td style='color:red; font-weight:bold;'>".date("d.m.Y \u\m H:i",strtotime($insertArr['start']))." Uhr</td></tr>
		<tr><td>Schule: </td><td>".$SchulInfo['Name']."</td></tr>
		<tr><td>Schulart: </td><td>".$SchulInfo['sTyp']."</td></tr>
		<tr><td>Lehrkraft: </td><td>".$insertArr['vname'].",".$insertArr['name']."</td></tr>
		<tr><td>Email: </td><td>".$insertArr['email']."</td></tr>
		<tr><td>Mobil: </td><td>".$insertArr['tel']."</td></tr>
		<tr><td>Anzahl der Teilnehmer: </td><td>".$insertArr['anzKollegen']."</td></tr>
		<tr><td>Bemerkungen: </td><td>".$parameter['bem']."</td></tr>
		</table>
		<p></p>
			<p>Viele Grüße</p>
			<p style='font-weight:bold;'>StR Peter Mayer</p>
			<p>pe.mayer@lmu.de</p>
			</body>
			</html>";

// 	emailSenden($from,array($imap_user_name),$subject, $message);
// 	emailSenden($imap_user_name,array($imap_user_name),$subject_dozent, $message_dozent);
	}else{
		//WARTELISTE
	$subject_dozent="Anmeldung SchILF - WARTELISTE - HINWEISE FÜR DOZENTEN";
	$message_dozent="
		<html>
		<head>
		<meta charset='utf-8'>
		<meta http-equiv=\'Content-Type\' content=\'text/html; charset=utf-8\' />
		</head>
		<body>
		<h1>WARTELISTE</h1>
		<h3>Details zur Anmeldung von ".$insertArr['vname'] .$insertArr['name']."</h3>
		<p>Hallo,</p>
		<p>für Ihre Veranstaltung ist eine Anmeldung eingegangen. Im Folgenden finden Sie die Details zur Buchung:</p>
		<table>
		<tr><td style='color:red; font-weight:bold;'>Termin: </td><td style='color:red; font-weight:bold;'>".date("d.m.Y \u\m H:i",strtotime($insertArr['start']))." Uhr</td></tr>
		<tr><td>Schule: </td><td>".$SchulInfo['Name']."</td></tr>
		<tr><td>Schulart: </td><td>".$SchulInfo['sTyp']."</td></tr>
		<tr><td>Lehrkraft: </td><td>".$insertArr['vname'].",".$insertArr['name']."</td></tr>
		<tr><td>Email: </td><td>".$insertArr['email']."</td></tr>
		<tr><td>Mobil: </td><td>".$insertArr['tel']."</td></tr>
		<tr><td>Anzahl der Teilnehmer: </td><td>".$insertArr['anzKollegen']."</td></tr>
		<tr><td>Bemerkungen: </td><td>".$parameter['bem']."</td></tr>
		</table>
		<p></p>
			<p>Viele Grüße</p>
			<p style='font-weight:bold;'>StR Peter Mayer</p>
			<p>pe.mayer@lmu.de</p>
			</body>
			</html>";


// 	emailSenden($imap_user_name,array($imap_user_name),$subject_dozent, $message_dozent);
	}
	emailSenden($imap_user_name,array("peter.mayer@fit4exam.de"),$subject_dozent, $message_dozent);
	unset($_POST);
	header("LOCATION: /module/mod_kontakt/kontakt.php");
}

?>

<html>
	<head>
		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/head_main.php");?>
		<script src="/plugins/tinymce/js/tinymce/tinymce.min.js"></script>
	</head>
	<body>
		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/header_bar.php");?>
		<div class="container">
			<form class="form-horizontal" method="POST" action="">
				<input type="hidden" name="BuchungsID" value="<?php if(isset($_SESSION['BuchungsID'])){echo $_SESSION['BuchungsID'];}else{echo 0;} ?>">
				<div class="form-group">
					<div class="col-sm-1"></div>
					<div class="col-sm-10">
						<h2>Gewählter Termin: <span class="text-danger"><?php  echo date("d.m.Y \a\b H:i",strtotime ($TerminInfo['start']));?> </span></h2>
						<input type="hidden" value="<?php echo $_SESSION['TerminID']; ?>" name="TerminID">
					</div>
					<div class="col-sm-1"></div>
				</div>
				<div class="form-group">
					<div class="col-sm-1"></div>
					<div class="col-sm-10">
						<h4>Schule</h4>
					</div>
					<div class="col-sm-1"></div>
				</div>
					<div class="form-group">
						<div class="col-sm-1"></div>
						<div class="col-sm-2"   style="text-align: right;">
							<label for="schule"  style="text-align: right;">Schulnummer oder Schulname</label>
						</div>
						<div  class="form-horizontal col-sm-8" >
							<div class="col-sm-2" style="padding:0;">
								<select  class="form-control" id="schule" name="SchulNr">
									<option value="">Bitte auswählen</option>
									<?php
									$SchulListe=getSchulen_Liste();
									foreach($SchulListe as $schule){
										if($schule['SchulNr']==$userInfo['SchulNr']){$selected="selected";}else{$selected="";}
									?>
									<option value="<?php echo $schule['SchulNr']; ?>" <?php echo $selected; ?>><?php echo str_pad ( $schule['SchulNr'] , 4, 0,STR_PAD_LEFT); ?></option>
									<?php
									}
									?>
								</select>
							</div>
							<div class="col-sm-10" style="padding:0;">
								<select  class="form-control" id="SchulName" name="SchulName">
									<option value="">Bitte auswählen</option>
									<?php

									foreach($SchulListe as $schule){
										$selected="";
										// 											if($schule['SchulNr']==$userInfo['SchulNr']){$selected="selected";}else{$selected="";}
									?>
									<option value="<?php echo $schule['SchulNr']; ?>" <?php echo $selected; ?>><?php echo $schule['Name']; ?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div>
						<div class="col-sm-1"></div>
					</div>
				<div class="form-group">
					<div class="col-sm-1"></div>
					<label for="anzKollegen" class="col-sm-2 control-label">Anzahl der Teilnehmer</label>
					<div class="col-sm-8">
						<input type="number" class="form-control" id="anzKollegen" placeholder="Anzahl der Teilnehmer" name="anzKollegen" required>
					</div>
					<div class="col-sm-1"></div>
				</div>
				<div class="form-group">
					<div class="col-sm-1"></div>
					<div class="col-sm-10">
						<h4>Ansprechpartner</h4>
					</div>
					<div class="col-sm-1"></div>
				</div>
				<div class="form-group">
					<div class="col-sm-1"></div>
					<label for="name" class="col-sm-2 control-label">Name</label>
					<div class="col-sm-8">
						<input type="test" class="form-control" id="name" placeholder="Name" name="name" required>
					</div>
					<div class="col-sm-1"></div>
				</div>
				<div class="form-group">
					<div class="col-sm-1"></div>
					<label for="vname" class="col-sm-2 control-label">Vorname</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="vname" placeholder="Vorname" name="vname" required>
					</div>
					<div class="col-sm-1"></div>
				</div>
				<div class="form-group">
					<div class="col-sm-1"></div>
					<label for="email" class="col-sm-2 control-label">Email</label>
					<div class="col-sm-8">
						<input type="email" class="form-control" id="email" placeholder="Email" name="email" required>
					</div>
					<div class="col-sm-1"></div>
				</div>
				<div class="form-group">
					<div class="col-sm-1"></div>
					<label for="tel" class="col-sm-2 control-label">Telefon / Mobil</label>
					<div class="col-sm-8">
						<input type="tel" class="form-control" id="tel" placeholder="Telefonnummer" name="tel" required>
					</div>
					<div class="col-sm-1"></div>
				</div>
				<div class="form-group">
					<div class="col-sm-1"></div>
					<div class="col-sm-10">
						<h4>Termindetails</h4>
					</div>
					<div class="col-sm-1"></div>
				</div>
				<div class="form-group">
					<div class="col-sm-1"></div>
					<label for="beginn" class="col-sm-2 control-label">Beginn</label>
					<div class="col-sm-8">
						<?php 
						?>
						<input type="time" class="form-control" min="<?php echo date("H:i:s",strtotime ($TerminInfo['start']));?>" max="<?php echo date("H:i:s", strtotime($TerminInfo['ende'])-120*60);?>" id="beginn" name="start" required value="<?php echo date("H:i:s",strtotime ($TerminInfo['start'])); ?>">

					</div>
					<div class="col-sm-1"></div>
				</div>
				<div class="form-group">
					<div class="col-sm-1"></div>
					<label for="ende" class="col-sm-2 control-label">Ende</label>
					<div class="col-sm-8">
						<input disabled type="time" class="form-control"  min="<?php echo date("H:i:s", strtotime($TerminInfo['start'])+120*60);?>" max="<?php echo date("H:i:s",strtotime ($TerminInfo['ende']));?>" id="ende" name="ende" required value='<?php echo date("H:i:s", strtotime($TerminInfo['start'])+120*60);?>'>
					</div>
					<div class="col-sm-1"></div>
				</div>
				<div class="form-group">
					<div class="col-sm-1"></div>
					<div class="col-sm-10">
						<h4>Sonstiges</h4>
					</div>
					<div class="col-sm-1"></div>
				</div>
				<div class="form-group">
					<div class="col-sm-1"></div>
					<label for="Bem" class="col-sm-2 control-label">Besonderheiten, Bermerkungen, Anfragen o.ä.</label>
					<div class="col-sm-8">
						<textarea class="form-control" id="bem" name="bem"></textarea>
					</div>
					<div class="col-sm-1"></div>
				</div>
				<hr>
				<div class="form-group">
					<div class="col-sm-1"></div>
					<div class="col-sm-10">
						<button type="submit" class="btn btn-primary btn-block">Buchung absenden</button>
					</div>
					<div class="col-sm-1"></div>
				</div>
			</form>
		</div>

		<script>

			$('#beginn').click(function()  {
				$( "#beginn" ).each(function(e){
					var startTime = $('input#beginn').val();
					var textArr = startTime.split(":");
					var origDate = new Date(1, 1, 1, textArr[0], textArr[1], 0, 0);
					origDate.setHours(origDate.getHours()+2);
					origDate.setMinutes(origDate.getMinutes()+00);    
					var endTime = pad(origDate.getHours(),2)+":"+pad(origDate.getMinutes(),2);
					$("#ende").val(endTime);
				});
			});

function pad (str, max) {
  str = str.toString();
  return str.length < max ? pad("0" + str, max) : str;
}
		</script>
	</body>
</html>
