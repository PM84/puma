

<?php
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/frage.php");

if(isset($_SESSION[$ftoken]['edit_Baustein_'.$Block])){
	
	// 	echo 'tem_vID_'.$Block;
	// 	echo $_SESSION[$ftoken]['tem_vID_'.$Block];
	


	switch($_SESSION[$ftoken]['edit_Baustein_'.$Block]){
		case 1:
?>

<input type="hidden" name="<?php echo 'Baustein_'.$Block; ?>" value='<?php echo $_SESSION[$ftoken]['edit_Baustein_'.$Block]; ?>'>
<div class="form-group">
	<label for="inhalt_<?php echo $Block;?>">Inhalt Block <i><?php echo $Block; ?></i></label>
	<textarea class="form-control" id="inhalt_<?php echo $Block;?>" name='inhalt_<?php echo $Block;?>'><?php if(isset($AufgabeInfo["inhalt_$Block"])){echo html_entity_decode ($AufgabeInfo["inhalt_$Block"], ENT_QUOTES , "UTF-8");} ?></textarea>
	<div>
		<input id="AnzMark_<?php echo $Block;?>" value="0" type="hidden">
		<h4>Markierungen in Bildern</h4>
		<p>
			Nach dem Speichern finden Sie hier eine Liste mit allen Bildern dieses Blocks. Durch einen Klick auf ein Objekt auf dem Bild können Sie Hover-Elemente an dieser Position des Bildes einfügen. 
		</p>
		<div class="imgWrapOut" id="imgDiv_<?php echo $Block;?>"></div>

	</div>
</div>
<style>


</style>

<script>
	function getSrc(textarea) {
		var temporaryElement = document.createElement('div');

		temporaryElement.innerHTML = textarea.value;

		var images = temporaryElement.getElementsByTagName('img');

		var output = [];

		for (var i = 0; i < images.length; i++) {
			output.push(images[i].src);
		}

		return output;
	}

	var MarkImg_Json_<?php echo $Block;?>="<?php echo html_entity_decode (json_encode($AufgabeInfo['ImgMark_'.$Block]), ENT_QUOTES , "UTF-8");?>;
	var ImgSrc=getSrc(document.getElementById("inhalt_<?php echo $Block;?>"));
	var outerDiv=document.getElementById("imgDiv_<?php echo $Block;?>")
	$( document ).ready(function() {

		for(i=0; i<ImgSrc.length;i++){

			var img = document.createElement('img');
			var src=ImgSrc[i];
			img.src = src;
			img.setAttribute('style',"width:100%;");
			var filename = src.match(/([^\/]+)(?=\.\w+$)/)[0];
			img.setAttribute('id',filename);
			img.setAttribute('class',"imgCls_<?php echo $Block;?>");

			var imgWrapper = document.createElement('div');
			imgWrapper.setAttribute('id',"wrap_"+filename);
			imgWrapper.setAttribute('class',"ImgWrapper");

			var innerDiv1 = document.createElement('div');
			innerDiv1.setAttribute('class',"col-xs-12 cont");
			innerDiv1.setAttribute('id',"image_"+filename);

			var innerDiv2 = document.createElement('div');
			innerDiv2.setAttribute('class',"col-xs-12 ImgBs");
			innerDiv2.setAttribute('id',"bs_"+filename);

			innerDiv1.appendChild(img);

			imgWrapper.append(innerDiv1);
			imgWrapper.append(innerDiv2);
			outerDiv.append(imgWrapper);
		}

		if(!jQuery.isEmptyObject(MarkImg_Json_<?php echo $Block;?>)){
			var MarkIDTmp;
			$.each(MarkImg_Json_<?php echo $Block;?>, function(MarkID,arr){ 
				console.log(<?php echo $Block;?>);
				createMark(arr['fn'], MarkID,arr['txt'],"<?php echo $Block;?>");
				console.log(arr['fn']+","+MarkID+","+arr['txt']+",<?php echo $Block;?>",1);
				filename=arr['fn'];
				MarkIDTmp=MarkID;
				SetMark(arr['x'],arr['y'],filename,MarkID);
			});
			$("#AnzMark_<?php echo $Block;?>").val(MarkIDTmp);
		}

	});

	$('.imgCls_<?php echo $Block;?>').click(function (e){
		var elm = $(this);
		var filename = $(this).attr('id');
		var elmWidth=elm.width();
		var elmHeight=elm.height();
		var xPos = e.pageX - elm.offset().left;
		var yPos = e.pageY - elm.offset().top;
		var xRel=Math.round((xPos*1000)/elmWidth)/10;
		var yRel=Math.round((yPos*1000)/elmHeight)/10;


		var AnzMarkNew=parseInt($('#AnzMark_<?php echo $Block;?>').val())+1;
		$('#AnzMark_<?php echo $Block;?>').val(AnzMarkNew);

		createMark(filename,AnzMarkNew,"","<?php echo $Block;?>",0);
		SetMark(xRel,yRel,filename,AnzMarkNew);
	});

</script>




<?php
			break;

		case 2:
			if(isset($_POST['tem_vID_'.$Block]) || isset($_SESSION[$ftoken]['edit_tem_vID_'.$Block])){
				if(isset($_POST['tem_vID_'.$Block])){
					$_SESSION[$ftoken]['edit_tem_vID_'.$Block]=intval($_POST['tem_vID_'.$Block]);
				}
				$videoInfo=Get_VideoInfos_By_vID($videos,$_SESSION[$ftoken]['edit_tem_vID_'.$Block]);
				
				$link_src=get_video_link($videoInfo,"sd");
				

?>
<input type="hidden" name="<?php echo 'Baustein_'.$Block; ?>" value='<?php echo $_SESSION[$ftoken]['edit_Baustein_'.$Block]; ?>'>
<input type="hidden" name="<?php echo 'tem_vID_'.$Block; ?>" value='<?php echo $_SESSION[$ftoken]['edit_tem_vID_'.$Block]; ?>'>
<video width="100%" muted controls>
	<source src="<?php echo $link_src; ?>" type="video/mp4">
	Ihr Browser unterstützt den Video Tag nicht. Bitte aktualisieren Sie Ihren Browser.
</video>
<?php
			}
			break;

		case 3:
			if(isset($_POST['tem_simID_'.$Block]) || isset($_SESSION[$ftoken]['edit_tem_simID_'.$Block])){
				if(isset($_POST['tem_simID_'.$Block])){
					$_SESSION[$ftoken]['edit_tem_simID_'.$Block]=intval($_POST['tem_simID_'.$Block]);
				}
				$simInfo=Get_SimInfos_By_vID($Sims,$_SESSION[$ftoken]['edit_tem_simID_'.$Block]);
				// 									$link_src=get_Sim_link($simInfo->link_src,"vid_m");

?>
<input type="hidden" name="<?php echo 'Baustein_'.$Block; ?>" value='<?php echo $_SESSION[$ftoken]['edit_Baustein_'.$Block]; ?>'>
<input type="hidden" name="<?php echo 'tem_simID_'.$Block; ?>" value='<?php echo $_SESSION[$ftoken]['edit_tem_simID_'.$Block]; ?>'>
<div class="iframe_container">
	<iframe class='iframe_window' src="<?php echo $simInfo->url; ?>"></iframe>

</div>
<?php
			}
			break;

		case 4:
?>
<input type="hidden" name="<?php echo 'Baustein_'.$Block; ?>" value='<?php echo $_SESSION[$ftoken]['edit_Baustein_'.$Block]; ?>'>
<div class='textarea_div_abgegeben textarea_div_abgegeben_margin'>An dieser Stelle wird jedem Teilnehmer ein Eingabefeld angezeigt.</div>
<?php
			break;

		case 5: //BAUSTEINE
			if(isset($_POST['bID_'.$Block]) || isset($_SESSION[$ftoken]['edit_bID_'.$Block])){
				if(isset($_POST['bID_'.$Block])){
					$_SESSION[$ftoken]['edit_bID_'.$Block]=intval($_POST['bID_'.$Block]);
					unset($_POST['bID_'.$Block]);
				}

?>
<input type="hidden" name="<?php echo 'Baustein_'.$Block; ?>" value='<?php echo $_SESSION[$ftoken]['edit_Baustein_'.$Block]; ?>'>
<input type="hidden" name="<?php echo 'bID_'.$Block; ?>" value='<?php echo $_SESSION[$ftoken]['edit_bID_'.$Block]; ?>'>
<?php 
				$bsRow=getBausteinInfo($_SESSION[$ftoken]['edit_bID_'.$Block]);		
				switch($bsRow['bTypID']){
					case 1:// Kontrollfrage
?>
<div class='textarea_div_abgegeben textarea_div_abgegeben_margin'>An dieser Stelle wird jedem Teilnehmer eine Kontrollfrage angezeigt.</div>
<?php						break;

					case 2: //Wordcloud
?>
<div class='textarea_div_abgegeben textarea_div_abgegeben_margin'>An dieser Stelle wird jedem Teilnehmer ein Eingabefeld angezeigt, das die Word Cloud speißt.</div>
<?php

						break;

					case 3: //Abstimmung
?>
<div class='textarea_div_abgegeben textarea_div_abgegeben_margin'>An dieser Stelle wird jedem Teilnehmer ein Abstimmungsfeld angezeigt.</div>
<?php
						break;
					case 4: //YouTube Videos
						$parameter=json_decode($bsRow['parameter'],true);
						if(array_key_exists('ytID', $parameter)){
?>
<iframe id="ytplayer" type="text/html" width="100%" height="<?php echo 1/(16/9)*100 ?>% src="https://www.youtube.com/embed/<?php echo $parameter['ytID'] ?>?rel=0&showinfo=0&color=white&iv_load_policy=3"
		frameborder="0" allowfullscreen>
</iframe> 
<?php
																}
						break;				
					case 5: //Evaluation
						$parameter=json_decode($bsRow['parameter'],true);
						$fArr=[];
						foreach($parameter['FrageGroupsSel'] as $FGroupID){
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
?>

<div class="row" style="padding:0; padding-bottom:5px; padding-top:5px; <?php if($f_iLauf+1<count($fArr)){echo "border-bottom: 1px dotted gray"; $f_iLauf++;}else{$f_iLauf++;} ?>">
	<div class="col-md-8" style="text-align:left;">
		<?php echo $FrageInfo->FrageTXT; ?><br><span style="font-size:0.8em; font-style:italic;"><?php echo $FrageInfo->FrageTipp; ?></span>
	</div>
	<div class="col-md-4" style="text-align:center;">

		<!--		<input id="Block_<?php echo $Block; ?>_f<?php echo $FrageID; ?>" type="text" />//-->
		<input id="Block_<?php echo $Block; ?>_f<?php echo $FrageID; ?>" type="text" name="FrageVal_<?php echo $Block; ?>[]" data-slider-id= "f_<?php  echo $Block; ?>_<?php echo $FrageID; ?>" <?php if(isset($FrageInfo->initToolTip)&&$FrageInfo->initToolTip=="off"){echo "data-slider-tooltip='hide'";}?> data-slider-handle="round" class="slider_noAnswer" data-slider-id="f_<?php echo $Block; ?>_<?php echo $FrageID; ?>_handle">

		<script>
			var slider = new Slider("#Block_<?php echo $Block; ?>_f<?php echo $FrageID; ?>", {
				step: 1,
				min: <?php echo intval($FrageInfo->FrageMin); ?>,
				max: <?php echo intval($FrageInfo->FrageMax); ?>,
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
				<?php }else{ $valLaufArr=[];
							if(isset($FrageInfo->noAnswer) && $FrageInfo->noAnswer=='on'){array_push($valLaufArr,intval($FrageInfo->FrageMin)-1);}
							for($valLauf=intval($FrageInfo->FrageMin);$valLauf<=intval($FrageInfo->FrageMax);$valLauf++){
								array_push($valLaufArr,$valLauf);
							}
							$ticksStr=join(",",$valLaufArr);

				?>
				ticks: [<?php echo $ticksStr; ?>],
				<?php } ?>				// 									ticks_positions: [0, 30, 60, 70, 90, 100],
				<?php if(abs(intval($FrageInfo->FrageMax)-intval($FrageInfo->FrageMin))>6){ ?>
				ticks_labels: ['<?php if(isset($FrageInfo->noAnswer) && $FrageInfo->noAnswer=='on'){echo '<span style="font-size:8px;">keine<br>Antwort</span>'; ?>', '<?php } echo html_entity_decode ($FrageInfo->FrageLabMin, ENT_QUOTES , "UTF-8"); ?>', '<?php echo html_entity_decode ($FrageInfo->FrageLabMax, ENT_QUOTES , "UTF-8");  ?>'],

				<?php }else{ $valLaufLabArr=[];
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
				ticks_snap_bounds: 0
			});

			if($( "input[id='f_<?php echo $Block; ?>_<?php echo $FrageID; ?>']" ).val()=="<?php echo intval($FrageInfo->FrageMin)-1; ?>){
			   console.log("init Value" + " => "+ $( "input[id='f_<?php echo $Block; ?>_<?php echo $FrageID; ?>']" ).val() + " // min: "+ <?php echo intval($FrageInfo->FrageMin)-1; ?>);
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
						}
						break;

					case 6: //iFrame Webseite einbinden
						$parameter=json_decode($bsRow['parameter'],true);
						if(array_key_exists('webUrl', $parameter))
						{
?>
<embed  width="100%" height="<?php echo 1/(16/9)*100 ?>% src="<?php echo $parameter['webUrl'] ?>">

<?php
						}
						break;

					case 8:
?>
<div class='textarea_div_abgegeben textarea_div_abgegeben_margin'>An dieser Stelle wird jedem Teilnehmer eine Liste von Aussagen angezeigt, die er/sie in die richtige Reihenfolge bringen muss..</div>
<?php
						break;

				} 

			}
	}
}
?>