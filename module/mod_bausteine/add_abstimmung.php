<?php
// ========================
// ========================
// ====== Abstimmung
// ========================
// ========================


?>


<form id='AbstForm' action="" method="post">
	<div class="form-group">
		<label for="titel">Titel</label>
		<input id='titel' type="text" class="form-control" name="titel" placeholder="Titel des Bausteins" required value='<?php if(isset($bsInfo['titel'])){echo html_entity_decode ($bsInfo['titel'], ENT_QUOTES , "UTF-8");} ?>'>
	</div>
	<div class="form-group">
		<label for="beschreibung">Frage / Aufgabe eingeben</label>
		<textarea class="form-control" id="beschreibung" name="beschreibung">
			<?php if(isset($bsInfo['beschreibung'])){echo html_entity_decode ($bsInfo['beschreibung'], ENT_QUOTES , "UTF-8");} ?>
		</textarea>
	</div>
	<div class="form-group">
		<div class="checkbox">
			<label>
				<input name='multiple_abstOption'  type="hidden" value="off">
				<input name='multiple_abstOption'  type="checkbox" data-toggle="toggle" data-on="Ja" data-off="Nein" data-onstyle="success" data-offstyle="danger" value=1 data-size="small" <?php if(isset($bsInfo['multiple_abstOption']) && $bsInfo['multiple_abstOption']==1){echo "checked";} ?>>Mehrfachauswahl ermöglichen</label>
		</div>

	</div>
	<div class="form-group">
		<label for="showAuswertung">
			<input type="hidden" value="off" name="showAuswertung">
			<input class="form-control" type="checkbox" data-toggle="toggle" data-on="Ja" data-off="Nein" name="showAuswertung" id="showAuswertung" data-offstyle="danger" data-onstyle="success">
			Zeige die Auswertung den Teilnehmern.
		</label>
		<script>
			if("<?php if(isset($bsInfo['showAuswertung']) && $bsInfo['showAuswertung']=="on"){echo "on";}else{echo "off";}?>"=="on"){
				$('#showAuswertung').bootstrapToggle('on')
			}else{
				$('#showAuswertung').bootstrapToggle('off')
			}
		</script>
	</div>
	<div class="form-group" id='AntwortOptionen'>
		<label for="beschreibung">Wahloptionen</label>
		<div id="AbOptDiv">
			<?php 
			// 			var_dump($bsInfo);
			if(isset($bsInfo['abstOption'])){for ( $iLauf=0; $iLauf<count($bsInfo['abstOption']); $iLauf++ ){ 
				include($_SERVER['DOCUMENT_ROOT']."/module/mod_bausteine/add_abstimmung_options.php");
				if($iLauf<count($bsInfo['abstOption'])-1){echo "<hr>";}
			}}else{
				$iLauf=0;
				include($_SERVER['DOCUMENT_ROOT']."/module/mod_bausteine/add_abstimmung_options.php");
			}
			?>
		</div>

	</div>
	<button type='button' onclick="addAllInputs('AbOptDiv', 'text')" class='btn btn-default'><span class='glyphicon glyphicon-plus'></span>Antwortoption hinzufügen</button>
	<button class="btn btn-primary" type="submit" value=1 name='smBut'>Speichern</button>
</form>


<script>
	var counterText = <?php echo $iLauf+1; ?>;
	var counterRadioButton = 0;
	var counterCheckBox = 0;
	var counterTextArea = 0;

	function addAllInputs(divName,typ){
		var newdiv = document.createElement('div');
		newdiv.innerHTML = "<hr><div class='row'><div class='col-sm-12'><input class='form-control' type='"+typ+"' placeholder='Auswahloption " + (counterText + 1) + "' name='abstOption[]'></div></div>";
		document.getElementById(divName).appendChild(newdiv);
		counterText++;
	}

</script>