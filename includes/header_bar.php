<?php
include_once($_SERVER['DOCUMENT_ROOT']."/php/system.php");
if(!isset($_GET['bTypID'])){
include($_SERVER['DOCUMENT_ROOT']."/includes/menu.php");
}
$_SESSION['lastPage']=(isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";