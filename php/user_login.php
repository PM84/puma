<?php
if (isset($_POST['PostFktn'])) {
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/php/system.php");
	switch ($_POST['PostFktn']) {
		case "validateUsername":
			// 	echo "Test erfolgreich222";
			$username = mysqli_real_escape_string($verbindung, htmlentities(mynl2br($_POST['username']), ENT_QUOTES, "UTF-8"));
			$uID = intval($_POST['Edit_uID']);
			echo validateUsername($username, $uID);
			break;
	}
}

/* function getUserGroup($uID){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$query="SELECT * FROM user_uID_groups_match WHERE uID=$uID";
	$ergebnis=mysqli_query($verbindung,$query);
	$userGroups=[];
	while($row=mysqli_fetch_assoc($ergebnis)){
		array_push($userGroups,$row['uGroupID']);
	}
	return 	$userGroups;
} */

function validateUsername($username, $uID)
{
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
	$query = "SELECT * FROM user WHERE username='$username' AND uID!='$uID'";
	$ergebnis = mysqli_query($verbindung, $query);
	if (mysqli_num_rows($ergebnis) > 0) {
		return false;
	} else {
		return true;
	}
}

function checkLogin($username, $passwort)
{
	// 	$passwort bereits gehashed
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/php/Sessions.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/php/teilnehmer.php");
	$query = "SELECT * FROM user WHERE username='$username' AND password='$passwort'";
	// 		echo $query;
	$ergebnis = mysqli_query($verbindung, $query);
	$uID = 0;
	if (mysqli_num_rows($ergebnis)) {
		$row = mysqli_fetch_assoc($ergebnis);
		$uID = $row['uID'];
		$userGroups = GetUserGroup($uID);
		Set_Session_Token($uID, $userGroups);
		$_SESSION['uID'] = $uID;
		$tnInfo = getTeilnehmerInfos(check_for_preview_teilnehmer($uID));
		$_SESSION['t_own'] = $tnInfo['token'];
		$_SESSION['SchulNr'] = $row['SchulNr'];
		return $uID;
	}
}

function addUser($name, $vname, $geschlecht, $email, $username, $password, $bundesland, $SchulNr, $Edit_uID)
{
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");

	if (isset($_SESSION['t'])) {
		$token = $_SESSION['t'];
	} else {
		$token = "";
	} // DIESE Funktion wird nur für die Dokumentation der Studie benötigt. Kann später gelöscht werden!

	if ($Edit_uID == null) {
		if ($password != null) {
			$datum = date("Y-m-d H:i:s");
			$query = "INSERT IGNORE INTO user (name,vname,geschlecht,email,username,password,bundesland,SchulNr, registered,registerToken) VALUES ('$name','$vname','$geschlecht','$email','$username','$password','$bundesland','$SchulNr','$datum','$token')";
		} else {
			$query = "";
		}
	} else {
		if ($password == null) {
			$query = "UPDATE user SET name='$name',vname='$vname',geschlecht='$geschlecht',email='$email',username='$username',bundesland='$bundesland',SchulNr='$SchulNr' WHERE uID=$Edit_uID";
		} else {
			$query = "UPDATE user SET name='$name',vname='$vname',geschlecht='$geschlecht',email='$email',username='$username',password='$password',bundesland='$bundesland',SchulNr='$SchulNr'  WHERE uID=$Edit_uID";
		}
	}
	if ($query != "") {
		$ergebnis = mysqli_query($verbindung, $query);
	}
	// echo $query;
}

function GetLast_uID()
{
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
	$query = "SELECT * FROM user ORDER BY uID DESC LIMIT 1";
	$ergebnis = mysqli_query($verbindung, $query);
	$row = mysqli_fetch_assoc($ergebnis);
	return $row['uID'];
}

function DeleteUserGroup($uID)
{
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
	$query = "DELETE FROM user_uID_groups_match WHERE uID=$uID";
	mysqli_query($verbindung, $query);
}

function SetUserGroup($uID, $uGroupID)
{
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
	$query = "INSERT IGNORE INTO user_uID_groups_match (uID,uGroupID) VALUES ($uID,$uGroupID)";
	mysqli_query($verbindung, $query);
}

function GetUserGroup($uID)
{
	//Liefert ein Array aller uGroups
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
	$query = "SELECT * FROM user_uID_groups_match WHERE uID='$uID'";
	$ergebnis = mysqli_query($verbindung, $query);
	$userGroups = [];
	while ($row = mysqli_fetch_assoc($ergebnis)) {
		array_push($userGroups, $row['uGroupID']);
	}
	// 	$_SESSION['uGroupID']=$userGroups;
	return $userGroups;
}

function GetUserGroupInfo($uGroup)
{
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
	$query = "SELECT * FROM user_groups WHERE uGroupID='$uGroup'";
	$ergebnis = mysqli_query($verbindung, $query);
	$row = mysqli_fetch_assoc($ergebnis);
	return $row;
}

function GetUserGroupListInfo($GroupsToShow, $all = 0)
{
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");

	if ($all != 1) {
		$whereClause = join(" Or uGroupID = ", $GroupsToShow);
		$query = "SELECT * FROM user_groups where uGroupID = $whereClause";
	} else {
		$query = "SELECT * FROM user_groups where uGroupID";
	}
	$ergebnis = mysqli_query($verbindung, $query);
	$GroupListe = [];
	while ($row = mysqli_fetch_assoc($ergebnis)) {
		array_push($GroupListe, $row);
	}
	return $GroupListe;
}

function GetUserID()
{
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
	$SessionID = $_SESSION['s'];
	$query = "SELECT * FROM Sessions WHERE SessionID='$SessionID'";
	$ergebnis = mysqli_query($verbindung, $query);
	$row = mysqli_fetch_assoc($ergebnis);
	return $row['uID'];
}

function getUserInfos($uID)
{
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
	$query = "SELECT * FROM user WHERE uID=$uID";
	$ergebnis = mysqli_query($verbindung, $query);
	$row = mysqli_fetch_assoc($ergebnis);
	return $row;
}

function getUserInfos_byEmail($email)
{
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
	$query = "SELECT * FROM user WHERE email='$email'";
	$ergebnis = mysqli_query($verbindung, $query);
	$row = mysqli_fetch_assoc($ergebnis);
	return $row;
}


function getBundeslandInfo($Bundesland)
{
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
	$query = "SELECT * FROM schule_bundesland WHERE Bundesland=$Bundesland";
	$ergebnis = mysqli_query($verbindung, $query);
	if(!$ergebnis){return [];}
	$row = mysqli_fetch_assoc($ergebnis);
	return $row;
}

function getSchulInfos($SchulNr)
{
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
	$query = "SELECT * FROM schule_daten WHERE SchulNr=$SchulNr";
	$ergebnis = mysqli_query($verbindung, $query);
	$row = mysqli_fetch_assoc($ergebnis);
	$row['blInfo'] = getBundeslandInfo($row['Bundesland']);
	return $row;
}

function getSchulListe()
{
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
	$query = "SELECT * FROM schule_daten order by Name ASC";
	$ergebnis = mysqli_query($verbindung, $query);
	$SchulListe = [];
	while ($row = mysqli_fetch_assoc($ergebnis)) {
		array_push($SchulListe, $row);
	}
	return $SchulListe;
}

function Get_uID_List()
{
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
	$uID = $_SESSION['uID'];
	$userGroups = GetUserGroup($uID);
	$myUserInfo = getUserInfos($uID);
	$mySchulNr = $myUserInfo['SchulNr'];
	if (in_array("1", $userGroups)) {
		// Administrator
		$query = "SELECT * FROM user";
	} elseif (in_array("2", $userGroups)) {
		// Lehrer
		$query = "SELECT * FROM user WHERE uID=$uID";
	} elseif (in_array("3", $userGroups)) {
		// Fachbetreuer
		$query = "SELECT * FROM user WHERE SchulNr='$mySchulNr'";
	}
	$ergebnis = mysqli_query($verbindung, $query);
	$UserList = [];
	while ($row = mysqli_fetch_assoc($ergebnis)) {
		// 		$userIDs['uGroups']=GetUserGroup($row['uID']);
		// 		$row['uGroups']=GetUserGroup($row['uID']);
		array_push($UserList, $row['uID']);
	}
	return $UserList;
}

function GetUserListLogin()
{
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
	// Administrator
	$query = "SELECT * FROM user";
	$ergebnis = mysqli_query($verbindung, $query);
	$UserList = [];
	return $UserList;
}

function GetUserList()
{
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
	$uID = $_SESSION['uID'];
	$userGroups = GetUserGroup($uID);
	$myUserInfo = getUserInfos($uID);
	$mySchulNr = $myUserInfo['SchulNr'];
	if (in_array("1", $userGroups)) {
		// Administrator
		$query = "SELECT * FROM user";
	} elseif (in_array("2", $userGroups)) {
		// Lehrer
		$query = "SELECT * FROM user WHERE uID=$uID";
	} elseif (in_array("3", $userGroups)) {
		// Fachbetreuer
		$query = "SELECT * FROM user WHERE SchulNr='$mySchulNr'";
	}
	$ergebnis = mysqli_query($verbindung, $query);
	$UserList = [];
	while ($row = mysqli_fetch_assoc($ergebnis)) {
		// 		$userIDs['uGroups']=GetUserGroup($row['uID']);
		$row['uGroups'] = GetUserGroup($row['uID']);
		array_push($UserList, $row);
	}
	return $UserList;
}
