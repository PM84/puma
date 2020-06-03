<?php
// ========================
// ========================
// ====== EVALUATION
// ========================
// ========================
include_once($_SERVER['DOCUMENT_ROOT']."/php/frage.php");
$fGroups=Get_Fragen_Gruppen($_SESSION['uID']);
?>

<style>

	.list {
		background-color:#8FBC8F;
		margin:5px;
		padding:5px;
		cursor:move;
		border-radius:5px;
		list-style-type: none;

	}
	.listblock:not(.listcontainer) {
		background-color:lightgray;
		min-height: 30px;
		margin: 10px;
		/* padding:10px; */
		width:100%;
		vertical-align:top;
		display:inline-block;
		border-radius:5px;
	}

</style>
<script src="/js/jqueryUI/jquery-ui.js"></script>


<form action="" method="post">
	<div class="form-group">
		<label for="titel">Titel</label>
		<input id='titel' type="text" class="form-control" name="titel" placeholder="Titel des Bausteins" required value='<?php if(isset($bsInfo['titel'])){echo html_entity_decode ($bsInfo['titel'], ENT_QUOTES , "UTF-8");} ?>'>
	</div>
	<div class="form-group">
		<label for="beschreibung">Beschreibung</label>
		<textarea class="form-control" id="beschreibung" name="beschreibung">
			<?php if(isset($bsInfo['beschreibung'])){echo html_entity_decode ($bsInfo['beschreibung'], ENT_QUOTES , "UTF-8");} ?>
		</textarea>
	</div>
<p>
	Bitte wählen Sie die zugehörigen Fragengruppen aus:<br>(mit gedrückter Strg-Taste können auch mehrere ausgewählt werden.)
	</p>
	<select class="form-control" id="FrageGroupsSel" name="FrageGroupsSel[]" multiple>
		<?php
		foreach($fGroups as $fGroup){
			$FGroupInfo=json_decode($fGroup['parameter']);
			$selected="";
// 			$bsInfo_parameter=json_decode($bsInfo['parameter'],true);
			if(isset($bsInfo['FrageGroupsSel'])){ // das Argument muss noch angepasst werden, auf die bs info $bsInfo['parameter'] -> FrageGroupsSel
// 				$GroupArr=getFrageGroupsByFrageID(intval($_SESSION['FrageID']));
				echo $fGroup['FGroupID'];
				if(in_array($fGroup['FGroupID'],$bsInfo['FrageGroupsSel'])){$selected=" selected";}else{$selected="";}
			}
		?>
		<option value="<?php echo $fGroup['FGroupID']; ?>" <?php echo $selected; ?>><?php echo $FGroupInfo->GroupTitel; ?></option>

		<?php
		}
		?>
	</select>
	<br>

	<button class="btn btn-primary" type="submit" value=1 name='smBut'>Speichern</button>
</form>

<script>


</script>