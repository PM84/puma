<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

if(isset($_POST['PostFktn'])){
	switch($_POST['PostFktn']){
		case 'get_Embed_Link':
			$kursID=intval($_POST['kursID']);
			echo get_Embed_Link($kursID);
			break;
	}
}


function GetKursInfos($kursID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT * FROM kurs WHERE kursID=$kursID";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$row=mysqli_fetch_assoc($ergebnis);
	return $row;
}

function getKursInfos_by_kursToken($kursToken){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT * FROM kurs kursTab INNER JOIN  kurs_uID_match matchTab  ON (kursTab.kursID = matchTab.kursID) WHERE kursToken='$kursToken'";
	// 	echo $query;
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$row=mysqli_fetch_assoc($ergebnis);
	return $row;
}

function create_Embed_Link($kursToken){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	return $WorkshopUrl. $_SESSION['DOCUMENT_ROOT_DIR'] ."/module/admin/kurs_auto_tn.php?kTok=$kursToken";
}

function get_Embed_Link($kursID){
	$kursInfos=GetKursInfos($kursID);
	return create_Embed_Link($kursInfos['kursToken']);
}

function GetKursListeInfos($uID,$KursTyp=1,$all=0){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");

	$query="SELECT * FROM kurs_uID_match WHERE uID=$uID";
	$ergebnis=mysqli_query($verbindung,$query) or die($query." => ".mysqli_error($verbindung));
	$KursArray=[];
	while($row=mysqli_fetch_assoc($ergebnis)){
		$kursID=$row['kursID'];
		$KursInfo=GetKursInfos($kursID);
		if($all==0){
			switch($KursTyp){
				case 1:
					if($KursInfo['kTyp']==$KursTyp){
						array_push($KursArray,$KursInfo);
					}
					break;
				case 2:
					if($KursInfo['kTyp']==$KursTyp){
						array_push($KursArray,$KursInfo);
					}
					break;
			}		
		}else{
			array_push($KursArray,$KursInfo);
		}
	}
	return $KursArray;
}

function Check_if_kurs_edit_allowed($kursID,$uID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT * FROM kurs_uID_match WHERE uID=$uID AND kursID=$kursID";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	return mysqli_num_rows($ergebnis);
}

function check_share_kurs($kursID=0){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$uID=$_SESSION['uID'];
	$query="SELECT * FROM kurs_share where kursID=$kursID";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	if(mysqli_num_rows($ergebnis)>0){
		return true;
	}else{
		return false;
	}
}

function unshare_kurs($kursID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$uID=$_SESSION['uID'];
	$query="DELETE FROM kurs_share where kursID=$kursID AND uID=$uID";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
}


function share_kurs($kursID,$share_group,$share_to_mail){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$uID=$_SESSION['uID'];
	$SchulNr=$_SESSION['SchulNr'];
	$query="INSERT INTO kurs_share (kursID,share_group,uID,share_to_mail, SchulNr) VALUES ('$kursID','$share_group','$uID','$share_to_mail','$SchulNr') on duplicate key update share_group='$share_group', share_to_mail='$share_to_mail'";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
}

function shared_Kurse_Liste_Infos(){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");

	$query="SELECT * FROM kurs_share WHERE share_group=2";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$KursArray=[];
	while($row=mysqli_fetch_assoc($ergebnis)){
		$kursID=$row['kursID'];
		$KursInfo=GetKursInfos($kursID);
		array_push($KursArray,$KursInfo);
	}

	$SchulNr=intval($_SESSION['SchulNr']);
	$query="SELECT * FROM kurs_share WHERE share_group=1 AND SchulNr=$SchulNr";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	while($row=mysqli_fetch_assoc($ergebnis)){
		$kursID=$row['kursID'];
		$KursInfo=GetKursInfos($kursID);
		array_push($KursArray,$KursInfo);
	}



	return $KursArray;
}

function get_kursIDs_from_Kurse_Liste_Infos($Kurse_Liste_Infos){
	$kursIDs=[];
	foreach($Kurse_Liste_Infos as $Kurs){
		
		array_push($kursIDs,$Kurs['kursID']);
	}
	return $kursIDs;
}

function shared_Kurse_Liste_Infos_filtered($search_arr){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$SharedKurseInfos=shared_Kurse_Liste_Infos();
	$KursIDs=get_kursIDs_from_Kurse_Liste_Infos($SharedKurseInfos);

	$query_part_ids=[];
	foreach($KursIDs as $kursID_tmp){
		array_push($query_part_ids," kursID = $kursID_tmp ");
	}
	$searchstr_ids=join(" OR ",$query_part_ids);

	$query_part=[];
	foreach($search_arr as $searchtmp){
		array_push($query_part,"(beschreibung LIKE '%$searchtmp%' OR titel LIKE '%$searchtmp%')");
	}
	$searchstr=join(" AND ",$query_part);

	$query="SELECT * FROM kurs WHERE ($searchstr) AND ($searchstr_ids)";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$KursArray=[];
	while($row=mysqli_fetch_assoc($ergebnis)){
		$kursID=$row['kursID'];
		$KursInfo=GetKursInfos($kursID);
		array_push($KursArray,$KursInfo);
	}
	return $KursArray;
}


function copy_Kurs($kursID_alt){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$kursID_neu=cp_kursListe($kursID_alt);
	// 	echo $kursID_neu;
	cp_folien($kursID_alt,$kursID_neu);
	// 	cp_Ablauf_gesamt($kursID_alt,$kursID_neu);
	include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/folie.php");
	$folienListe_neu=getFolienByKurs($kursID_neu);
	foreach($folienListe_neu as $folie){
		$fID_alt=$folie['cp_fID'];
		$fID_neu=$folie['fID'];
		cp_Ablauf_single($fID_alt,$fID_neu,$kursID_alt,$kursID_neu);
		cp_bausteine_match($fID_alt,$fID_neu);
		$mediaList_alt=get_mediaList_by_matchingKurs($kursID_alt,$fID_alt);
		foreach($mediaList_alt as $mediaID){
			$mediaID_alt=$mediaID;
			$mediaID_neu=cp_media_verlinkung_single($mediaID_alt);
			cp_media_match_single($fID_alt,$fID_neu,$kursID_alt,$kursID_neu,$mediaID_alt,$mediaID_neu);
		}
	}

}

function cp_kursListe($kursID_alt){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="CREATE TEMPORARY TABLE tmp SELECT * from kurs WHERE kursID=$kursID_alt";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$query="ALTER TABLE tmp drop kursID";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$query="INSERT INTO kurs SELECT 0,tmp.* FROM tmp";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$kursID_new=mysqli_insert_id ( $verbindung );
	$query="DROP TEMPORARY TABLE tmp;";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));

	$uID=$_SESSION['uID'];
	$query="INSERT INTO kurs_uID_match (kursID,uID) VALUES ($kursID_new,$uID)";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	return $kursID_new;
}

function cp_folien($kursID_alt,$kursID_neu){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	// 	$query="DROP TEMPORARY TABLE tmp;";
	// 	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$query="CREATE TEMPORARY TABLE tmp SELECT * from folien WHERE kursID=$kursID_alt";
	$ergebnis=mysqli_query($verbindung,$query) or die($query." => ".mysqli_error($verbindung));
	$query="ALTER TABLE tmp drop cp_fID";
	$ergebnis=mysqli_query($verbindung,$query) or die($query." => ".mysqli_error($verbindung));
	// 	$query="ALTER TABLE `tmp` CHANGE `fID` `cp_fID`";
	$query="ALTER TABLE `tmp` CHANGE `fID` `cp_fID` INT";
	$ergebnis=mysqli_query($verbindung,$query) or die($query." => ".mysqli_error($verbindung));
	$query="ALTER TABLE tmp MODIFY COLUMN cp_fID INT AFTER parameter";
	$ergebnis=mysqli_query($verbindung,$query) or die($query." => ".mysqli_error($verbindung));
	$query="UPDATE tmp SET kursID=$kursID_neu WHERE kursID=$kursID_alt";
	$ergebnis=mysqli_query($verbindung,$query) or die($query." => ".mysqli_error($verbindung));
	$query="INSERT INTO folien SELECT 0,tmp.* FROM tmp";
	$ergebnis=mysqli_query($verbindung,$query) or die($query." => ".mysqli_error($verbindung));
	$query="DROP TEMPORARY TABLE tmp;";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
}

/* function cp_Ablauf_gesamt($kursID_alt,$kursID_neu){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
}
 */
function cp_bausteine_match($fID_alt,$fID_neu){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="CREATE TEMPORARY TABLE tmp SELECT * from baustein_folie_position_match WHERE fID=$fID_alt";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	// 	$query="ALTER TABLE tmp drop id";
	// 	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$query="UPDATE tmp SET fID=$fID_neu WHERE fID=$fID_alt";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$query="INSERT INTO baustein_folie_position_match SELECT tmp.* FROM tmp";
	$ergebnis=mysqli_query($verbindung,$query) or die($query." => ".mysqli_error($verbindung));
	$query="DROP TEMPORARY TABLE tmp;";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));

}


function cp_Ablauf_single($fID_alt,$fID_neu,$kursID_alt,$kursID_neu){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="CREATE TEMPORARY TABLE tmp SELECT * from ablauf_master WHERE kursID=$kursID_alt AND fID=$fID_alt";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$query="ALTER TABLE tmp drop id";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$query="UPDATE tmp SET fID=$fID_neu, kursID=$kursID_neu WHERE fID=$fID_alt AND kursID=$kursID_alt";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$query="INSERT INTO ablauf_master SELECT 0,tmp.* FROM tmp";
	$ergebnis=mysqli_query($verbindung,$query) or die($query." => ".mysqli_error($verbindung));
	$query="DROP TEMPORARY TABLE tmp;";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
}


function cp_media_match_single($fID_alt,$fID_neu,$kursID_alt,$kursID_neu,$mediaID_alt,$mediaID_neu){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$uID=$_SESSION['uID'];
	$query="CREATE TEMPORARY TABLE tmp SELECT * from media_kurs_match WHERE kursID=$kursID_alt AND fID=$fID_alt AND mediaID=$mediaID_alt";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	// 	$query="ALTER TABLE tmp drop mediaID";
	// 	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$query="UPDATE tmp SET fID=$fID_neu, kursID=$kursID_neu, uID=$uID,mediaID=$mediaID_neu WHERE fID=$fID_alt AND kursID=$kursID_alt AND mediaID=$mediaID_alt";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$query="INSERT INTO media_kurs_match SELECT tmp.* FROM tmp";
	$ergebnis=mysqli_query($verbindung,$query) or die($query." => ".mysqli_error($verbindung));
	$query="DROP TEMPORARY TABLE tmp;";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
}

function cp_media_verlinkung_single($mediaID_alt){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$uID=$_SESSION['uID'];
	$query="CREATE TEMPORARY TABLE tmp SELECT * from media WHERE mediaID=$mediaID_alt";
	$ergebnis=mysqli_query($verbindung,$query) or die($query." => ".mysqli_error($verbindung));
	$query="ALTER TABLE tmp drop cp_mediaID";
	$ergebnis=mysqli_query($verbindung,$query) or die($query." => ".mysqli_error($verbindung));
	$query="ALTER TABLE `tmp` CHANGE `mediaID` `cp_mediaID` INT";
	$ergebnis=mysqli_query($verbindung,$query) or die($query." => ".mysqli_error($verbindung));
	$uID=$_SESSION['uID'];
	$query="UPDATE tmp SET uID=$uID";
	$ergebnis=mysqli_query($verbindung,$query) or die($query." => ".mysqli_error($verbindung));
	$query="INSERT INTO media SELECT 0,tmp.* FROM tmp";
	$ergebnis=mysqli_query($verbindung,$query) or die($query." => ".mysqli_error($verbindung));
	$mediaID_neu=mysqli_insert_id ( $verbindung );
	$query="DROP TEMPORARY TABLE tmp;";
	$ergebnis=mysqli_query($verbindung,$query) or die($query." => ".mysqli_error($verbindung));
	return $mediaID_neu;
}


/* function cp_media($fID_alt,$fID_neu,$kursID_alt,$kursID_neu){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$uID=$_SESSION['uID'];
	$query="CREATE TEMPORARY TABLE tmp SELECT * from media WHERE mediaID=$mediaID_alt";
	$ergebnis=mysqli_query($verbindung,$query) or die($query." => ".mysqli_error($verbindung));
	$query="ALTER TABLE tmp drop cp_mediaID";
	$ergebnis=mysqli_query($verbindung,$query) or die($query." => ".mysqli_error($verbindung));
	$query="ALTER TABLE `tmp` CHANGE `mediaID` `cp_mediaID` INT";
	$ergebnis=mysqli_query($verbindung,$query) or die($query." => ".mysqli_error($verbindung));
	$uID=$_SESSION['uID'];
	$query="UPDATE tmp SET uID=$uID";
	$ergebnis=mysqli_query($verbindung,$query) or die($query." => ".mysqli_error($verbindung));
	$query="INSERT INTO media SELECT 0,tmp.* FROM tmp";
	$ergebnis=mysqli_query($verbindung,$query) or die($query." => ".mysqli_error($verbindung));
	$mediaID_neu=mysqli_insert_id ( $verbindung );
	$query="DROP TEMPORARY TABLE tmp;";
	$ergebnis=mysqli_query($verbindung,$query) or die($query." => ".mysqli_error($verbindung));

} */