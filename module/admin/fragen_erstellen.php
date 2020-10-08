<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/header_php.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/session_delay.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/kursInfos.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/Sessions.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/module.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/frage.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/system.php");
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
$SessionInfos=Get_SessionInfos($_SESSION['s']);
$uID=$SessionInfos['uID'];

// ========================
// ====== FRAGENGRUPPE EDITIEREN
// ========================
if(isset($_POST['FGroupIDedit'])){
	$FGroupID=intval($_POST['FGroupIDedit']);
	$_SESSION['FGroupID']=intval($_POST['FGroupIDedit']);
	unset($_SESSION['FrageID']);
}

// ========================
// ====== FRAGENGRUPPE HINZUFÜGEN o. UPDATED
// ========================

if(isset($_POST['selFGroupID'])){
	$PostArr['GroupTitel']=mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($_POST['GroupTitel']), ENT_QUOTES , "UTF-8"));
// 	$FGroupID=intval($_POST['GroupTitel']);
	$PostJson=json_encode($PostArr);
	if(isset($_SESSION['FGroupID'])){
		UpdateFrageGruppe(intval($_SESSION['FGroupID']),$PostJson);
	}else{
		InsertFrageGruppe($uID,$PostJson);
	}
	unset($_POST);
	unset($_SESSION['FGroupID']);
}

// ========================
// ====== FRAGEN IMPORTIEREN
// ========================
if(isset($_POST['action']) && $_POST['action']=="f_import"){
	if($_POST['del_Fragen_in_Fragegruppen']=='on'){
		$delFragen=1;
	}else{
		$delFragen=0;
	}
	if ( isset($_FILES["InputFile"])) {

		//if there was an error uploading the file
		if ($_FILES["InputFile"]["error"] > 0) {
			//             echo "Return Code: " . $_FILES["InputFile"]["error"] . "<br />";
		}
		else {
			//Print file details
			//              echo "Upload: " . $_FILES["InputFile"]["name"] . "<br />";
			//              echo "Type: " . $_FILES["InputFile"]["type"] . "<br />";
			//              echo "Size: " . ($_FILES["InputFile"]["size"] / 1024) . " Kb<br />";
			//              echo "Temp file: " . $_FILES["InputFile"]["tmp_name"] . "<br />";
			if( strtolower(end(explode('.', $_FILES['InputFile']['name']))) === 'csv'){


				$storagename = $_SESSION['uID']."_f_import_".date("Y_m_d__H_i_s").".txt";
				move_uploaded_file($_FILES["InputFile"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/media/uploads_tmp/" . $storagename);
				//             echo "Stored in: " . $_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/media/uploads_tmp/" . $_FILES["InputFile"]["name"] . "<br />";
				import_txt_frageListe($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/media/uploads_tmp/" . $storagename,$delFragen);
			}else{
				echo "<b>Falscher Dateityp!</b> Es sind nur csv-Dateien erlaubt!";
			}
		}
	} else {
		echo "Keine Datei ausgwählt!";
	}
}

// ========================
// ====== FRAGEN HINZUFÜGEN o. UPDATED
// ========================

if(isset($_POST['action']) && ($_POST['action']=="range" or $_POST['action']=="input")){
	if(isset($_POST['titel']) && isset($_POST['FrageTXT'])){
		$PostArr=[];
		$GroupArr=[];
		foreach($_POST as $key => $val){
			if(strpos($key,"FrageGroupsSel")===FALSE){
				$PostArr[$key]=mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($val), ENT_QUOTES , "UTF-8"));
			}else{
				if(intval($val)>0){
					$GroupArr=$val;
				}
			}
		}
		$PostJson=json_encode($PostArr);
		$SkalaTyp=intval($_POST['SkalaTyp']); // 1: kontinuierlich 2: Lickert 3: Freitext
		if(isset($_SESSION['FrageID'])){
			$FrageID=intval($_SESSION['FrageID']);
			UpdateFrage($uID,$SkalaTyp,$FrageID,$PostJson);
		}else{
			$FrageID=InsertFrage($uID,$SkalaTyp,$PostJson);
		}
		unset($_POST);

		// 	if(count($GroupArr)>0){
		InsertGroupMatches($GroupArr,$FrageID);
		// 	}
	}
}


// ========================
// ====== FRAGEID SETZEN
// ========================

if(isset($_POST['selFrageID'])){
	$_SESSION['FrageID']=intval($_POST['selFrageID']);
}

// ========================
// ====== FRAGE ZUM BEARBEITEN LADEN
// ========================

if(isset($_SESSION['FrageID'])){
	// 	echo "HALLO";
	$FolieArr=getFrageInfo(intval($_SESSION['FrageID']));
	$FrageInfo=json_decode($FolieArr['parameter']);
	$FrageGroups=getFrageGroupsByFrageID(intval($_SESSION['FrageID']));
}

?>


<html>
	<head>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/head_main.php");?>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/head_backend.php");?>
		<style>

			.clickable{
				cursor: pointer;   
			}

			.panel-heading span {
				margin-top: -20px;
				font-size: 15px;
			}

		</style>
	</head>
	<body>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/header_bar.php");?>

		<div class="container">
			<div class="row" style='margin-top:15px;'>
				<div class="col-md-4" style='margin: 0 0 50px 0;'>
					<p class="lead">Fragengruppe erstellen</p>
					<form action='' method="POST" style='margin:2px 0 0 0;'>
						<input type=hidden value='<?php  echo $fGroup['FGroupID']; ?>' name='selFGroupID'>
						<div class="form-group" style='margin-bottom:2px;'>
							<!--							<label for="GroupTitel">Titel der neuen Gruppe</label>//-->
							<?php 	
							if(isset($_SESSION['FGroupID'])){
								$FGroupEditInfo=getGroupInfo($_SESSION['FGroupID']);
								$fGroupInfo=json_decode($FGroupEditInfo['parameter']);
							}
							?>
							<input id='GroupTitel' type="text" class="form-control" name="GroupTitel" placeholder="Titel der Fragengruppe" required value='<?php if(isset($fGroupInfo->GroupTitel)){echo $fGroupInfo->GroupTitel;} ?>'>
						</div>						
						<input type="submit" class="btn btn-primary btn-block"  value="Gruppe erstellen">
					</form>
					<br><br><br>
					<p class="lead">Fragen importieren</p>
					<form action="" method="post" enctype="multipart/form-data">
						<input type="hidden" name="action" value="f_import">
						<div class="form-group">
							<label for="InputFile">Verwenden Sie die Import-Vorlage!</label>
							<input type="file" class="form-control-file" name="InputFile" name="frageCSV">
						</div>
						<div class="form-group">
							<label for="del_Fragen_in_Fragegruppen">Sollen die Fragen, in den vom Import betroffenen Fragengruppen entfernt werden? (Alle etwaigen Ergebnisse werden dadurch gelöscht!)
								<input type="hidden" value="off" name="del_Fragen_in_Fragegruppen">
								<input class="form-control" type="checkbox" data-value="off" data-toggle="toggle" data-on="Ja" data-off="nein" name="del_Fragen_in_Fragegruppen" id="del_Fragen_in_Fragegruppen" data-onstyle="danger" data-offstyle="success">
							</label>
						</div>
						<div class="form-group">
							<input type="submit" class="btn btn-primary btn-block" value="Import starten">
						</div>

					</form>
				</div>

				<div class="col-md-4" style='margin: 0 0 50px 0;'>
					<p class="lead">Meine Fragengruppen und Fragen</p>
					<div class="panel-group" id="accordion">

						<?php
						$fGroups=Get_Fragen_Gruppen($uID);
						foreach($fGroups as $fGroup){
							$status=0;
							$FGroupInfo=json_decode($fGroup['parameter']);
						?>
						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="row">
									<div class="col-xs-9" >
										<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $fGroup['FGroupID'];?>" style='none'>
											<div>
												<h4 class="panel-title">
													<?php echo $FGroupInfo->GroupTitel;?>
												</h4>
											</div>
										</a>
									</div>
									<div class="col-xs-3" style="text-align:right;">

										<form style='display:inline-block;' action="" method="POST" style="margin:0"><input type='hidden' value='<?php echo $fGroup['FGroupID'];?>' name='FGroupIDedit'><button type="submit" class="glyphicon glyphicon-edit"></button></form><span style='display:inline-block; margin-left:10px;' >(id: <b><?php echo $fGroup['FGroupID'];?></b>)</span>
									</div>
								</div>
							</div>
							<div id="collapse<?php echo $fGroup['FGroupID'];?>" class="panel-collapse collapse">
								<div class="panel-body">
									<?php
							$FrageArr=getFragenByGroups(intval($fGroup['FGroupID']));
							foreach($FrageArr as $FrageID){
								
								/* 							if(in_array($thema->themaID,$video->themen)){
 */								$status=1;
								$FrageMenuInfo=[];
								$FrageInfoRow=getFrageInfo($FrageID);
								$FrageInfoPanel=json_decode($FrageInfoRow['parameter']);
								
								// 								$FrageMenuInfo=json_decode($frage['parameter']);
									?>
									<form action='' method="POST" style='margin:0;'>
										<input type=hidden value='<?php  echo $FrageID; ?>' name='selFrageID'><input type="submit" class="btn btn-default" style='width:100%' value="<?php echo $FrageInfoPanel->titel; ?>">
									</form>

									<?php
								// 							}
							}
							if($status==0){
								echo "Dieser Gruppe wurden noch keine Fragen zugeordnet.";
							}

									?>
								</div>
							</div>
						</div>
						<?php
						}
						?>
						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="row">
									<div class="col-xs-10">

										<a class="" data-toggle="collapse" data-parent="#accordion" href="#collapse_all" style='none'>
											<div>
												<h4 class="panel-title">
													Alle Fragen 
												</h4>
											</div>
										</a>
									</div>
									<div class="col-xs-2">

										<form class='' action="" method="POST" style="margin:0"><input type='hidden' value=''><button type="submit" class="glyphicon glyphicon-edit"></button></form>
									</div>
								</div>
							</div>
							<div id="collapse_all" class="panel-collapse collapse">
								<div class="panel-body">

									<?php
									$FragenArr=getFragenByUser($uID);
									foreach($FragenArr as $frage){
										$FrageMenuInfo=[];
										$FrageMenuInfo=json_decode($frage['parameter']);
									?>
									<form action='' method="POST" style='margin:2px 0 0 0;'>
										<input type=hidden value='<?php  echo $frage['FrageID']; ?>' name='selFrageID'>
										<input type="submit" class="btn btn-default" style='width:100%' value="<?php echo $FrageMenuInfo->titel; ?>">
									</form>

									<?php
									}
									?>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-4">
					<p class="lead">Frage erstellen/editieren</p>

					<div>

						<!-- Nav tabs -->
						<ul class="nav nav-tabs" role="tablist">
							<li role="presentation" class="active"><a href="#regler" aria-controls="regler" role="tab" data-toggle="tab">Regler</a></li>
							<li role="presentation"><a href="#input" aria-controls="input" role="tab" data-toggle="tab">Eingabefeld</a></li>
						</ul>

						<!-- Tab panes -->
						<div class="tab-content">
							<div role="tabpanel" class="tab-pane active" id="regler">
								<form action='' method="POST" style='margin:0;'>
									<input type=hidden name="action" value="range">
									<input type=hidden name="SkalaTyp" value="1">
									<div class="form-group">
										<label for="titel">Titel</label>
										<input id='titel' type="text" class="form-control" name="titel" placeholder="Titel der Frage" required value='<?php if(isset($FrageInfo->titel)){echo $FrageInfo->titel;} ?>'>
									</div>

									<div class="form-group">
										<label for="FrageTXT">Fragentext</label>
										<input id='FrageTXT' type="text" class="form-control" name="FrageTXT" placeholder="Fragentext" required value='<?php if(isset($FrageInfo->FrageTXT)){echo $FrageInfo->FrageTXT;} ?>'>
									</div>

									<div class="form-group">
										<label for="FrageTipp">Hinweis / Erläuterung / Tipp</label>
										<input id='FrageTipp' type="text" class="form-control" name="FrageTipp" placeholder="Hinweis / Erläuterung"  value='<?php if(isset($FrageInfo->FrageTipp)){echo $FrageInfo->FrageTipp;} ?>'>
									</div>

									<div class="form-group">
										<label for="FrageLabMax">Beschriftung des Maximalwerts</label>
										<input id='FrageLabMax' type="text" class="form-control" name="FrageLabMax" placeholder="Beschriftung des Maximalwerts" required value='<?php if(isset($FrageInfo->FrageLabMax)){echo $FrageInfo->FrageLabMax;} ?>'>
									</div>

									<div class="form-group">
										<label for="FrageMax">Maximalwert</label>
										<input id='FrageMax' type="number" class="form-control" name="FrageMax" placeholder="Maximalwert" required value='<?php if(isset($FrageInfo->FrageMax)){echo $FrageInfo->FrageMax;} ?>'>
									</div>


									<div class="form-group">
										<label for="FrageLabMin">Beschriftung des Minimalwerts</label>
										<input id='FrageLabMin' type="text" class="form-control" name="FrageLabMin" placeholder="Beschriftung des Minimalwerts" required value='<?php if(isset($FrageInfo->FrageLabMin)){echo $FrageInfo->FrageLabMin;} ?>'>
									</div>
									<div class="form-group">
										<label for="FrageMin">Minimalwert</label>
										<input id='FrageMin' type="number" class="form-control" name="FrageMin" placeholder="Minimalwert" required value='<?php if(isset($FrageInfo->FrageMin)){echo $FrageInfo->FrageMin;} ?>'>
									</div>
									<div class="form-group">
										<label for="initVal">Startwert
											<input type="hidden" value="off" name="initVal">
											<input class="form-control" type="checkbox" checked data-toggle="toggle" data-on="bei Minimalwert" data-off="in der Mitte" name="initVal" id="initVal" data-offstyle="warning">
										</label>
										<script>
											if("<?php if(isset($FrageInfo->initVal) && $FrageInfo->initVal=="on"){echo "on";}else{echo "off";}?>"=="on"){
												$('#initVal').bootstrapToggle('on')
											}else{
												$('#initVal').bootstrapToggle('off')
											}
										</script>
									</div>
									<div class="form-group">
										<label for="initVal">
											<input type="hidden" value="off" name="initToolTip">
											<input class="form-control" type="checkbox" checked data-toggle="toggle" data-on="Ja" data-off="nein" name="initToolTip" id="initToolTip" data-offstyle="warning">
											Tooltip
										</label>
										<script>
											if("<?php if(isset($FrageInfo->initToolTip) && $FrageInfo->initToolTip=="on"){echo "on";}else{echo "off";}?>"=="on"){
												$('#initToolTip').bootstrapToggle('on')
											}else{
												$('#initToolTip').bootstrapToggle('off')
											}
										</script>
									</div>
									<div class="form-group">
										<label for="noAnswer">
											<input type="hidden" value="off" name="noAnswer">
											<input class="form-control" type="checkbox" checked data-toggle="toggle" data-on="Ja" data-off="nein" name="noAnswer" id="noAnswer" data-offstyle="warning">
											"keine Antwort" - Option einblenden
										</label>
										<script>
											if("<?php if(isset($FrageInfo->noAnswer) && $FrageInfo->noAnswer=="on"){echo "on";}else{echo "off";}?>"=="on"){
												$('#noAnswer').bootstrapToggle('on')
											}else{
												$('#noAnswer').bootstrapToggle('off')
											}
										</script>
									</div>
									<div class="form-group">
										<label for="hideTrack">
											<input type="hidden" value="off" name="hideTrack">
											<input class="form-control" type="checkbox" checked data-toggle="toggle" data-on="Ja" data-off="nein" name="hideTrack" id="hideTrack" data-offstyle="warning">
											"Track" - ausblenden (nur wenn Max-Min kleiner als 7)
										</label>
										<script>
											if("<?php if(isset($FrageInfo->hideTrack) && $FrageInfo->hideTrack=="on"){echo "on";}else{echo "off";}?>"=="on"){
												$('#hideTrack').bootstrapToggle('on')
											}else{
												$('#hideTrack').bootstrapToggle('off')
											}
										</script>
									</div>
									<div class="form-group">
										<label for="hideSelection">
											<input type="hidden" value="off" name="hideSelection">
											<input class="form-control" type="checkbox" checked data-toggle="toggle" data-on="Ja" data-off="nein" name="hideSelection" id="hideSelection" data-offstyle="warning">
											"Auswahl" - ausblenden
										</label>
										<script>
											if("<?php if(isset($FrageInfo->hideSelection) && $FrageInfo->hideSelection=="on"){echo "on";}else{echo "off";}?>"=="on"){
												$('#hideSelection').bootstrapToggle('on')
											}else{
												$('#hideSelection').bootstrapToggle('off')
											}
										</script>
									</div>
									<div class="form-group">
										<label for="FrageGroupsSel">Frage der/den Fragengruppen zuordnen</label>
										<select class="form-control" id="FrageGroupsSel" name="FrageGroupsSel[]" multiple>
											<?php
											foreach($fGroups as $fGroup){
												$FGroupInfo=json_decode($fGroup['parameter']);
												$selected="";
												if(isset($_SESSION['FrageID'])){
													$GroupArr=getFrageGroupsByFrageID(intval($_SESSION['FrageID']));
													if(in_array($fGroup['FGroupID'],$GroupArr)){$selected=" selected";}else{$selected="";}
												}
											?>
											<option value="<?php echo $fGroup['FGroupID']; ?>" <?php echo $selected; ?>><?php echo $FGroupInfo->GroupTitel; ?></option>

											<?php
											}
											?>
										</select>	
									</div>

									<input class='btn btn-primary' type=submit style="width:100%;" value="Frage eintragen">

								</form>
							</div>
							<div role="tabpanel" class="tab-pane" id="input">
								<form action='' method="POST" style='margin:0;'>
									<input type=hidden name="action" value="input">
									<input type=hidden name="SkalaTyp" value="3">
									<div class="form-group">
										<label for="titel">Titel</label>
										<input id='titel' type="text" class="form-control" name="titel" placeholder="Titel der Frage" required value='<?php if(isset($FrageInfo->titel)){echo $FrageInfo->titel;} ?>'>
									</div>

									<div class="form-group">
										<label for="FrageTXT">Fragentext</label>
										<input id='FrageTXT' type="text" class="form-control" name="FrageTXT" placeholder="Fragentext" required value='<?php if(isset($FrageInfo->FrageTXT)){echo $FrageInfo->FrageTXT;} ?>'>
									</div>

									<div class="form-group">
										<label for="FrageTipp">Hinweis / Erläuterung / Tipp</label>
										<input id='FrageTipp' type="text" class="form-control" name="FrageTipp" placeholder="Hinweis / Erläuterung"  value='<?php if(isset($FrageInfo->FrageTipp)){echo $FrageInfo->FrageTipp;} ?>'>
									</div>
									<div class="form-group">
										<label for="FrageGroupsSel">Frage der/den Fragengruppen zuordnen</label>
										<select class="form-control" id="FrageGroupsSel" name="FrageGroupsSel[]" multiple>
											<?php
											foreach($fGroups as $fGroup){
												$FGroupInfo=json_decode($fGroup['parameter']);
												$selected="";
												if(isset($_SESSION['FrageID'])){
													$GroupArr=getFrageGroupsByFrageID(intval($_SESSION['FrageID']));
													if(in_array($fGroup['FGroupID'],$GroupArr)){$selected=" selected";}else{$selected="";}
												}
											?>
											<option value="<?php echo $fGroup['FGroupID']; ?>" <?php echo $selected; ?>><?php echo $FGroupInfo->GroupTitel; ?></option>

											<?php
											}
											?>
										</select>	
									</div>
									<input class='btn btn-primary' type=submit style="width:100%;" value="Frage eintragen">


								</form>

							</div>
						</div>

					</div>

				</div>
				<!--				<div class="col-md-3">
<p class="lead">Fragen gruppieren</p>
</div>//-->
			</div>
		</div>

		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/bottom_main.php");?>
	</body>
</html>