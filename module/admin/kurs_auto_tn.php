<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/teilnehmer.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/kursInfos.php");

if(isset($_GET['kTok'])){
	$kursToken=mysqli_real_escape_string ($verbindung, htmlentities ($_GET['kTok'], ENT_QUOTES , "UTF-8"));

	$KursInfos=getKursInfos_by_kursToken($kursToken);
	if($KursInfos!==null){
		$noKurs=0;
		$KursID=$KursInfos['kursID'];
		$uID=$KursInfos['uID'];



		$praefix=date("Y-m-d\_H:i:s");

		switch(rand (0 , 1 )){
			case 1:
				$geschlecht="m";
				break;

			default:
				$geschlecht="w";
				break;

		}

		// 		$name=$praefix."_Name"; 
		// 		$vname=$praefix."_vName";
		$name=date("Y-m-d"); 
		$vname=date("H:i:s");
		$email=$praefix."_email@anonymous.de";

		$token=AddTeilnehmer($geschlecht, $name, $vname, $email, $uID, $KursID);

		// 		echo "Ihr Zugangstoken lautet: $token";
?>
<html>
	<head>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/head_main.php");?>
		<script src="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/plugins/tinymce/js/tinymce/tinymce.min.js"></script>
	</head>
	<body>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/header_bar.php");?>
		<div class="container">
			<div class="row">
				<div class="col-md-3"></div>
				<div class="col-md-6">
					<h2>
						<?php echo "Ihr Zugangscode lautet: $token"; ?>
					</h2>
					<p>
						Bitte notieren Sie sich den Zugriffscode um auch später auf den Kurs zugreifen zu können.
					</p>
					<p>
						Besuchen Sie <a href="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/index.php" target="_blank"><strong>www.physik-workshop.de</strong></a> und geben dort den Zugriffscode ein oder
					</p>
					<a href="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/index.php?t="<?php echo $token; ?>" class="btn btn-primary" target="_blank">
						klicken um zum Kurs zu wechseln
					</a>

				</div>
				<div class="col-md-3"></div>
			</div>
		</div>
	</body>
</html>
<?php
	}else{
		$noKurs=1;
	}
}else{
	$noKurs=1;
}



if($noKurs==1){
?>
<html>
	<head>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/head_main.php");?>
		<script src="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/plugins/tinymce/js/tinymce/tinymce.min.js"></script>
	</head>
	<body>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/header_bar.php");?>
		<div class="container">
			<div class="row">
				<div class="col-md-3"></div>
				<div class="col-md-6 alert alert-danger"><strong>ACHTUNG</strong><br>Diesem Link wurde kein Kurs zugeordnet!<br> Bitte kontaktieren Sie die Person, von der Sie diesen Link erhalten haben!</div>
				<div class="col-md-3"></div>
			</div>

		</div>
	</body>
</html>
<?php
			  }