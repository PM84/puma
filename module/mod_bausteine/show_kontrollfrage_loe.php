<?php
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/abgabe.php");
$abRow=getAbgabeInfo($_SESSION['fID'],$_SESSION['t']);
$abInfo=json_decode($abRow['parameter'],true);
?>


<div class="row">
	<div class="col-md-12">
		<span><?php if(isset($bInfo['beschreibung'])){echo html_entity_decode ($bInfo['beschreibung'], ENT_QUOTES , "UTF-8");} ?></span>
	</div>
</div>

<div class="row" style='padding: 5 0; <?php if($iLauf<count($bInfo['antwortOption'])){echo "border-bottom: dotted gray 1px;";} ?>'>
	<div class="col-md-9"></div>
	<div class="col-md-2">deine Antwort(en)</div>
	<div class="col-md-1"></div>

</div>
<?php
$iLauf=1;
if(isset($bInfo['antwortOption'])){
	for($iLauf=0;$iLauf<count($bInfo['antwortOption']); $iLauf++)
	{

?>
<div class="row" style='padding: 5 0; <?php if($iLauf<count($bInfo['antwortOption'])){echo "border-bottom: dotted gray 1px;";} if(in_array($iLauf+1,$bInfo['richtigeOption'])){echo "background-color: lightgreen;";}?>'>
	<div class="col-md-8">
		<label for="opt_<?php echo $iLauf; ?>"><?php if(isset($bInfo['antwortOption'][$iLauf])){echo html_entity_decode ($bInfo['antwortOption'][$iLauf], ENT_QUOTES , "UTF-8");} ?></label>

		<span style="display: none" id="erl_<?php echo  $Block."_".$iLauf; ?>"><?php if(isset($bInfo['erlaeuterung'][$iLauf])){echo html_entity_decode ($bInfo['erlaeuterung'][$iLauf], ENT_QUOTES , "UTF-8");} ?></span>
	</div>

	<div class="col-md-1">
		<?php if(isset($bInfo['erlaeuterung'][$iLauf]) && strlen($bInfo['erlaeuterung'][$iLauf])>0){?><span class='btn glyphicon glyphicon-info-sign' style='margin-right:5px;' onclick="TogErl_<?php echo  $Block."_".$iLauf; ?>()"></span><?php } ?>
	</div>

	<div class="col-md-2" style='min-width:70px;'>
		<input name='KoFra_Option_<?php echo $Block; ?>[]' id="opt_<?php echo $iLauf; ?>" type="checkbox" class='form-control' data-toggle='toggle' data-on='stimmt' data-off='stimmt nicht' data-onstyle='success' data-offstyle='danger' value='<?php echo $iLauf; ?>' disabled <?php if(in_array($iLauf+1,$abInfo['KoFra_Option_'.$Block])){echo "checked";} ?>>
	</div>
	<div class="col-md-1" >
		<?php if((!in_array($iLauf+1,$abInfo['KoFra_Option_'.$Block]) && !in_array($iLauf+1,$bInfo['richtigeOption'])) || (in_array($iLauf+1,$bInfo['richtigeOption']) && in_array($iLauf+1,$abInfo['KoFra_Option_'.$Block]))){echo "<img src='/images/correct.png' height=32px;>";}else{echo "<img src='/images/wrong.png' height=32px;>";} ?>
	</div>
</div>
<script>
	function TogErl_<?php echo $Block."_".$iLauf; ?>(){
		$( "#erl_<?php echo  $Block."_".$iLauf; ?>" ).toggle( );
	}
</script>
<?php
	}
}
?>
