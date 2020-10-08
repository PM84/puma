<?php
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/module/mod_fotowettbewerb/fw.php");

$zuFolienArr=Get_zugeordnete_Folien_join_master($fID,2);
$Punkte=[];
$Punkte_Durchschnitt=[];

$AnzahlBewertungen=0;

foreach($zuFolienArr as $folieRow){
	$fID_temp=$folieRow['fID'];
	$Punkte_Durchschnitt[$fID_temp]=[];
	$Anzahl[$fID_temp]=[];
	
	// 	echo "<h2>{$folieRow['uID']}</h2>";
	$abgabeArr=getAbgabeInfos($fID_temp);

	$AnzahlBewertungen=$AnzahlBewertungen+count($abgabeArr);

	foreach($abgabeArr as $abgabeRow){
		$parameter=json_decode($abgabeRow['parameter'],true);
		// 		$iLauf=0;
		foreach($parameter['FragenWerte_1'] as $key=>$value){
			// 			$Antworten[$abgabeRow][$key]=$value
			$Punkte[$fID_temp][$key]=$Punkte[$fID_temp][$key] + $value;
			$Anzahl[$fID_temp][$key]=$Anzahl[$fID_temp][$key]+1;
		}
	}

	foreach($Anzahl[$fID_temp] as $key=>$value){
		if($value>0){
			$Punkte_Durchschnitt[$fID_temp][$key]=$Punkte[$fID_temp][$key] / $value;
		}
	}
}

$anzahlAbgabe=[];
foreach($Anzahl as $key => $value){
	foreach($value as $key2=>$value2){
		$anzahlAbgabe[$key]=$value2;
	}
}

// echo "==>".$AnzahlBewertungen."<==";
foreach($zuFolienArr as $folieRow){
	$fID_temp=$folieRow['fID'];
	// 	$Punkteschnitt_gesamt[$fID_temp]=[];
	$AnzahlAufgaben=count($Punkte_Durchschnitt[$fID_temp]);
	foreach($Punkte_Durchschnitt[$fID_temp] as $key => $value){
		$Punkteschnitt_gesamt[$fID_temp]= $Punkteschnitt_gesamt[$fID_temp] + $value;
	}
	if($Punkteschnitt_gesamt[$fID_temp]>0){
		$Punkteschnitt_gesamt[$fID_temp]=$Punkteschnitt_gesamt[$fID_temp]/$AnzahlAufgaben;
	}else{
		$Punkteschnitt_gesamt[$fID_temp]=0;
	}

}

foreach($zuFolienArr as $folieRow){
	$fID_temp=$folieRow['fID'];
	// 	$Punkte_gesamt[$fID_temp]=[];
	$AnzahlAufgaben=count($Punkte[$fID_temp]);
	foreach($Punkte[$fID_temp] as $key => $value){
		$Punkte_gesamt[$fID_temp]= $Punkte_gesamt[$fID_temp] + $value;
	}
	$Punkte_gesamt[$fID_temp]=$Punkte_gesamt[$fID_temp];
	// 	$anzahlAbgabe[$fID_temp]=$AnzahlAufgaben;
}

switch(isset($_GET['s']) && $_GET['s']){
	case 1:
		arsort($Punkteschnitt_gesamt);
		$Punkte_transfer=$Punkteschnitt_gesamt;
		break;
	default:
		arsort($Punkte_gesamt);
		$Punkte_transfer=$Punkte_gesamt;
		break;
}


?>

<p class="lead">Tabelle der Bewertungen der Bilder:</p>
<div style='width:100%;' id="fw">
	<a class="btn btn-default" href="?s=1">Sortieren nach Punkteschnitt</a>
	<a class="btn btn-default" href="?s=0">Sortieren nach Gesamtpunktzahl</a>
</div>

<table class="table table-striped">
	<tr><td>Platz</td><td>Bild</td><td>Name</td><td>Schule</td><td>JgSt</td><td>Punkte Gesamt</td></tr>
	<?php $iLauf=1; foreach($Punkte_transfer as $key => $value){ 

	$folInfo=getFolieInfo($key);
	$parameter=json_decode($folInfo['parameter'],true);
	$abInfo=getAbgabeInfo($key,$parameter['token']);
	$abInfo=getAbgabeInfoByAbID($parameter['zu_abID']);
	$abParameter=json_decode($abInfo['parameter'],true);
	?>
	<tr>
		<td><?php echo $iLauf; ?>.</td>
		<td><img src="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/media/uploads/fotowettbewerb/<?php echo $abParameter['bild']; ?>" style="width:200px;"></td>
		<td><?php echo $abParameter['name']." ($key)"."<br>".$abParameter['email']."<br>".$abInfo['token']; ?></td>
		<td><?php echo $abParameter['schule']; ?></td>
		<td><?php echo $abParameter['jgst']; ?></td>
		<td><?php echo round($value*100)/100 ." (#{$anzahlAbgabe[$key]})"; ?></td>
	</tr>
	<?php $iLauf++;} ?>
</table>

<script>
	setInterval(function() {
		jQuery.ajax({
			type: 'POST',
			url: '/module/mod_fotowettbewerb/check_for_new_bewertung.php',
			data: {
				fID:"<?php echo $fID ;?>",
				istAnzahl:"<?php echo $AnzahlBewertungen; ?>"
			},
			dataType: 'text',
			success: function (data) {
				console.log(data);
				if(data==1){
					window.location.reload(1);
				}
			},
			async:true
		});
	}, 5000);

	// 	alert("<?php $AnzahlBewertungen; ?>");
</script>