<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/session_delay_token.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/kursInfos.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/Sessions.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/folie.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/videos.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/abgabe.php");
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");

$_SESSION['fID']=intval($_GET['f']);
$folieInfo=getFolieInfo(intval($_GET['f']));

$parameter=json_decode($folieInfo['parameter'],true);
$videos=Get_Videos_Liste();
?>



<html>
	<head>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/head_main.php");?>
	</head>
	<body>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/header_bar.php");?>

		<div class="container">
			<div class="row" style='margin-top:50px;'>
				<div class="col-md-2"></div>
				<div class="col-md-8">
					<p class="lead"><?php echo $parameter['titel']; ?></p>
					<p>
						<?php echo $parameter['beschreibung']; ?>
					</p>
					<?php
					if(array_key_exists('ytID', $parameter)){
					?>
					<iframe id="ytplayer" type="text/html" width="100%" height="<?php echo 1/(16/9)*100 ?>% src="https://www.youtube.com/embed/<?php echo $parameter['ytID']; ?>?rel=0&showinfo=0&color=white&iv_load_policy=3"
							frameborder="0" allowfullscreen>
					</iframe> 
					<?php
					}elseif(array_key_exists('vID', $parameter)){
						$videoInfo=Get_VideoInfos_By_vID($videos,intval($parameter['vID']));
						$link_src=get_video_link($videoInfo,"sd");
					?>
					<video width="100%" muted controls style='margin-bottom:30px;'>
						<source src="<?php echo $link_src; ?>" type="video/mp4">
						Ihr Browser unterstützt den Video Tag nicht. Bitte aktualisieren Sie Ihren Browser.
					</video>
					<?php
					}
					?>				
				</div>
				<div class="col-md-2"></div>
			</div>
		</div>

		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/bottom_main.php");?>
	</body>
</html>