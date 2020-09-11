<?php
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/abgabe.php");
// $abRow=getAbgabeInfo($_SESSION['fID'],$_SESSION['t']);
$abRow=$AbgabeInfoRow;
$abInfo=json_decode($abRow['parameter'],true);
?>


<div class="row">
	<div class="col-md-12">
		<span><?php if(isset($bInfo['beschreibung'])){echo html_entity_decode ($bInfo['beschreibung'], ENT_QUOTES , "UTF-8");} ?></span>
	</div>
</div>

<table class="table table-striped">
	<thead>
		<tr>
			<td></td>
			<td>Aussagen in deiner Reihenfolge</td>
			<td>Soll<br>Position</td>
			<td></td>
		</tr>

	</thead>
	<?php
	$iLauf=1;
	// 	var_dump($abRow);
	if(isset($bInfo['CombinedOptions'])){
		foreach($abInfo['StatementOrder_'.$Block] as $optionID){
	?>
	<tr>
		<td><?php echo $iLauf; ?></td>
		<td><?php if(isset($bInfo['CombinedOptions'][$optionID])){echo html_entity_decode ($bInfo['CombinedOptions'][$optionID], ENT_QUOTES , "UTF-8");} ?></td>
		<td><?php echo array_search ( $optionID , $bInfo['order'] )+1; ?></td>
		<td>
			<?php 
			if( array_search ( $optionID , $bInfo['order'] )+1==$iLauf){
				echo "<img src='/images/correct.png' height=32px;>";
			}else{
				echo "<img src='/images/wrong.png' height=32px;>";
			} ?>
		</td>
	</tr>
	<?php
			$iLauf++;
		}
	}else{echo "PROBLEM!";}
	?>
</table>
