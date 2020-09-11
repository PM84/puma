<?php
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/system.php");

$csv = array();

// check there are no errors
if($_FILES['csv']['error'] == 0){
	$name = $_FILES['csv']['name'];
	$ext = strtolower(end(explode('.', $_FILES['csv']['name'])));
	$type = $_FILES['csv']['type'];
	$tmpName = $_FILES['csv']['tmp_name'];

	$csv=processCsv($tmpName);
	foreach($csv as $schule){
		// 	foreach($csv as $key => $value ){
		WriteDataToDB($schule);
// 		echo "<hr>";
	}
//  	var_dump($csv);
}

// echo htmlspecialchars ("﻿SchulNr",ENT_COMPAT,'ISO-8859-1', true);
function WriteDataToDB($valueArray){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/system.php");
	$values=array();
	foreach($valueArray as $key => $value ){
		if($key=="﻿SchulNr"){$key="sNr";}
		$values[mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($key), ENT_QUOTES , "UTF-8"))]=mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($value), ENT_QUOTES , "UTF-8"));
//  		echo mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($key), ENT_QUOTES , "UTF-8"))." => $value<br>";
	}
// 	echo "===".$values['SchulNr']."===<br>";
// 	var_dump($values);
	$query="INSERT IGNORE INTO schule_daten (SchulNr,Bundesland,Name,sTyp,rechtlicherStatus,strasse,plz,ort,url,email) VALUES ('".$values['sNr']."','1','".$values['Name']."','".$values['Schultyp']."','".$values['rechtlicherStatus']."','".$values['Strasse']."','".$values['PLZ']."','".$values['Ort']."','".$values['Webadresse']."','".$values['Email']."')";
	echo "<br>".$query."<br>"; 
	 mysqli_query($verbindung,$query)or die(mysqli_error($verbindung));
}


function processCsv($absolutePath)
{
	$csv = array_map('str_getcsv', file($absolutePath),array_fill(0, count(file($absolutePath)), ';'));
	$headers = $csv[0];
	unset($csv[0]);
	$rowsWithKeys = [];
	foreach ($csv as $row) {
		$newRow = [];
		foreach ($headers as $k => $key) {
			$newRow[$key] = $row[$k];
		}
		$rowsWithKeys[] = $newRow;
	}
	return $rowsWithKeys;
}
?>


<html>
	<head>

	</head>
	<body>
		<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
			<input type="file" name="csv" id="file">
			<input type="submit" name="sumbmit" value="Hochladen">
		</form>
	</body>
</html>