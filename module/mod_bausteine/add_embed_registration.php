<?php
// ========================
// ========================
// ====== EMBED PUMA KOMPONENTEN EINBINDEN
// ========================
// ========================


?>


<form id='' action="" method="post" style='padding-top:30px;'>
	<div class="form-group">
		<label for="titel">Titel</label>
		<input id='titel' type="text" class="form-control" name="titel" placeholder="Titel des Bausteins" required value='<?php if(isset($bsInfo['titel'])){echo html_entity_decode ($bsInfo['titel'], ENT_QUOTES , "UTF-8");} ?>'>
	</div>
	<div class="form-group">
		<label for="embLink">Link zur Komponente</label>
		<input id='embLink' type="text" class="form-control" name="embLink" placeholder="Link zur Komponente" required value='<?php if(isset($bsInfo['embLink'])){echo $bsInfo['embLink'];} ?>'>
		<small id="embLinkHelp" class="form-text text-muted">Kopieren Sie in das Textfeld den Link zur Komponente.</small>
	</div>
	<button class="btn btn-primary" type="submit" value=1 name='smBut'>Speichern</button>
</form>