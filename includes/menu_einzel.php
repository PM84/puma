<?php 
$FolienListe=[];
$FBArrTMP=[];
// $FolienListe=getFolienListe($_SESSION['t']);
$FolienListe=getFolienListe_ORDER($_SESSION['t']);
$FolienListe=ArrayPush_Ablauf_Status($FolienListe);
$FolienListe=Remove_inaktiv_from_FolieListe($FolienListe);

// echo "xxx";
$FolienListe=Remove_aTyp_from_FolieListe($FolienListe,2);

$FolienListe=Remove_aTyp_from_FolieListe($FolienListe,3);


// $bewArr=array_push($FolienListe,GetFolieListe_by_aTyp($_SESSION['kursID'],2));
$bewArr=GetFolieListe_by_aTyp($_SESSION['kursID'],2);
$FBArrTmp=GetFolieListe_by_aTyp($_SESSION['kursID'],3);
// foreach($bewArrtmp as $bewRow){array_push($FolienListe,$bewRow);}
// foreach($FBArrTmp as $FBRow){array_push($FolienListe,$FBRow);}

// array_push($FolienListe,$FBArrTmp);
// 			$bewArr=getAbgabeBy_abID_token_aTyp($token,1);

foreach($FolienListe as $folie){
	$parameterFolie=json_decode($folie['parameter']);
	$modID=$folie['modID'];
	$modInfo=getModulInfos($modID);
	if(isset($parameterFolie->tnarr)){
		$tnarr=$parameterFolie->tnarr;
	}else{
		$tnarr=[];
	}

	if($folie['viewTyp']==1 || ($folie['viewTyp']==2 && in_array ( $tnInfo['tnID'] , $tnarr )) || ($folie['viewTyp']==3 && !in_array (  $tnInfo['tnID'] ,$tnarr)) )
	{
?>
<li><a href="<?php echo "/".$modInfo['mod_dir']."/".$modInfo['mod_show']."?f=".$folie['fID']; ?>" class='btn btn-default btn-margin-menu'><?php echo $parameterFolie->titel; ?></a></li>
<?php
	}else{
// 		echo "Anzeige nicht erlaubt";
	}
}

//===========================================
//======= BEWERTUNGS MENÜ
//===========================================

$bewArr=Remove_zugriff_from_folieListe($bewArr);

$bewArr=Remove_nicht_abgegebene($bewArr);


if(count($bewArr)>0){
?>
<li>
	<div class="dropdown">
		<button class="btn btn-default dropdown-toggle  btn-margin-menu" type="button" id="dropdownMenu_Bew" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style='width: 289px;'>
			Bewertung / Review
			<span class="caret"></span>
		</button>
		<ul class="dropdown-menu" aria-labelledby="dropdownMenu_Bew" style='margin-left: 10px; width: 280px;'>
			<?php
	foreach($bewArr as $bewFolie){
		$modID=$bewFolie['modID'];

		$parameter=json_decode($bewFolie['parameter'],true);
		$modInfo=getModulInfos($modID);
		// 		$modInfo=$bewFolie['modInfo'];
		$zu_fID=$bewFolie['zu_fID'];
		$abArr=getAbgabeInfos($zu_fID);
		
		foreach($abArr as $abgabe){
			if($abgabe['abTyp']==1){
			?>
			<li><a href="<?php echo "/".$modInfo['mod_dir']."/".$modInfo['mod_show']."?f=".$bewFolie['fID']."&ab=".$abgabe['abID']; ?>" class='btn btn-default btn-margin-menu' style="text-overflow:ellipsis; white-space: nowrap; overflow: hidden;">Bewertung von: <i><?php echo $parameter['titel']; ?></i></a></li>

			<?php
			}
		}
	}
			?>
		</ul>
	</div>
</li>
<?php
}

//===========================================
//======= FEEDBACK MENÜ
//===========================================

$FBArr=[];
$FBArr=get_folieListe_Infos_by_kurs_aTyp($_SESSION['kursID'],3);
$FBArr=Remove_zugriff_from_folieListe($FBArr);

$FBArr=Remove_nicht_abgegebene($FBArr);



if(count($FBArr)>0){
?>
<li>
	<div class="dropdown">
		<button class="btn btn-default dropdown-toggle  btn-margin-menu" type="button" id="dropdownMenu_Bew" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style='width: 289px;'>
			Feedback
			<span class="caret"></span>
		</button>
		<ul class="dropdown-menu" aria-labelledby="dropdownMenu_Bew" style='margin-left: 10px; width: 280px;'>
			<?php
	foreach($FBArr as $FB_Folie){
		$m_fID=$FB_Folie['fID'];
		// 		$folieInfo=get_zu_fID_Info_by_aTyp($zu_fID,3);
		$folieInfo=getFolieInfo($m_fID);
		$modInfo=getModulInfos($folieInfo['modID']);
		$folieInfoJson=json_decode($folieInfo['parameter']);
			?>
			<li><a href="<?php echo "/".$modInfo['mod_dir']."/".$modInfo['mod_show']."?f=".$m_fID; ?>" class='btn btn-default btn-margin-menu' style="text-overflow:ellipsis; white-space: nowrap; overflow: hidden;"><?php echo $folieInfoJson->titel; ?></a></li>
			<?php
	}
}
			?>
		</ul>
	</div>
</li>