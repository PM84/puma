<?php
// echo "Das ist eine Präsentation";
include_once($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/module/mod_preasentation/praesentationseinstellungen.php");

// $FolienListe_Praes=FolienAnzeige_Menu($_SESSION['kursID'],$_SESSION['t']);
$FolienArr = get_aktuellen_Ablauf($_SESSION['kursID']);
// 			$bewArr=getAbgabeBy_abID_token_aTyp($token,1);
// 	var_dump($FolienArr);
$fID_previous = 0;
foreach ($FolienArr as $folieTemp) {

	$fID = $folieTemp['fID'];
	$folie = getFolieInfo($fID);
	$parameterFolie = json_decode($folie['parameter']);
	$modID = $folie['modID'];
	$modInfo = getModulInfos($modID);

	$link = $_SESSION['DOCUMENT_ROOT_DIR'] . "/" . $modInfo['mod_dir'] . "/" . $modInfo['mod_show'] . "?f=" . $folie['fID'];
	$toolTip = "";
?>
	<li>
		<a href="<?php echo $link; ?>" class='btn btn-default btn-margin-menu' <?php echo $toolTip; ?>>
			<?php echo $parameterFolie->titel; ?>
		</a>
	</li>
<?php
}

?>
<div id="nav_response"></div>
<script>
	$(document).ready(function() {
		$('[data-toggle="tooltip"]').tooltip();
	});
</script>
<?php
if (!isset($_SESSION['uID'])  /* && isset($_GET['fID']) */ /* $ausserhalbKurs!=1 */) {
?>
	<script>
		window.setInterval(function() {
			$.post("<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/module/mod_preasentation/praesentationseinstellungen.php", {
					fkt: "getLehrerSync",
					kursID: <?php echo $_SESSION['kursID']; ?>
				})
				.done(function(data) {
					if (data == "null") {} else {
						console.log(data);
						var response = jQuery.parseJSON(data);
						if (response['fID'] != "<?php echo $_SESSION['fID']; ?>) {
							SeiteAktualisieren();
						}
					}
				});
		}, 5000);

		function SeiteAktualisieren() {
			// 					console.log("Start");
			$.post("<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/module/mod_preasentation/praesentationseinstellungen.php", {
					fkt: "SeiteAktualisieren",
					kursID: <?php echo $_SESSION['kursID']; ?>
				})
				.done(function(data) {
						$("#nav_response").html(data);
						// 						console.log(data);
						// 			alert(data);
					}

				);
		}
	</script><?php
			}
				?>