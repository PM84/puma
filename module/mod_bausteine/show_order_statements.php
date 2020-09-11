<script src="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/js/jqueryUI/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/js/jqueryUI/jquery-ui.css">
<style>
	.placeholder{
		/* background-color:lightgray; */
	}
</style>
<div class="row">
	<div class="col-md-12">
		<span><?php if(isset($bInfo['beschreibung'])){echo html_entity_decode ($bInfo['beschreibung'], ENT_QUOTES , "UTF-8");} ?></span>
	</div>
</div>
<div class="row grid_<?php echo $Block; ?>" style="overflow:hidden; margin-left:5px; margin-right:5px">
	<?php 
	$iLauf=1;
	// 	var_dump($bInfo['antwortOption']);


	if(isset($bInfo['CombinedOptions'])){

		// 		var_dump($bInfo['order']);
		$OptionsOrder=$bInfo['CombinedOptions'];
		// 		var_dump($OptionsOrder);
		$OptionsOrder=shuffle_assoc($OptionsOrder);
		// 		echo "<hr>";
		// 		var_dump($OptionsOrder);
		$shuffledOrder=array();
		foreach($OptionsOrder as $optionID=>$optionTXT){
			array_push($shuffledOrder,$optionID);
	?>
	<div  id="statement-<?php echo $optionID; ?>" class="row alert alert-info" >
		<div class="col-xs-11">
			<div><?php echo html_entity_decode ($optionTXT, ENT_QUOTES , "UTF-8"); ?></div>
		</div>
		<div class='col-xs-1'><span class="glyphicon glyphicon-resize-vertical"></span>
		</div>
	</div>
	<?php
		}
	?>
	<input id="StatementOrder_<?php echo $Block; ?>" name="StatementOrder_<?php echo $Block; ?>" type="hidden" value="<?php if(isset($shuffledOrder)){echo json_encode($shuffledOrder);}  ?>">

	<?php
	}
	?>

</div>

<script>
	$(function () {
		$(".grid_<?php echo $Block; ?>").sortable({
			connectWith: ".grid_<?php echo $Block; ?>",
			start: function(e, ui){
				ui.placeholder.height(ui.item.height()+20);
				// 				alert(ui.item.height());
			},			tolerance: 'pointer',
			revert: 'invalid',
			placeholder: 'totWidth placeholder',
			forceHelperSize: true,
			update: function (event, ui) {
				var data = $(this).sortable('serialize');
// 				console.log(data);
				// 				$("#StatementOrder").val(data);
				// erst durch die Übergabe an PHP wird aus dem "String" ein Array
				$.ajax({
					data: data,
					type: 'POST',
					url: '/module/mod_bausteine/add_order_statements_ajax.php',
					dataType: 'text',
					success:function(data2) {
						$("#StatementOrder_<?php echo $Block; ?>").val(data2);
// 						console.log(data2);
					}
				}); 
			}
		});
	});

</script>


<?php 

?>