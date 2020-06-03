<?php
include_once($_SERVER['DOCUMENT_ROOT']."/php/teilnehmer.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/kursInfos.php");

?>
<div class="form-group">
	<label for="viewTyp">Wer soll Zugriff auf die Folie haben?</label>
	<select class="form-control" id="viewTyp" name='viewTyp'>
		<?php /* ?>
		<option value=1 <?php if(isset($FolieArr['viewTyp'])){if($FolieArr['viewTyp']==1){echo "selected";}} ?>>alle Teilnehmer</option>
		<option value=2 <?php if(isset($FolieArr['viewTyp'])){if($FolieArr['viewTyp']==2){echo "selected";}} ?>>Auswahl</option>
		<option value=3 <?php if(isset($FolieArr['viewTyp'])){if($FolieArr['viewTyp']==3){echo "selected";}} ?>>alle bis auf Auswahl</option>
		<?php */ ?>
		<option value=2 selected>Auswahl</option>
	</select>
</div>

<div class="form-group">
	<label for="tnarr">Auswahl der Teilnehmer</label>
		<?php /* ?>
	<select multiple class="form-control" id="tnarr" name='tnarr[]'>
				<?php */ ?>
	<select  class="form-control" id="tnarr" name='tnarr[]'>
		<?php
		echo $_SESSION['k'];
		$TeilnehmerListe=getTeilnehmerListeInfos($_SESSION['k']);
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
<?php 
if(isset($CopyToKursAllow) && $CopyToKursAllow==1){
?>
<hr>
<div class="form-group">
	<label for="tnarr">Folie in anderen Kurs speichern/kopieren</label>

	<select class="form-control" id="kursArr" name='CopyToKursID'>
		<option value="">Bitte Zielkurs auswählen!</option>
		<?php
		echo $_SESSION['kursID'];
		$KursListe=GetKursListeInfos($_SESSION['uID'],null,1);
		var_dump($KursListe);
		foreach($KursListe as $kurs){
		?>
		<option value="<?php echo $kurs['kursID']; ?>"><?php echo $kurs['titel']; ?></option>
		<?php
		}
		?>
	</select>
</div>
<hr>
<?php 
}
?>