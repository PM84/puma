<div id="statement-<?php echo $StatementID;?>"  data-StatID='<?php echo $StatementID;?>' class="row alert alert-info alert-dismissible" >
	<div class='col-sm-11'>
		<input class='form-control' type='text' placeholder='Aussage <?php echo $StatementID; ?>' name='antwortOption[<?php echo $StatementID; ?>]' value='<?php if(isset($StatementTXT)){echo html_entity_decode ($StatementTXT, ENT_QUOTES , "UTF-8");} ?>'>
	</div>
	<div class='col-sm-1'><span class="glyphicon glyphicon-resize-vertical"></span><span class="deleteStatement glyphicon glyphicon-trash" style="margin-left:20px; pointer:cursor;"></span></div>
	</div>