<?php
session_start();
session_destroy();
header("LOCATION:  " . $_SESSION['DOCUMENT_ROOT_DIR']."index.php");