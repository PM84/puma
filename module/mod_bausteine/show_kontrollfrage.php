<div class="row">
	<div class="col-md-12">
		<span><?php if(isset($bInfo['beschreibung'])){echo html_entity_decode ($bInfo['beschreibung'], ENT_QUOTES , "UTF-8");} ?></span>
	</div>
</div>
<?php 
$iLauf=1;
if(isset($bInfo['antwortOption'])){
	foreach($bInfo['antwortOption'] as $option)
	{
?>
<div class="row" style='padding: 5 0; <?php if($iLauf<count($bInfo['antwortOption'])){echo "border-bottom: dotted gray 1px;";} ?>'>
	<div class="col-md-10">
		<label for="opt_<?php echo $iLauf; ?>"><?php if(isset($option)){echo html_entity_decode ($option, ENT_QUOTES , "UTF-8");} ?></label>
	</div>
	<div class="col-md-2" style='min-width:70px;'>
		<input name='KoFra_Option_<?php echo $Block; ?>[]' id="opt_<?php echo $iLauf; ?>" type="hidden" value=0>
		<input name='KoFra_Option_<?php echo $Block; ?>[]' id="opt_<?php echo $iLauf; ?>" type="checkbox" class='form-control' data-toggle='toggle' data-on='stimmt' data-off='stimmt nicht' data-onstyle='success' data-offstyle='danger' value='<?php echo $iLauf; ?>'>
	</div>

</div>
<?php
	 $iLauf++;
	}
}
?>

