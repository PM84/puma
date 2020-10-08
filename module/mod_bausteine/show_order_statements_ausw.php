<?php
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/abgabe.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/bausteine.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/folie.php");

$abRows=getAbgabeInfos($_SESSION['fID']);

$FolieInfos=getFolieInfo($_SESSION['fID']);
$parameter=json_decode($FolieInfos['parameter'],true);
$bID=$parameter["bID_$Block"];
$bsInfo=getBausteinInfo($bID);
$bInfo=json_decode($bsInfo['parameter'],true);
// $numberOptions=count($bs_parameter['antwortOption']);

?>
<style>
	.correctOrderLabel{
		text-align: center;
		vertical-align: middle;
		font-size: 35px;
	}
.tooltip {
/* 	z-index:500; */
/*     position: fixed; */
}
</style>

<table class="table table-striped">
	<thead>
		<tr>
			<th colspan=2>richtige Reihenfolge: </th>
			<?php foreach($bInfo['CombinedOptions'] as $optionID => $optionTXT){ ?>
			<th rowspan=2 class="correctOrderLabel">
				<div data-toggle="tooltip" data-placement="top" title="<?php echo $optionTXT; ?>" >
					<?php echo $optionID; ?>
				</div>
			</th>
			<?php } ?>
		</tr>
		<tr>
			<th>Schüler</th>
			<th>Token</th>
			<?php /* foreach($bInfo['CombinedOptions'] as  $optionID => $optionTXT){ ?><th> <span data-toggle="tooltip" data-placement="top" title="<?php echo $optionTXT ?>"> Aussage <?php echo $optionID; ?></span></th><?php } */ ?>
		</tr>
	</thead>
	<?php
	foreach($abRows as $abRow){
		// 		KoFra_Option_1
		$abInfo=json_decode($abRow['parameter'],true);
		$tnInfo=getTeilnehmerInfosByToken($abRow['token']);
		$Name=$tnInfo['name'].", ".$tnInfo['vname'];
		$iLauf=0;
	?>
	<tr>
		<td><?php echo $Name; ?></td>
		<td><?php echo $abRow['token']; ?></td>
		<?php 
		// 		echo "===$Block==="; 
		
		foreach($abInfo['StatementOrder_'.$Block] as  $optionID){ ?>
		<td style="text-align:center;" <?php if(array_search ( $optionID , $bInfo['order'] )==$iLauf){echo "class='success'";} ?> > 
			<div class="tooltipSpan" data-toggle="tooltip" data-placement="top" title="<?php echo $bInfo['CombinedOptions'][$optionID]; ?>" >
				<?php 
																 
																 if( array_search ( $optionID , $bInfo['order'] )==$iLauf){
																	 echo "<span class='correctOrderLabel'>$optionID</span><img src='".$_SESSION['DOCUMENT_ROOT_DIR']."/images/correct.png' height=20px;>";
																 }else{
																	 echo "<span class='correctOrderLabel'>$optionID</span><img src='".$_SESSION['DOCUMENT_ROOT_DIR']."/images/wrong.png' height=20px;>"; 
																 } 
																 $iLauf++; 
				?>
			</div>
		</td><?php } ?>
	</tr>
	<?php
	}
	?>
</table>