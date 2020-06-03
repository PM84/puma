<?php
// ========================
// ========================
// ====== PRÄSENTATION - mehrspaltig
// ========================
// ========================


$themen=Get_VideoThemen();
$videos=Get_Videos_Liste();
$Sims=Get_Sim_Liste();
// echo $_SESSION[$ftoken]['Baustein_top'];

if(isset($_POST['Baustein_top'])){
	$_SESSION[$ftoken]['edit_Baustein_top']=intval($_POST['Baustein_top']) ;
}
if(isset($_POST['Baustein_bottom'])){
	$_SESSION[$ftoken]['edit_Baustein_bottom']=intval($_POST['Baustein_bottom']) ;
}

for($iLauf=1;$iLauf<=$_SESSION[$ftoken]['edit_DesignTyp'];$iLauf++){
	if(isset($_POST['Baustein_'.$iLauf])){
		$_SESSION[$ftoken]['edit_Baustein_'.$iLauf]=intval($_POST['Baustein_'.$iLauf]);
	}
}


?>
<div class="row" style='margin-bottom:200px;'>
	<!--<div class="col-md-1"></div>//-->
	<div class="col-md-1"></div>

	<div class="col-md-10">
		<p class="lead" style='margin:0'>Bausteine auswählen</p>

		<div class="row" style="margin-bottom:4px;">
		<h5>TOP</h5>
			<div class="col-md-12" style='background-color: lightgray; border: 1px gray solid;'>
				<?php $Block='top'; ?>
				<?php include($_SERVER['DOCUMENT_ROOT']."/module/mod_preasentation/add_bausteine_form.php"); ?>
			</div>
		</div>
		<div class="row" style="margin-bottom:4px;">
		<h5>Spalten</h5>
			<?php
			for($iLauf=1;$iLauf<=$AnzCol;$iLauf++){
				$Block=$iLauf;

			?>
			<div class="col-md-<?php echo 12/$_SESSION[$ftoken]['edit_DesignTyp']; ?>" style='background-color: lightgray; border: 1px gray solid;'>
				<?php include($_SERVER['DOCUMENT_ROOT']."/module/mod_preasentation/add_bausteine_form.php"); ?>
			</div>
			<?php
			}
			?>
		</div>
		<div class="row">
		<h5>BOTTOM</h5>
			<div class="col-md-12" style='background-color: lightgray; border: 1px gray solid;'>
				<?php $Block='bottom'; ?>
				<?php include($_SERVER['DOCUMENT_ROOT']."/module/mod_preasentation/add_bausteine_form.php"); ?>
			</div>
		</div>

		<hr>
		<p class="lead" style='margin:0'>Inhalt bearbeiten</p>
		<br>
		<form id="praesForm" action='' method="POST" style='margin:0;' accept-charset="UTF-8">
								<input type="hidden" value="<?php echo $ftoken; ?>" name="ftoken">

			<div class="form-group">
				<label for="titel">Titel</label>
				<input id='titel' type="text" class="form-control" name="titel" placeholder="Titel der Folie" required value='<?php if(isset($AufgabeInfo["titel"])){echo html_entity_decode ($AufgabeInfo["titel"], ENT_QUOTES , "UTF-8");} ?>'>
			</div>
			<input type="hidden" name="fID" value='<?php echo $_SESSION[$ftoken]['edit_fID']; ?>'>
			<hr>
			<div class="row">
				<div class="col-md-12" style=''>

					<?php $Block="top"; ?>
					<?php include($_SERVER['DOCUMENT_ROOT']."/module/mod_preasentation/add_task_preview_setting.php"); ?>

				</div>
			</div>

			<div class="row">
				<?php

				for($iLauf=1;$iLauf<=$AnzCol;$iLauf++){
					$Block=$iLauf;

				?>
				<div class="col-md-<?php echo 12/$_SESSION[$ftoken]['edit_DesignTyp']; ?>" style=''>
					<?php include($_SERVER['DOCUMENT_ROOT']."/module/mod_preasentation/add_task_preview_setting.php"); ?>
				</div>
				<?php
				}				
				?>
			</div>

			<div class="row">
				<div class="col-md-12" style=''>
					<?php $Block="bottom";?>
					<?php include($_SERVER['DOCUMENT_ROOT']."/module/mod_preasentation/add_task_preview_setting.php"); ?>

				</div>
			</div>
			<div>
				<?php include($_SERVER['DOCUMENT_ROOT']."/includes/folieAnzeigeOptionen.php") ?>
			</div>

			<!--<input class="btn btn-primary btn-lg btn-block" value='Speichern' type="submit">//-->
				<button class="btn btn-default btn-lg" style="margin-top: 8px; margin-right: 15px; margin-bottom: 8px;" name="savePraes" value='2' type="submit">Speichern & Schließen</button>
				<button class="btn btn-primary btn-lg" style="margin-top: 8px; margin-right: 15px; margin-bottom: 8px;" name="savePraes" value='1' type="submit">Speichern</button>
		</form>

	</div>
	<div class="col-md-1"></div>
</div>
<script>
	$( ".delTrash" ).click(function() {
		var elm = $(this);
		var id = $(this).attr('data');
		console.log(id);
		deleteMark(id)
	});


</script>