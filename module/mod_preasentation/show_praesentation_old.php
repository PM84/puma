<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT']."/includes/session_delay_token.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/kursInfos.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/Sessions.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/folie.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/videos.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/abgabe.php");
include($_SERVER['DOCUMENT_ROOT']."/config.php");
$_SESSION['fID']=intval($_GET['f']);
$folieInfo=getFolieInfo(intval($_GET['f']));
$parameter=json_decode($folieInfo['parameter']);
$token=$_SESSION['t'];

// ========================
// ====== ABGEBEN
// ========================

if(isset($_POST['submit'])){
	$fID=$_SESSION['fID'];
	$query="SELECT * FROM abgabe WHERE fID='$fID' AND token='$token' AND abTyp=3";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	if(mysqli_num_rows($ergebnis)==1){
		$row=mysqli_fetch_assoc($ergebnis);
		$parameter_insert=json_decode($row['parameter'],true);
		if($parameter_insert===NULL){
			$parameter_insert=array("abgegeben"=>1);
		}else{
			$parameter_insert["abgegeben"]=1;
		}
	}else{
		$parameter_insert=array("abgegeben"=>1);
	}
	$parameter_insert->abgegeben=1;
	$parameter_insert=json_encode($parameter_insert);
	$abTyp=3;
	$abID="";
	$query="INSERT INTO abgabe (fID,abTyp,token,zu_abID,parameter) VALUES ('$fID','$abTyp','$token','$abID','$parameter_insert') ON DUPLICATE KEY UPDATE parameter='$parameter_insert'";
	// 	$query="INSERT INTO abgabe SET parameter='$parameter' WHERE fID='$fID' AND token='$token'";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	unset($_POST);
}

// ========================
// ====== ABGABE LADEN
// ========================

$AbgabeInfoRow=getAbgabeInfo($_SESSION['fID'],$token);
if(count($AbgabeInfoRow)>0){
	$AbgabeInfo=json_decode($AbgabeInfoRow['parameter']);
	$abgegeben=$AbgabeInfo->abgegeben;
}else{
	$abgegeben=0;
}


?>



<html>
	<head>
		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/head_main.php");?>
	</head>
	<body>
		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/header_bar.php");?>
		<?php 
// 		var_dump(FolienAnzeige_Menu($_SESSION['kursID'],$_SESSION['t']));
		?>
		<div class="container">
			<div class="row" style='margin-top:50px;'>
				<div class="col-md-2"></div>
				<div class="col-md-8">
					<!--<p class="lead"><?php echo html_entity_decode ($parameter->titel, ENT_QUOTES , "UTF-8"); ?></p>//-->
					<?php echo html_entity_decode ($parameter->inhalt, ENT_QUOTES , "UTF-8");?>
					<span style='display:block; margin-top:50px; border-top: 1px gray solid; padding-top:15px; width:100%;'>
						<?php 
						if($abgegeben!=1){
						?>
						<form action="" method="post">
							<input type="submit" class="btn btn-primary" name="submit" value='Ich bin fertig!'>
						</form>
						<?php 
						}else{
						?>
						<span class="btn btn-success" >Bereits abgegeben</span>
						<?php 
						}
						?>

					</span>
				</div>
				<div class="col-md-2"></div>
			</div>
		</div>

		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/bottom_main.php");?>
	</body>
</html>