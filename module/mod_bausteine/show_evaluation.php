<?php
include_once($_SERVER['DOCUMENT_ROOT']."/php/frage.php");
// var_dump($bInfo);
// $parameter=json_decode($bInfo['parameter'],true);
$fArr=array();
foreach($bInfo['FrageGroupsSel'] as $FGroupID){
	$FrageID_arr=getFragenByGroups($FGroupID);
	foreach($FrageID_arr as $FrageID_tmp){
		if(!in_array(intval($FrageID_tmp), $fArr, true)){
			array_push($fArr, intval($FrageID_tmp));
		}
	}
}


$f_iLauf=0;
foreach($fArr as $FrageID){
	$FrageRow=getFrageInfo($FrageID);
	$FrageInfo=json_decode($FrageRow['parameter']);
	switch($FrageRow['SkalaTyp']){
		case 1:

?>
<div class="row" style="padding:0; padding-bottom:5px; padding-top:5px; <?php if($f_iLauf+1<count($fArr)){echo "border-bottom: 1px dotted gray"; $f_iLauf++;}else{$f_iLauf++;} ?>">
	<div class="col-lg-7 col-md-6" style="text-align:left;">
		<?php echo $FrageInfo->FrageTXT; ?><br><span style="font-size:0.8em; font-style:italic;"><?php echo $FrageInfo->FrageTipp; ?></span>
	</div>
	<div class="col-lg-5 col-md-6" style="text-align:center;">
		<input type=hidden name='FrageID_<?php echo $Block; ?>[]' value='<?php echo $FrageID; ?>'>
		<input type=hidden name='f_<?php echo $Block; ?>_<?php echo $FrageID; ?>_minVal' value='<?php echo intval($FrageInfo->FrageMin); ?>'>
		<input id="f_<?php echo $Block; ?>_<?php echo $FrageID; ?>" type="text" name="FrageVal_<?php echo $Block; ?>[]" data-slider-id= "f_<?php  echo $Block; ?>_<?php echo $FrageID; ?>" <?php if(isset($FrageInfo->initToolTip)&&$FrageInfo->initToolTip=="off"){echo "data-slider-tooltip='hide'";}?> data-slider-handle="round" class="slider_noAnswer" data-slider-id="f_<?php echo $Block; ?>_<?php echo $FrageID; ?>_handle">

		<script>
			var slider = new Slider("#f_<?php echo $Block; ?>_<?php echo $FrageID; ?>", {
				step: 1,
				min: <?php echo intval($FrageInfo->FrageMin); ?>,
				max: <?php echo intval($FrageInfo->FrageMax); ?>,
				track:false,
				<?php if(isset($FrageInfo->hideSelection)){?> selection:false,<?php ;}?>
				value: <?php 
			if(isset($FrageInfo->noAnswer) && $FrageInfo->noAnswer=='on'){
				echo (intval($FrageInfo->FrageMin)-1);
				// 				$initval=intval($FrageInfo->FrageMin)-1;
			}elseif(isset($FrageInfo->initVal)&&$FrageInfo->initVal=="off"){
				echo (intval($FrageInfo->FrageMax)-intval($FrageInfo->FrageMin))/2+intval($FrageInfo->FrageMin);
				// 				$initval=(intval($FrageInfo->FrageMax)-intval($FrageInfo->FrageMin))/2+intval($FrageInfo->FrageMin);
			}else{
				echo intval($FrageInfo->FrageMin);
				// 				$initval=intval($FrageInfo->FrageMin);
			} ?>,
				<?php if(abs(intval($FrageInfo->FrageMax)-intval($FrageInfo->FrageMin))>6){ 

				?>
				ticks: [<?php if(isset($FrageInfo->noAnswer) && $FrageInfo->noAnswer=='on'){echo (intval($FrageInfo->FrageMin)-1).",";} echo intval($FrageInfo->FrageMin); ?>, <?php echo intval($FrageInfo->FrageMax); ?>],
				<?php }else{ $valLaufArr=array();
							if(isset($FrageInfo->noAnswer) && $FrageInfo->noAnswer=='on'){array_push($valLaufArr,intval($FrageInfo->FrageMin)-1);}
							for($valLauf=intval($FrageInfo->FrageMin);$valLauf<=intval($FrageInfo->FrageMax);$valLauf++){
								array_push($valLaufArr,$valLauf);
							}
							$ticksStr=join(",",$valLaufArr);

				?>
				ticks: [<?php echo $ticksStr; ?>],
				<?php } ?>


				<?php if(abs(intval($FrageInfo->FrageMax)-intval($FrageInfo->FrageMin))>6){ ?>
				ticks_labels: ['<?php if(isset($FrageInfo->noAnswer) && $FrageInfo->noAnswer=='on'){echo '<span style="font-size:8px;">keine<br>Antwort</span>'; ?>', '<?php } echo html_entity_decode ($FrageInfo->FrageLabMin, ENT_QUOTES , "UTF-8"); ?>', '<?php echo html_entity_decode ($FrageInfo->FrageLabMax, ENT_QUOTES , "UTF-8");  ?>'],

				<?php }else{ $valLaufLabArr=array();
							if(isset($FrageInfo->noAnswer) && $FrageInfo->noAnswer=='on'){array_push($valLaufLabArr,'<span style="font-size:8px;">keine<br>Antwort</span>');}
							array_push($valLaufLabArr,html_entity_decode ($FrageInfo->FrageLabMin, ENT_QUOTES , "UTF-8"));
							for($valLauf=intval($FrageInfo->FrageMin);$valLauf<intval($FrageInfo->FrageMax)-1;$valLauf++){
								array_push($valLaufLabArr,null);
							}
							array_push($valLaufLabArr,html_entity_decode ($FrageInfo->FrageLabMax, ENT_QUOTES , "UTF-8"));
							$ticksLabStr=join("','",$valLaufLabArr);

				?>
				ticks_labels: ['<?php echo $ticksLabStr; ?>'],
				<?php } ?>
				// 				ticks_positions: [0, 2, 4, 6, 8, 10], 
				// 				ticks_labels: ['<?php echo html_entity_decode ($FrageInfo->FrageLabMin, ENT_QUOTES , "UTF-8"); ?>', '<?php echo html_entity_decode ($FrageInfo->FrageLabMax, ENT_QUOTES , "UTF-8");  ?>'],
				ticks_snap_bounds: 0
			});
			if($( "input[id='f_<?php echo $Block; ?>_<?php echo $FrageID; ?>']" ).val()==<?php echo intval($FrageInfo->FrageMin)-1; ?>){
// 	 			console.log("init Value" + " => "+ $( "input[id='f_<?php echo $Block; ?>_<?php echo $FrageID; ?>']" ).val() + " // min: "+ <?php echo intval($FrageInfo->FrageMin)-1; ?>);
				$( "div[id='f_<?php echo $Block; ?>_<?php echo $FrageID; ?>']" ).addClass( 'slider_noAnswer' );
				$( "div[id='f_<?php echo $Block; ?>_<?php echo $FrageID; ?>']" ).addClass( 'slider_noAnswer_firstTick' );
			}else{
				$( "div[id='f_<?php echo $Block; ?>_<?php echo $FrageID; ?>']" ).removeClass( 'slider_noAnswer' );
			}
			if("<?php if(isset($FrageInfo->hideTrack)){echo $FrageInfo->hideTrack;}else{echo "off";} ?>"=="on"){
				$( "div[id='f_<?php echo $Block; ?>_<?php echo $FrageID; ?>']" ).addClass( 'hideTrack' );
			}
			if("<?php if(isset($FrageInfo->hideSelection)){echo $FrageInfo->hideSelection;}else{echo "off";}  ?>"=="on"){
				$( "div[id='f_<?php echo $Block; ?>_<?php echo $FrageID; ?>']" ).addClass( 'hideSelection' );
			}

		</script>
	</div>
</div>
<?php 
			break;
		case 3:
?>
<div class="row" style="padding:0; padding-bottom:5px; padding-top:5px; <?php if($f_iLauf+1<count($fArr)){echo "border-bottom: 1px dotted gray"; $f_iLauf++;}else{$f_iLauf++;} ?>">
	<div class="col-md-8" style="text-align:left;">
		<?php echo $FrageInfo->FrageTXT; ?><br><span style="font-size:0.8em; font-style:italic;"><?php echo $FrageInfo->FrageTipp; ?></span>
	</div>
	<div class="col-md-4" style="text-align:center;">
		<input type=hidden name='FrageID_<?php echo $Block; ?>[]' value='<?php echo $FrageID; ?>'>
		<input id="f_<?php echo $Block; ?>_<?php echo $FrageID; ?>" type="text" name="FrageVal_<?php echo $Block; ?>[]" class="form-control">
	</div>
</div>
<?php 

			break;
	}
} ?>


<script>
	$( "input" )
		.change(function() {
		var value= $(this).val();
		// 		console.log(value);
		var selector=this.id;
		var selector_min=this.id + "_minVal";
		var minVal= $("input[name='"+selector_min+"']").val()-1;
		// 		console.log(this.id + "_minVal :" + minVal);
		if($( this ).val()==minVal){
// 			$( "div[id='"+selector+"']" ).addClass( 'slider_noAnswer' );
		}else{
			$( "div[id='"+selector+"']" ).removeClass( 'slider_noAnswer' );
		}
	})
		.keyup();
</script>