<?php
if(!is_file ("config.php")){
	header("LOCATION: install/index.php");
}
session_start();
include("config.php");
echo $_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR'];
echo "<br>" . $_SERVER['DOCUMENT_ROOT'];
echo "<br>" . $_SESSION['DOCUMENT_ROOT_DIR'];

include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/teilnehmer.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/kursInfos.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/module.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/folie.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/system.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/module/user/checkToken.php");
// unset($_SESSION['t']);
$ausserhalbKurs=1;
$error=0;
// ========================
// ====== TOKEN VERIFIZIEREN
// ========================

if(isset($_POST['token'])){
	if(CheckToken($_POST['token'])){
		$_SESSION['t']=mysqli_real_escape_string ($verbindung,  htmlentities (mynl2br($_POST['token']), ENT_QUOTES , "UTF-8"));
		unset($_POST['token']);
		$Hinweis="";
	}else{
		$Hinweis="<div class='alert alert-danger'><strong>ACHTUNG!</strong> Der Zugriffstoken ist unbekannt.</div>";
	}
}else{
	$Hinweis="";
}

// ========================
// ====== TOKEN in SESSION schreiben
// ========================

// ========================
// ====== TOKEN AUS URL LESEN UND IN SESSION SCHREIBEN
// ========================

if(isset($_GET['t'])){
	$_SESSION['t']=htmlspecialchars($_GET['t'], ENT_QUOTES);
}


// ========================
// ====== KURS AUSWAHL
// ========================

// var_dump($_POST);
if(isset($_POST['kursID']) || isset($_GET['kt'])){

	if(isset($_GET['kt'])){
		$kt=mysqli_real_escape_string ($verbindung,  htmlentities (mynl2br($_GET['kt']), ENT_QUOTES , "UTF-8"));
		$KursInfo=getKursInfos_by_kursToken($kt);
// 		var_dump($KursInfo);
		$_SESSION['kursID']=$KursInfo['kursID'];
	}else{
		$_SESSION['kursID']=intval($_POST['kursID']);
	}

	$KursInfos=GetKursInfos(intval($_SESSION['kursID']));
	$_SESSION['kTyp']=$KursInfos['kTyp'];

	switch($_SESSION['kTyp']){
		case 2:
			$ersteFolie=get_erste_Folie($_SESSION['kursID']);
			// 			var_dump($ersteFolie);
			if(intval($ersteFolie['fID'])>0){
				$FolieInfo=getFolieInfo($ersteFolie['fID']);
				$parameterFolie=json_decode($FolieInfo['parameter']);
				$modID=$FolieInfo['modID'];
				$modInfo=getModulInfos($modID);
			}else{
				$error=404;
			}
			break;

		case 1:
			$ersteFolie['fID']=get_erste_Folie_2($_SESSION['kursID'],$_SESSION['t']);
			if(intval($ersteFolie['fID'])>0){
				$FolieInfo=getFolieInfo($ersteFolie['fID']);
				$parameterFolie=json_decode($FolieInfo['parameter']);
				$modID=$FolieInfo['modID'];
				$modInfo=getModulInfos($modID);
			}else{
				$error=404;
			}
			break;
	}

	if(isset($ersteFolie['fID']) && $ersteFolie['fID']>0 && $error==0){
		$firstFolie=$_SESSION['DOCUMENT_ROOT_DIR'] . "/".$modInfo['mod_dir']."/".$modInfo['mod_show']."?f=".$ersteFolie['fID'];
		// 		echo $firstFolie;
		echo "<script>window.location = '" . $_SESSION['DOCUMENT_ROOT_DIR']."$firstFolie';</script>";  //Fehler bei der Abfrage aufgetreten
	}else{
		$error=404;
	}
	unset($_POST['kursID']);
}

// ========================
// ====== TOKEN AUS URL LESEN UND IN SESSION SCHREIBEN
// ========================

// if(isset($_GET['t'])){
// 	$_SESSION['t']=htmlspecialchars($_GET['t'], ENT_QUOTES);
// }

?>
<html>
	<head>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/head_main.php");?>
	</head>
	<body>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/header_bar.php");?>

		<div class="container">

			<div class="row" style='margin-top:50px;'>
				<div class="col-md-4"></div>
				<div class="col-md-4">
					<?php 
					if(!isset($_SESSION['t'])){
						if(isset($_GET['e'])){
							switch($_GET['e']){
								case 1:
					?>
					<div class='alert alert-danger' style='text-align:center;'><p class="lead "><b>Die Sitzung ist abgelaufen.</b><br>Bitte melden Sie sich erneut an.</p></div>
					<?php
									break;
								case 2:
					?>
					<div class='alert alert-danger' style='text-align:center;'><p class="lead "><b>Die Sitzung ist abgelaufen.</b><br>Bitte geben Sie den Zugiffstoken erneut ein.</p></div>
					<?php
									break;
							}
						}
						echo $Hinweis;
						include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/module/user/TokenForm.php");
					}else{
					?>
					<p class="lead">Ihr Zugriffstoken ist:</p>
					<div class='alert alert-success' style='text-align:center;'><p class="lead "><?php echo $_SESSION['t']; ?></p></div>
					<a class='btn btn-danger' style="width:100%;" href='<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/module/user/CancelToken.php'>Abmelden</a>
					<hr>

					<p class="lead">Meine Aufgaben:</p>
					<?php
						if($error==404){
					?>
					<div class='alert alert-danger' style='text-align:center;'><p class="lead "><b>Keine Aufgaben gefunden!</b><br>Für Sie stehen aktuell keine Aufgben bereit!</p></div>
					<?php
						}

						if(!isset($_SESSION['kursID']) || !isset($_SESSION['kTyp'])){
					?>
					<div class='alert alert-danger arrow-down' style='text-align:center;'><p class="lead "><b>Keine Aufgabe ausgewählt</b><br>Bitte wählen Sie eine Aufgabe aus!</p></div>
					<?php
						}elseif($error!=404){
					?>
					<div class='alert alert-success' style='text-align:center;'><p class="lead ">Die Folien und Aufgaben finden Sie im Menü</p></div>

					<?php
						}
						$tnInfo=getTeilnehmerInfosByToken($_SESSION['t']);
						$KursArr=getKurseByTnID($tnInfo['tnID']);
						foreach($KursArr as $Kurs){
							$KursInfo=GetKursInfos($Kurs['kursID']);
					?>
					<form acition="" method="POST">
						<input type='hidden' value='<?php echo $KursInfo['kursID']; ?>' name='kursID'>
						<button type="submit" class="btn <?php if($KursInfo['kursID'] != $_SESSION['kursID']){echo "btn-default";}else{ echo "btn-primary";} ?> btn-block" ><?php echo $KursInfo['titel'] ?></button>
					</form>
					<?php
						}
					?>
					<?php
					}
					?>
				</div>
				<div class="col-md-4"></div>
			</div>
		</div>
		<div style="position:absolute; bottom:0; border-width: 1px 0 0; margin-bottom:0; width:100%; text-align:center;padding-top:15px;" class="navbar navbar-default" >
			<a style="" href="impressum.php">Impressum</a>
		</div>

		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/bottom_main.php");?>
	</body>
</html>
