<div class="row">
	<div class='col-sm-12'>
		<input class='form-control' type='text' placeholder='Auswahloption <?php echo $iLauf+1; ?>' name='abstOption[]' value='<?php if(isset($bsInfo['abstOption'][$iLauf])){echo html_entity_decode ($bsInfo['abstOption'][$iLauf], ENT_QUOTES , "UTF-8");} ?>'>
	</div>
</div>