<?php

session_start();
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/session_delay_token.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/kursInfos.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/Sessions.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/folie.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/videos.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/simulationen.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/abgabe.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/system.php");
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
// $_SESSION['fID']=intval($_GET['f']);
$token=$_SESSION['t'];
$abgabeErforderlich=0; // Definition der Variable auf Standardwert 0 -> kein "Ich bin fertig" Button wird angezeigt, falls er nicht von der Folieneinstellung geforfert wird.

$abgegeben=2;  // NUR für Auswertungsseite

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
// 			echo "Test";
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


	if(isset($AufgabeInfo["bID_top"])){
		$_SESSION['bID_top']=$AufgabeInfo["bID_top"];
	}
	if(isset($AufgabeInfo["bID_bottom"])){
		$_SESSION['bID_bottom']=$AufgabeInfo["bID_bottom"];
	}
	for($iLauf=1;$iLauf<=$_SESSION['DesignTyp'];$iLauf++){
		if(isset($AufgabeInfo['bID_'.$iLauf])){
			$_SESSION['bID_'.$iLauf]=$AufgabeInfo['bID_'.$iLauf];
		}
	}
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
		<script type="text/javascript"
				src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS_HTML">
		</script>
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
						include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/module/mod_preasentation/praesentationseinstellungen.php");
						include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/module/mod_preasentation/show_praesentation_bloecke.php");
						$maxOrderID=getMaxOrderID($_SESSION['kursID'],1);
						$aktOrderID=getOrderID($_SESSION['fID'],$_SESSION['kursID']);
						?>
					<?php 
// 					}else{
					?>
					<?php 
// 						include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/module/mod_preasentation/show_praesentation_bloecke.php");
					?>
<!--					<span  style='margin-top: 50px;' class="btn btn-success btn-lg btn-block" >Bereits abgegeben</span>//-->
					<?php 
// 					}
					?>


				</div>
				<div class="col-md-1"></div>
			</div>
		</div>


		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/bottom_main.php");?>
	</body>
</html>