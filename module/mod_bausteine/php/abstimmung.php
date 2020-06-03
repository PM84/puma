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

function get_abstimmung_OptArray($fID,$abst_name,$bID,$Block){
	$abst_name=$abst_name."_".$Block;
	include($_SERVER['DOCUMENT_ROOT']."/config.php");
	$query="SELECT * FROM abgabe WHERE fID=$fID";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$Stimmen=array();
	while($row=mysqli_fetch_assoc($ergebnis)){
		$parameter=json_decode($row['parameter'],true);
		if(array_key_exists ( $abst_name , $parameter)){
			$Stimme=$parameter[$abst_name];
			// var_dump($Stimme);	
			if(is_array($Stimme)){
				foreach($Stimme as $vote){
					if(isset($Stimmen[$vote])){
						$Stimmen[$vote]=$Stimmen[$vote]+1;
					}else{
						$Stimmen[$vote]=1;
					}

				}
			}else{
				if(isset($Stimmen[$Stimme])){
					$Stimmen[$Stimme]=$Stimmen[$Stimme]+1;
				}else{
					$Stimmen[$Stimme]=1;
				}
			}
		}
	}
	return  convertToGoogleAPI_json_Data($Stimmen,$bID,$Block);
	// 	return json_encode($Stimmen);
}

function convertToGoogleAPI_json_Data($Stimmen,$bID=0,$Block){
	$cols=array(
		$colTitel=array("id"=>"","label"=>"Optionen","pattern"=>"","type"=>"string"),
		$colNumbers=array("id"=>"","label"=>"Anzahl","pattern"=>"","type"=>"number")
	);
	$table['cols']=$cols;
	$abstOptionen=get_abstimmung_options($bID,$Block);

	for($iLauf=0;$iLauf<count($abstOptionen);$iLauf++) {

		$temp = array();


		$temp[] = array('v' => (string) $abstOptionen[$iLauf]); 
		// var_dump($Stimmen);
		if(isset($Stimmen[$iLauf])){
			$temp[] = array('v' => (int) $Stimmen[$iLauf]); 
			$rows[] = array('c' => $temp);
		}else{
			$temp[] = array('v' => (int) 0); 
			$rows[] = array('c' => $temp);

		}
	}
	$table['rows'] =array();
	$table['rows'] = $rows;

	$jsonTable = json_encode($table);

	return $jsonTable;

}

function get_abstimmung_options($bID,$Block){
	include($_SERVER['DOCUMENT_ROOT']."/config.php");
	$query="SELECT * FROM bausteine WHERE bID=$bID";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$row=mysqli_fetch_assoc($ergebnis);
	$parameter=json_decode($row['parameter'],true);
	$abst_optionen=$parameter['abstOption'];
	return $abst_optionen;
}


function get_abstimmung_numberOfOpt($fID,$abst_name){
	$array=json_decode(get_abstimmung_OptArray($fID,$abst_name));
	return count($array);
}