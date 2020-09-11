<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/teilnehmer.php");

$KursID=24;
$uID=1;

$praefix="k_demo_".uniqid();


switch(rand (0 , 1 )){
	case 1:
		$geschlecht="m";
		break;

	default:
		$geschlecht="w";
		break;

}

$name=$praefix."_Name"; 
$vname=$praefix."_vName";
$email=$praefix."_email@anonymous.de";

$token=AddTeilnehmer($geschlecht, $name, $vname, $email, $uID, $KursID);

echo "Ihr Zugangstoken lautet: $token";
?>
<html>
	<head>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/head_main.php");?>
		<script src="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/plugins/tinymce/js/tinymce/tinymce.min.js"></script>
	</head>
	<body>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/header_bar.php");?>
		<div class="container">
			<h2>
			<?php echo "Ihr Zugangscode lautet: $token"; ?>
			</h2>
			<p>
Bitte notieren Sie sich den Zugriffscode um auch später auf den Demo-Kurs zugreifen zu können.
			</p>
			<p>
				Besuchen Sie <a href="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/index.php" target="_blank"><strong>www.physik-workshop.de</strong></a> und geben dort den Zugriffscode ein oder
			</p>
			<a href="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/index.php?t="<?php echo $token; ?>" class="btn btn-primary" target="_blank">
				klicken um zur Demo wechseln
			</a>
		</div>
	</body>
</html>