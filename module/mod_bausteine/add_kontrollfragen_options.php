<div id="option_<?php echo $iLauf;?>">

	<div class="row">
		<div class='col-sm-11'>
			<input class='form-control' type='text' placeholder='Auswahloption <?php echo $iLauf+1; ?>' name='antwortOption[]' value='<?php if(isset($bsInfo['antwortOption'][$iLauf])){echo html_entity_decode ($bsInfo['antwortOption'][$iLauf], ENT_QUOTES , "UTF-8");} ?>'>
		</div>
		<div class='col-sm-1'>
			<input class='form-control'  name='richtigeOption[]' type='checkbox' data-toggle='toggle' data-on='richtig' data-off='falsch' data-onstyle='success' data-offstyle='danger' value='<?php echo $iLauf+1; ?>' data-size='small' <?php if(isset($bsInfo['richtigeOption']) && in_array($iLauf+1,$bsInfo['richtigeOption'])){echo "checked";}; ?>>
		</div>
	</div>
	<div class='row' style="margin-top:10px;">
		<div class='col-sm-11'>
			<textarea id='erlaeuterung_1' class='form-control' name='erlaeuterung[]' style='height:150px;' placeholder='Erläuterung / Erklärung eingeben'>
				<?php if(isset($bsInfo['erlaeuterung'][$iLauf])){echo html_entity_decode ($bsInfo['erlaeuterung'][$iLauf], ENT_QUOTES , "UTF-8");} ?>
			</textarea></div>
		<div class='col-sm-1'>
			<span onclick="deleteAnswerOption('option_<?php echo $iLauf;?>')" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></span>
</div>
	</div>
</div>