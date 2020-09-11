<?php
session_start();
$SessionID=$_SESSION['s'];
session_destroy ();
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
$query="DELETE FROM Sessions WHERE SessionID='$SessionID'";
mysqli_query($verbindung,$query);

header("LOCATION: " .$_SESSION['DOCUMENT_ROOT_DIR']."/index.php");