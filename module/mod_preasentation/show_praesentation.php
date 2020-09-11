<?php

/* 
if(isset($_SERVER['HTTPS'])){
	header("LOCATION: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
	// 	echo "Hallo HTTPS";

}else{
	// 	echo "Hallo";
} */




session_start();
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/session_delay_token.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/kursInfos.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/Sessions.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/folie.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/videos.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/simulationen.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/abgabe.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/system.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/bausteine.php");
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");

if(check_if_zugriff_auf_Folie_erlaubt(intval($_GET['f']))){

	$_SESSION['fID']=intval($_GET['f']);


	/* $folieInfo=getFolieInfo(intval($_GET['f']));
$parameter=json_decode($folieInfo['parameter']);*/
	$token=$_SESSION['t'];
	$abgabeErforderlich=1; // Definition der Variable auf Standardwert 0 -> kein "Ich bin fertig" Button wird angezeigt, falls er nicht von der Folieneinstellung geforfert wird.
	// ========================
	// ====== SESSION VARIABLEN LEEREN
	// ========================
	unset($_SESSION['Baustein_top']);
	unset($_SESSION['Baustein_bottom']);
	unset($_SESSION['tem_vID_top']);
	unset($_SESSION['tem_vID_bottom']);
	unset($_SESSION['tem_simID_top']);
	unset($_SESSION['tem_simID_bottom']);
	if(isset($_SESSION['DesignTyp'])){
		for($iLauf=1;$iLauf<=$_SESSION['DesignTyp'];$iLauf++){
			unset($_SESSION['Baustein_'.$iLauf]);
		}
		for($iLauf=1;$iLauf<=$_SESSION['DesignTyp'];$iLauf++){
			unset($_SESSION['bID_'.$iLauf]);
		}
		for($iLauf=1;$iLauf<=$_SESSION['DesignTyp'];$iLauf++){
			unset($_SESSION['tem_vID_'.$iLauf]);
		}
		for($iLauf=1;$iLauf<=$_SESSION['DesignTyp'];$iLauf++){
			unset($_SESSION['tem_simID_'.$iLauf]);
		}
	}
	// ========================
	// ====== FOLIE LADEN
	// ========================
	if($_SESSION['fID']>0){
		$FolieArr=getFolieInfo(intval($_SESSION['fID']));
		$AufgabeInfo=json_decode($FolieArr['parameter'],true);
		$_SESSION['DesignTyp']=$AufgabeInfo['DesignTyp'];

		if(isset($AufgabeInfo["Baustein_top"])){
			$_SESSION['Baustein_top']=$AufgabeInfo["Baustein_top"];
		}
		if(isset($AufgabeInfo["Baustein_bottom"])){
			$_SESSION['Baustein_bottom']=$AufgabeInfo["Baustein_bottom"];
		}
		if(isset($AufgabeInfo["tem_vID_top"])){
			$_SESSION['tem_vID_top']=$AufgabeInfo["tem_vID_top"];
		}
		if(isset($AufgabeInfo["tem_vID_bottom"])){
			$_SESSION['tem_vID_bottom']=$AufgabeInfo["tem_vID_bottom"];
		}
		if(isset($AufgabeInfo["tem_simID_top"])){
			$_SESSION['tem_simID_top']=$AufgabeInfo["tem_simID_top"];
		}
		if(isset($AufgabeInfo["tem_simID_bottom"])){
			$_SESSION['tem_simID_bottom']=$AufgabeInfo["tem_simID_bottom"];
		}
		for($iLauf=1;$iLauf<=$_SESSION['DesignTyp'];$iLauf++){
			if(isset($AufgabeInfo['Baustein_'.$iLauf])){
				$_SESSION['Baustein_'.$iLauf]=$AufgabeInfo['Baustein_'.$iLauf];
			}
		}
		for($iLauf=1;$iLauf<=$_SESSION['DesignTyp'];$iLauf++){
			if(isset($AufgabeInfo['tem_vID_'.$iLauf])){
				$_SESSION['tem_vID_'.$iLauf]=$AufgabeInfo['tem_vID_'.$iLauf];
			}
		}
		for($iLauf=1;$iLauf<=$_SESSION['DesignTyp'];$iLauf++){
			if(isset($AufgabeInfo['tem_simID_'.$iLauf])){
				$_SESSION['tem_simID_'.$iLauf]=$AufgabeInfo['tem_simID_'.$iLauf];
			}
		}


		// ALT

		/* 	if(isset($AufgabeInfo["bID_top"])){
		$_SESSION['bID_top']=$AufgabeInfo["bID_top"];
	}
	if(isset($AufgabeInfo["bID_bottom"])){
		$_SESSION['bID_bottom']=$AufgabeInfo["bID_bottom"];
	}
	for($iLauf=1;$iLauf<=$_SESSION['DesignTyp'];$iLauf++){
		if(isset($AufgabeInfo['bID_'.$iLauf])){
			$_SESSION['bID_'.$iLauf]=$AufgabeInfo['bID_'.$iLauf];
		}
	} */


		// NEU
		$bsArr=get_bIDs_from_match($_SESSION['fID']);
		foreach($bsArr as $row){
			$_SESSION[$row['blockID']]=$row['bID'];
		}
	}



	// ========================
	// ====== ABGEBEN
	// ========================
	// 	 var_dump($_POST);
	if(isset($_POST['abgegeben'])){
		if($_POST['abgegeben']==1){$abgegeben=1;}else{$abgegeben=0;}
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
				if(strpos($Tempkey,"Cloud")!==false){
					if(isset($parameter_insert[$Tempkey])){$WC_ArrTemp=$parameter_insert[$Tempkey];}else{$WC_ArrTemp=array();}
					$Tempvalue=strip_tags($Tempvalue);
					$Tempvalue=removeWhiteSpacesVorKomma($Tempvalue);
					$WC_Arr=explode(",",$Tempvalue);
					foreach($WC_Arr as $item){
						array_push($WC_ArrTemp,$item);
					}
					$WC_Arr=array_unique ($WC_ArrTemp);
					$WC_Arr=array_filter($WC_Arr, function($value) { return $value !== ''; });
					$parameter_insert[$Tempkey]=$WC_Arr;
				}elseif(strpos($Tempkey,"KoFra")!==false || strpos($Tempkey,"abstOption")!==false){
					if(is_array($Tempvalue)){
						$tempOptions=array();
						foreach($Tempvalue as $option){
							array_push($tempOptions,$option);
						}
						$parameter_insert[$Tempkey]=$tempOptions;
					}else{
						$parameter_insert[$Tempkey]=$Tempvalue;
					}
				}elseif(strpos($Tempkey,"FrageID")!==false){
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
				}elseif(strpos($Tempkey,"StatementOrder")!==false){
					$parameter_insert[$Tempkey]=json_decode($_POST[$Tempkey]);
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
	// ====== ABGABE LADEN
	// ========================

	if($_SESSION['fID']>0){
		$AbgabeInfoRow=getAbgabeInfo($_SESSION['fID'],$token);
		$AbgabeInfo=json_decode($AbgabeInfoRow['parameter'],true);
		// 		var_dump($AbgabeInfoRow);
		if($AbgabeInfo['abgegeben']!=0){
			$abgegeben=$AbgabeInfo['abgegeben'];
		}else{
			$abgegeben=0;
		}
	}

}else{
?>
<html>
	<head>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/head_main.php");?>


	</head>
	<body>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/header_bar.php");?>
		<div class="container">
			<div class='alert alert-danger' style="text-align:center;"><h3>Sie haben KEINEN Zugriff auf diese Folie!</h3></div>
		</div>
	</body>
</html>

<?php
	  exit;
	 }

?>



<html>
	<head>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/head_main.php");?>

		<script src="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/plugins/tinymce/js/tinymce/tinymce.min.js"></script>
		<script type="text/x-mathjax-config">
  MathJax.Hub.Config({
    extensions: ["tex2jax.js"],
    jax: ["input/TeX", "output/HTML-CSS"],
    tex2jax: {
      inlineMath: [ ['$%','$%'], ["\\(","\\)"] ],
      displayMath: [ ['$$','$$'], ["\\[","\\]"] ],
      processEscapes: true
    },
    "HTML-CSS": { availableFonts: ["TeX"] }
  });
		</script>
		<?php /* ?>
		<script type="text/javascript"
				src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS_HTML">
		</script>
		<?php */ ?>
		<!--		<script type="text/javascript" src="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/plugins/mathjax/MathJax.js"></script>
//-->
	</head>
	<body>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/header_bar.php");?>
		<?php 


		// 		var_dump(FolienAnzeige_Menu($_SESSION['kursID'],$_SESSION['t']));
		?>
		<div class="container">
			<div class="row" style='margin:30 0;'>
				<div class="col-md-1"></div>
				<div class="col-md-10">

					<?php 
					// 					echo "===$abgegeben====$token====";
					if($abgegeben!=1){

					?>
					<form id='praesForm' action="" method="post">
						<?php 

						include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/module/mod_preasentation/praesentationseinstellungen.php");
						include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/module/mod_preasentation/show_praesentation_bloecke.php");
						$maxOrderID=getMaxOrderID($_SESSION['kursID'],1);
						$aktOrderID=getOrderID($_SESSION['fID'],$_SESSION['kursID']);
						if((($_SESSION['kTyp']==2 && $weiter_href!=="")||($_SESSION['kTyp']==2 && $maxOrderID==$aktOrderID)) && $abgabeErforderlich!=1){}else{
							/* 						?>
						<hr>
						<input type="hidden" id="abgegeben" name="abgegeben" value=1>
						<button style='margin-top: 50px;' type="submit" class="btn btn-primary btn-lg btn-block">Ich bin fertig!</button>
						<?php
 */						}
						?>
						<input type="hidden" id="abgegeben" name="abgegeben" value=1>
					</form>
					<?php 
					}else{
					?>
					<?php 
						include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/module/mod_preasentation/show_praesentation_bloecke.php");
						/* 					?>
					<span  style='margin-top: 50px;' class="btn btn-success btn-lg btn-block" >Bereits abgegeben</span>
					<?php 
 */					}
					?>


				</div>
				<div class="col-md-1"></div>
			</div>
		</div>


		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/bottom_main.php");?>
	</body>
	<script>
		$( document ).ready(function() {
			$(".ImgMarker").hover(function(){
				var thisObject=$(this).attr("id")
				console.log(thisObject);
				// 		$("#TT_"+thisObject).removeClass('hidden');
				$("#TT_"+thisObject).toggleClass('hidden');
			});
		});
	</script>

</html>