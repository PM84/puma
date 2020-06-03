<?php
session_start();
$SessionID=$_SESSION['s'];
session_destroy ();
include($_SERVER['DOCUMENT_ROOT']."/config.php");
$query="DELETE FROM Sessions WHERE SessionID='$SessionID'";
mysqli_query($verbindung,$query);

header("LOCATION: /index.php");