<?php
if(isset($_POST['fkt'])){
	$FKT=$_POST['fkt'];
	switch($FKT){
		case "SetLehrerSync":
			echo SetLehrerSync(intval($_POST['kursID']),intval($_POST['fID']));
			break;

		case "SetFreigabeStatus":
			echo SetFreigabeStatus(intval($_POST['kursID']),intval($_POST['fID']));
			break;

		case "getLehrerSync":
			echo json_encode(getLehrerSync(intval($_POST['kursID'])));
			break;

		case "SeiteAktualisieren":
			echo SeiteAktualisieren(intval($_POST['kursID']));
			break;

		case "CheckFreigabeStatus":
			echo CheckFreigabeStatus(intval($_POST['kursID']),intval($_POST['fID']));
			break;
	}
}

function changeAktivStatus($fID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$kursID=$_SESSION['k'];
	$query="UPDATE ablauf_master SET aktiv=IF(aktiv=0,1,0), OrderID=999999999 WHERE kursID='$kursID' AND fID='$fID'";
	// 	echo $query;
	$ergebnis=mysqli_query($verbindung,$query);

}

function insertFolieToMaster($fID,$kursID,$defaultParameter){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="INSERT INTO ablauf_master (kursID,fID,parameter) VALUES ('$kursID','$fID','$defaultParameter') ON DUPLICATE KEY UPDATE parameter='$defaultParameter'";
	mysqli_query($verbindung,$query);
}

function save_einstellungen($parameterArr){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$fID=$_SESSION['fID_praes'];
	$kursID=$_SESSION['k'];
	$parameter=json_encode($parameterArr);
	$query="INSERT INTO ablauf_master (kursID,fID,parameter) VALUES ('$kursID','$fID','$parameter') ON DUPLICATE KEY UPDATE parameter='$parameter'";
	mysqli_query($verbindung,$query);
}

function load_einstellungen($fID,$kursID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT * FROM ablauf_master WHERE kursID='$kursID' AND fID='$fID'";
	$ergebnis=mysqli_query($verbindung,$query);
	$row=mysqli_fetch_assoc($ergebnis);
	return $row;
}

function InsertOrderSetting($fID,$kursID,$OrderID,$defaultParameter='{"show_beginn":1,"show_aktiv":1,"show_freigabe":0,"show_nach_bearb":1,"show_auto":0}',$aktiv=1){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
// 	$defaultParameter='{"show_beginn":1,"show_aktiv":1,"show_freigabe":0,"show_nach_bearb":1,"show_auto":0}';
	$query="INSERT INTO ablauf_master (fID,KursID,OrderID,parameter,aktiv) VALUES($fID,$kursID,$OrderID,'$defaultParameter','$aktiv') ON DUPLICATE KEY UPDATE OrderID=$OrderID, aktiv=$aktiv";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
}


function getMaxOrderID($kursID,$aktiv=0){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	switch($aktiv){
		case 1:
			$query="SELECT * FROM ablauf_master WHERE kursID='$kursID' and aktiv=1 ORDER BY OrderID DESC LIMIT 1";
			break;

		default:
			$query="SELECT * FROM ablauf_master WHERE kursID='$kursID' ORDER BY OrderID DESC LIMIT 1";
			break;
	}
	$ergebnis=mysqli_query($verbindung,$query);
	$row=mysqli_fetch_assoc($ergebnis);
	return $row['OrderID'];
}

function getOrderID($fID,$kursID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT * FROM ablauf_master WHERE kursID='$kursID' AND fID='$fID'";
	$ergebnis=mysqli_query($verbindung,$query);
	$row=mysqli_fetch_assoc($ergebnis);
	return $row['OrderID'];
}


function getPraesentationsSettingsListe($kursID){
	include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/folie.php");
	$FolienListe=getFolienListeInfos_ORDER($kursID);
	$tempArr=[];
	foreach($FolienListe as $folie){
		if($folie['aTyp']==1){
			$row=load_einstellungen($folie['fID'],$kursID);
			array_push($tempArr,$row);
		}
	}
	return $tempArr;
}




function GetAblaufArr($kursID){
	include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/folie.php");
	$FolienListe=getFolienListeInfos_ORDER($kursID);
	
	$tempArr=[];
	foreach($FolienListe as $folie){
		$tempRow=[];
		if($folie['aTyp']==1){
			$row=load_einstellungen($folie['fID'],$kursID);
			if($row!=null){
				foreach($row as $key => $value){
					if($key=="parameter"){
						// 					echo $value;
						$parameter=json_decode($value,true);
						foreach($parameter as $pkey => $pval){
							$tempRow[$pkey]=$pval;
						}
					}else{
						$tempRow[$key]=$value;
					}
				}
				array_push($tempArr,$tempRow);
			}
		}
	}
	return $tempArr;
}

function set_nextShow_to_AblaufArr($ablaufArr){
	$tempArr=[];
	$iLauf=0;
	foreach($ablaufArr as $folie){
		// 		if(!isset($tempArr[$iLauf]) && !is_array($tempArr[$iLauf])){$tempArr[$iLauf]=[];}
		foreach($folie as $key => $value){
			$tempArr[$iLauf][$key]=$value;
			if($iLauf>0){
				if($key=="show_auto"){
					$tempArr[$iLauf_prev]['show_auto_next']=$value;
				}
			}
		}
		// 		array_push($tempArr[$iLauf],$tempRow);
		$iLauf_prev=$iLauf;
		$iLauf++;
	}
	$tempArr2=[];
	foreach($tempArr as $key => $row){
		array_push($tempArr2,$row);
	}
	
	return $tempArr2;
}

function GetAblaufArrFiltered($AblaufArr){
	
	// Eingabe ist die Ausgabe von GetAblaufArr
	$abArr=GetAblaufArr_CheckForAbgabe($AblaufArr);
	
	$tempArr=[];
	$iLauf_prev=0;
	$auto=1;
	$tmpAbgabe_prev=0;
	for($iLauf=0;$iLauf<count($abArr);$iLauf++){
		if($abArr[$iLauf]['show_nach_bearb']==0 && $abArr[$iLauf]['abgegeben']==1){$abArr[$iLauf]['show']=$abArr[$iLauf]['show']*false;}

		if($abArr[$iLauf]['aktiv']==0 ){$abArr[$iLauf]['show']=$abArr[$iLauf]['show']*false;}

		if($iLauf>0){
			if($abArr[$iLauf]['show_auto']==1 && $tmpAbgabe_prev == 0){$abArr[$iLauf]['show']=$abArr[$iLauf]['show']*false;	$auto=0;}
		}
		if($abArr[$iLauf]['show_freigabe']==1 && $abArr[$iLauf]['freigabeStatus']==0){
			$abArr[$iLauf]['show']=$abArr[$iLauf]['show']*false;
			$auto=0;
		}else{}
		if($auto==0){$abArr[$iLauf]['show']=$abArr[$iLauf]['show']*false;} // Nötig, damit ab dieser Folie keine weiteren mehr angezeigt werden... 
		$tmpAbgabe_prev=$abArr[$iLauf]['abgegeben'];
		array_push($tempArr,$abArr[$iLauf]);
	}
	// 	echo "<hr>";
	

	return $tempArr;
}

/* function GetAblaufArrFiltered($AblaufArr){
	// Eingabe ist die Ausgabe von GetAblaufArr
	$abArr=GetAblaufArr_CheckForAbgabe($AblaufArr);
	$tempArr=[];
	$iLauf_prev=0;
	$auto=1;
	for($iLauf=0;$iLauf<count($abArr);$iLauf++){
		if($abArr[$iLauf]['show_nach_bearb']==0 && $abArr[$iLauf]['abgegeben']==1){$abArr[$iLauf]['show']=$abArr[$iLauf]['show']*false;}
		if($abArr[$iLauf]['aktiv']==0 ){$abArr[$iLauf]['show']=$abArr[$iLauf]['show']*false;}
		if($iLauf>0){if($abArr[$iLauf]['show_auto']==1 && $tmpAbgabe_prev == 0){$abArr[$iLauf]['show']=$abArr[$iLauf]['show']*false;$auto=0;}}else{}
		if($auto==0){$abArr[$iLauf]['show']=$abArr[$iLauf]['show']*false;} // Nötig, damit ab dieser Folie keine weiteren mehr angezeigt werden... 
		if($abArr[$iLauf]['show_freigabe']==1 && $abArr[$iLauf]['freigabeStatus']==0){
			$abArr[$iLauf]['show']=$abArr[$iLauf]['show']*false;
			// 			 			if($iLauf_prev>0){
			// 				$abArr[$iLauf_prev]['show_freigabe_next']=$abArr[$iLauf]['show_freigabe'];
			// 				$abArr[$iLauf_prev]['freigabeStatus_next']=$abArr[$iLauf]['freigabeStatus'];
			// 			} 
		}
		$tmpAbgabe_prev=$abArr[$iLauf]['abgegeben'];
		array_push($tempArr,$abArr[$iLauf]);
		// 		 		$iLauf_prev=$iLauf; 
	}

	
	if(isset($_SESSION['uID'])){
		return $tempArr;
	}else{
		return remove_fIDs_not_shown($tempArr);

	}
	// 	 	if(intval($_SESSION['uID'])>0){
	// 		return remove_fIDs_not_shown($tempArr);
	// 	}else{
	// 		return $tempArr;
	// 	} 
} */


function remove_fIDs_not_shown($FilteredArr){
	
	$tempArr=[];
	$showAuto=0;
	foreach($FilteredArr as $folie){

		// 		if($folie['show_auto']==1){$showAuto=1;}

		// 		if($folie['show']==1 && ($showAuto==0)){
		if($folie['show']==1 ){
			array_push($tempArr,$folie);
		}
	}
	
	return $tempArr;
}
function GetAblaufArr_CheckForAbgabe($AblaufArr){
	include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/abgabe.php");
	$retArr=[];
	foreach($AblaufArr as $folie){
		$fID=$folie['fID'];
		$folie['abgegeben']=check_ob_folie_abgegeben($fID);
		$folie['show']=true;
		array_push($retArr,$folie);
	}
	return $retArr;
}

function get_aktuellen_Ablauf($kursID){
	$tempArr=GetAblaufArrFiltered(set_nextShow_to_AblaufArr(GetAblaufArr($kursID)));
	if(isset($_SESSION['uID'])){
		return $tempArr;
	}else{
		return remove_fIDs_not_shown($tempArr);

	}
}

function get_fID_index($abArr,$fID){
	$retval=0;
	for($iLauf=0;$iLauf<count($abArr);$iLauf++){
		if($abArr[$iLauf]['fID']==$fID){
			$retval=$iLauf;
			break;
		}
	}
	return $retval;
}


function get_next_fID_Arr($kursID,$fID){
	$Ablauf_aktuell_Arr=GetAblaufArrFiltered(set_nextShow_to_AblaufArr(GetAblaufArr($kursID)));
	$aktuellerIndex=get_fID_index($Ablauf_aktuell_Arr,$fID);
	$fID_Arr['aktuell']=$fID;
	$fID_Arr['freigabeStatus']=$Ablauf_aktuell_Arr[$aktuellerIndex]['freigabeStatus'];
	$lastFolie=end($Ablauf_aktuell_Arr);
	$fID_Arr['last']=$lastFolie['fID'];
	$nextArr=array_slice ($Ablauf_aktuell_Arr,$aktuellerIndex+1,null,false);

	if(count($nextArr)>0){
		if(isset($nextArr[0]['fID']) && ($nextArr[0]['show_freigabe'] == 1 && $nextArr[0]['freigabeStatus']==0 ) ){
			$fID_Arr['wait']=1;
		}else{
			$fID_Arr['wait']=0;
		}
		$fID_Arr['next_freigabeStatus']=$nextArr[0]['freigabeStatus'];
		$fID_Arr['next_show_freigabe']=$nextArr[0]['show_freigabe'];
		$fID_Arr['wait_for_fID']=$nextArr[0]['fID'];
	}
// echo "HALLO:". Check_if_kurs_edit_allowed($_SESSION['kursID'],intval($_SESSION['uID']));
	if(!isset($_SESSION['uID']) || Check_if_kurs_edit_allowed($_SESSION['kursID'],intval($_SESSION['uID']))==0){
		$nextArr=remove_fIDs_not_shown($nextArr);
	}
// 		$nextArr=remove_fIDs_not_shown($nextArr);
	if(isset($nextArr[0]['fID'])){
		$fID_Arr['next']=$nextArr[0]['fID'];
	}

	$prevArr=array_reverse ( $Ablauf_aktuell_Arr , false );
	$firstFolie=end($prevArr);
	$fID_Arr['first']=$firstFolie['fID'];

	$aktuellerIndex=get_fID_index($prevArr,$fID);
	$prevArr=array_slice ( $prevArr , $aktuellerIndex+1,null,false);
	if(!isset($_SESSION['uID']) || Check_if_kurs_edit_allowed($_SESSION['kursID'],intval($_SESSION['uID']))==0){
		$prevArr=remove_fIDs_not_shown($prevArr);
	}
	// 	
	if(isset($prevArr[0]['fID'])){
		$fID_Arr['previous']=$prevArr[0]['fID'];
	}
	return $fID_Arr;
}


/* function get_next_fID_Arr($kursID,$fID){
	$Ablauf_aktuell_Arr=get_aktuellen_Ablauf($kursID);
	$aktuellerIndex=get_fID_index($Ablauf_aktuell_Arr,$fID);
	$fID_Arr['aktuell']=$fID;
	$akt_Arr=array_slice ( $Ablauf_aktuell_Arr , $aktuellerIndex,null,false);
	$fID_Arr['freigabeStatus']=$akt_Arr[0]['freigabeStatus'];
	$fID_Arr['show_freigabe']=$akt_Arr[0]['show_freigabe'];

	$nextArr=array_slice ( $Ablauf_aktuell_Arr , $aktuellerIndex+1,null,false);

	if(isset($nextArr[0]['fID'])){
		$fID_Arr['next']=$nextArr[0]['fID'];
	}
	$prevArr=array_reverse ( $Ablauf_aktuell_Arr , false );
	$aktuellerIndex=get_fID_index($prevArr,$fID);
	$prevArr=array_slice ( $prevArr , $aktuellerIndex+1,null,false);
	if(isset($prevArr[0]['fID'])){
		$fID_Arr['previous']=$prevArr[0]['fID'];
	}
	return $fID_Arr;
} */




function getLehrerSync($kursID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT * FROM ablauf_sync WHERE kursID='$kursID'";
	$ergebnis=mysqli_query($verbindung,$query)or die($query." => ".mysqli_error($verbindung));
	$row=mysqli_fetch_assoc($ergebnis);
	return $row;
}

function SetLehrerSync($kursID,$fID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");


	$query="INSERT INTO ablauf_sync (kursID,fID,aktiv) VALUES ('$kursID','$fID',1) ON DUPLICATE KEY UPDATE fID='$fID', aktiv=IF( fID='$fID' AND aktiv = 1, 0 , IF( fID='$fID' AND aktiv = 0, 1 , IF(fID!='$fID',1,1)))";
// echo $query; 
	mysqli_query($verbindung,$query)or die($query." => ".mysqli_error($verbindung));
}

function SeiteAktualisieren($kursID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/folie.php");
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/module.php");
	$row=getLehrerSync($kursID);
	if($row['aktiv']==1){
		$FolieInfo=getFolieInfo($row['fID']);
		$parameterFolie=json_decode($FolieInfo['parameter']);
		$modID=$FolieInfo['modID'];
		$modInfo=getModulInfos($modID);
		$href= $_SESSION['DOCUMENT_ROOT_DIR'].$modInfo['mod_dir']."/".$modInfo['mod_show']."?f=".$row['fID'];

		// 	header("LOCATION: $href");
		return "<script>window.location = '" . $_SESSION['DOCUMENT_ROOT_DIR']."$href';</script>";
	}
}

function SetFreigabeStatus($kursID,$fID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="UPDATE ablauf_master SET freigabeStatus=IF(freigabeStatus = 1, 0, 1) WHERE kursID=$kursID AND fID=$fID";
	mysqli_query($verbindung,$query)or die($query." => ".mysqli_error($verbindung));
}

function CheckFreigabeStatus($kursID,$fID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT * FROM ablauf_master WHERE freigabeStatus=1 AND kursID=$kursID AND fID=$fID";
	$ergebnis=mysqli_query($verbindung,$query)or die($query." => ".mysqli_error($verbindung));
	if(mysqli_num_rows($ergebnis)==1){return true;}else{return false;}
}