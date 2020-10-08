<?php


// error_reporting(E_ALL);
// ini_set('display_errors', 1);


// ========================
// ========================
// ====== PRÄSENTATION
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
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/videos.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/simulationen.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/folie.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/teilnehmer.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/module.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/media.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/bausteine.php");
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");



// ========================
// ====== FOLIE TOKEN SETZEN FALLS FOLIE BEREITS GEPOSTET
// ========================

if(isset($_GET['f'])){

	$folInfo=getFolieInfo(intval($_GET['f']));
	$ftoken=$folInfo['ftoken'];
}else{
	$ftoken=mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($_GET['ft']), ENT_QUOTES , "UTF-8"));
	if(strlen($_GET['ft'])==0){
		$ftoken=uniqid();
		echo "<script>window.location = '?ft=$ftoken';</script>";

	}
}



$confirmMessage="Möchten Sie die Einstellung wirklich ändern? Alle NICHT gespeicherten Inhalte gehen dadurch verloren!";

$modTitel="Präsentationsfolien";
$modID=getModIDFromTitel($modTitel);
$CopyToKursAllow=1;

$kursID=$_SESSION['k'];
$aTyp=1; // Aufgabe
$zu_fID=0;

if(!isset($_SESSION[$ftoken]['edit_fID'])){
	$_SESSION[$ftoken]['edit_fID']=0;
}

// ========================
// ====== SESSION VARIABLEN LEEREN
// ========================
if(isset($_POST['btn_back']) && intval($_POST['btn_back'])==1){
	unset($_SESSION[$ftoken]);
	echo "<script>window.location = '" . $_SESSION['DOCUMENT_ROOT_DIR']."/module/admin/folie_erstellen.php';</script>";
	exit;
}
// ========================
// ====== Weiterleiten zur Feedbackfolien
// ========================


// ========================
// ====== AUFGABE EINTRAGEN
// ========================
if(isset($_POST['titel']) && strlen($_POST['titel'])>0){


	$insertArr=[];
	$bsArr=[];
	$insertArr['DesignTyp']=$_SESSION[$ftoken]['edit_DesignTyp'];
	foreach($_POST as $key => $value){
		if(is_array($value)){
			mysqli_real_escape_string ($verbindung, htmlentities (mynl2br(preg_match ( "/[^_]+$/" , $key ,$Blocks)), ENT_QUOTES , "UTF-8"));
			$Block=$Blocks[0];
			$ignoreKeyPartArr=array("img_hov_x_$Block","img_hov_y_$Block","img_hov_txt_$Block","img_hov_filename_$Block");
			if(is_int(strpos($key,"hov_MarkID_$Block"))){
				$valArr=[];
				foreach($value as $markKey => $MarkID){
					$valArr[$MarkID]["x"]=$_POST["img_hov_x_$Block"][$markKey];
					$valArr[$MarkID]["y"]=$_POST["img_hov_y_$Block"][$markKey];
					$valArr[$MarkID]["txt"]=mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($_POST["img_hov_txt_$Block"][$markKey]), ENT_QUOTES , "UTF-8"));
					$valArr[$MarkID]["fn"]=mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($_POST["img_hov_filename_$Block"][$markKey]), ENT_QUOTES , "UTF-8"));
				}
				$Tempkey="ImgMark_".$Block;
// 			 			echo "$Tempkey<br>";
				$insertArr[$Tempkey]=$valArr;
			}elseif(!in_array($key,$ignoreKeyPartArr)){
				$Tempkey=mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($key), ENT_QUOTES , "UTF-8"));
				$insertArr[$Tempkey]=$value;
			}
			// 			echo "$key gefunden!!!!".$insertArr[$Tempkey];
		}else{
			$Tempkey=mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($key), ENT_QUOTES , "UTF-8"));
			$Tempvalue=mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($value), ENT_QUOTES , "UTF-8"));
			// 		if(strpos($Tempkey,"Baustein_")>=0 || strpos($Tempkey,"bID_")>=0){
			if(!is_bool(strpos($Tempkey,"bID_"))){
				$bsArr[$Tempkey]=$Tempvalue;
			}
			$insertArr[$Tempkey]=$Tempvalue;
		}
	}
	$viewTyp=intval($_POST['viewTyp']);
	switch($viewTyp){
		default:
			if(isset($_POST['tnarr'])){
				$tnArrTmp=$_POST['tnarr'];
				$tnArr=[];
				foreach($tnArrTmp as $TN){
					array_push($tnArr,intval($TN));
				}
			}else{
				$tnArr=[];
			}
			$insertArr['tnarr']=$tnArr;
			break;
		case 1:
			break;
	}
	$parameter=json_encode($insertArr);

	// 	$redirect=0; // KEIN BESONDERER REDIRECT NÖTIG!
	$redirect=intval($_POST['savePraes']);
	if(isset($insertArr['CopyToKursID']) && intval($insertArr['CopyToKursID'])>0){$CopyToKursID=$insertArr['CopyToKursID'];}else{$CopyToKursID=0;}

	loop_match_table($parameter);

	$redirectStatus=add_folie($parameter,$modID,$viewTyp,$_SESSION[$ftoken]['edit_fID'],$redirect,1,0,$CopyToKursID,$bsArr);
	// echo $redirectStatus;
	if($redirectStatus==2){
		unset($_SESSION[$ftoken]);
		echo "<script>window.location = '" . $_SESSION['DOCUMENT_ROOT_DIR']."/module/admin/folie_erstellen.php';</script>";
	}elseif($redirectStatus==3){
		$preview_tnInfo=get_preview_teilnehmer($_SESSION['uID']);
		$_SESSION['t']=$preview_tnInfo['token'];
		$KursInfos=GetKursInfos(intval($_SESSION['k']));
		$_SESSION['kTyp']=$KursInfos['kTyp'];
		$FolieInfo=getFolieInfo($_SESSION[$ftoken]['edit_fID']);
		$parameterFolie=json_decode($FolieInfo['parameter']);
		$modID=$FolieInfo['modID'];
		$modInfo=getModulInfos($modID);
		$_SESSION['kursID']=$_SESSION['k'];
		$FoliePath=$_SESSION['DOCUMENT_ROOT_DIR']."/".$modInfo['mod_dir']."/".$modInfo['mod_show']."?f=".$_SESSION[$ftoken]['edit_fID'];

?>
<?php
	}
}

// ========================
// ====== FOLIE ZUM BEARBEITEN LADEN
// ========================
$FolieArr=getFolieInfo_bytoken($ftoken);
$_SESSION[$ftoken]['edit_fID']=$FolieArr['fID'];


if($_SESSION[$ftoken]['edit_fID']>0){
	// if(strlen($ftoken)>0){
	// 	echo "Folie wird geladen";

	// 	$FolieArr=getFolieInfo(intval($_SESSION['edit_fID']));
	$FolieArr=getFolieInfo_bytoken($ftoken);
	$_SESSION[$ftoken]['edit_fID']=$FolieArr['fID'];
	$AufgabeInfo=json_decode($FolieArr['parameter'],true);
	
	// 	echo "==".$_SESSION['bereitsgeladen']."==";
	if(!isset($_SESSION[$ftoken]['bereitsgeladen'])){
		// echo "Folie wird geladen";
		$_SESSION[$ftoken]['edit_DesignTyp']=$AufgabeInfo['DesignTyp'];

		// Einstellungen Allgemein laden
		if(isset($AufgabeInfo["Baustein_top"])){
			$_SESSION[$ftoken]['edit_Baustein_top']=$AufgabeInfo["Baustein_top"];
		}
		if(isset($AufgabeInfo["Baustein_bottom"])){
			$_SESSION[$ftoken]['edit_Baustein_bottom']=$AufgabeInfo["Baustein_bottom"];
		}
		for($iLauf=1;$iLauf<=$_SESSION[$ftoken]['edit_DesignTyp'];$iLauf++){
			if(isset($AufgabeInfo['Baustein_'.$iLauf])){
				$_SESSION[$ftoken]['edit_Baustein_'.$iLauf]=$AufgabeInfo['Baustein_'.$iLauf];
			}else{$_SESSION[$ftoken]['edit_Baustein_'.$iLauf]="";}
		}

		// Einstellungen Video laden
		if(isset($AufgabeInfo["tem_vID_top"])){
			$_SESSION[$ftoken]['edit_tem_vID_top']=$AufgabeInfo["tem_vID_top"];
		}else{$_SESSION[$ftoken]['edit_tem_vID_top']="";}

		for($iLauf=1;$iLauf<=$_SESSION[$ftoken]['edit_DesignTyp'];$iLauf++){
			if(isset($AufgabeInfo['tem_vID_'.$iLauf])){
				$_SESSION[$ftoken]['edit_tem_vID_'.$iLauf]=$AufgabeInfo['tem_vID_'.$iLauf];
			}else{$_SESSION[$ftoken]['edit_tem_vID_'.$iLauf]="";}
		}

		if(isset($AufgabeInfo["tem_vID_bottom"])){
			$_SESSION[$ftoken]['edit_tem_vID_bottom']=$AufgabeInfo["tem_vID_bottom"];
		}else{$_SESSION[$ftoken]['edit_tem_vID_bottom']="";}


		// Einstellungen Simulation laden
		if(isset($AufgabeInfo["tem_simID_top"])){
			$_SESSION[$ftoken]['edit_tem_simID_top']=$AufgabeInfo["tem_simID_top"];
		}else{$_SESSION[$ftoken]['edit_tem_simID_top']="";}

		for($iLauf=1;$iLauf<=$_SESSION[$ftoken]['edit_DesignTyp'];$iLauf++){
			if(isset($AufgabeInfo['tem_simID_'.$iLauf])){
				$_SESSION[$ftoken]['edit_tem_simID_'.$iLauf]=$AufgabeInfo['tem_simID_'.$iLauf];
			}else{$_SESSION[$ftoken]['edit_tem_simID_'.$iLauf]="";}
		}

		if(isset($AufgabeInfo["tem_simID_bottom"])){
			$_SESSION[$ftoken]['edit_tem_simID_bottom']=$AufgabeInfo["tem_simID_bottom"];
		}else{$_SESSION[$ftoken]['edit_tem_simID_bottom']="";}

		// Einstellungen Bausteine laden (Wordcloud Kontrollfragen Umfragen etc.)
		for($iLauf=1;$iLauf<=$_SESSION[$ftoken]['edit_DesignTyp'];$iLauf++){
			if(isset($AufgabeInfo['bID_'.$iLauf])){
				$_SESSION[$ftoken]['edit_bID_'.$iLauf]=$AufgabeInfo['bID_'.$iLauf];
			}else{$_SESSION[$ftoken]['edit_bID_'.$iLauf]="";}
		}

		$_SESSION[$ftoken]['bereitsgeladen']=1;
	}
}/* else{
	echo "nix zum laden";
} */

if(isset($_POST['DesignTyp'])){$_SESSION[$ftoken]['edit_DesignTyp']=intval($_POST['DesignTyp']);}





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
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/header_bar.php");?>

		<div class="container" style="">

			<div class="row">
				<div class="col-md-1"></div>
				<div class="col-md-10">
					<div class="row" style=' text-align:center; background-color:lightgray; padding:10px; border-radius: 10px;'>
						<div class="col-md-1">
							<form id="backForm" action="" method="POST" style="margin:0;">
								<button type=submit  class='btn btn-success hidden-xs hidden-sm' name="btn_back" value=1>zurück</button>
							</form>
						</div>
						<div class="col-md-10"><p class="lead" style='margin:0'>Präsentationsfolie hinzufügen</p></div>
						<div class="col-md-1"></div>
					</div>
				</div>
				<div class="col-md-1"></div>
			</div>
			<div class="row">
				<div class="col-md-1"></div>
				<div class="col-md-10">
					<p class="lead" style='margin:0'>Grunddesign auswählen:</p>

					<div class="row">
						<div class="col-md-12" style='text-align:center;'>
							<form id='Form_DesignTyp' action="" method="post">
								<div class="btn-group" data-toggle="buttons">
									<?php //SMALL ?>
									<label class="btn-sq btn-sq-sm btn-sq-margin hidden-md hidden-lg btnColSel btn <?php if($_SESSION[$ftoken]['edit_DesignTyp']==1){echo "btn-success";}else{echo "btn-default";} ?> " style="">
										<input type="radio" name="DesignTyp" value=1 autocomplete="off"> einspaltig
									</label>
									<label class="btn-sq btn-sq-sm btn-sq-margin hidden-md hidden-lg  btnColSel btn <?php if($_SESSION[$ftoken]['edit_DesignTyp']==2){echo "btn-success";}else{echo "btn-default";} ?>" style="">
										<input type="radio" name="DesignTyp" value=2 autocomplete="off"> zweispaltig
									</label>
									<label class="btn-sq btn-sq-sm btn-sq-margin hidden-md hidden-lg  btnColSel btn <?php if($_SESSION[$ftoken]['edit_DesignTyp']==3){echo "btn-success";}else{echo "btn-default";} ?>" style=''>
										<input type="radio" name="DesignTyp" value=3 autocomplete="off"> dreispaltig
									</label>
									<label class="btn-sq btn-sq-sm btn-sq-margin hidden-md hidden-lg btnColSel btn <?php if($_SESSION[$ftoken]['edit_DesignTyp']==4){echo "btn-success";}else{echo "btn-default";} ?>" style=''>
										<input type="radio" name="DesignTyp" value=4 autocomplete="off"> vierspaltig
									</label>

									<?php //LARGE ?>

									<label class="btn-sq btn-sq-lg btn-sq-margin hidden-xs hidden-sm btnColSel btn <?php if($_SESSION[$ftoken]['edit_DesignTyp']==1){echo "btn-success";}else{echo "btn-default";} ?> " style="">
										<input type="radio" name="DesignTyp" value=1 autocomplete="off"> einspaltig
									</label>
									<label class="btn-sq btn-sq-lg btn-sq-margin hidden-xs hidden-sm btnColSel btn <?php if($_SESSION[$ftoken]['edit_DesignTyp']==2){echo "btn-success";}else{echo "btn-default";} ?>" style="">
										<input type="radio" name="DesignTyp" value=2 autocomplete="off"> zweispaltig
									</label>
									<label class="btn-sq btn-sq-lg btn-sq-margin hidden-xs hidden-sm btnColSel btn <?php if($_SESSION[$ftoken]['edit_DesignTyp']==3){echo "btn-success";}else{echo "btn-default";} ?>" style=''>
										<input type="radio" name="DesignTyp" value=3 autocomplete="off"> dreispaltig
									</label>
									<label class="btn-sq btn-sq-lg btn-sq-margin hidden-xs hidden-sm btnColSel btn <?php if($_SESSION[$ftoken]['edit_DesignTyp']==4){echo "btn-success";}else{echo "btn-default";} ?>" style=''>
										<input type="radio" name="DesignTyp" value=4 autocomplete="off"> vierspaltig
									</label>
								</div>
								<script>
									$(function() {
										$("input[name=DesignTyp]").change(function() {
											$("#Form_DesignTyp").submit();
										});
									});
								</script>

							</form>
						</div>
					</div>
				</div>
				<div class="col-md-1"></div>
			</div>
			<?php
			// ab hier Rohdesign anzeige:
			if(isset($_SESSION[$ftoken]['edit_DesignTyp'])){
				$AnzCol=$_SESSION[$ftoken]['edit_DesignTyp'];
				include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/module/mod_preasentation/add_task_multi_col.php");
			}
			?>
		</div>

		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/bottom_main.php");?>
	</body>
</html>