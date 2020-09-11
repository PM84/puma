<?php
// ========================
// ========================
// ====== Kontrollfragen
// ========================
// ========================


?>


<form id='KoFraForm' action="" method="post">
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
	<div class="form-group" id='AntwortOptionen'>
		<label for="beschreibung">Kontrollfragen</label>
		<div id="KoFraDiv">
			<?php 
			if(isset($bsInfo['antwortOption'])){for ( $iLauf=0; $iLauf<count($bsInfo['antwortOption']); $iLauf++ ){ 
				include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/module/mod_bausteine/add_kontrollfragen_options.php");
				if($iLauf<count($bsInfo['antwortOption'])-1){echo "<hr>";}
			}}else{
				$iLauf=0;
				include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/module/mod_bausteine/add_kontrollfragen_options.php");
			}
			?>
		</div>

	</div>
	<input type='button' onclick="addAllInputs('KoFraDiv', 'text')" value="Antwortoption hinzufügen">
	<button class="btn btn-default" type="submit" value=1 name='smBut'>Speichern & Schließen</button>
	<button class="btn btn-primary" type="submit" value=1 name='smBut_stay'>Speichern</button>
</form>


<script>
	var counterText = <?php echo $iLauf+1; ?>;
	var counterRadioButton = 0;
	var counterCheckBox = 0;
	var counterTextArea = 0;

	function addAllInputs(divName){
		var newdiv = document.createElement('div');
		newdiv.innerHTML = "<hr><div class='row'><div class='col-sm-11'><input class='form-control' type='text' placeholder='Auswahloption " + (counterText + 1) + "' name='antwortOption[]'></div><div class='col-sm-1'><input class='form-control '  name='richtigeOption[]' type='checkbox' data-toggle='toggle' data-on='richtig' data-off='falsch' data-onstyle='success' data-offstyle='danger' value=" + (counterText + 1) + " data-size='small'></div></div><div class='row'><div class='col-sm-11'><textarea id='erlaeuterung_" + (counterText + 1) + "' class='form-control EditorField' name='erlaeuterung[]' style='height:150px;' placeholder='Erläuterung / Erklärung eingeben'></textarea></div><div class='col-sm-1'></div></div>";
		document.getElementById(divName).appendChild(newdiv);
		$("[data-toggle='toggle']").bootstrapToggle('destroy')                 
		$("[data-toggle='toggle']").bootstrapToggle();
		// 		tinyMCE.execCommand("mceAddEditor", false, 'erlaeuterung_'+counterText);

		tinymce.init({
			selector: '.EditorField',
			<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/plugins/tinymce/include/init_pfreferences_lehrer.php"); ?> 
		});

		counterText++;

	}

	function deleteAnswerOption(divName){
		$( "#"+divName ).remove();
	}
	/* 	function addAllInputs(divName, inputType){
		var newdiv = document.createElement('div');
		switch(inputType) {
			case 'text':
				newdiv.innerHTML = "Entry " + (counterText + 1) + " <br><input type='text' name='myInputs[]'>";
				counterText++;
				break;
			case 'radio':
				newdiv.innerHTML = "Entry " + (counterRadioButton + 1) + " <br><input type='radio' name='myRadioButtons[]'>";
				counterRadioButton++;
				break;
			case 'checkbox':
				newdiv.innerHTML = "Entry " + (counterCheckBox + 1) + " <br><input type='checkbox' name='myCheckBoxes[]'>";
				counterCheckBox++;
				break;
			case 'textarea':
				newdiv.innerHTML = "Entry " + (counterTextArea + 1) + " <br><textarea name='myTextAreas[]'>type here...</textarea>";
				counterTextArea++;
				break;
		}
		document.getElementById(divName).appendChild(newdiv);
	} */
</script>