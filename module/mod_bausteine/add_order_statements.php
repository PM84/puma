<?php
// ========================
// ========================
// ====== Ordnungsaufgaben
// ========================
// ========================

// var_dump($bsInfo);

?>
<script src="/js/jqueryUI/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="/js/jqueryUI/jquery-ui.css">

<div style="overflow:hidden">

	<form id='KoFraForm' action="" method="post">
		<input type="hidden" name="StatementOrder" id="StatementOrder">
		<input type="hidden" name="BS_Typ" value="StatementOrder">
		<div class="form-group">
			<label for="titel">Titel</label>
			<input id='titel' type="text" class="form-control" name="titel" placeholder="Titel des Bausteins" required value='<?php if(isset($bsInfo['titel'])){echo html_entity_decode ($bsInfo['titel'], ENT_QUOTES , "UTF-8");} ?>'>
		</div>
		<div class="form-group">
			<label for="beschreibung">Aufgabenbeschreibung</label>
			<textarea class="form-control" id="beschreibung" name="beschreibung">
				<?php if(isset($bsInfo['beschreibung'])){echo html_entity_decode ($bsInfo['beschreibung'], ENT_QUOTES , "UTF-8");} ?>
			</textarea>
		</div>
		<div class="form-group" id='AntwortOptionen'>
			<label for="beschreibung">Aussagen</label>
			<div class="grid" id="KoFraDiv">

				<?php 
				if(isset($bsInfo['CombinedOptions'])){
					// 					var_dump($bsInfo['CombinedOptions']);
					// 					for ( $iLauf=0; $iLauf<count($bsInfo['antwortOption']); $iLauf++ ){ 
					foreach($bsInfo['CombinedOptions'] as $StatementID=>$StatementTXT){
						include($_SERVER['DOCUMENT_ROOT']."/module/mod_bausteine/add_order_statements_options.php");
						// 					if($iLauf<count($bsInfo['antwortOption'])-1){echo "<hr>";}
					}
				}else{
					$StatementID=1;
					include($_SERVER['DOCUMENT_ROOT']."/module/mod_bausteine/add_order_statements_options.php");
				}
				?>
			</div>

		</div>
		<input type='button' onclick="addAllInputs('KoFraDiv', 'text')" value="Aussage hinzufügen">
		<button class="btn btn-default" type="submit" value=1 name='smBut'>Speichern & Schließen</button>
		<button class="btn btn-primary" type="submit" value=1 name='smBut_stay'>Speichern</button>
	</form>
</div>
<div id="dialog-confirm" title="Aussage löschen?">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>Soll diese Aussage wirklich gelöscht werden?</p>
</div>
<script>

	var counterText = <?php echo $StatementID; ?>;
	var counterRadioButton = 0;
	var counterCheckBox = 0;
	var counterTextArea = 0;

	$(".deleteStatement").click(function(){
						var del = $(this).parent().parent().attr('id');

		$( function() {
			$( "#dialog-confirm" ).dialog({
				resizable: false,
				height: "auto",
				width: 400,
				modal: true,
				buttons: {
					"Aussage löschen": function() {
						$( this ).dialog( "close" );
						$("#"+del).alert('close');
					},
					"Abbrechen": function() {
						$( this ).dialog( "close" );
					}
				}
			});
		} );

		// 		var del = $(this).parent().parent().attr('id');
		// 		$("#"+del).alert('close');
	});


	function addAllInputs(divName){
		// 		var newdiv = document.createElement('div');
		// 		newdiv.innerHTML 
		$("#KoFraDiv").append("<div id='statement-" + (counterText + 1) + "' class='row alert alert-info'><div class='col-sm-11'><input class='form-control' type='text' placeholder='Aussage " + (counterText + 1) + "' name='antwortOption[" + (counterText + 1) + "]'></div><div class='col-sm-1'><span class='glyphicon glyphicon-resize-vertical'></span><span class='deleteStatement glyphicon glyphicon-trash' style='margin-left:20px; pointer:cursor;'></span></div></div>");
		// 		document.getElementById(divName).appendChild(newdiv);
		counterText++;

	}

	function deleteAnswerOption(divName){
		$( "#"+divName ).remove();
	}


	$(function () {
		$(".grid").sortable({
			connectWith: ".grid",
			start: function(e, ui){
				ui.placeholder.height(ui.item.height()+20);
				// 				alert(ui.item.height());
			},

			tolerance: 'pointer',
			revert: 'invalid',
			placeholder: 'totWidth placeholder',
			forceHelperSize: true,
			update: function (event, ui) {
				var data = $(this).sortable('serialize');
				console.log(data);
				// 				$("#StatementOrder").val(data);
				// erst durch die Übergabe an PHP wird aus dem "String" ein Array
				$.ajax({
					data: data,
					type: 'POST',
					url: 'add_order_statements_ajax.php',
					dataType: 'text',
					success:function(data2) {
						$("#StatementOrder").val(data2);
						console.log(data2);
					}
				}); 
			}
		});
	});



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