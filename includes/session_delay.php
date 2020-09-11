<?php

if (!isset($_SESSION['s'])) {
	echo "<script>window.location = '" . $_SESSION['DOCUMENT_ROOT_DIR'] . "/index.php?e=1';</script>";
}
