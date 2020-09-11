<?php

if(!isset($_SESSION['t'])){
		echo "<script>window.location = '" . $_SESSION['DOCUMENT_ROOT_DIR']."/index.php?e=2';</script>";
}