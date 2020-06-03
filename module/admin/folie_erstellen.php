<?php
include($_SERVER['DOCUMENT_ROOT']."/includes/header_php.php");
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

$ausserhalbKurs=1;

include_once($_SERVER['DOCUMENT_ROOT']."/includes/session_delay.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/kursInfos.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/Sessions.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/module.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/folie.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/user_login.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/teilnehmer.php");

include_once($_SERVER['DOCUMENT_ROOT']."/config.php");
$SessionInfos=Get_SessionInfos($_SESSION['s']);
// var_dump($SessionInfos);
$uID=$SessionInfos['uID'];

$userInfos=getUserInfos($uID);
$preview_teilnehmer_infos=get_preview_teilnehmer_infos($uID);
unset($_SESSION['edit_fID']);
// ========================
// ====== KURSID IN SESSION SCHREIBEN
// ========================

if(isset($_POST['k'])){
	$kursID=intval($_POST['k']);
	$_SESSION['k']=$kursID;
	$aktKursInfo=GetKursInfos($_SESSION['k']);
	$_SESSION['kTyp']=$aktKursInfo['kTyp'];
	unset($_POST['k']);
}elseif(isset($_SESSION['k'])){
	$_SESSION['kTyp']=2;
	$aktKursInfo=GetKursInfos($_SESSION['k']);
}else{
	$_SESSION['kTyp']=2;
}
// echo "ok";
// ========================
// ====== fID IN SESSION SCHREIBEN UND WEITERLEITEN
// ========================

if(isset($_POST['fID'])){
	$_SESSION['edit_fID']=intval($_POST['fID']);
	unset($_POST['fID']);
	redirectTo_addTask(intval($_SESSION['edit_fID']));
}
?>
<html>
	<head>
		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/head_main.php");?>
		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/head_backend.php");?>
	</head>
	<body>
		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/header_bar.php");?>

		<div class="container">
			<div class="row" >
				<div class="col-md-1"></div>
				<div class="col-md-3">
					<p class="lead">Ihre Kurse</p>
					<?php
					$Kurse=GetKursListeInfos($uID,1,1);
					foreach($Kurse as $KursInfo){
					?>
					<form action='' method="POST" style='margin:0;' accept-charset="UTF-8">
						<input type=hidden value='<?php  echo $KursInfo['kursID']; ?>' name='k'><input type="submit" class="btn <?php if(isset($_SESSION['k']) && $_SESSION['k']==$KursInfo['kursID']){echo "btn-primary";}else{echo "btn-default";}?>" style='width:100%' value="<?php echo $KursInfo['titel']; ?>">
					</form>
					<?php
					}
					?>
				</div>
				<div class="col-md-4">
					<p class="lead">Folientyp auswählen</p>
					<?php

					if(isset($_SESSION['k'])){
						// 						$KursInfo=GetKursInfos(htmlspecialchars($_SESSION['k'], ENT_QUOTES));
					?>
					<!--					<p class="" style='margin-bottom:5px;;'>ausgewählter Kurs: <b style='font-size:20px;'><?php echo $KursInfo['titel']; ?></b></p>//-->
					<?php
						// 						echo $_SESSION['kTyp'];
// 						if($_SESSION['kTyp']==1){$kTyp=0;}else{$kTyp=$_SESSION['kTyp'];}
						$_SESSION['kTyp']=$_SESSION['kTyp'];
						$modArr=getModulListeInfos($kTyp);
						foreach($modArr as $modul){
							if($modul['show']==0){continue;}
					?>
					<a class="btn btn-default" style='width:100%' href='/<?php echo $modul['mod_dir']; ?>/<?php echo $modul['mod_add']; ?>'><?php echo $modul['mod_titel']; ?></a>
					<?php
						}
					}
					?>
				</div>
				<div class="col-md-3">
					<p class="lead">Folien des aktuellen Kurses</p>
					<?php
					if(isset($_SESSION['k'])){
						$folienArr=getFolienListeInfos($_SESSION['k']);
						if(count($folienArr)>0){


							// 							var_dump($aktKursInfo);
					?>
					<a href="/index.php?kt=<?php echo $aktKursInfo['kursToken']; ?>&t=<?php echo $preview_teilnehmer_infos['token']; ?>" class="btn btn-primary btn-block" target="blank"><span class="glyphicon glyphicon-eye-open" style="margin-right:20px;"></span>Vorschau</a>
					<?php
						}
						// 						var_dump($folienArr);
						foreach($folienArr as $folie){
							// 							echo $folie['parameter'];
							$folieInfo=json_decode($folie['parameter']);
							// 							var_dump($folieInfo);
							// 							var_dump(json_decode($folie['parameter'], true, 4));
							$fID=$folie['fID'];
							if($folie['zu_fID']>0 && $folie['modID']!=10){continue;}
							/* 					?>
					<form action='' method="POST" style='margin:0;' accept-charset="UTF-8">
						<input type=hidden value='<?php  echo $fID; ?>' name='fID'>
						<input type="submit" class="btn btn-default" style='width:100%' value="<?php if(strlen($folieInfo->titel)==0){echo "==leer==";}else{echo $folieInfo->titel;} ?>">
					</form>
					<?php */
							switch($folie['modID']){
								default:
					?>
					<a class="btn btn-default btn-block" href='/module/mod_preasentation/add_task.php?ft=<?php  echo $folie['ftoken']; ?>'><?php if(strlen($folieInfo->titel)==0){echo "==leer==";}else{echo $folieInfo->titel;} ?></a>
					<?php
									break;
								case 1:
					?>
					<a class="btn btn-default btn-block" href='/module/mod_videovertonung/add_task.php?ft=<?php  echo $folie['ftoken']; ?>'><?php if(strlen($folieInfo->titel)==0){echo "==leer==";}else{echo $folieInfo->titel;} ?></a>
					<?php
									break;
								case 3:
					?>
					<a class="btn btn-default btn-block" href='/module/mod_videoanalyse/add_task.php?ft=<?php  echo $folie['ftoken']; ?>'><?php if(strlen($folieInfo->titel)==0){echo "==leer==";}else{echo $folieInfo->titel;} ?></a>
					<?php
									break;

							}
						}
						if(count($folienArr)==0){
					?>
					<div class="alert alert-info">Keine Folien gefunden!</div>
					<?php

						}
					}
					?>
				</div>
				<div class="col-md-1"></div>
			</div>
		</div>

		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/bottom_main.php");?>
	</body>
</html>