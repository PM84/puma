<?php
if(isset($_POST['fkt'])){
	switch($_POST['fkt']){
		case "get_numberOfWords":
			$aktNumber=$_POST['aktNbr'];
			$BlockName=$_POST['BlockName'];
			$fID=$_POST['fID'];
			$newNumber=get_numberOfWords($fID,$BlockName);
			if(intval($aktNumber)==intval($newNumber)){echo 0;}else{echo 1;}
			break;
	}
}

function get_WC_WortArray($fID,$WC_name){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT * FROM abgabe WHERE fID=$fID";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$woerter=array();
	while($row=mysqli_fetch_assoc($ergebnis)){
		$parameter=json_decode($row['parameter'],true);
		if(array_key_exists ( $WC_name , $parameter)){
			$woerterTMP=$parameter[$WC_name];
			foreach($woerterTMP as $wort){
				array_push($woerter,$wort);
			}
		}
	}
	return json_encode($woerter);
}


function get_numberOfWords($fID,$WC_name){
	$array=json_decode(get_WC_WortArray($fID,$WC_name));
	return count($array);
}