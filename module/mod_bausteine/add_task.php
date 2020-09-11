<?php
// ========================
// ========================
// ====== Kontrollfragen
// ========================
// ========================

// var_dump($_POST);

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/header_php.php");
$ausserhalbKurs=1;
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/session_delay.php");

// include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/kursInfos.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/Sessions.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/system.php");
// include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/folie.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/module.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/bausteine.php");
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");

$SessionInfos=Get_SessionInfos($_SESSION['s']);
$uID=$SessionInfos['uID'];
$_SESSION['uID']=$uID;


$modTitel="Bausteine";
$modID=getModIDFromTitel($modTitel);

// ========================
// ====== Baustein-Typ laden
// ========================
if(isset($_GET['bTypID'])){
	$bTypInfo=getBausteinTypInfo(intval($_GET['bTypID']));
}else{
	$bTypInfo=getBausteinTypInfo($_SESSION['edit_bTypID']);
}
// var_dump($bTypInfo);



// echo "==".$_SESSION['bTypID']."==";

// ========================
// ====== BAUSTEIN EINTRAGEN
// ========================
// var_dump($_POST);
if(isset($_POST['smBut']) or isset($_POST['smBut_stay'])){
	if(isset($_POST['smBut_stay'])){
		$stayOnSite=1;
	}else{$stayOnSite=0;}

	$insertArr=array();


	foreach($_POST as $key => $value){
		$Tempkey=mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($key), ENT_QUOTES , "UTF-8"));
		if(!is_array($value)){
			$Tempvalue=mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($value), ENT_QUOTES , "UTF-8"));
			$insertArr[$Tempkey]=$Tempvalue;
		}else{
			$tempArr=array();
			foreach($value as $option){
				array_push($tempArr,mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($option), ENT_QUOTES , "UTF-8")));
			}
			$insertArr[$Tempkey]=$tempArr;
		}
	}

	// Aussagen ordnen
	if(isset($_POST['BS_Typ'])&& $_POST['BS_Typ']=="StatementOrder"){
// 		echo "<hr>";
// 		var_dump($_POST['antwortOption']);
		$insertArr['order']=array();
		if(isset($_POST['StatementOrder']) && !$_POST['StatementOrder']==0){
			$antwortOptionIDs=json_decode($_POST['StatementOrder'],true);
			foreach($antwortOptionIDs as $optionID){
				array_push($insertArr['order'],$optionID);
			}
		}else{
			$antwortOptionen=$_POST['antwortOption'];
			foreach($antwortOptionen as $optionID=>$optionTXT){
				array_push($insertArr['order'],$optionID);
			}
			// 			$insertArr['order']=$orderTEMP;
		}

		$insertArr['CombinedOptions']=array_combine ( $insertArr['order'] , $insertArr['antwortOption'] );
// var_dump($insertArr['CombinedOptions']);

		unset($insertArr['StatementOrder']);
		unset($insertArr['BS_Typ']);
	}

	// YouTube Video-ID ermitteln
	if(isset($_POST['ytlink'])){
		$YouTube=array();
		$ytLink=mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($_POST['ytlink']), ENT_QUOTES , "UTF-8"));
		preg_match('/[\\?\\&]v=([^\\?\\&]+)/',$ytLink, $matches);
		$ytID = mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($matches[1]), ENT_QUOTES , "UTF-8"));
		$insertArr['ytID']=$ytID;
		// 		$insertArr['ytlink']=$ytLink;
	}

	$parameter=json_encode($insertArr);
	// echo $parameter;
	if(!isset($_SESSION['edit_bID'])){
		if(isset($_GET['bTypID'])){
			$_SESSION['edit_bID']=insertBaustein($uID,intval($_GET['bTypID']),$parameter);
		}else{
			$_SESSION['edit_bID']=insertBaustein($uID,$_SESSION['edit_bTypID'],$parameter);
		}
	}elseif(intval($_SESSION['edit_bID'])>0){
		updateBaustein($_SESSION['edit_bID'],$parameter);
	}

	unset($_POST);

	switch($stayOnSite){
		default:
			unset($_SESSION['edit_bTypID']);
			unset($_SESSION['edit_bID']);
			echo "<script>window.location = '" . $_SESSION['DOCUMENT_ROOT_DIR']."/module/admin/baustein_erstellen.php';</script>";
			break;

		case 1:
			break;

	}
}

// ========================
// ====== BAUSTEIN ZUR BEARBEITUNG LADEN
// ========================

if(isset($_SESSION['edit_bID'])){
	$bsInfoRow=getBausteinInfo($_SESSION['edit_bID']);
// 	 	var_dump($bsInfoRow);
	$bsInfo=json_decode($bsInfoRow['parameter'],true);
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
		<script src="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/plugins/tinymce/js/tinymce/tinymce.min.js"></script>
		<script>
			tinymce.init({
				selector: 'textarea',
				<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/plugins/tinymce/include/init_pfreferences_lehrer.php"); ?>
			});
		</script>

	</head>
	<body>

		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/header_bar.php");?>

		<div class="container" style="<?php if(isset($_GET['bTypID'])){ ?>padding:0; <?php } ?>">
			<?php
			if(!isset($_GET['bTypID'])){ // Damit wird für das Baustein Panel die obere Leiste ausgeblendet

			?>
			<div class="row">
				<div class="col-md-1"></div>
				<div class="col-md-10">
					<div class="row" style='margin-top:10px; text-align:center; background-color:lightgray; padding:10px; border-radius: 10px;'>

						<div class="col-md-1"><a href='<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/module/admin/baustein_erstellen.php' class='btn btn-success'>zurück</a></div>
						<div class="col-md-10"><p class="lead" style='margin:0'>Baustein hinzufügen - <?php echo $bTypInfo['titel']; ?></p></div>
						<div class="col-md-1"></div>

					</div>
				</div>
				<div class="col-md-1"></div>
			</div>
			<?php
			}

			?>
			<div class="row" style=''>
				<div class="col-md-2"></div>
				<div class="col-md-8">
					<?php

					include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR'].$bTypInfo['bs_dir']."/".$bTypInfo['bs_add']);
					?>
				</div>
				<div class="col-md-2"></div>
			</div>
		</div>

		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/bottom_main.php");?>
	</body>
</html>