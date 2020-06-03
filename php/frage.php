<?php


function getFrageInfo($FrageID){
	include($_SERVER['DOCUMENT_ROOT']."/config.php");
	$query="SELECT * FROM fragen WHERE FrageID=$FrageID";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$row=mysqli_fetch_assoc($ergebnis);
	return $row;
}

function getFragenByUser($uID){
	include($_SERVER['DOCUMENT_ROOT']."/config.php");
	$fragenArray=array();
	$query="SELECT * FROM fragen WHERE uID=$uID";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	while($row=mysqli_fetch_assoc($ergebnis)){
		// 		var_dump($row);
		array_push($fragenArray,$row);
	}
	return $fragenArray;
}

function InsertFrage($uID,$SkalaTyp,$PostJson){
	include($_SERVER['DOCUMENT_ROOT']."/config.php");
	$query="INSERT INTO fragen (uID,parameter,SkalaTyp) VALUES ('$uID','$PostJson',$SkalaTyp)";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	return mysqli_insert_id($verbindung);

}


function UpdateFrage($uID,$SkalaTyp,$FrageID,$PostJson){
	include($_SERVER['DOCUMENT_ROOT']."/config.php");
	$query="UPDATE fragen SET SkalaTyp='$SkalaTyp' ,parameter= '$PostJson' WHERE FrageID='$FrageID'";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	unset($_SESSION['FrageID']);
}


function UpdateFrageGruppe($FGroupID,$PostJson){
	include($_SERVER['DOCUMENT_ROOT']."/config.php");
	$query="UPDATE fragen_groups SET parameter= '$PostJson' WHERE FGroupID='$FGroupID'";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));

}

function InsertFrageGruppe($uID,$PostJson){
	include($_SERVER['DOCUMENT_ROOT']."/config.php");
	$query="INSERT INTO fragen_groups (uID,parameter) VALUES ('$uID','$PostJson')";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));

}


function Get_Fragen_Gruppen($uID){
	include($_SERVER['DOCUMENT_ROOT']."/config.php");
	$groupArray=array();
	$query="SELECT * FROM fragen_groups WHERE uID=$uID";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	while($row=mysqli_fetch_assoc($ergebnis)){
		// 		var_dump($row);
		array_push($groupArray,$row);
	}
	return $groupArray;
}

function InsertGroupMatches($GroupArr=array(),$FrageID){
	include($_SERVER['DOCUMENT_ROOT']."/config.php");

	$query="DELETE FROM fragen_groups_fragen_match WHERE FrageID=$FrageID";
	mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));


	foreach($GroupArr as $group){
		// 		$FGroupID=
		// 		var_dump($GroupArr);
		// 		var_dump($group);
		$query="INSERT INTO fragen_groups_fragen_match (FGroupID,FrageID) VALUES ('$group','$FrageID')";
		$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	}
}

function getGroupInfo($FGroupID){
	include($_SERVER['DOCUMENT_ROOT']."/config.php");
	$query="SELECT * FROM fragen_groups WHERE FGroupID=$FGroupID";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$row=mysqli_fetch_assoc($ergebnis);
	return $row;
}

function getFrageGroupsByFrageID($FrageID){
	include($_SERVER['DOCUMENT_ROOT']."/config.php");
	$query="SELECT * FROM fragen_groups_fragen_match WHERE FrageID=$FrageID";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$groupArray=array();
	while($row=mysqli_fetch_assoc($ergebnis)){
		array_push($groupArray,$row['FGroupID']);
	}
	return $groupArray;
}

function del_ALLE_Fragen_in_Fragegruppen($fGroup){
	include($_SERVER['DOCUMENT_ROOT']."/config.php");
	$uID=$_SESSION['uID'];
	$query="DELETE tabFragen FROM fragen tabFragen JOIN fragen_groups_fragen_match tabGroups ON tabFragen.FrageID=tabGroups.FrageID WHERE tabGroups.FGroupID=$fGroup AND tabFragen.uID='$uID'";
	// 	$query;
	$ergebnis=mysqli_query($verbindung,$query) or die($query." ===> ". mysqli_error($verbindung));
}

function getFragenByGroups($FGroupID){
	include($_SERVER['DOCUMENT_ROOT']."/config.php");
	$query="SELECT * FROM fragen_groups_fragen_match WHERE FGroupID=$FGroupID";
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$FrageArray=array();
	while($row=mysqli_fetch_assoc($ergebnis)){
		array_push($FrageArray,$row['FrageID']);
	}
	return $FrageArray;
}


function import_txt_frageListe($csvFile,$del_Fragen_in_Fragegruppen){
	include($_SERVER['DOCUMENT_ROOT']."/config.php");
	include_once($_SERVER['DOCUMENT_ROOT']."/php/system.php");
	if(($handle = fopen($csvFile, 'r')) !== FALSE) {
		// necessary if a large csv file
		set_time_limit(0);

		$row = 0;
		$delFGroupArr=array();

		while(($data = fgetcsv($handle, 1000, ';')) !== FALSE) {
			if($row==0){
				// 					var_dump($data);
				$colTitelArr=get_col_titel_from_first_row($data);
// 				var_dump($colTitelArr);
			}else{
				// number of fields in the csv
				//                 $col_count = count($data);
				$PostArr=array();
				// $FrageGruppe=array();
				foreach($colTitelArr as $colTitel => $colID){
					if($colTitel!="FrageGruppe"){
						switch($colTitel){
							case "initVal":
								if(intval($data[$colID])==1){
									$PostArr[$colTitel]="on";
								}else{
									$PostArr[$colTitel]="off";

								}
								break;
							case "initToolTip":
								if(intval($data[$colID])==1){
									$PostArr[$colTitel]="on";
								}else{
									$PostArr[$colTitel]="off";

								}
								break;
							case "noAnswer":
								if(intval($data[$colID])==1){
									$PostArr[$colTitel]="on";
								}else{
									$PostArr[$colTitel]="off";

								}
								break;
							case "hideTrack":
								if(intval($data[$colID])==1){
									$PostArr[$colTitel]="on";
								}else{
									$PostArr[$colTitel]="off";

								}
								break;
							case "hideSelection":
								if(intval($data[$colID])==1){
									$PostArr[$colTitel]="on";
								}else{
									$PostArr[$colTitel]="off";

								}
								break;

							default:
								$PostArr[$colTitel]=mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($data[$colID]), ENT_QUOTES , "UTF-8"));
								break;

						}
					}else{
						$FrageGruppe=explode(",",mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($data[$colID]), ENT_QUOTES , "UTF-8")));
					}

				}
				$PostJson=json_encode($PostArr);
				// 				echo $PostJson;
				// 				var_dump($FrageGruppe);
				$FrageID=InsertFrage($_SESSION['uID'],intval($PostArr['SkalaTyp']),$PostJson);

				if($del_Fragen_in_Fragegruppen==1){
					foreach($FrageGruppe as $fGroup){
						if(!in_array($fGroup,$delFGroupArr)){
							del_ALLE_Fragen_in_Fragegruppen($fGroup);
// 							echo "<br>Gruppe: $fGroup gelöscht!";
							array_push($delFGroupArr,$fGroup);
						}
					}
				}

				InsertGroupMatches($FrageGruppe,$FrageID);


			}

			// get the values from the csv
			// 			$csv[$row]['col1'] = $data[0];
			// 			$csv[$row]['col2'] = $data[1];

			// inc the row
			$row++;
		}
		fclose($handle);
	}
	// 	var_dump ($csv);

}