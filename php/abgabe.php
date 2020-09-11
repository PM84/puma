<?php
//Hallo

function getAbgabeListeOf_Modul($kursID,$modID,$filterArr=array(2,3)){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT *, tA.parameter as AParameter, tF.parameter as FParameter, tA.token as abToken, tT.token as TnToken from folien as tF LEFT JOIN abgabe tA ON tA.fID=tF.fID LEFT JOIN user_teilnehmer tT on tT.token=tA.token WHERE tF.kursID='$kursID' AND tF.modID='$modID'  ORDER BY tA.abID DESC";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$abArray=array();
	while($row=mysqli_fetch_assoc($ergebnis)){
		if(!in_array($row['abTyp'],$filterArr)){
			array_push($abArray,$row);
		}
	}
	return $abArray;
}

function getAbgabeOfVideovertonung($fID,$token){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT *, tA.parameter as AParameter, tF.parameter as FParameter, tA.token as abToken, tT.token as TnToken from folien as tF LEFT JOIN abgabe tA ON tA.fID=tF.fID LEFT JOIN user_teilnehmer tT on tT.token=tA.token WHERE tF.fID='$fID' AND tA.token='$token' AND tF.modID=1";
	// echo $query;
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$row=mysqli_fetch_assoc($ergebnis);
	return $row;
}

function getAbgabeInfos_with_Feedback($fID,$abID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT tA.abID as A_abID, tA.fID fID, tT.name name, tT.vname vname, tA.parameter as A_Parameter, tA2.abID F_abID, tA2.parameter as F_Parameter, tA.token A_token, tA2.token F_token FROM abgabe tA INNER JOIN abgabe tA2 on tA2.zu_abID=tA.abID INNER JOIN user_teilnehmer tT on tT.token=tA.token WHERE tA.abID='$abID' AND tA.fID='$fID';";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$abArray=array();
	while($row=mysqli_fetch_assoc($ergebnis)){
		array_push($abArray,$row);
	}
	return $abArray;
}



function getAbgabeInfo($fID,$token,$abTyp=3){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT * FROM abgabe WHERE fID=$fID and token='$token' and abTyp='$abTyp'";
// 	 	echo $query;
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$row=mysqli_fetch_assoc($ergebnis);
	return $row;
}

function getAbgabe_abID($fID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT * FROM abgabe WHERE fID=$fID";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$row=mysqli_fetch_assoc($ergebnis);
	return $row['abID'];
}

function getAbgabeInfoByAbID($abID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT * FROM abgabe tA INNER JOIN user_teilnehmer tT ON tA.token=tT.token WHERE tA.abID=$abID";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$row=mysqli_fetch_assoc($ergebnis);
	return $row;
}


function get_zu_AbgabeInfoByAbID($abID,$fID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT * FROM abgabe tA INNER JOIN user_teilnehmer tT on tT.token=tA.token WHERE tA.zu_abID=$abID AND tA.fID=$fID";
	// 	echo $query;
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$abArray=array();
	while($row=mysqli_fetch_assoc($ergebnis)){
		array_push($abArray,$row);
	}
	return $abArray;
}

function getAbgabeInfos($fID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT * FROM abgabe WHERE fID=$fID";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$abArray=array();
	while($row=mysqli_fetch_assoc($ergebnis)){
		array_push($abArray,$row);
	}
	return $abArray;
}

function getAbgabeBy_abID_token_aTyp($token,$abTyp,$abID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT * FROM abgabe WHERE token='$token' AND zu_abID=$abID AND abTyp=$abTyp";
	// 	echo $query;
	$ergebnis=mysqli_query($verbindung,$query);
	$abArray=array();
	while($row=mysqli_fetch_assoc($ergebnis)){
		array_push($abArray,$row);
	}
	return $abArray;
}

function getAbgabeBy_fID_token_aTyp($token,$abTyp,$fID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT * FROM abgabe WHERE token='$token' AND fID=$fID AND abTyp=$abTyp";
	// 	echo $query;
	$ergebnis=mysqli_query($verbindung,$query);
	$abArray=array();
	while($row=mysqli_fetch_assoc($ergebnis)){
		array_push($abArray,$row);
	}
	return $abArray;
}

function get_all_Abgaben_by_token($token){
	// überprüft ob ein Token bereits eingesetzt wurde.
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT * FROM abgabe WHERE token='$token'";
	// 	echo $query;
	$ergebnis=mysqli_query($verbindung,$query);
	$abArray=array();
	while($row=mysqli_fetch_assoc($ergebnis)){
		array_push($abArray,$row);
	}
	return $abArray;
}

function get_all_Abgaben_of_fID_by_token($fID,$token){
	// überprüft ob ein Token bereits eingesetzt wurde.
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT * FROM abgabe WHERE token='$token' and fID='$fID'";
	// 	echo $query;
	$ergebnis=mysqli_query($verbindung,$query);
	$abArray=array();
	while($row=mysqli_fetch_assoc($ergebnis)){
		array_push($abArray,$row);
	}
	return $abArray;
}

function getAbgabeBy_aTyp($abTyp){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT * FROM abgabe WHERE abTyp=$abTyp";
	// 	echo $query;
	$ergebnis=mysqli_query($verbindung,$query);
	$abArray=array();
	while($row=mysqli_fetch_assoc($ergebnis)){
		array_push($abArray,$row);
	}
	return $abArray;
}



function get_FB_AbgabeInfoBy_AbID_Bew($abID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT * FROM abgabe WHERE zu_abID=$abID Group By zu_abID";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$abArray=array();
	while($row=mysqli_fetch_assoc($ergebnis)){
		array_push($abArray,$row);
	}
	return $abArray;
}


function get_FB_folien($token){
	$abTyp=1;
	$folArr=getAbgabeBy_aTyp($abTyp);
	$retArr=array();	
	foreach($folArr as $folie){
		$abID=$folie['abID'];
		$fID=$folie['fID'];
		$abInfos=get_FB_AbgabeInfoBy_AbID_Bew($abID);
		foreach($abInfos as $fb){
			$tmpArr=array('abID'=>$abID,'FB_fID'=>$fID);
			array_push($retArr,$tmpArr);
		}
	}
	return $retArr;
}

function check_ob_vertonung_abgegeben($fID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$token=$_SESSION['t'];
	$query="SELECT * FROM abgabe WHERE fID='$fID' AND token='$token'"; // AND parameter LIKE '%\"abgegeben\":1%'";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$row=mysqli_fetch_assoc($ergebnis);
	$parameter=json_decode($row['parameter'],true);
	$audioArr=$parameter['audioArr'];
	$retval=false;
	foreach($audioArr as $audio){
		if(isset($audio['abgegeben']) && $audio['abgegeben']==1){
			$retval=true;
		}
	}
	return 	$retval;
}

function check_ob_vertonung_abgegeben_overall($fID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$token=$_SESSION['t'];
	$query="SELECT * FROM abgabe WHERE fID='$fID'"; // AND parameter LIKE '%\"abgegeben\":1%'";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$row=mysqli_fetch_assoc($ergebnis);
	$parameter=json_decode($row['parameter'],true);
	$audioArr=$parameter['audioArr'];
	$retval=false;
	foreach($audioArr as $audio){
		if(isset($audio['abgegeben']) && $audio['abgegeben']==1){
			$retval=true;
		}
	}
	return 	$retval;
}

function check_ob_folie_abgegeben($fID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$token=$_SESSION['t'];
	$query="SELECT * FROM abgabe WHERE fID='$fID' AND token='$token'"; // AND parameter LIKE '%\"abgegeben\":1%'";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$row=mysqli_fetch_assoc($ergebnis);
	$parameter=json_decode($row['parameter'],true);
	if(isset($parameter['audioArr'])){
		return check_ob_vertonung_abgegeben($fID);
	}else{
		// 		var_dump($parameter);
		if(isset($parameter['abgegeben']) && $parameter['abgegeben']==1 ){
			return true;
		}else{
			return false;
		}
	}
}

function check_ob_folie_abgegeben_overall($fID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$token=$_SESSION['t'];
	$query="SELECT * FROM abgabe WHERE fID='$fID'"; // AND parameter LIKE '%\"abgegeben\":1%'";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$row=mysqli_fetch_assoc($ergebnis);
	$parameter=json_decode($row['parameter'],true);
	if(isset($parameter['audioArr'])){
		return check_ob_vertonung_abgegeben_overall($fID);
	}else{
		// 		var_dump($parameter);
		if(isset($parameter['abgegeben']) && $parameter['abgegeben']==1 ){
			return true;
		}else{
			return false;
		}
	}
}