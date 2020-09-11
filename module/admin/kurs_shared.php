<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/header_php.php");
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/kursInfos.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/media.php");
// var_dump($SharedKurseInfos);
check_used_media();;
if(isset($_POST['search_input'])){
	$search_input=mysqli_real_escape_string ($verbindung, htmlentities ($_POST['search_input'], ENT_QUOTES , "UTF-8"));
	// 	echo $search_input;
	$search_arr=explode(" ",$search_input);
	$SharedKurseInfos=shared_Kurse_Liste_Infos_filtered($search_arr);
}else{
	$SharedKurseInfos=shared_Kurse_Liste_Infos();

}

if($_POST['action']=="cpKurs"){
	$kursID_alt=intval($_POST['kursID']);
	copy_Kurs($kursID_alt);
}

//LISTE durchsuchbar machen, indem mittels der Lösung der Frage http://stackoverflow.com/questions/6661530/php-multidimensional-array-search-by-value das Array $SharedKurseInfos durchsucht wird mit if(strpos(beschreibung) || strpos(titel)) kann dann eine Liste mit den passenden Kursen zurückgegeben werdne
?>

<html>
	<head>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/head_main.php");?>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/head_backend.php");?>
	</head>
	<body>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/header_bar.php");?>

		<div class="container">
			<div class="row" >
				<div class="col-md-1"></div>
				<div class="col-md-5">
					<p class="lead">freigegebene Kurse</p>
				</div>
				<div class="col-md-5">
				</div>
				<div class="col-md-1"></div>
			</div>
			<div class="row" >
				<div class="col-md-4"></div>
				<div class="col-md-2"></div>
				<div class="col-md-5">
					<form action="" method="post">
						<div class="input-group mb-2 mr-sm-2 mb-sm-0">
							<div class="input-group-addon"><button type="submit" style="background:none; border:none;" ><span class="glyphicon glyphicon-search"></span></button></div>
							<input class="form-control" type="search" value="" name="search_input">
						</div>
					</form>

				</div>
				<div class="col-md-1"></div>
			</div>

			<div class="row" >
				<div class="col-md-1"></div>
				<div class="col-md-10">
					<table class="table table-striped">
						<tr><th style="min-width:200px; max-width:250px;">Titel</th><th>Beschreibung</th><th>Optionen</th></tr>
						<?php
						foreach($SharedKurseInfos as $Kurs){
						?>
						<tr><th><?php echo $Kurs['titel']; ?></th><td><?php echo $Kurs['beschreibung']; ?></td><td><form action="" method="post"><input type="hidden" value='cpKurs' name="action"><input type="hidden" name="kursID" value="<?php echo $Kurs['kursID']; ?>"><button class="btn btn-success" type="submit"><span style="margin-right:10px;" class="glyphicon glyphicon-copy"></span>Kurs kopieren</button></form></td></tr>

						<?php
						}
						?>

					</table>



				</div>

				<div class="col-md-1"></div>
			</div>
		</div>
	</body>
</html>