<?php
session_start();

$ausserhalbKurs=1;
include($_SERVER['DOCUMENT_ROOT']."/config.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/system.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/agb.php");

if(isset($_POST['action']) && $_POST['action']=="saveAGB"){
	$agb_txt=mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($_POST['agb_txt']), ENT_QUOTES , "UTF-8"));
	$agbID=intval($_POST['agbID']);
	$valid_from=mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($_POST['valid_from']), ENT_QUOTES , "UTF-8"));
	addAGB($agb_txt,$valid_from,$agbID);
}

$agbErgebnis=get_AGB_versionsListe();

if(isset($_POST['action']) && $_POST['action']=="loadAGB"){
	$agbID=intval($_POST['agbID']);
	$loadedAGB=loadAGB($agbID);
}


?>

<html>
	<head>
		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/head_main.php");?>
		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/head_backend.php");?>

		<script src="/plugins/tinymce/js/tinymce/tinymce.min.js"></script>
		<script>
			tinymce.init({
				selector : "textarea",
				language: 'de',
				height: 600,
				theme: 'modern',
				plugins: [
					'advlist autolink lists link charmap print preview hr anchor powerpaste',
					'searchreplace wordcount visualblocks visualchars code fullscreen',
					'insertdatetime nonbreaking save table contextmenu directionality',
					'emoticons textcolor colorpicker textpattern codesample toc anchor'
				],
				toolbar1: 'undo redo | bold italic underline | bullist numlist outdent indent | link',
				toolbar2: 'forecolor | codesample anchor',
				image_advtab: true,
				content_css: [
					'//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
					'//www.tinymce.com/css/codepen.min.css'
				],
			});
		</script>

	</head>
	<body>
		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/header_bar.php");?>

		<div class="container">
			<div class="row">
				<div class="col-md-1"></div>
				<div class="col-md-3">
					<h2>AGB-Versionen</h2>
					<?php
					while($rowAGB=mysqli_fetch_assoc($agbErgebnis)){
					?>
					<form action="" method="post" style="margin-bottom:5px">
						<input type="hidden" name='agbID' value="<?php echo $rowAGB['agbID']; ?>">
						<input type="hidden" name='action' value="loadAGB">
						<button class="btn btn-default btn-block" type="submit"> Gültig ab: <?php echo date('d.m.Y',strtotime($rowAGB["valid_from"])); ?></button>
					</form>
					<?php
					}

					?>
				</div>
				<div class="col-md-7">
					<h2>AGB-Version bearbeiten oder neu erstellen</h2>
					<form action="" method="POST">
						<input type="hidden" name="action" value="saveAGB">
						<input type="hidden" name="agbID" value="<?php echo $loadedAGB['agbID']; ?>">
						<div style="margin-bottom:15px;">
							<textarea name="agb_txt" ><?php if(isset($loadedAGB['text'])){echo html_entity_decode ($loadedAGB['text'], ENT_QUOTES , "UTF-8");} ?></textarea>
						</div>
						<div class="form-group">
							<label>Gültig ab</label>
							<input type="date" name="valid_from" class="form-control" value="<?php if(isset($loadedAGB['valid_from'])){echo date('Y-m-d',strtotime($loadedAGB["valid_from"]));} ?>" required>
						</div>
						<div class="form-group">
							<input type="submit" class="btn btn-success btn-block" value="Speichern">
						</div>
					</form>
				</div>
				<div class="col-md-1"></div>
			</div>
		</div>
	</body>
</html>