<?php
// ========================
// ========================
// ====== WEBPAGE ALS IFRAME EINBINDEN
// ========================
// ========================


?>


<form id='' action="" method="post" style='<?php if(!isset($_GET['bTypID'])){ ?>padding-top:30px;<?php } ?>'>
	<div class="form-group">
		<label for="titel">Titel</label>
		<input id='titel' type="text" class="form-control" name="titel" placeholder="Titel des Bausteins" required value='<?php if(isset($bsInfo['titel'])){echo html_entity_decode ($bsInfo['titel'], ENT_QUOTES , "UTF-8");} ?>'>
	</div>
	<div class="form-group">
		<label for="webUrl">URL der Webseite</label>
		<input id='webUrl' type="text" class="form-control" name="webUrl" placeholder="URL der Webseite" required value='<?php if(isset($bsInfo['webUrl'])){echo $bsInfo['webUrl'];} ?>'>
		<small id="webUrlHelp" class="form-text text-muted">Kopieren Sie in das Textfeld die URL der einzubindenden Webseite.</small>
	</div>
	<button class="btn btn-primary" type="submit" value=1 name='smBut'>Speichern</button>
</form>