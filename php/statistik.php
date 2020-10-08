<?php
// if (session_status() == PHP_SESSION_NONE) {
session_start();
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/system.php");

// }
switch($_POST['PostFktn']){
	case 'GetKonfidentsChart':
		$zu_abID=intval($_POST['abID']);
		$Bew_fID=intval($_POST['bew_fID']);
		$StatArr=get_Statistik_konfidentschart($zu_abID,$Bew_fID);
		// 		echo "TEST";
		echo json_encode($StatArr);
		break;

	case 'GetKonfidentsChart_Evaluation':
		$fID=intval($_POST['fID']);
		$Block=mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($_POST['Block']), ENT_QUOTES , "UTF-8"));
		$StatArr=get_Statistik_konfidentschart_evaluation($fID,$Block);
		echo json_encode($StatArr);
		break;
}


function get_Statistik_konfidentschart_evaluation($fID,$Block){
	$FrArr=getAlleVerwendeteFragen_Evaluation($fID,$Block);
	// 	$FrArr=array(17,26);
	// 	echo "==========x";
	
	// 	echo "x==========";
	$FragenArr=$FrArr['FragenArr'];
	$FragenWerte=$FrArr['FragenWerte'];
	$FragenInfoArr=$FrArr['FragenInfoArr'];
	$retArray=[];
	foreach($FragenArr as $frage){
		$n=count($FragenWerte[$frage]);
		$MW=getMittelwert($FragenWerte[$frage]);
		$StdAbw=getStandardabweichung($FragenWerte[$frage],$MW);
		$Var=getVarianz($FragenWerte[$frage],$MW);
		array_push($retArray,array("FrageID"=> $frage, "n" => $n, "MW"=>$MW, "StdAbw" => $StdAbw, "Varianz" => $Var,"FragenInfoArr"=>$FragenInfoArr));
	}

	// Auswertung aller DOZENTEN wird erstellt
	
	$FragenWerte=$FrArr['Dozent_FragenWerteArr'];
	
	$Dozent_retArray=[];
	if(count($FragenWerte)>0){
		foreach($FragenArr as $frage){
			$n=count($FragenWerte[$frage]);
			$MW=getMittelwert($FragenWerte[$frage]);
			$StdAbw=getStandardabweichung($FragenWerte[$frage],$MW);
			$Var=getVarianz($FragenWerte[$frage],$MW);
			array_push($Dozent_retArray,array("FrageID"=> $frage, "n" => $n, "MW"=>$MW, "StdAbw" => $StdAbw, "Varianz" => $Var,"FragenInfoArr"=>$FragenInfoArr));
		}
	}
	
	$retArray['dozent']=[];
	if(isset($Dozent_retArray[0]['n']) && $Dozent_retArray[0]['n']>0){
		$retArray['dozent']=$Dozent_retArray;
	}
	// 	echo "==>";
	
	// 		echo "<==";
	// Auswertung OWN-Values
	$FragenWerte=$FrArr['own'];
	
	$retArray['own']=[];
	if(count($FragenWerte)>0){
		$retArray['own']=$FragenWerte;
	}

	$retArray['FragenInfoArr']=$FragenInfoArr;

	$FragenWerte=$FrArr['input_Arr'];
	$retArray['input_Arr']=[];
	if(count($FragenWerte)>0){
		$retArray['input_Arr']=$FragenWerte;
	}

	// 	echo "==>";
	
	// 		echo "<==";
	return $retArray;

}

function get_Statistik_konfidentschart($zu_abID,$Bew_fID){
	$FrArr=getAlleVerwendeteFragen($zu_abID,$Bew_fID);
	// 	$FrArr=array(17,26);
	// 	echo "==========x";
	
	// 	echo "x==========";
	$FragenArr=$FrArr['FragenArr'];
	$FragenWerte=$FrArr['FragenWerte'];
	$FragenInfoArr=$FrArr['FragenInfoArr'];

	
	// Auswertung aller Teilnehmer wird erstellt
	$retArray=[];
	foreach($FragenArr as $frage){
		$n=count($FragenWerte[$frage]);
		$MW=getMittelwert($FragenWerte[$frage]);
		$StdAbw=getStandardabweichung($FragenWerte[$frage],$MW);
		$Var=getVarianz($FragenWerte[$frage],$MW);
		array_push($retArray,array("FrageID"=> $frage, "n" => $n, "MW"=>$MW, "StdAbw" => $StdAbw, "Varianz" => $Var,"FragenInfoArr"=>$FragenInfoArr));
	}

	// Auswertung aller DOZENTEN wird erstellt
	
	$FragenWerte=$FrArr['Dozent_FragenWerteArr'];
	
	$Dozent_retArray=[];
	if(count($FragenWerte)>0){
		foreach($FragenArr as $frage){
			$n=count($FragenWerte[$frage]);
			$MW=getMittelwert($FragenWerte[$frage]);
			$StdAbw=getStandardabweichung($FragenWerte[$frage],$MW);
			$Var=getVarianz($FragenWerte[$frage],$MW);
			array_push($Dozent_retArray,array("FrageID"=> $frage, "n" => $n, "MW"=>$MW, "StdAbw" => $StdAbw, "Varianz" => $Var,"FragenInfoArr"=>$FragenInfoArr));
		}
	}
	
	$retArray['dozent']=[];
	if(isset($Dozent_retArray[0]['n']) && $Dozent_retArray[0]['n']>0){
		$retArray['dozent']=$Dozent_retArray;
	}
	// 	echo "==>";
	
	// 		echo "<==";
	// Auswertung OWN-Values
	$FragenWerte=$FrArr['own'];
	
	$retArray['own']=[];
	if(count($FragenWerte)>0){
		$retArray['own']=$FragenWerte;
	}

	// 	echo "==>";
	
	// 		echo "<==";
	return $retArray;
}

function getAlleVerwendeteFragen_Evaluation($fID,$Block){
	// es muss ein mysqli ergebnis eingefügt werden, vgl. SELECT * FROM abgabe WHERE zu_abID=$zu_abID
	include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/frage.php");
	include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/teilnehmer.php");
	// echo "Test";
	$Dozent_FragenWerteArr=[];
	$dozentArr=getDozent_tnInfos(1);
	$dozentTokenArr=[];
	$own_FragenWerteArr=[];
	foreach($dozentArr as $dozent){
		array_push($dozentTokenArr,$dozent['token']);
	}
	
	// echo $fID;
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	// 		echo "===>$zu_abID<===";
	if($fID>0){
		$query="SELECT * FROM abgabe WHERE fID=$fID";
	}else{
		exit;
	}
	//  		echo $query;
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$inputArr=[];
	$FragenArr=[];
	$FragenWerteArr=[];
	while($row=mysqli_fetch_assoc($ergebnis)){
		//  		echo $row['parameter'];
		// 		echo "FragenWerte_$Block";
		$parameter=json_decode($row['parameter'],true);
		if(isset($parameter["FragenWerte_$Block"])){
			$FragenWerte=$parameter["FragenWerte_$Block"];
			/* 
		if($row['token']==$_SESSION['t']){
			//	Die eigenen Antworten werden in das Return Array geschrieben. 
			$FragenInfoArr["own"]=[];
			$FragenInfoArr["own"]=$FragenWerte;
		}
 */	
			foreach($FragenWerte as $key=>$value){
				$FrageInfo=getFrageInfo($key);
				switch($FrageInfo['SkalaTyp']){
					case 1:
						if(!in_array($key, $FragenArr)){ // 
							//	Wenn die Frage noch nicht in der Liste der verwendeten Fragen ist, dann wird sie hinzugefügt
							array_push($FragenArr,$key);
						}
						if(!isset($FragenWerteArr[$key]) || !is_array($FragenWerteArr[$key])){
							//	ein Unterarray wird erstellt, das im Anschluss gefüllt werden kann.
							$FragenWerteArr[$key]=[];
							$FragenInfoArr[$key]=[];
						}
						//	die Fragen Details (Titel Text etc.) werden in das Rückmelde Array geschrieben.
						array_push($FragenInfoArr[$key],json_decode($FrageInfo['parameter'],true));
						array_push($FragenWerteArr[$key],$value);
						// 			echo "====".in_array($row['token'],$dozentTokenArr)."====";
						if(in_array($row['token'],$dozentTokenArr)){
							if(!isset($Dozent_FragenWerteArr[$key]) || !is_array($Dozent_FragenWerteArr[$key])){
								//	ein Unterarray wird erstellt, das im Anschluss gefüllt werden kann.
								$Dozent_FragenWerteArr[$key]=[];
							}
							array_push($Dozent_FragenWerteArr[$key],$value);
						}
						if($row['token']==$_SESSION['t']){
							// 		 if(isset($own_FragenWerteArr[$key]) || !is_array($own_FragenWerteArr[$key]) ){
							//	ein Unterarray wird erstellt, das im Anschluss gefüllt werden kann.
							$own_FragenWerteArr[$key]=[];
							// 				}
							$own_FragenWerteArr[$key]=$value;
						}
						break;
					case 3:
						if(!isset($inputArr[$key]) || !is_array($inputArr[$key])){
							//	ein Unterarray wird erstellt, das im Anschluss gefüllt werden kann.
							$inputArr[$key]=[];
							$FragenInfoArr[$key]=[];
						}
						array_push($inputArr[$key],$value);
						array_push($FragenInfoArr[$key],json_decode($FrageInfo['parameter'],true));
						break;
				}
			}
		}
	}
	// 	echo "==========";
	
	// 	echo "==========";
	return array("FragenWerte"=>$FragenWerteArr, "FragenArr" => $FragenArr,"FragenInfoArr"=>$FragenInfoArr,"Dozent_FragenWerteArr"=>$Dozent_FragenWerteArr,"own"=>$own_FragenWerteArr,"input_Arr"=>$inputArr);
}

function getAlleVerwendeteFragen($zu_abID,$Bew_fID){
	// es muss ein mysqli ergebnis eingefügt werden, vgl. SELECT * FROM abgabe WHERE zu_abID=$zu_abID
	include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/frage.php");
	include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/teilnehmer.php");
	// echo "Test";
	$Dozent_FragenWerteArr=[];
	$dozentArr=getDozent_tnInfos(1);
	$dozentTokenArr=[];
	$own_FragenWerteArr=[];
	foreach($dozentArr as $dozent){
		array_push($dozentTokenArr,$dozent['token']);
	}
	

	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	// 		echo "===>$zu_abID<===";
	if($zu_abID>0){
		$query="SELECT * FROM abgabe WHERE zu_abID=$zu_abID AND fID=$Bew_fID";
	}else{
		$query="SELECT * FROM abgabe WHERE fID=$Bew_fID";
	}
	// 		echo $query;
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));

	$FragenArr=[];
	$FragenWerteArr=[];
	while($row=mysqli_fetch_assoc($ergebnis)){
		$parameter=json_decode($row['parameter'],true);
		$FragenWerte=$parameter['FragenWerte'];
		/* 		if($row['token']==$_SESSION['t']){
			//	Die eigenen Antworten werden in das Return Array geschrieben. 
			$FragenInfoArr["own"]=[];
			$FragenInfoArr["own"]=$FragenWerte;
		}
 */		foreach($FragenWerte as $key=>$value){
	 if(!in_array($key, $FragenArr)){
		 //	Wenn die Frage noch nicht in der Liste der verwendeten Fragen ist, dann wird sie hinzugefügt
		 array_push($FragenArr,$key);
	 }
	 if(!isset($FragenWerteArr[$key]) || !is_array($FragenWerteArr[$key])){
		 //	ein Unterarray wird erstellt, das im Anschluss gefüllt werden kann.
		 $FragenWerteArr[$key]=[];
		 $FragenInfoArr[$key]=[];
	 }
	 //	die Fragen Details (Titel Text etc.) werden in das Rückmelde Array geschrieben.
	 $FrageInfo=getFrageInfo($key);
	 array_push($FragenInfoArr[$key],json_decode($FrageInfo['parameter'],true));
	 array_push($FragenWerteArr[$key],$value);
	 // 			echo "====".in_array($row['token'],$dozentTokenArr)."====";
	 if(in_array($row['token'],$dozentTokenArr)){
		 if(!isset($Dozent_FragenWerteArr[$key]) || !is_array($Dozent_FragenWerteArr[$key])){
			 //	ein Unterarray wird erstellt, das im Anschluss gefüllt werden kann.
			 $Dozent_FragenWerteArr[$key]=[];
		 }
		 array_push($Dozent_FragenWerteArr[$key],$value);
	 }
	 if($row['token']==$_SESSION['t']){
		 // 		 if(isset($own_FragenWerteArr[$key]) || !is_array($own_FragenWerteArr[$key]) ){
		 //	ein Unterarray wird erstellt, das im Anschluss gefüllt werden kann.
		 $own_FragenWerteArr[$key]=[];
		 // 				}
		 $own_FragenWerteArr[$key]=$value;
	 }
 }
	}
	// 	echo "==========";
	
	// 	echo "==========";
	return array("FragenWerte"=>$FragenWerteArr, "FragenArr" => $FragenArr,"FragenInfoArr"=>$FragenInfoArr,"Dozent_FragenWerteArr"=>$Dozent_FragenWerteArr,"own"=>$own_FragenWerteArr);
}

function getMittelwert($rowOfValeus){
	$sumOfValues=array_sum($rowOfValeus);
	$countOfValues=count($rowOfValeus);
	if($countOfValues>0){
		$erw=$sumOfValues/$countOfValues;
	}
	return $erw;
}

function getStandardabweichung($rowOfValeus,$Erwartungswert){
	$iLauf=0;
	foreach($rowOfValeus as $value){
		$ValueArr[$iLauf]=$value*$value;
		$iLauf++;
	}
	return sqrt(array_sum($ValueArr)/count($rowOfValeus)-floatval($Erwartungswert)*floatval($Erwartungswert)); //Standardabweichung
}

function getVarianz($rowOfValeus,$Erwartungswert){
	$iLauf=0;
	foreach($rowOfValeus as $value){
		$ValueArr[$iLauf]=$value*$value;
		$iLauf++;
	}
	return array_sum($ValueArr)/count($rowOfValeus)-floatval($Erwartungswert)*floatval($Erwartungswert);  //Varianz
}