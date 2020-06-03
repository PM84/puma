<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT']."/includes/session_delay_token.php");
include($_SERVER['DOCUMENT_ROOT']."/config.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/kursInfos.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/Sessions.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/videos.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/folie.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/abgabe.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/media.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/frage.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/system.php");

$fID=intval($_GET['f']);
$_SESSION['fID']=$fID;
$token=$_SESSION['t'];


// ========================
// ====== Bewertung speichern 
// ========================
if(isset($_POST['action']) && $_POST['action']=="save" ){
	$abgegeben=1;
	$fID=$_SESSION['fID'];
	$query="SELECT * FROM abgabe WHERE fID='$fID' AND token='$token' AND abTyp=3";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	if(mysqli_num_rows($ergebnis)==1){
		$row=mysqli_fetch_assoc($ergebnis);
		$parameter_insert=json_decode($row['parameter'],true);
		if($parameter_insert===NULL){
			$parameter_insert=array("abgegeben"=>$abgegeben);
		}else{
			$parameter_insert["abgegeben"]=$abgegeben;
		}


	}else{
		$parameter_insert=array("abgegeben"=>$abgegeben);
	}
	// 	$parameter_insert['abgegeben']=1;
	// var_dump($_POST);
	$FragenWerte=array();
	foreach($_POST as $key => $value){
		if($key!="submit"){
			$Tempkey=mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($key), ENT_QUOTES , "UTF-8"));
			// 			$Tempvalue=mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($value), ENT_QUOTES , "UTF-8"));
			if(!is_array($value)){
				$Tempvalue=mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($value), ENT_QUOTES , "UTF-8"));
			}else{
				$tempArr=array();
				foreach($value as $option){
					array_push($tempArr,mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($option), ENT_QUOTES , "UTF-8")));
				}
				$Tempvalue=$tempArr;
			}
			if(strpos($Tempkey,"FrageID")!==false){
				// ====== Fragen-Werte
				$BlockArr=explode("_",$Tempkey);
				$Block=$BlockArr[1];
				$FragenIDs=$_POST[$Tempkey];
				$FragenArr=$_POST["FrageVal_$Block"];
				foreach ($FragenArr as $key => $input_arr) {
					$FragenArr[$key] = mysqli_real_escape_string ($verbindung,  htmlentities (mynl2br($input_arr), ENT_QUOTES , "UTF-8"));
				} 
				foreach ($FragenIDs as $key => $input_arr) {
					$FragenIDs[$key] =mysqli_real_escape_string ($verbindung,  htmlentities (mynl2br($input_arr), ENT_QUOTES , "UTF-8"));
				}
				$FrageArr2=array();
				$jfLauf=0;
				foreach($FragenIDs as $FrageID){
					$FrageArr2[$FrageID]=$FragenArr[$jfLauf];
					$jfLauf++;
				}
				$parameter_insert["FragenWerte_$Block"]=$FrageArr2;
			}elseif(strpos($Tempkey,"FrageVal")!==false){
				//nichts tun, da diese Werte bereits im vorherigen Fall abgedeckt und gespeichert wurden.
			}else{
				$parameter_insert[$Tempkey]=$Tempvalue;
			}

		}
	}
	$parameter_insert=json_encode($parameter_insert);
	$abTyp=3;
	$abID="";
	$datum=date("Y-m-d H:i:s");
	$query="INSERT INTO abgabe (fID,abTyp,token,zu_abID,parameter,datum) VALUES ('$fID','$abTyp','$token','$abID','$parameter_insert','$datum') ON DUPLICATE KEY UPDATE parameter='$parameter_insert', datum='$datum'";
	// 	$query="INSERT INTO abgabe SET parameter='$parameter' WHERE fID='$fID' AND token='$token'";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));

	if(isset($_POST['SaveAndNext']) && $_POST['SaveAndNext']=="goToNext_fID" ){
		unset($_POST);
		$redirect_next_folie=1;

	}else{
		$redirect_next_folie=0;
	}
	unset($_POST);
}
// ========================
// ====== Zugriffskontrolle 
// ========================

if(!check_if_zugriff_auf_Folie_erlaubt(intval($_GET['f']))){
?>
<html>
	<head>
		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/head_main.php");?>
	</head>
	<body>
		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/header_bar.php");?>
		<div class="container">
			<div class="row" style='margin-top:0px;'>
				<!--<div class="col-md-1"></div>//-->
				<div class="col-md-3"></div>
				<div class="col-md-6 alert alert-danger">Zugriff auf diese Folie ist nicht erlaubt!</div>
				<div class="col-md-3"></div>
			</div>
		</div>
	</body>
</html>


<?php
															exit;
														   }


$FolieInfo=getFolieInfo($fID);
$FolieParam=json_decode($FolieInfo['parameter'],true);
$AbgabeRow=getAbgabeInfoByAbID($FolieParam['zu_abID']);
// 	$AbgabeRow=getAbgabeBy_fID_token_aTyp($token,$abTyp,$fID); //getAbgabeBy_abID_token_aTyp($token,$abTyp,$abID);

if($AbgabeRow!==NULL && isset($AbgabeRow)){
	$AbgabeParameter=json_decode($AbgabeRow['parameter'],true);
}else{
	$AbgabeParameter=array();
}
// var_dump($AbgabeParameter);

// ========================
// ====== Korrektur 
// ========================
$abTyp=3;
$korrRow=getAbgabeBy_fID_token_aTyp($token,$abTyp,$fID); //getAbgabeBy_abID_token_aTyp($token,$abTyp,$abID);
// var_dump($AbgabeRow);
if($korrRow!==NULL && isset($korrRow[0])){
	$KorrParameter=json_decode($korrRow[0]['parameter'],true);
}else{
	$KorrParameter=array();
}


?>


<html>
	<head>
		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/head_main.php");?>
		<?php include($_SERVER['DOCUMENT_ROOT']."/plugins/tinymce/include/init_preferences_mail.php");?>


	</head>
	<body>
		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/header_bar.php");?>

		<div class="container">
			<div class="row" style='margin-top:0px;'>
				<!--<div class="col-md-1"></div>//-->
				<div class="col-md-6">
					<div class="container">

						<?php if(isset($AbgabeParameter['bild']) && strlen($AbgabeParameter['bild'])>0){
						?>
						<div><img src='/media/uploads/fotowettbewerb/<?php echo $AbgabeParameter['bild'];?>' style="margin:10px 0; width:100%;"></div>
						<?php
} elseif(isset($AbgabeParameter['bild'])){
						?>
						<div class="alert alert-warning" style="margin-top:20px;">Es wurde kein Bild gefunden!</div>
						<?php
}
						?>
					</div> <!-- /container -->

				</div>
				<div class="col-md-6">
					<?php if(count($KorrParameter)>0){?>
					<div class="alert alert-success">
						<strong>Bereits gespeichert!</strong><br>Die Bewertung für dieses Bild wurde erfolgreich abgegeben!
					</div>
					<?php }else{
					?>
						<div style="margin:30px 0;">
							<label for="kommentar">Erläuterung des Schülers:</label>
							<div class="textarea_div_abgegeben">
								<h2>JgSt: <?php echo $AbgabeParameter['jgst']; ?></h2>

								<?php if(isset($AbgabeParameter['kommentar'])){echo html_entity_decode ($AbgabeParameter['kommentar'], ENT_QUOTES , "UTF-8");} ?>
							</div>
						</div>
					<form action="" method="post" enctype="multipart/form-data" id="praesForm">
						<input name='action' type="hidden" value="save">

						<?php
	include_once($_SERVER['DOCUMENT_ROOT']."/php/bausteine.php");
	$bID=$FolieParam['bID'];
	$bInfoRow=getBausteinInfo($bID);
	$bInfo=json_decode($bInfoRow['parameter'],true);
	$bsTypInfo=getBausteinTypInfo($bInfoRow['bTypID']);
	$Block=1;

	include($_SERVER['DOCUMENT_ROOT']."/module/mod_bausteine/".$bsTypInfo['bs_show']);
						?>




						<input class="btn btn-primary" type="submit" value='Bewertung abgeben'>
					</form>
					<?php } ?>
						</div>
				</div>
		</div>


		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/bottom_main.php");?>
	</body>
</html>