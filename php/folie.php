<?php


function create_inactive_folie($uID, $kursID, $parameter, $modID, $viewTyp, $aktiv = 0, $fID = 0, $redirect = 0, $aTyp = 1, $zu_fID = 0)
{
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/module/mod_preasentation/praesentationseinstellungen.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/php/kursInfos.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/php/Sessions.php");
	$SessionInfos = Get_SessionInfos($_SESSION['s']);
	$aktiv = 0; //Folie ist im Ablauf NICHT sichtbar.

	$ftoken = uniqid();
	if ($fID == 0) {
		$query = "INSERT INTO folien (uID,kursID,modID,parameter,viewTyp,aTyp,zu_fID,ftoken) VALUES ('$uID','$kursID','$modID','$parameter','$viewTyp','$aTyp','$zu_fID','$ftoken')";
		$ergebnis = mysqli_query($verbindung, $query) or die(mysqli_error($verbindung));
		$fID = mysqli_insert_id($verbindung);
	} else {
		$query = "UPDATE folien SET kursID='$kursID',modID='$modID',parameter='$parameter',viewTyp='$viewTyp',aTyp='$aTyp',ftoken='$ftoken' WHERE fID='$fID'";
		// echo $query;
		$ergebnis = mysqli_query($verbindung, $query) or die(mysqli_error($verbindung));
	}
	$_SESSION['edit_fID'] = $fID;
	$KursInfos = GetKursInfos($kursID);
	// 		if($KursInfos['kTyp']==2){
	include_once($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/module/mod_preasentation/praesentationseinstellungen.php");
	$aktuelelOrderID = getMaxOrderID($kursID);
	$newOrderID = $aktuelelOrderID + 1;
	InsertOrderSetting($fID, $kursID, $newOrderID, '{"show_beginn":1,"show_aktiv":1,"show_freigabe":0,"show_nach_bearb":1,"show_auto":0}', $aktiv);
	return $folieDetails = array('fID' => $fID, 'ftoken' => $ftoken);
}

function activate_folie($fID, $aktiv = 1)
{
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
	$query = "UPDATE ablauf_master SET aktiv='$aktiv' WHERE fID='$fID'";
	// 	echo $query;
	$ergebnis = mysqli_query($verbindung, $query) or die(mysqli_error($verbindung));
}

function add_folie($parameter, $modID, $viewTyp, $fID = 0, $redirect = 0, $aTyp = 1, $zu_fID = 0, $CopyToKursID = 0, $bs_array = array())
{
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/php/Sessions.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/php/bausteine.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/php/media.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/php/kursInfos.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/module/mod_preasentation/praesentationseinstellungen.php");
	$SessionInfos = Get_SessionInfos($_SESSION['s']);
	$uID = $SessionInfos['uID'];
	$parameter_arr = json_decode($parameter, true);
	$ftoken = $parameter_arr['ftoken'];
	if ($CopyToKursID == 0) {
		$kursID = intval($_SESSION['k']);
	} else {
		$kursID = intval($CopyToKursID);
		$ftoken = uniqid();
		$fID = 0;
	}

	if (intval($fID) > 0) {
		$query = "Update folien SET parameter='$parameter', viewTyp='$viewTyp' WHERE fID='$fID'";
		// 		echo $query;
		$ergebnis = mysqli_query($verbindung, $query) or die(mysqli_error($verbindung));
	} else {
		$query = "INSERT INTO folien (uID,kursID,modID,parameter,viewTyp,aTyp,zu_fID,ftoken) VALUES ('$uID','$kursID','$modID','$parameter','$viewTyp','$aTyp','$zu_fID','$ftoken')";
		// 		echo $query;
		$ergebnis = mysqli_query($verbindung, $query) or die(mysqli_error($verbindung));
		$fID = mysqli_insert_id($verbindung);
		$_SESSION['edit_fID'] = $fID;
		$KursInfos = GetKursInfos($kursID);
		// 		if($KursInfos['kTyp']==2){
		include_once($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/module/mod_preasentation/praesentationseinstellungen.php");
		$aktuelelOrderID = getMaxOrderID($kursID);
		$newOrderID = $aktuelelOrderID + 1;
		InsertOrderSetting($fID, $kursID, $newOrderID);

		// 		}
	}
	if (count($bs_array) > 0) {
		insert_baustein_folie_match($fID, $bs_array);
	}
	// 	echo $query;
	Update_fID_file_match($fID);

	/* 	switch($redirect){
		case 1:
			return 1;
			break;

		default:
			unset($_SESSION['fID']);
			echo "<script>window.location = '" . $_SESSION['DOCUMENT_ROOT_DIR']."/module/admin/folie_erstellen.php';</script>";
			break;
	} */
	if ($redirect > 0) {
		return $redirect;
	} else {
		unset($_SESSION['edit_fID']);
		echo "<script>window.location = '" . $_SESSION['DOCUMENT_ROOT_DIR'] . "/module/admin/folie_erstellen.php';</script>";
	}
}

function add_folie_fotowettbewerb($uID, $parameter, $modID, $viewTyp, $redirect = 0, $aTyp = 1, $zu_fID = 0, $kursID)
{
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/php/Sessions.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/php/bausteine.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/php/kursInfos.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/module/mod_preasentation/praesentationseinstellungen.php");
	$query = "INSERT INTO folien (uID,kursID,modID,parameter,viewTyp,aTyp,zu_fID) VALUES ('$uID','$kursID','$modID','$parameter','$viewTyp','$aTyp','$zu_fID')";
	// 	echo $query;
	$ergebnis = mysqli_query($verbindung, $query) or die(mysqli_error($verbindung));
	$fID = mysqli_insert_id($verbindung);
	$_SESSION['edit_fID'] = $fID;
	$KursInfos = GetKursInfos($kursID);
	// 		if($KursInfos['kTyp']==2){
	include_once($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/module/mod_preasentation/praesentationseinstellungen.php");
	$aktuelelOrderID = getMaxOrderID($kursID);
	$newOrderID = $aktuelelOrderID + 1;
	InsertOrderSetting($fID, $kursID, $newOrderID, '{"show_beginn":1,"show_aktiv":0,"show_freigabe":0,"show_nach_bearb":1,"show_auto":1}');
	if ($redirect > 0) {
		return $redirect;
	} else {
		unset($_SESSION['edit_fID']);
	}
}

function delete_folie($fID)
{
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
	$query = "DELETE FROM folien WHERE fID=$fID";
	// 	echo $query;
	mysqli_query($verbindung, $query);
}


function get_last_inserted_id()
{
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
}

function get_erste_Folie($kursID)
{
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
	$query = "SELECT * FROM ablauf_master WHERE kursID=$kursID Order By OrderID ASC LIMIT 1";
	$ergebnis = mysqli_query($verbindung, $query) or die(mysqli_error($verbindung));
	$row = mysqli_fetch_assoc($ergebnis);
	return $row;
}

function get_erste_Folie_2($kursID, $token)
{
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/php/teilnehmer.php");
	$tnInfo = getTeilnehmerInfosByToken($token);
	$tnID = $tnInfo['tnID'];
	$query = "SELECT *, tabFol.parameter as param FROM folien tabFol JOIN ablauf_master tabMaster  on (tabMaster.fID=tabFol.fID) WHERE tabMaster.kursID=$kursID Order By OrderID ASC";
	// 	echo $query;
	$ergebnis = mysqli_query($verbindung, $query) or die($query . " => " . mysqli_error($verbindung));
	while ($row = mysqli_fetch_assoc($ergebnis)) {
		// 		echo "<hr>".$row['param'];
		$parameter = json_decode($row['param'], true);
		switch ($row['viewTyp']) {
			case 1:
				return $row['fID'];
				break;

			case 2:
				if (isset($parameter['tnarr']) && in_array($tnID, $parameter['tnarr'])) {
					return $row['fID'];
				}
				break;

			case 3:
				if (isset($parameter['tnarr']) && !in_array($tnID, $parameter['tnarr'])) {
					return $row['fID'];
				}
				break;
		}
	}
	return 0;
}


function check_if_zugriff_auf_Folie_erlaubt($fID)
{
	$kursID_ist = $_SESSION['kursID'];
	$kursID_soll = get_KursID_By_fID($fID);
	// 	echo "$kursID_ist==$kursID_soll";
	if ($kursID_ist == $kursID_soll) {
		return true;
	} else {
		return false;
	}
}


function get_KursID_By_fID($fID)
{
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
	$query = "SELECT * FROM folien WHERE fID=$fID";
	$ergebnis = mysqli_query($verbindung, $query) or die(mysqli_error($verbindung));
	$KursArray = [];
	$row = mysqli_fetch_assoc($ergebnis);
	return $row['kursID'];
}

function get_zu_fID_Info_by_aTyp($fID, $aTyp)
{
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
	$query = "SELECT * FROM folien WHERE zu_fID=$fID AND aTyp=$aTyp";
	$ergebnis = mysqli_query($verbindung, $query) or die(mysqli_error($verbindung));
	$row = mysqli_fetch_assoc($ergebnis);
	return $row;
}

function get_folieListe_Infos_by_kurs_aTyp($kursID, $aTyp)
{
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
	$query = "SELECT * FROM folien WHERE kursID=$kursID AND aTyp=$aTyp";
	$ergebnis = mysqli_query($verbindung, $query) or die(mysqli_error($verbindung));
	$tempArr = [];
	while ($row = mysqli_fetch_assoc($ergebnis)) {
		array_push($tempArr, $row);
	}
	return $tempArr;
}

function getFolieInfo($fID)
{
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
	$query = "SELECT * FROM folien WHERE fID=$fID";
	$ergebnis = mysqli_query($verbindung, $query) or die($query . mysqli_error($verbindung));
	$row = mysqli_fetch_assoc($ergebnis);
	
	return $row;
}

function getFolieInfo_bytoken($ftoken)
{
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
	$query = "SELECT * FROM folien WHERE ftoken='$ftoken'";
	// 	echo $query;
	$ergebnis = mysqli_query($verbindung, $query) or die($query . mysqli_error($verbindung));
	$row = mysqli_fetch_assoc($ergebnis);
	if (!is_array($row)) {
		$row = [];
	}
	
	return $row;
}

function Get_zugeordnete_Folien($fID)
{
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
	$query = "SELECT * FROM folien WHERE zu_fID=$fID";
	$ergebnis = mysqli_query($verbindung, $query) or die($query . mysqli_error($verbindung));
	$zuFolien = [];
	while ($row = mysqli_fetch_assoc($ergebnis)) {
		array_push($zuFolien, $row);
	}
	return $zuFolien;
}

function Get_zugeordnete_Folien_join_master($fID, $all = 1)
{
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
	switch ($all) {
		case 0:
			//   $all = 0    =>    NUR ausgeblendete werden angezeigt.
			$query = "SELECT * FROM folien tabFol INNER JOIN ablauf_master tabMaster on tabFol.fID=tabMaster.fID WHERE tabFol.zu_fID=$fID AND aktiv=0";
			break;

		default:
			//   $all = 1    =>    ALLE inkl. ausgeblendete werden angezeigt.
			$query = "SELECT * FROM folien tabFol INNER JOIN ablauf_master tabMaster on tabFol.fID=tabMaster.fID WHERE tabFol.zu_fID=$fID";
			break;
		case 2:
			//   $all = 2    =>    NUR aktive werden angezeigt.
			$query = "SELECT * FROM folien tabFol INNER JOIN ablauf_master tabMaster on tabFol.fID=tabMaster.fID WHERE tabFol.zu_fID=$fID AND aktiv=1";
			break;
	}
	$ergebnis = mysqli_query($verbindung, $query) or die($query . mysqli_error($verbindung));
	$zuFolien = [];
	while ($row = mysqli_fetch_assoc($ergebnis)) {
		array_push($zuFolien, $row);
	}
	// 	shuffle ($zuFolien);
	return $zuFolien;
}
function Get_zugeordnete_Folien_by_module($fID, $modID)
{
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
	$query = "SELECT * FROM folien WHERE zu_fID=$fID AND modID='$modID'";
	// 	echo $query;
	$ergebnis = mysqli_query($verbindung, $query) or die(mysqli_error($verbindung));
	$zuFolien = [];
	while ($row = mysqli_fetch_assoc($ergebnis)) {
		array_push($zuFolien, $row);
	}
	return $zuFolien;
}

function getFolienListeInfos($kursID)
{
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
	$folArr = getFolienListeInfos_ORDER_all($kursID);
	// 	$folArr=getFolienByKurs($kursID);
	$folienArray = [];
	foreach ($folArr as $folie) {
		$fID = $folie['fID'];
		$query = "SELECT * FROM folien WHERE fID='$fID'";
		$ergebnis = mysqli_query($verbindung, $query) or die(mysqli_error($verbindung));
		$row = mysqli_fetch_assoc($ergebnis);
		array_push($folienArray, $row);
	}
	return $folienArray;
}

function getFolienListeInfos_by_kurs_modID($kursID, $modID)
{
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");

	$query = "SELECT *,tF.fID as fID, tF.parameter as FParameter, tA.parameter as AParameter, tAbl.parameter as AblaufParameter FROM folien tF INNER JOIN ablauf_master tAbl on tF.fID=tAbl.fID Left JOIN abgabe tA ON tA.fID=tF.fID WHERE tF.kursID='$kursID' && tF.modID='$modID' Order By OrderID ASC";
	$ergebnis = mysqli_query($verbindung, $query) or die(mysqli_error($verbindung));

	$folienArray = [];
	while ($row = mysqli_fetch_assoc($ergebnis)) {
		array_push($folienArray, $row);
	}
	return $folienArray;
}

function getFolienListeInfos_ORDER_all($kursID)
{
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
	$folArr = getFolienByKursOrder($kursID); //Abfrage aus ablauf_master
	$folArr_orig = getFolienByKurs($kursID);

	foreach ($folArr_orig as $folie) {
		$fID = $folie['fID'];
		$isInArrIndex = 0;
		foreach ($folArr as $tmpArr) {
			if (in_array($fID, $tmpArr, true)) {
				$isInArrIndex = 1;
			}
		}
		if ($isInArrIndex == 0) {
			$tmpArrFolie = array('fID' => $folie['fID'], 'noOrder' => 1);
			array_push($folArr, $tmpArrFolie);
		}
	}

	$folienArray = [];
	foreach ($folArr as $folie) {
		$fID = $folie['fID'];
		$query = "SELECT * FROM folien WHERE fID='$fID'";
		$ergebnis = mysqli_query($verbindung, $query) or die(mysqli_error($verbindung));
		$row = mysqli_fetch_assoc($ergebnis);
		if (isset($folie['noOrder'])) {
			$row["noOrder"] = 1;
		}
		array_push($folienArray, $row);
	}
	return $folienArray;
}


function getFolienListeInfos_ORDER($kursID)
{
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
	$folArr = getFolienByKursOrder($kursID); //Abfrage aus ablauf_master
	$folArr_orig = getFolienByKurs($kursID);

	foreach ($folArr_orig as $folie) {
		$fID = $folie['fID'];
		$isInArrIndex = 0;
		/* 	foreach($folArr as $tmpArr){
			if(in_array($fID, $tmpArr, true)){
				$isInArrIndex=1;
			}
		}
  		if($isInArrIndex==0){
			$tmpArrFolie=array('fID'=>$folie['fID'],'noOrder'=>1);
			array_push($folArr, $tmpArrFolie);
		}
 */
	}

	$folienArray = [];
	foreach ($folArr as $folie) {
		$fID = $folie['fID'];
		$query = "SELECT * FROM folien WHERE fID='$fID'";
		$ergebnis = mysqli_query($verbindung, $query) or die(mysqli_error($verbindung));
		$row = mysqli_fetch_assoc($ergebnis);
		if (isset($folie['noOrder'])) {
			$row["noOrder"] = 1;
		}
		array_push($folienArray, $row);
	}
	return $folienArray;
}

function drop_aTyp($FolienListeInfos_ORDER, $aTyp_toDrop)
{
	$tempArr = [];
	foreach ($FolienListeInfos_ORDER as $folie) {
		if ($aTyp_toDrop != $folie['aTyp']) {
			array_push($tempArr, $folie);
		}
	}
	return $tempArr;
}

function getFolienByKursOrder($kursID)
{
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
	$folienArray = [];
	$query = "SELECT * FROM ablauf_master WHERE kursID=$kursID and aktiv=1 Order By OrderID ASC";
	$ergebnis = mysqli_query($verbindung, $query) or die(mysqli_error($verbindung));
	while ($row = mysqli_fetch_assoc($ergebnis)) {
		array_push($folienArray, $row);
	}
	return $folienArray;
}

function getFolienByKurs($kursID)
{
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
	$folienArray = [];
	$query = "SELECT * FROM folien WHERE kursID=$kursID";
	$ergebnis = mysqli_query($verbindung, $query) or die(mysqli_error($verbindung));
	while ($row = mysqli_fetch_assoc($ergebnis)) {
		array_push($folienArray, $row);
	}
	return $folienArray;
}

function redirectTo_addTask($fID)
{
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
	$query = "SELECT * FROM folien WHERE fID=$fID";
	include_once($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/php/module.php");
	$ergebnis = mysqli_query($verbindung, $query) or die(mysqli_error($verbindung));
	$row = mysqli_fetch_assoc($ergebnis);
	$modID = $row['modID'];
	$ModInfo = getModulInfos($modID);
	// 	echo "<script>alert('/".$ModInfo['mod_dir']."/".$ModInfo['mod_add']."');</script>";
	echo "<script>window.location = '" . $_SESSION['DOCUMENT_ROOT_DIR'] . "/" . $ModInfo['mod_dir'] . "/" . $ModInfo['mod_add'] . "';</script>";
}


function getFolienListe($token)
{

	//liefert eine Liste aller Folien, die einem Teilnehmer angezeigt werden könnten. Eine Unterscheidung nach Status ist hier noch nicht erfolgt!

	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/php/teilnehmer.php");
	$TNInfo = getTeilnehmerInfosByToken($token);
	$tnID = $TNInfo['tnID'];
	// 	$kursIDRow=getKursByTnID($tnID);
	// 	$FolienInfos=getFolienListeInfos($_SESSION['kursID']);
	$FolienInfos = getFolienListeInfos_ORDER($_SESSION['kursID']);
	
	$ShowArr = [];
	foreach ($FolienInfos as $folie) {
		$parameter = json_decode($folie['parameter']);
		if (isset($parameter->tnarr)) {
			$tnarr = $parameter->tnarr;
			$viewTyp = $folie['viewTyp'];
			$fID = $folie['fID'];
			switch ($viewTyp) {
				default:
					array_push($ShowArr, $folie);
					break;
				case 2:
					if (in_array($tnID, $tnarr)) {
						array_push($ShowArr, $folie);
					}
					break;
				case 3:
					if (!in_array($tnID, $tnarr)) {
						array_push($ShowArr, $folie);
					}
					break;
			}
		} elseif ($folie['viewTyp'] == 1) {
			array_push($ShowArr, $folie);
		}
	}
	return $ShowArr;
}

function getFolienListe_ORDER($token)
{

	//liefert eine Liste aller Folien, die einem Teilnehmer angezeigt werden könnten. Eine Unterscheidung nach Status ist hier noch nicht erfolgt!

	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/php/teilnehmer.php");
	$TNInfo = getTeilnehmerInfosByToken($token);
	$tnID = $TNInfo['tnID'];
	// 	$kursIDRow=getKursByTnID($tnID);
	$FolienInfos = getFolienListeInfos_ORDER($_SESSION['kursID']);
	
	$ShowArr = [];
	foreach ($FolienInfos as $folie) {
		$parameter = json_decode($folie['parameter']);
		// 			array_push($ShowArr,$folie);
		if (isset($parameter->tnarr)) {
			$tnarr = $parameter->tnarr;
			$viewTyp = $folie['viewTyp'];
			$fID = $folie['fID'];
			switch ($viewTyp) {
				default:
					array_push($ShowArr, $folie);
					break;
				case 2:
					if (in_array($tnID, $tnarr)) {
						array_push($ShowArr, $folie);
					}
					break;
				case 3:
					if (!in_array($tnID, $tnarr)) {
						array_push($ShowArr, $folie);
					}
					break;
			}
		} elseif ($folie['viewTyp'] == 1) {
			array_push($ShowArr, $folie);
		}
	}
	return $ShowArr;
}


function ArrayPush_Ablauf_Status($folieListe)
{
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/module/mod_preasentation/praesentationseinstellungen.php");
	$folieListeNeu = [];
	foreach ($folieListe as $folie) {
		$settings = load_einstellungen($folie['fID'], $_SESSION['kursID']);
		$folie['aktiv'] = $settings['aktiv'];
		array_push($folieListeNeu, $folie);
	}
	return $folieListeNeu;
}

function GetFolieListe_by_aTyp($kursID, $aTyp)
{
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
	$query = "SELECT * FROM folien WHERE kursID=$kursID AND aTyp=$aTyp";
	// 	echo $query;
	$folienArray = [];
	$ergebnis = mysqli_query($verbindung, $query) or die(mysqli_error($verbindung));
	while ($row = mysqli_fetch_assoc($ergebnis)) {
		array_push($folienArray, $row);
	}
	return $folienArray;
}


function Remove_inaktiv_from_FolieListe($folieListe)
{
	$folieListeNeu = [];
	foreach ($folieListe as $folie) {
		if ($folie['aktiv'] != 0) {
			array_push($folieListeNeu, $folie);
		}
	}
	return $folieListeNeu;
}

function Remove_aTyp_from_FolieListe($folienListe, $aTyp)
{
	$folieListeNeu = [];
	foreach ($folienListe as $folie) {
		if (intval($folie['aTyp']) != $aTyp) {
			array_push($folieListeNeu, $folie);
		}
	}
	return $folieListeNeu;
}

function Remove_zugriff_from_folieListe($folienListe)
{
	include_once($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/php/teilnehmer.php");
	$tnInfo = getTeilnehmerInfosByToken($_SESSION['t']);
	$folieListeNeu = [];
	foreach ($folienListe as $folie) {
		$parameter = json_decode($folie['parameter'], true);
		$titel = $parameter['titel'];
		$TNArr = array($tnInfo['tnID']);
		if ($folie['viewTyp'] == 1 || ($folie['viewTyp'] == 2 && in_array($tnInfo['tnID'], $parameter['tnarr'])) || ($folie['viewTyp'] == 3 && count(array_intersect($TNArr, $parameter['tnarr'])) == 0)) {
			// echo "<br>hinzugefügt ($titel)";
			array_push($folieListeNeu, $folie);
		} else {
			// echo "<br>entfernt ($titel)";
		}
	}
	return $folieListeNeu;
}

function Remove_nicht_abgegebene($folienListe)
{
	include_once($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/php/abgabe.php");
	$folieListeNeu = [];
	foreach ($folienListe as $folie) {
		
		if ($folie['zu_fID'] > 0) {
			// 			$boolval=check_ob_folie_abgegeben_overall($folie['zu_fID']) ? 'true' : 'false';
			// 			echo $folie['fID']."=>".$folie['zu_fID']."=>". $boolval."<br>";
			if (check_ob_folie_abgegeben_overall($folie['zu_fID'])) {
				array_push($folieListeNeu, $folie);
			}
		}
	}
	return $folieListeNeu;
}
