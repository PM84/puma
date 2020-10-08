<?php 
session_start();
$_SESSION['TerminID']=intval($_POST['TerminID']);
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/schule.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/system.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/module/mod_klassenbesuch/fkt_buchung.php");


$TerminInfo=getTermin_by_TerminID($_SESSION['TerminID']);
$Termin_parameter=json_decode($TerminInfo['parameter'],true);


$Buchungen=getBuchungen_by_TerminID($_SESSION['TerminID']);

if(isset($_POST['BuchungsID'])){
	
	$insertArr=[];
	foreach($_POST as $key => $value){
		$Tempkey=mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($key), ENT_QUOTES , "UTF-8"));
		$Tempvalue=mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($value), ENT_QUOTES , "UTF-8"));
		$insertArr[$Tempkey]=$Tempvalue;
	}
	$insertArr['SchulNr']=intval($insertArr['SchulNr']);
	if($insertArr['SchulNr']==0){$insertArr['SchulNr']=intval($_POST['SchulName']);}

	$parameter=[];
	$parameter['bem']=$insertArr['bem'];
	$parameter['JgSt']=$insertArr['JgSt'];

	$parameter_insert=json_encode($parameter);

	$query="INSERT INTO z_klassenbesuch_buchung (TerminID,SchulNr,name,vname,email,tel,anzSchueler,parameter) VALUES ('".$insertArr['TerminID']."','".$insertArr['SchulNr']."','".$insertArr['name']."','".$insertArr['vname']."','".$insertArr['email']."','".$insertArr['tel']."','".$insertArr['anzSchueler']."','".$parameter_insert."')";
	// 	echo $query;
	mysqli_query($verbindung,$query)or die($query." => ".mysqli_error($verbindung));

	if(count($Buchungen)==0){
		//BUCHUNG
		$subject="Anmeldung zum Klassenbesuch - BUCHUNGSBESTÄTIGUNG";
		$message="
		<html>
		<head>
		<meta charset='utf-8'>
		<meta http-equiv=\'Content-Type\' content=\'text/html; charset=utf-8\' />
		</head>
		<body>
		<h3>Anmeldung zum Klassenbesuch</h3>
		<p>Hallo,</p><p>Sie haben sich eben für einen Klassenbesuch am ".date("d.m.Y \u\m H:i",strtotime($TerminInfo['start']))." Uhr am Lehrstuhl Didaktik der Physik angemeldet. Dies ist eine automatisch generierte Bestätigung, dass Ihre Buchung bei uns eingegangen ist und akzeptiert wurde.<br><br>Sollten Sie noch Fragen haben, können Sie den Dozenten der jeweiligen Begleitveranstaltung (".$TerminInfo['betreuer'].",".$TerminInfo['betreuer_mail'].") kontaktieren.</p><p>Ansonsten freuen wir uns auf Ihren Besuch!<br><br>Für allgemeine Fragen stehe ich Ihnen natürlich gerne zur Verfügung!</p>
			<p>Viele Grüße</p>
			<p style='font-weight:bold;'>StR Peter Mayer</p>
			<p>pe.mayer@lmu.de</p>
			</body>
			</html>";
	}else{
		//WARTELISTE
		$subject="Anmeldung zum Klassenbesuch - WARTELISTE";
		$message="
		<html>
		<head>
		<meta charset='utf-8'>
		<meta http-equiv=\'Content-Type\' content=\'text/html; charset=utf-8\' />
		</head>
		<body>
		<h3>Anmeldung zum Klassenbesuch - Warteliste</h3>
		<p>Hallo,</p><p>Sie haben sich eben für einen Klassenbesuch am ".date("d.m.Y \u\m H:i",strtotime($TerminInfo['start']))." Uhr am Lehrstuhl Didaktik der Physik angemeldet. Dies ist eine automatisch generierte Bestätigung dafür, dass Sie in die Warteliste eingetragen wurden.<br><br>Sollte der Termin frei werden, dann wird sich der Dozent der jeweiligen Begleitveranstaltung (".$TerminInfo['betreuer'].",".$TerminInfo['betreuer_mail'].") rechtzeitig bei Ihnen melden um Details zu besprechen.<br><br>Für Fragen stehe ich Ihnen natürlich gerne zur Verfügung!</p>
			<p>Viele Grüße</p>
			<p style='font-weight:bold;'>StR Peter Mayer</p>
			<p>pe.mayer@lmu.de</p>
			</body>
			</html>";
	}

	emailSenden($TerminInfo['betreuer_mail'],array($imap_user_name,$insertArr['email'],$TerminInfo['betreuer_mail']),$subject, $message);

	$SchulInfo=getSchulInfo_by_SchulNr($insertArr['SchulNr']);
	
	if(count($Buchungen)==0){
		//BUCHUNG
		$subject_dozent="Anmeldung zum Klassenbesuch - HINWEISE FÜR DOZENTEN";
		$message_dozent="
		<html>
		<head>
		<meta charset='utf-8'>
		<meta http-equiv=\'Content-Type\' content=\'text/html; charset=utf-8\' />
		</head>
		<body>
		<h3>Details zur Anmeldung von ".$insertArr['vname']." " .$insertArr['name']."</h3>
		<p>Hallo,</p>
		<p>für Ihre Veranstaltung ist eine Anmeldung eingegangen. Im Folgenden finden Sie die Details zur Buchung:</p>
		<table>
		<tr><td style='color:red; font-weight:bold;'>Termin: </td><td style='color:red; font-weight:bold;'>".date("d.m.Y \u\m H:i",strtotime($TerminInfo['start']))." Uhr</td></tr>
		<tr><td>Schule: </td><td>".$SchulInfo['Name']."</td></tr>
		<tr><td>Schulart: </td><td>".$SchulInfo['sTyp']."</td></tr>
		<tr><td>Lehrkraft: </td><td>".$insertArr['vname'].",".$insertArr['name']."</td></tr>
		<tr><td>Email: </td><td>".$insertArr['email']."</td></tr>
		<tr><td>Mobil: </td><td>".$insertArr['tel']."</td></tr>
		<tr><td>Anzahl der Schüler: </td><td>".$insertArr['anzSchueler']."</td></tr>
		<tr><td>JgSt: </td><td>".$parameter['JgSt']."</td></tr>
		<tr><td>Bemerkungen: </td><td>".$parameter['bem']."</td></tr>
		</table>
		<p></p>
			<p>Viele Grüße</p>
			<p style='font-weight:bold;'>StR Peter Mayer</p>
			<p>pe.mayer@lmu.de</p>
			</body>
			</html>";

		emailSenden($email_adresse,array($imap_user_name,$TerminInfo['betreuer_mail']),$subject_dozent, $message_dozent);
	}else{
		//WARTELISTE
		$subject_dozent="Anmeldung zum Klassenbesuch - WARTELISTE - HINWEISE FÜR DOZENTEN";
		$message_dozent="
		<html>
		<head>
		<meta charset='utf-8'>
		<meta http-equiv=\'Content-Type\' content=\'text/html; charset=utf-8\' />
		</head>
		<body>
		<h1>WARTELISTE</h1>
		<h3>Details zur Anmeldung von ".$insertArr['vname']." " .$insertArr['name']."</h3>
		<p>Hallo,</p>
		<p>für Ihre Veranstaltung ist eine Anmeldung eingegangen. Im Folgenden finden Sie die Details zur Buchung:</p>
		<table>
		<tr><td style='color:red; font-weight:bold;'>Termin: </td><td style='color:red; font-weight:bold;'>".date("d.m.Y \u\m H:i",strtotime($TerminInfo['start']))." Uhr</td></tr>
		<tr><td>Schule: </td><td>".$SchulInfo['Name']."</td></tr>
		<tr><td>Schulart: </td><td>".$SchulInfo['sTyp']."</td></tr>
		<tr><td>Lehrkraft: </td><td>".$insertArr['vname'].",".$insertArr['name']."</td></tr>
		<tr><td>Email: </td><td>".$insertArr['email']."</td></tr>
		<tr><td>Mobil: </td><td>".$insertArr['tel']."</td></tr>
		<tr><td>Anzahl der Schüler: </td><td>".$insertArr['anzSchueler']."</td></tr>
		<tr><td>JgSt: </td><td>".$parameter['JgSt']."</td></tr>
		<tr><td>Bemerkungen: </td><td>".$parameter['bem']."</td></tr>
		</table>
		<p></p>
			<p>Viele Grüße</p>
			<p style='font-weight:bold;'>StR Peter Mayer</p>
			<p>pe.mayer@lmu.de</p>
			</body>
			</html>";

		emailSenden($email_adresse,array($imap_user_name,$TerminInfo['betreuer_mail']),$subject_dozent, $message_dozent);
	}

	unset($_POST);
	header("LOCATION:  " . $_SESSION['DOCUMENT_ROOT_DIR']."module/mod_klassenbesuch/index.php");
}

?>

<html>
	<head>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/head_main.php");?>
	</head>
	<body>
		<div class="navmenu navmenu-default navmenu-fixed-left">
			<div style='width:100%; display:block;text-align:center;'>
				<img src="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/images/PumaLMU_LS_Logo.png" alt="" height="50">
			</div>
			<ul class="nav navmenu-nav"  style='margin-top:10px;'></ul>
			<ul class="nav navmenu-nav"></ul>
		</div>

		<!--<div class="loginCanv navmenu-default navmenu-fixed-right ">
<?php 

?>
</div>//-->

		<div class="canvas" style="">
			<div class="navbar navbar-default navbar-fixed-top" style="width:100%">
				<div class='row'>
					<div class="col-sm-6" style="height: 55px;">
						<span style="font-size: 24px; font-family: inherit;"><img src="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/images/LMU_Logo.png" style="margin:10px;"><span style="margin-top:10px;">Klassenbesuche</span></span>
					</div><div class="col-sm-6" style="text-align:center;">
					</div>

				</div>
			</div>
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


					<!--					<div class="form-group">
<div class="col-sm-1"></div>
<label for="inputEmail3" class="col-sm-2 control-label">SchulNr & Schulname</label>
<div class="col-sm-8">
<select class="form-control" id="schulauswahl" name="SchulNr" required>
<option value="">Bitte auswählen</option>
<?php
foreach($SchulListe as $Schule){
?>
<option value="<?php echo $Schule['SchulNr']; ?>"><?php  echo str_pad($Schule['SchulNr'], 4, '0', STR_PAD_LEFT)." => ".  $Schule['Name'];  ?></option>
<?php } ?>
</select>
</div>
<div class="col-sm-1"></div>
</div>
//-->
					<div class="form-group">
						<div class="col-sm-1"></div>
						<label for="anzKollegen" class="col-sm-2 control-label">Anzahl der Schüler</label>
						<div class="col-sm-7">
							<input type="number" class="form-control" id="anzKollegen" placeholder="Anzahl der Schüler" name="anzSchueler" min=0 max="<?php echo $Termin_parameter['maxTN']; ?>" required>
						</div>
						<div class="col-sm-1">Max: <?php echo $Termin_parameter['maxTN']; ?></div>
						<div class="col-sm-1"></div>
					</div>
					<div class="form-group">
						<div class="col-sm-1"></div>
						<label for="anzKollegen" class="col-sm-2 control-label">Jahrgangsstufe</label>
						<div class="col-sm-7">
							<input type="number" class="form-control" id="anzKollegen" placeholder="Jahrgangsstufe" name="JgSt" min=1 max="13" required>
						</div>
						<div class="col-sm-1">empfohlen: <?php echo "GY: ".join(", ",$Termin_parameter['Gym']["JgSt"])."<br> RS: ".join(", ",$Termin_parameter['RS']["JgSt"]);?></div>
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
						<label for="beginn" class="col-sm-2 control-label">Thema</label>
						<div class="col-sm-8">
							<h4><?php echo $TerminInfo['titel']; ?></h4>
						</div>
						<div class="col-sm-1"></div>
					</div>
					<div class="form-group">
						<div class="col-sm-1"></div>
						<label for="beginn" class="col-sm-2 control-label">Beginn</label>
						<div class="col-sm-8">
							<h4><?php echo date("d.m.Y \u\m H:i",strtotime ($TerminInfo['start'])); ?> Uhr</h4>
						</div>
						<div class="col-sm-1"></div>
					</div>
					<div class="form-group">
						<div class="col-sm-1"></div>
						<label for="ende" class="col-sm-2 control-label">Ende</label>
						<div class="col-sm-8">
							<h4><?php echo date("d.m.Y \u\m H:i",strtotime ($TerminInfo['ende'])); ?> Uhr</h4>
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
		</div>
		<script>

			$('#beginn').click(function()  {
				$( "#beginn" ).each(function(e){
					var startTime = $('input#beginn').val();
					var textArr = startTime.split(":");
					var origDate = new Date(1, 1, 1, textArr[0], textArr[1], 0, 0);
					origDate.setHours(origDate.getHours()+1);
					origDate.setMinutes(origDate.getMinutes()+30);    
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