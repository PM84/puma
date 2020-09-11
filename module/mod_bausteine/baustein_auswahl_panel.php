<?php
// ========================
// ========================
// ====== BAUSTEIN AUSWAHL PANEL 
// ========================
// ========================

// ========================
// ====== WICHTIG
// ========================

// $themen=Get_SimThemen();
// $Sims=Get_Sim_Liste();

// MÜSSEN AUßERHALB DER SCHLEIFE GESETZT WERDEN DADURCH WIRD DIE GESCHWINDIGKEIT DER SEITE MASSIV ERHÖHT! UND ANERE ROUTINEN HABEN EBENFALLS ZUGRIFF!

// ========================
// ====== WICHTIG - E N D E
// ========================

// include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/frage.php"); 
// $FragenGruppen=Get_Fragen_Gruppen($_SESSION[$ftoken]['uID']);

?>

<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
	<?php
	$bsArr = getBausteineListeInfos($_SESSION['uID'], 1);
	foreach ($bsArrTyp as $bs) {
		$bTypID = $bs['bTypID'];
	?>
		<div class="panel panel-default">
			<div class="panel-heading" role="tab" id="headingOne">
				<h4 class="panel-title">
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $Block . "_" . $bTypID; ?>" aria-expanded="true" aria-controls="collapse_<?php echo $Block . "_" . $bTypID; ?>">
						<?php echo $bs['titel'] . "   (" . count($bsArr[$bTypID]) . ")"; ?>
					</a>
				</h4>
			</div>
			<div id="collapse_<?php echo $Block . "_" . $bTypID; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
				<div class="panel-body">
					<?php
					if (isset($bsArr[$bTypID])) {
						foreach ($bsArr[$bTypID] as $bsArrInfo) {
							$bsInfo = json_decode($bsArrInfo['parameter'], true);
					?>
							<form action='' method="POST" style='margin:0;'>
								<input type="hidden" value="<?php echo $folie_token; ?>" name="folie_token">
								<input type="hidden" name='bID_<?php echo $Block; ?>' value="<?php echo $bsArrInfo['bID']; ?>">
								<input type="hidden" name='ziel_bTypID' value="<?php echo $bs['bTypID']; ?>">
								<input type=hidden value='<?php echo $bsArrInfo['bID']; ?>' name='bID'>
								<input type="submit" class="btn btn-default" style='width:100%' value="<?php echo $bsInfo['titel']; ?>">
							</form>

						<?php
						}
						?>
						<div style="margin-top:5px;">
							<?php
							switch ($bs['bTypID']) {
								case 1: // Kontrollfragen
									echo "<a href='" . $_SESSION['DOCUMENT_ROOT_DIR'] . "/module/admin/baustein_erstellen.php' class='btn btn-success' style='display:block;width:100%;' target=blank>Kontrollfragen erstellen & editieren</a>";
									break;

								case 2: // Wordcloud
									echo "<a href='" . $_SESSION['DOCUMENT_ROOT_DIR'] . "/module/admin/baustein_erstellen.php' class='btn btn-success' style='display:block;width:100%;' target=blank>Wordcloud erstellen & editieren</a>";
									break;

								case 3: // Abstimmungen
									echo "<a href='" . $_SESSION['DOCUMENT_ROOT_DIR'] . ">/module/admin/baustein_erstellen.php' class='btn btn-success' style='display:block;width:100%;' target=blank>Abstimmungen erstellen & editieren</a>";
									break;
								case 4:
									echo "<a href='" . $_SESSION['DOCUMENT_ROOT_DIR'] . "/module/admin/baustein_erstellen.php' class='btn btn-success' style='display:block;width:100%;' target=blank>YouTube Videos hinzufügen & editieren</a>";

									break;

								case 5: // Evaluation
									echo "<a href='" . $_SESSION['DOCUMENT_ROOT_DIR'] . "/module/admin/fragen_erstellen.php' class='btn btn-success' style='display:block;width:100%;' target=blank>Fragen erstellen & editieren</a>";
									break;

								case 6: //
									echo "<a href='" . $_SESSION['DOCUMENT_ROOT_DIR'] . "/module/admin/baustein_erstellen.php' class='btn btn-success' style='display:block;width:100%;' target=blank>Webseiten hinzufügen & editieren</a>";

									break;
							}
							?>

						</div>
					<?php
					} elseif (isset($bs['bTypID'])) {
						switch ($bs['bTypID']) {
							case 1: // Kontrollfragen
								echo "<a href='" . $_SESSION['DOCUMENT_ROOT_DIR'] . "/module/admin/baustein_erstellen.php' class='btn btn-success' style='display:block;width:100%;' target=blank>Kontrollfragen erstellen & editieren</a>";
								break;

							case 2: // Wordcloud
								echo "<a href='" . $_SESSION['DOCUMENT_ROOT_DIR'] . "/module/admin/baustein_erstellen.php' class='btn btn-success' style='display:block;width:100%;' target=blank>Wordcloud erstellen & editieren</a>";
								break;

							case 3: // Abstimmungen
								echo "<a href='" . $_SESSION['DOCUMENT_ROOT_DIR'] . "/module/admin/baustein_erstellen.php' class='btn btn-success' style='display:block;width:100%;' target=blank>Abstimmungen erstellen & editieren</a>";
								break;

							case 4: // YouTube
								echo "<a href='" . $_SESSION['DOCUMENT_ROOT_DIR'] . "/module/admin/baustein_erstellen.php' class='btn btn-success' style='display:block;width:100%;' target=blank>YouTube Video hinzufügen & editieren</a>";
								break;

							case 5: // Evaluation
								echo "<a href='" . $_SESSION['DOCUMENT_ROOT_DIR'] . "/module/admin/fragen_erstellen.php' class='btn btn-success' style='display:block;width:100%;' target=blank>Fragen erstellen & editieren</a>";
								break;

							case 6: // Webseiten
								echo "<a href='" . $_SESSION['DOCUMENT_ROOT_DIR'] . "/module/admin/baustein_erstellen.php' class='btn btn-success' style='display:block;width:100%;' target=blank>Webseiten hinzufügen & editieren</a>";
								break;
							default:
								echo "Zu dieser Gruppe gibt es noch keine Bausteine.";
								break;
						}
					} else {
						echo "Zu dieser Gruppe gibt es noch keine Bausteine.";
					}
					?>

				</div>
			</div>
		</div>

	<?php

	}

	?>

</div>