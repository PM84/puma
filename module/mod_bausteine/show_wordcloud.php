<div class="row">
	<div class="col-md-12">
		<div>
			<p><?php echo  html_entity_decode ($bInfo['beschreibung'], ENT_QUOTES , "UTF-8");?></p>
		</div>
		<div class="input-group mb-2 mr-sm-2 mb-sm-0">
			<div  class="input-group-addon"><span class='glyphicon glyphicon-cloud'></span></div>
			<textarea name="WordCloud_<?php echo $Block; ?>" class='form-control' style='width:100%; height:100px;' form="praesForm"></textarea><br>

		</div>
		<span style='display:block; width:100%; text-align:center;'>Mehrere Begriffe müssen durch ein "," (Komma) getrennt werden.</span>
		<br>
		<input type='button' value='Begriffe eintragen' onclick="ChangeSubmitValue(0)">
		<div>
			<?php 
			if(isset($AbgabeInfo['WordCloud_'.$Block])){
				foreach($AbgabeInfo['WordCloud_'.$Block] as $WC_abgabe){
					?>
					<span class='d-block bg-warning' style="display:block; width:100%; padding:5px;margin:2 0 2 0"><?php echo html_entity_decode ($WC_abgabe, ENT_QUOTES , "UTF-8"); ?></span>
			<?php
				} 
			}
			?>
		</div>
	</div>
</div>

<script>
	function ChangeSubmitValue(value){
		$("#abgegeben").val(value);
		$("<?php echo "#praesForm"; ?>").submit();
		// 		$("#praesForm").submit();
	}
</script>