<div class="row">
	<div class="col-md-12">
		<span><?php if(isset($bInfo['beschreibung'])){echo html_entity_decode ($bInfo['beschreibung'], ENT_QUOTES , "UTF-8");} ?></span>
	</div>
</div>
<div class="funkyradio">
	<?php 
	$kLauf=0;
	if(isset($bInfo['abstOption'])){
		foreach($bInfo['abstOption'] as $option)
		{
	?>
	<div class="funkyradio-success">
		<?php 
			if(isset($bInfo['multiple_abstOption']) && $bInfo['multiple_abstOption']==1){
		?>
		<input type="hidden" name="abstOption_<?php echo $Block; ?>[]" value='-1'/>
		<input type="checkbox" name="abstOption_<?php echo $Block; ?>[]" id="abst_Option_id_<?php echo $Block; ?>_<?php echo $kLauf;?>" value='<?php echo $kLauf; ?>'/>
		<?php
			}else{ ?>
		<input type="radio" name="abstOption_<?php echo $Block; ?>" id="abst_Option_id_<?php echo $Block; ?>_<?php echo $kLauf;?>" value='<?php echo $kLauf; ?>'/>
		<?php
				 }
		?>
		<label for="abst_Option_id_<?php echo $Block; ?>_<?php echo $kLauf; ?>"><?php if(isset($option)){echo html_entity_decode ($option, ENT_QUOTES , "UTF-8");} ?></label>
	</div>
	<?php
			$kLauf++;
		}
	}
	?>
</div>