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
include_once($_SERVER['DOCUMENT_ROOT']."/module/mod_preasentation/praesentationseinstellungen.php");

$abTyp=1;
$token=$_SESSION['t'];


// ========================
// ====== FOLIENDATEN LADEN
// ========================
if(intval($_GET['f'])>0){
	$fID=intval($_GET['f']);
	$_SESSION['fID']=$fID;
	$FolieArr=getFolieInfo($fID);
	// echo "===>".$FolieArr['parameter'];
	$AufgabeInfo=json_decode($FolieArr['parameter'],true);
}


// ========================
// ====== ABGABE LADEN
// ========================
$AbgabeRow=getAbgabeBy_fID_token_aTyp($token,$abTyp,$fID); //getAbgabeBy_abID_token_aTyp($token,$abTyp,$abID);
// var_dump($AbgabeRow);
if($AbgabeRow!==NULL && isset($AbgabeRow[0])){
	$AbgabeParameter=json_decode($AbgabeRow[0]['parameter'],true);
	$abID=$AbgabeRow[0]['abID'];
}else{
	$AbgabeParameter=array();
}



// ========================
// ====== KORREKTUR SPEICHERN
// ========================

// var_dump($_POST);

if(isset($_POST['action']) && $_POST['action']=="save" ){
	$insertArr=array();
	foreach ($_POST as $key => $value) {
		$key=mysqli_real_escape_string ($verbindung,  htmlentities (mynl2br($key), ENT_QUOTES , "UTF-8"));
		$value=mysqli_real_escape_string ($verbindung,  htmlentities (mynl2br($value), ENT_QUOTES , "UTF-8"));
		$insertArr[$key]=$value;
	}
	$datum=date("Y-m-d H:i:s");

	// 	echo $temp_name;
	$insertJson=json_encode($insertArr);
	$query="INSERT INTO abgabe (fID,abTyp,token,parameter,datum) VALUES ('$fID','$abTyp','$token','$insertJson','$datum') ON DUPLICATE KEY UPDATE parameter='$insertJson'";
	// 	echo $query;
	mysqli_query($verbindung,$query) or die($query." => ".mysqli_error($verbindung));

	$temp_name = $_FILES['bild']['tmp_name'];

	if( !empty($temp_name) && is_uploaded_file( $temp_name )){
		// 	if(files_uploaded()) {
		try {

			// Undefined | Multiple Files | $_FILES Corruption Attack
			// If this request falls under any of them, treat it invalid.
			if (
				!isset($_FILES['bild']['error']) ||
				is_array($_FILES['bild']['error'])
			) {
				throw new RuntimeException('Invalid parameters.');
			}

			// Check $_FILES['bild']['error'] value.
			switch ($_FILES['bild']['error']) {
				case UPLOAD_ERR_OK:
					break;
				case UPLOAD_ERR_NO_FILE:
					$errorMsg='Kein Bild wurde hochgeladen.';
					// 					throw new RuntimeException('Kein Bild wurde hochgeladen.');
					break;
				case UPLOAD_ERR_INI_SIZE:
				case UPLOAD_ERR_FORM_SIZE:
					$errorMsg='Das Bild überschreitet die maximal erlaubte Dateigröße von 2 MB.';
					// 					throw new RuntimeException('Das Bild überschreitet die maximal erlaubte Dateigröße von 2 MB.');
					break;
				default:
					$errorMsg='Ein unbekannter Fehler ist aufgetreten!';
					// 					throw new RuntimeException('Unbekannter Fehler');
					break;
			}

			// You should also check filesize here. 
			if ($_FILES['bild']['size'] > 2000000) {
				$errorMsg='Das Bild überschreitet die maximal erlaubte Dateigröße von 2 MB.';
			}

			if(!isset($errorMsg)){
				// DO NOT TRUST $_FILES['bild']['mime'] VALUE !!
				// Check MIME Type by yourself.
				$finfo = new finfo(FILEINFO_MIME_TYPE);
				if (false === $ext = array_search(
					$finfo->file($_FILES['bild']['tmp_name']),
					array(
						'jpg' => 'image/jpeg',
						'png' => 'image/png',
						'gif' => 'image/gif',
					),
					true
				)) {
					throw new RuntimeException('Invalid file format.');
				}

				$filename=$_SESSION['kursID']."_".$token."_".uniqid().".".$ext;
				$insertArr['bild']=$filename;
				if (!move_uploaded_file($_FILES['bild']['tmp_name'], $_SERVER['DOCUMENT_ROOT']."/media/uploads/fotowettbewerb/".$filename)) {
					throw new RuntimeException('Failed to move uploaded file.');
				}

				// 			echo 'File is uploaded successfully.';
			}elseif(isset($_POST['bild_old'])&&strlen($_POST['bild_old'])>0){
				$filename=mysqli_real_escape_string ($verbindung,  htmlentities (mynl2br($_POST['bild_old']), ENT_QUOTES , "UTF-8"));
				$insertArr['bild']=$filename;

			}else{
				$insertArr['bild']="";
			}
		} catch (RuntimeException $e) {

			echo $e->getMessage();


		}
	}else{
		// 		echo "verwende bestehendes Bild!";
		$filename=mysqli_real_escape_string ($verbindung,  htmlentities (mynl2br($_POST['bild_old']), ENT_QUOTES , "UTF-8"));
		$insertArr['bild']=$filename;
	}

	$insertJson=json_encode($insertArr);
	$query="INSERT INTO abgabe (fID,abTyp,token,parameter,datum) VALUES ('$fID','$abTyp','$token','$insertJson','$datum') ON DUPLICATE KEY UPDATE parameter='$insertJson'";
	mysqli_query($verbindung,$query) or die($query." => ".mysqli_error($verbindung));
	if(!isset($abID)){
		$abID=mysqli_insert_id ($verbindung);
		$parameter=json_encode(array("titel"=>$token,"zu_abID"=>$abID,"bID"=>$AufgabeInfo['add_baustein']));
		add_folie_fotowettbewerb($FolieArr['uID'],$parameter,10,1,0,1,$fID,$AufgabeInfo['addToKurs']);
	}
	unset($_POST);
	// 	$reload=1;
}

/* if(isset($reload) && $reload==1){
	echo "<script>window.reload();</script>";
}
 */
// ========================
// ====== ABGABE LADEN
// ========================
$AbgabeRow=getAbgabeBy_fID_token_aTyp($token,$abTyp,$fID); //getAbgabeBy_abID_token_aTyp($token,$abTyp,$abID);

if($AbgabeRow!==NULL && isset($AbgabeRow[0])){
	$AbgabeParameter=json_decode($AbgabeRow[0]['parameter'],true);
}else{
	$AbgabeParameter=array();
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
			<form action="" method="post" enctype="multipart/form-data" id='praesForm' >
				<input name='action' type="hidden" value="save">
				<div class="row" style='margin-top:0px;'>
					<!--<div class="col-md-1"></div>//-->
					<div class="col-md-6">
						<div class="container">
							<div class="panel panel-default">
								<div class="panel-body">

									<!-- Standar Form -->
									<h4>Wähle dein Bild auf deinem Computer aus:</h4>
									<div class="form-inline">
										<div class="form-group">
											<input type="file" name="bild" id="bild">
											<input type="hidden" name=bild_old id="bild_old" value="<?php if(isset($AbgabeParameter['bild'])){echo $AbgabeParameter['bild']; }?>">
										</div>
									</div>

									<?php
									if(isset($errorMsg)){
									?>
									<div class="alert alert-danger" style="margin-top:20px;">
										<?php echo $errorMsg; ?>

									</div>
									<?php
									}

									?>

									<?php if(isset($AbgabeParameter['bild']) && strlen($AbgabeParameter['bild'])>0){
									?>
									<div><img src='/media/uploads/fotowettbewerb/<?php echo $AbgabeParameter['bild'];?>' style="margin:10px 0; width:100%;"></div>
									<?php
} elseif(isset($AbgabeParameter['bild'])){
									?>
									<div class="alert alert-warning" style="margin-top:20px;">Du hast noch kein Bild erfolgreich hochgeladen!</div>
									<?php
}

									?>
								</div>
							</div>
							<div class="form-group">
								<label for="kommentar">Erklärung für das Phänomen, das auf dem Bild zu sehen ist:</label>
								<textarea id='KommentarFeld'  name='kommentar' class="form-control" id="kommentar" style='height:120px;'><?php if(isset($AbgabeParameter['kommentar'])){echo $AbgabeParameter['kommentar'];} ?></textarea>
							</div>
						</div> <!-- /container -->

					</div>
					<div class="col-md-6">
						<?php if(count($AbgabeRow)>0){?>
						<div class="alert alert-success">
							<strong>Bereits gespeichert!</strong><br> Deine Antworten wurden bereits gespeichert.<br>Wenn du deine Antworten nochmal korrigieren möchtest, benötigst du folgenden Zugangscode:<br><p class="lead">
							<?php echo $token; ?>
							</p>Diesen kannst du auf <b>www.physik-workshop.de</b> eingeben. Du gelangst dann wieder hier her!
						</div>
						<?php }?>
						<p class="alert alert-info">
							Damit wir dein Bild zuordnen können und dir im Anschluss gegebenenfalls auch einen Preis zustellen können, benötigen wir von dir einige Angaben:
						</p>
						<div class="form-group">
							<label for="name">Vorname, Name</label>
							<input name='name' class="form-control" id="name" value="<?php if(isset($AbgabeParameter['name'])){echo $AbgabeParameter['name'];} ?>" placeholder="Vorname, Name" required>
						</div>
						<div class="form-group">
							<label for="schule">Schule</label>
							<input name='schule' class="form-control" id="schule" value="<?php if(isset($AbgabeParameter['schule'])){echo $AbgabeParameter['schule'];} ?>" placeholder="Schule" required>
						</div>
						<div class="form-group">
							<label for="email">Deine Email</label>
							<input name='email' class="form-control" id="email" value="<?php if(isset($AbgabeParameter['email'])){echo $AbgabeParameter['email'];} ?>" placeholder="Email" required>
						</div>
						<div class="form-group">
							<label for="jgst">Deine Jahrgangsstufe</label>
							<input type="number" min=1 max=13 name='jgst' class="form-control" id="jgst" value="<?php if(isset($AbgabeParameter['jgst'])){echo $AbgabeParameter['jgst'];} ?>" placeholder="JgSt" required>
						</div>
						<div class="form-group">
							<label for="namePhysiklehrer">Name deines Physiklehrers</label>
							<input name='namePhysiklehrer' class="form-control" id="namePhysiklehrer" value="<?php if(isset($AbgabeParameter['namePhysiklehrer'])){echo $AbgabeParameter['namePhysiklehrer'];} ?>" placeholder="Name deines Physiklehrers" required>
						</div>



						<input class="btn btn-primary" type="submit" value='Bild hochladen und Speichern'>
					</div>
				</div>
			</form>
		</div>


		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/bottom_main.php");?>
	</body>
</html>