<?php
// ========================
// ========================
// ====== Word Cloud
// ========================
// ========================

?>


<form action="" method="post">
	<div class="form-group">
		<label for="titel">Titel</label>
		<input id='titel' type="text" class="form-control" name="titel" placeholder="Titel des Bausteins" required value='<?php if(isset($bsInfo['titel'])){echo html_entity_decode ($bsInfo['titel'], ENT_QUOTES , "UTF-8");} ?>'>
	</div>
	<div class="form-group">
		<label for="beschreibung">Beschreibung</label>
		<textarea class="form-control" id="beschreibung" name="beschreibung">
			<?php if(isset($bsInfo['beschreibung'])){echo html_entity_decode ($bsInfo['beschreibung'], ENT_QUOTES , "UTF-8");} ?>
		</textarea>
	</div>
	<button class="btn btn-primary" type="submit" value=1 name='smBut'>Speichern</button>
</form>