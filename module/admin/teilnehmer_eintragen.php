<?php
include($_SERVER['DOCUMENT_ROOT']."/includes/header_php.php");
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
// 	var_dump($_SESSION);

$ausserhalbKurs=1;

include_once($_SERVER['DOCUMENT_ROOT']."/includes/session_delay.php");

// header('Content-Type: text/html; charset=UTF-8');
include_once($_SERVER['DOCUMENT_ROOT']."/php/kursInfos.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/Sessions.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/teilnehmer.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/system.php");
include($_SERVER['DOCUMENT_ROOT']."/config.php");
// $SessionInfos=Get_SessionInfos($_SESSION['s']);
// $uID=$SessionInfos['uID'];
$uID=$_SESSION['uID'];

// ========================
// ====== KURSID IN SESSION SCHREIBEN
// ========================

if(isset($_POST['k'])){
	$kursID=intval($_POST['k']);
	$_SESSION['k']=$kursID;
}

// ========================
// ====== TEILNEHMER LÖSCHEN
// ========================

if(isset($_POST['delTN'])){
	deleteTN(intval($_POST['delTN']),$_SESSION['k']);
	unset($_POST['delTN']);
}

// ========================
// ====== TEILNEHMER BEARBEITEN
// ========================


if(isset($_POST['tn'])){
	$_SESSION['tnID']=intval($_POST['tn']);
	$TeilnehmerInfo=getTeilnehmerInfos(intval($_POST['tn']));
	unset($_POST['tn']);
}

// ========================
// ====== TEILNEHMER HINZUFÜGEN o. UPDATED
// ========================

if(isset($_POST['vname']) && isset($_POST['name'])){
	if(isset($_SESSION['tnID'])){
		UpdateTeilnehmer(mysqli_real_escape_string ($verbindung, htmlentities ($_POST['geschlecht'], ENT_QUOTES , "UTF-8")), mysqli_real_escape_string ($verbindung, htmlentities ($_POST['name'], ENT_QUOTES , "UTF-8")), mysqli_real_escape_string ($verbindung, htmlentities ($_POST['vname'], ENT_QUOTES , "UTF-8")), mysqli_real_escape_string ($verbindung, htmlentities ($_POST['email'], ENT_QUOTES , "UTF-8")),mysqli_real_escape_string ($verbindung, htmlentities ($_SESSION['tnID'], ENT_QUOTES , "UTF-8")));
		unset($_SESSION['tnID']);
	}else{
		AddTeilnehmer(mysqli_real_escape_string ($verbindung, htmlentities ($_POST['geschlecht'], ENT_QUOTES , "UTF-8")), mysqli_real_escape_string ($verbindung, htmlentities ($_POST['name'], ENT_QUOTES , "UTF-8")), mysqli_real_escape_string ($verbindung, htmlentities ($_POST['vname'], ENT_QUOTES , "UTF-8")), mysqli_real_escape_string ($verbindung, htmlentities ($_POST['email'], ENT_QUOTES , "UTF-8")), $uID,mysqli_real_escape_string ($verbindung, htmlentities ($_SESSION['k'], ENT_QUOTES , "UTF-8")));
	}
	reset($_POST);
}


// ========================
// ====== TEILNEHMER DIESEM KURS ZUORDNEN
// ========================

if(isset($_POST['tn_other'])){
	foreach($_POST['tn_other'] as $key => $value){
		$Tempkey=mysqli_real_escape_string ($verbindung, htmlentities ($key, ENT_QUOTES , "UTF-8"));
		$Tempvalue=mysqli_real_escape_string ($verbindung, htmlentities ($value, ENT_QUOTES , "UTF-8"));
		$TempArr[$Tempkey]=$Tempvalue;
	}
	foreach($TempArr as $tnID){
		AddTeilnehmerKursMatch($_SESSION['k'],$tnID);
		// 		echo $tnID."<br>";

	}
}

// ========================
// ====== ANONYMOUS - TEILNEHMER HINZUFÜGEN
// ========================

if(isset($_POST['AnzTN'])){

	$praefix=mysqli_real_escape_string ($verbindung, htmlentities ($_POST['praefix'], ENT_QUOTES , "UTF-8"));


	for($iLauf=1;$iLauf<=intval($_POST['AnzTN']);$iLauf++){
		switch(rand (0 , 1 )){
			case 1:
				$geschlecht="m";
				break;

			default:
				$geschlecht="w";
				break;

		}

		$name=$praefix."_Name_".$iLauf; 
		$vname=$praefix."_vName_".$iLauf;
		$email=$praefix."_email_".$iLauf."@anonymous.de";
		AddTeilnehmer($geschlecht, $name, $vname, $email, $uID, $_SESSION['k']);
	}
	unset($_POST['AnzTN']);
}

// ========================
// ====== TEILNEHMER AUS EINER TXT/CSV DATEI IMPORTIEREN
// ========================

if ( isset($_FILES["file"])) {

	if ($_FILES["file"]["error"] > 0) {
		echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
	}
	else {
		//Print file details
		// 		echo "Upload: " . $_FILES["file"]["name"] . "<br />";
		// 		echo "Type: " . $_FILES["file"]["type"] . "<br />";
		// 		echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
		// 		echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

		if (file_exists($_SERVER['DOCUMENT_ROOT']."/tmp/" . $_FILES["file"]["name"])) {
			echo $_FILES["file"]["name"] . " already exists. ";
		}
		else {
			$storagename = $uID."_".uniqid().".txt";
			move_uploaded_file($_FILES["file"]["tmp_name"], $_SERVER['DOCUMENT_ROOT']."/tmp/" . $storagename);
		}
	}

	if ( $file = fopen(  $_SERVER['DOCUMENT_ROOT']."/tmp/" . $storagename ,'r' ) ) {

		$firstline = utf8_encode(fgets ($file, 4096 )); 
		//Gets the number of fields, in CSV-files the names of the fields are mostly given in the first line
		$num = strlen($firstline) - strlen(str_replace(";", "", $firstline));

		//save the different fields of the firstline in an array called fields
		$fields = array();
		$fields = explode( ";", trim(preg_replace('/\s+/', '',$firstline)), ($num+1) );

		//array aller SOLL - Felder
		$SollArr=array("geschlecht"=>0,"vname"=>0,"name"=>0,"email"=>0);
		foreach($SollArr as $key=>$value){
			$key_ist=array_search ( $key , $fields);
			$SollArr[$key]=$key_ist;
		}


		$line = array();
		$i = 0;

		while ( $line[$i] = utf8_encode(fgets ($file, 4096) )) {
			$dsatz[$i] = array();
			$dsatz[$i] = explode( ";", trim(preg_replace('/\s+/', '', $line[$i])), ($num+1) );
			$i++;
		}

		$i = 0;
		$dsatzSort=array();
		for ($i=0;$i<count($dsatz);$i++) {
			$dsatzSort[$i]['name'] =$dsatz[$i][$SollArr['name']] ;
			$dsatzSort[$i]['vname'] =$dsatz[$i][$SollArr['vname']] ;
			$dsatzSort[$i]['geschlecht'] =$dsatz[$i][$SollArr['geschlecht']] ;
			$dsatzSort[$i]['email'] =$dsatz[$i][$SollArr['email']] ;
		}

		array_walk_recursive($dsatzSort, function($item, $key) {
			include($_SERVER['DOCUMENT_ROOT']."/config.php");
			$item=mysqli_real_escape_string ($verbindung, htmlentities ($item, ENT_QUOTES , "UTF-8"));
		});


		for ($i=0;$i<count($dsatz);$i++) {
			AddTeilnehmer($dsatzSort[$i]['geschlecht'], $dsatzSort[$i]['name'], $dsatzSort[$i]['vname'], $dsatzSort[$i]['email'], $uID, intval($_SESSION['k']));
		}
	}
}




?>
<html>
	<head>
		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/head_main.php");?>
		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/head_backend.php");?>


		<?php include($_SERVER['DOCUMENT_ROOT']."/plugins/tinymce/include/init_preferences_mail.php");?>

	</head>
	<body>
		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/header_bar.php");?>

		<div class="container">
			<div class="row" style='margin-top:50px;'>
				<div class="col-md-1"></div>
				<div class="col-md-2">
					<p class="lead">Ihre Kurse:</p>
					<?php
					$Kurse=GetKursListeInfos($uID,1,1);
					foreach($Kurse as $KursInfo){
						// 						var_dump($KursInfo);
					?>
					<form action='' method="POST" style='margin:0;'>
						<input type=hidden value='<?php  echo $KursInfo['kursID']; ?>' name='k'><input type="submit" class="btn <?php if(isset($_SESSION['k']) && $_SESSION['k']==$KursInfo['kursID']){echo "btn-primary";}else{echo "btn-default";}?>" style='width:100%' value="<?php echo $KursInfo['titel']; ?>">
					</form>
					<?php
					}
					?>
				</div>

				<div class="col-md-4">
					<?php
					if(isset($_SESSION['k'])){
					?>
					<p class="lead">Neuen Teilnehmer eintragen</p>
					<form class=''  method="POST" action="">
						<div class="form-group">
							<label for="geschl">Geschlecht</label>
							<select class="form-control" id="geschl" name="geschlecht" required>
								<option value='m' <?php if(isset($TeilnehmerInfo['geschlecht'])){ if($TeilnehmerInfo['geschlecht']=="m"){echo "selected";}} ?>>männlich</option>
								<option value='w' <?php if(isset($TeilnehmerInfo['geschlecht'])){if($TeilnehmerInfo['geschlecht']=="w"){echo "selected";}} ?>>weiblich</option>
							</select>
						</div>
						<div class="form-group">
							<label for="vname">Vorname</label>
							<input id='vname' type="text" class="form-control" name="vname" placeholder="Vorname" required value='<?php if(isset($TeilnehmerInfo['vname'])){echo $TeilnehmerInfo['vname'];} ?>'>
						</div>
						<div class="form-group">
							<label for="name">Name</label>
							<input id='name' type="text" class="form-control" name="name" placeholder="Name" required value='<?php if(isset($TeilnehmerInfo['name'])){echo $TeilnehmerInfo['name'];} ?>'>
						</div>
						<div class="form-group">
							<label for="eMail">eMail</label>
							<input id='eMail' type="text" class="form-control" name="email" placeholder="eMail" required value='<?php if(isset($TeilnehmerInfo['email'])){echo $TeilnehmerInfo['email'];} ?>'>
						</div>
						<button type="submit" class="btn btn-primary">Teilnehmer eintragen / updaten</button>
					</form>

					<hr>

					<p class="lead">Anonymous-Teilnehmer erstellen</p>
					<form class=''  method="POST" action="">
						<div class="form-group">
							<label for="praefix">Präfix des Anonymous-Teilnehmers</label>
							<input type="text" class="form-control" value="" placeholder="Präfix" name="praefix" id="praefix">
							<label for="name">Anzahl der Anonymous-Teilnehmer</label>
							<input id='name' type="number" class="form-control" name="AnzTN" placeholder="Anzahl der Teilnehmer" required>
						</div>
						<button type="submit" class="btn btn-primary">Anonymous-Teilnehmer erstellen</button>
					</form>
					<hr>

					<p class="lead">Teilnehmerliste importieren</p>
					<form class=''  method="POST" action="" enctype="multipart/form-data">
						<div class="form-group">
							<label for="file">Teilnehmerliste auswählen</label>
							<input type="file" class="form-control-file" id="file" name='file' aria-describedby="fileHelp"><br>
							<small id="fileHelp" class="form-text text-muted"><code>Die Import-Datei muss die Struktur dieser <a target="_blank" href='/vorlagen/Vorlage_TeilnehmerImport.txt'>Demo-Datei</a> aufweisen. Die erste Zeile enthält die Überschriften und darf keinesfalls gelöscht oder verändert werden!</code></small>
						</div>

						<button type="submit" class="btn btn-primary">Teilnehmer importieren</button>
					</form>	
					<hr>

					<p class="lead">Teilnehmer aus anderen Kursen zu diesem Kurs hinzufügen</p>
					<form class=''  method="POST" action="" enctype="multipart/form-data">
						<div class="form-group">
							<label for="file">Teilnehmer auswählen</label>
							<select multiple class="form-control" name='tn_other[]'>
								<?php
						$tnArr=getAllTeilnehmerOfUser($uID);
						foreach($tnArr as $tn){
							$tnID=$tn['tnID'];
							$tnName=$tn['name'];
							$tnVName=$tn['vname'];

							echo "<option value='$tnID'>$tnVName, $tnName</option>";
						}

								?>
							</select>
						</div>

						<button type="submit" class="btn btn-primary">Teilnehmer importieren</button>
					</form>					<?php
					}
					?>
				</div>
				<div class="col-md-4">
					<?php
					if(isset($_SESSION['k'])){
					?>
					<p class="lead">Kursteilnehmer 
						<a href='/module/admin/token_drucken.php' class='glyphicon glyphicon-print' target="blank"></a>
						<a data-toggle="modal"  data-id='<?php  echo $_SESSION['k']; ?>' href="#normalModal"  class='glyphicon glyphicon-envelope mail_btn' target="blank"></a></p>
					<?php 
						if(isset($_GET['m'])&& intval($_GET['m'])==1){
					?>
					<div class="alert alert-success"> Alle Emails wurden erfolgreich versendet!</div>
					<?php 
						}elseif(isset($_GET['m'])&& intval($_GET['m'])==0){
					?>
					<div class="alert alert-danger"> Bei mindestens einer Email ist ein Fehler aufgetreten!</div>
					<?php 
						}elseif(isset($_GET['m'])&& intval($_GET['m'])==2){
					?>
					<div class="alert alert-danger"> Es wurden keine Emails versendet, da Sie noch keine Teilnehmer eingetragen haben!</div>
					<?php 
						}
					?>
					<div class="row">
						<table class='table-striped' style='width:100%'>
							<tr><th>Vorname</th><th>Name</th><th class="hidden-sm hidden-xs">Token</th><th>Optionen</th></tr>
							<?php
						$tnArr=getTeilnehmerListeInfos($_SESSION['k']);
						//  						var_dump($tnArr);
						foreach($tnArr as $tn){
							$abArr=get_all_Abgaben_by_token($tn['token']);
							?>
							<tr>
								<td>
									<form action='' method="POST" style='display: inline-block; margin:0; width:100%;'>
										<input type=hidden value='<?php  echo $tn['tnID']; ?>' name='tn'>
										<button type="submit" class=""  style='background:none; border:none; text-decoration: underline; color: darkgreen; '><?php echo $tn['vname']; ?></button>
									</form>
								</td>
								<td>
									<form action='' method="POST" style='display: inline-block; margin:0; width:100%;'>
										<input type=hidden value='<?php  echo $tn['tnID']; ?>' name='tn'>
										<button type="submit" class=""  style='background:none; border:none; text-decoration: underline; color: darkgreen; '><?php echo $tn['name']; ?></button>
									</form>
								</td>
								<td class="hidden-sm hidden-xs"><?php echo $tn['token']; ?></td>
<!--								<td  class="visible-sm visible-xs ">
									<div class="row" style=''>
										<div class="col-sm-6 col-xs-6">
											<div>
												<?php if($tn['dozent']==0){?>
												<img src="/images/professor_red.svg" style="height:22px;">
												<?php }else{?>
												<img src="/images/professor_green.svg" style="height:22px;">
												<?php	   }?>
											</div>
										</div>
										<div class="col-sm-6 col-xs-6">
											<div class="tn_icon_used">.</div>
										</div>
									</div>
								</td>//-->
<!--								<td  class="hidden-sm hidden-xs" style='text-align:right;'>//-->
								<td  class="" style='text-align:right;'>
									<div class="row" style=''>
										<div class="col-md-4">
											<div id="tn_<?php  echo $tn['tnID']; ?>" data-options='{"tnID":"<?php  echo $tn['tnID']; ?>"}' class="teacherIMG">
												<?php if($tn['dozent']==0){?>
												<img src="/images/professor_red.svg" style="height:22px;">
												<?php }else{?>
												<img src="/images/professor_green.svg" style="height:22px;">
												<?php	   }?>
											</div>
										</div>	
										<div class="col-md-2">
											<div style="padding: 5px 0;"><span class="tn_icon_used <?php if(count($abArr)>0){echo 'tn_not_used';}else{echo 'tn_used';} ?>" <?php if(count($abArr)>0){echo 'data-toggle="tooltip" title="Dieser Zugriffstoken wurde bereits verwendet"';}else{echo 'data-toggle="tooltip" title="Dieser Zugriffstoken wurde noch nicht verwendet"';} ?>></span></div>
										</div>
										<div class="col-md-5">
											<form action='' method="POST" style='display: inline-block; margin:0; width:100%;'>
												<input type=hidden value='<?php  echo $tn['tnID']; ?>' name='delTN'>
												<button type="submit" class="btn btn-danger"  style=''><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
											</form>
										</div>	
									</div>
								</td>
							</tr>

							<?php
						}
							?>
						</table>
						<?php
					}
						?>
					</div>
					<div class="col-md-1"></div>
				</div>
			</div>
		</div>

		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/bottom_main.php");?>

		<script>
			$(function() {
				$('.teacherIMG').click(function(){
					var tnID=$( this ).data( "options" ).tnID;
					$.ajax({
						type: "POST",
						url: "/php/teilnehmer.php",
						data: {tnID:tnID,PostFktn:"changeTeacherStatus"},
						success: function(data){
							$('#tn_'+tnID).html(data);
						}
					})
					// 					$('#ts_'+tnID).html(data);
					return false;
				});
			});

		</script>

		<script>
			$(".modal-wide").on("show.bs.modal", function() {
				var height = $(window).height() - 200;
				$(this).find(".modal-body").css("max-height", height);
			});

			$(".mail_btn").on("click", function () {
				var KursID = $(this).data('id');
				$(".modal-body #KursID").val( KursID );
			});
		</script>

		<div id="normalModal" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<form method="post" action="token_email.php">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title">Einladungsmails versenden</h4>
						</div>
						<div class="modal-body">
							<p>Geben Sie bitte einen kurzen Email-Text zur Beschreibung ein. Die Anrede und die Tokenlinks werder automatisch generiert und hinzugefügt.</p>
							<textarea name="email_TXT"></textarea>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
							<button type="submit" class="btn btn-primary">Emails versenden</button>
						</div>
					</form>
				</div>
			</div>
		</div>

	</body>
</html>