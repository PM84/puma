<?php
// ========================
// ========================
// ====== YouTube Videos
// ========================
// ========================


?>


<form id='AbstForm' action="" method="post" style='<?php if(!isset($_GET['bTypID'])){ ?>padding-top:30px;<?php } ?>'>
	<div class="form-group">
		<label for="titel">Titel</label>
		<input id='titel' type="text" class="form-control" name="titel" placeholder="Titel des Bausteins" required value='<?php if(isset($bsInfo['titel'])){echo html_entity_decode ($bsInfo['titel'], ENT_QUOTES , "UTF-8");} ?>'>
	</div>
	<div class="form-group">
		<label for="YTLink">YouTube Link</label>
		<input id='YTLink' type="text" class="form-control" name="ytlink" placeholder="YouTube Link / URL" required value='<?php if(isset($bsInfo['ytlink'])){echo $bsInfo['ytlink'];} ?>'>
		<small id="YTLinkHelp" class="form-text text-muted">Kopieren Sie in das Textfeld die URL des jeweiligen YouTube-Videos.</small>
	</div>
	<script src="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/js/timingfield.js"></script>
	<link href="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/css/timingfield.css" type="text/css" rel="stylesheet" media="screen" />
	<div style="margin-bottom:25px;">
		<span style=" cursor:pointer; font-weight:bold;"  data-toggle="collapse" data-target="#advanced"> &rsaquo;&rsaquo; erweiterte Einstellungen</span>
		<div class="panel panel-default collapse" id="advanced">
			<div class="panel-body" >
				<div class="form-group">
					<label for="YT_von">Nur Ausschnitt abspielen.<br>von:</label>
					<script type="text/javascript">
						jQuery(document).ready(function($) {
							$(".von").timingfield();
						});
					</script>

					<input type="text" class="von" id="YT_von" name="von"/>

				</div>
				<div class="form-group">
					<label for="YT_bis">bis:</label>
					<script type="text/javascript">
						jQuery(document).ready(function($) {
							$(".bis").timingfield();
						});
					</script>

					<input type="text" class="bis" id="YT_bis" name="bis"/>

				</div>
			</div>
		</div>
	</div>
	<button class="btn btn-primary" type="submit" value=1 name='smBut'>Speichern</button>
</form>