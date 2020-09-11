<?php
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/kursInfos.php");
if (isset($_SESSION['uID']) && isset($_SESSION['kursID']) && Check_if_kurs_edit_allowed($_SESSION['kursID'], $_SESSION['uID']) == 1) {
	$syncRow = getLehrerSync($_SESSION['kursID']);
?>
	<button style="float:right;" type="button" class="navbar-toggle glyphicon glyphicon-cog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
	<ul class="dropdown-menu" style="left:auto; right:20px; padding:15px;">
		<li role="separator" class="divider"></li>
		<li>
			<div class="checkbox">
				<?php $FolieInfo = getFolieInfo(intval($_GET['f']));
				if ($FolieInfo['modID'] == 1) {
					$_SESSION['last_shown_page'] = $_SERVER["REQUEST_URI"];  ?>
					<a class="btn btn-default" href="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/module/mod_videovertonung/show_abgabe_uebersicht.php">Auswertung der Videovertonungen</a>
				<?php } else { ?>
					<a class="btn btn-default" href="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/module/mod_preasentation/show_auswertung.php">Auswertung dieser Folie zeigen</a>
				<?php } ?>
			</div>
		</li>

	</ul>
<?php } ?>