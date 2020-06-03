<?php
include_once($_SERVER['DOCUMENT_ROOT']."/php/abgabe.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/bausteine.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/folie.php");

$abRows=getAbgabeInfos($_SESSION['fID']);

$FolieInfos=getFolieInfo($_SESSION['fID']);
$parameter=json_decode($FolieInfos['parameter'],true);
$bID=$parameter["bID_$Block"];
$bsInfo=getBausteinInfo($bID);
$bInfo=json_decode($bsInfo['parameter'],true);
// $numberOptions=count($bs_parameter['antwortOption']);
// var_dump($bInfo['richtigeOption']);
$iLauf=1;
?>

<table class="table table-striped">
	<tr><th>Schüler</th><th>Token</th><?php foreach($bInfo['antwortOption'] as $option){ ?><th <?php if(in_array($iLauf,$bInfo['richtigeOption'])){echo "class='success'";} ?> > <span data-toggle="tooltip" data-placement="top" title="<?php echo $option ?>"> Option <?php echo $iLauf; $iLauf++; ?></span></th><?php } ?></tr>

	<?php
	foreach($abRows as $abRow){
		// 		KoFra_Option_1
		$abInfo=json_decode($abRow['parameter'],true);
		$tnInfo=getTeilnehmerInfosByToken($abRow['token']);
		$Name=$tnInfo['name'].", ".$tnInfo['vname'];
		$iLauf=1;
	?>
	<tr><td><?php echo $Name; ?></td><td><?php echo $abRow['token']; ?></td><?php foreach($bInfo['antwortOption'] as $option){ ?><td style="text-align:center;" <?php if(in_array($iLauf,$bInfo['richtigeOption'])){echo "class='success'";} ?> > <span data-toggle="tooltip" data-placement="top" title="<?php echo $option ?>" ><?php  if((!in_array($iLauf,$abInfo['KoFra_Option_'.$Block]) && !in_array($iLauf,$bInfo['richtigeOption'])) || (in_array($iLauf,$bInfo['richtigeOption']) && in_array($iLauf,$abInfo['KoFra_Option_'.$Block]))){echo "<img src='/images/correct.png' height=32px;>";}else{echo "<img src='/images/wrong.png' height=32px;>"; } $iLauf++; ?></span></td><?php } ?></tr>
	<?php
	}
	?>
</table>