<form id='BS_Form_<?php echo $Block; ?>' action='' method="POST" style='margin:0;' accept-charset="UTF-8" >
	<input type="hidden" value="<?php echo $folie_token; ?>" name="folie_token">
	<div class="form-group" style='padding-top:10px;'>
		<label for="Baustein_<?php echo $Block; ?>">Inhalt des Bereichs auswählen</label>
		<select class="form-control" name='Baustein_<?php echo $Block; ?>' id="Baustein_<?php echo $Block; ?>">
			<option value="">Bitte auswählen</option>
			<option value="1" <?php if(isset($_SESSION[$ftoken]['edit_Baustein_'.$Block]) && ($_SESSION[$ftoken]['edit_Baustein_'.$Block]==1)){echo "selected";} ?>>Freitext</option>
			<option value="2" <?php if(isset($_SESSION[$ftoken]['edit_Baustein_'.$Block]) && ($_SESSION[$ftoken]['edit_Baustein_'.$Block]==2)){echo "selected";} ?>>Video</option>
			<option value="3" <?php if(isset($_SESSION[$ftoken]['edit_Baustein_'.$Block]) && ($_SESSION[$ftoken]['edit_Baustein_'.$Block]==3)){echo "selected";} ?>>Simulation/Animation</option>
			<option value="4" <?php if(isset($_SESSION[$ftoken]['edit_Baustein_'.$Block]) && ($_SESSION[$ftoken]['edit_Baustein_'.$Block]==4)){echo "selected";} ?>>Eingabefeld für Schüler</option>
			<option value="5" <?php if(isset($_SESSION[$ftoken]['edit_Baustein_'.$Block]) && ($_SESSION[$ftoken]['edit_Baustein_'.$Block]==5)){echo "selected";} ?>>Baustein</option>
		</select>
		<script>
			$(function() {
				$("<?php echo "#Baustein_".$Block; ?>").change(function() {
					$("<?php echo "#BS_Form_".$Block; ?>").submit();
				});
			});
		</script>
	</div>
</form>
<?php
if(isset($_SESSION[$ftoken]['edit_Baustein_'.$Block])){
	switch($_SESSION[$ftoken]['edit_Baustein_'.$Block]){
		case 1:
			//Freitext -> nix zu tun!
			break;
		case 2:
			$tem_vID_Block=$Block;  // => tem_vID_top
			include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/video_auswahl_panel.php");
			break;
		case 3:
			$tem_simID_Block=$Block;  // => tem_vID_top
			include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/sim_auswahl_panel.php");
			break;
		case 4:
			break;
		case 5:
			$bsArrTyp=getBausteineTypen();
			echo "<p class='lead' style='margin:0'>Baustein auswählen</p>";
			include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/module/mod_bausteine/baustein_auswahl_panel.php");
			break;
	}
}
?>
