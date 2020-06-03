<?php
include_once($_SERVER['DOCUMENT_ROOT']."/php/teilnehmer.php");

?>
<div class="form-group">
	<label for="viewTyp">Wer soll Zugriff auf die Folie haben?</label>
	<select class="form-control" id="viewTyp" name='viewTyp'>
		<option value=1 <?php if(isset($FolieArr['viewTyp'])){if($FolieArr['viewTyp']==1){echo "selected";}} ?>>alle Teilnehmer</option>
		<option value=2 <?php if(isset($FolieArr['viewTyp'])){if($FolieArr['viewTyp']==2){echo "selected";}} ?>>Auswahl</option>
		<option value=3 <?php if(isset($FolieArr['viewTyp'])){if($FolieArr['viewTyp']==3){echo "selected";}} ?>>alle bis auf Auswahl</option>
	</select>
</div>

<div class="form-group">
	<label for="tnarr">Auswahl der Teilnehmer</label>

	<select multiple class="form-control" id="tnarr" name='tnarr[]'>
		<?php
		echo $_SESSION['kursID'];
		$TeilnehmerListe=getTeilnehmerListeInfos($_SESSION['kursID']);
// 		var_dump($TeilnehmerListe);
		$tnarr=array();
		$tnarr=$AufgabeInfo->tnarr;
// 		echo $AufgabeInfo->tnarr;
		foreach($TeilnehmerListe as $TN){
		?>
		<option value="<?php echo $TN['tnID']; ?>" <?php if(is_array($tnarr)){if(in_array($TN['tnID'],$tnarr)){echo "selected";} }?>><?php echo $TN['vname']." ".$TN['name']; ?></option>
		<?php
		}
		?>
	</select>
</div>