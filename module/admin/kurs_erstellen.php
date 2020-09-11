<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/includes/header_php.php");

include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
include_once($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/includes/session_delay.php");
include_once($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/php/kursInfos.php");
include_once($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/php/teilnehmer.php");
include_once($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/php/user_login.php");
include_once($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/php/folie.php");
include_once($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/php/Sessions.php");
include_once($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/module/mod_preasentation/praesentationseinstellungen.php");

$SessionInfos = Get_SessionInfos($_SESSION['s']);
$uID = $SessionInfos['uID'];

if ($uID == 0) {
	header("LOCATION:  " . $_SESSION['DOCUMENT_ROOT_DIR'] . "module/user/logout.php");
}


if (isset($_POST['action']) && $_POST['action'] == "noShare") {
	$share_KursID = intval($_POST['share_KursID']);
	if (Check_if_kurs_edit_allowed($share_KursID, $uID)) {
		unshare_kurs($share_KursID);
	}
}

if (isset($_POST['action']) && $_POST['action'] == "Share") {
	// if(isset($_POST['share_KursID']) && intval($_POST['share_KursID'])>0){
	$share_to_email = mysqli_real_escape_string($verbindung, htmlentities($_POST['share_to_email'], ENT_QUOTES, "UTF-8"));
	$share_group = intval($_POST['share_group']);
	$share_KursID = intval($_POST['share_KursID']);
	if (Check_if_kurs_edit_allowed($share_KursID, $uID)) {
		share_kurs($share_KursID, $share_group, $share_to_email);
	}
}

if (isset($_POST['delKurs'])) {
	$KursID = intval($_POST['delKurs']);

	$query = "DELETE tK,tF,tA,tTM,tMM, tKM, tBM FROM kurs tK 
		INNER JOIN kurs_uID_match tKM ON tKM.kursID=tK.kursID
INNER JOIN folien tF on tF.kursID=tK.kursID 
LEFT JOIN abgabe tA on tF.fID=tA.fID 
LEFT JOIN user_teilnehmer_kurs_match tTM on tTM.kursID=tK.kursID 
LEFT JOIN media_kurs_match tMM on tMM.kursID=tK.kursID
LEFT JOIN baustein_folie_position_match tBM on tBM.fID=tF.fID
WHERE tK.kursID='$KursID'";

	mysqli_query($verbindung, $query) or die(mysqli_error($verbindung));
	unset($_POST['delKurs']);
}

if (isset($_POST['kurstitel']) && isset($_POST['beschreibung']) && isset($_POST['kTyp'])) {
	if (isset($_SESSION['k_edit'])) {
		$query = "UPDATE kurs SET titel='" . mysqli_real_escape_string($verbindung, htmlentities($_POST['kurstitel'], ENT_QUOTES, "UTF-8")) . "', beschreibung='" . mysqli_real_escape_string($verbindung, htmlentities($_POST['beschreibung'], ENT_QUOTES, "UTF-8")) . "', kTyp='" . intval($_POST['kTyp']) . "' WHERE kursID='" . $_SESSION['k_edit'] . "'";
		mysqli_query($verbindung, $query) or die(mysqli_error($verbindung));
		if ($_POST['kTyp'] == 2) {
			$aktuelleOrderID = getMaxOrderID($_SESSION['k_edit']);
			$folien = getFolienByKurs($_SESSION['k_edit']);
			$i = 1;
			foreach ($folien as $folie) {
				InsertOrderSetting($folie['fID'], $_SESSION['k_edit'], $i);
				$i++;
			}
		}
		unset($_SESSION['k_edit']);
	} else {
		$query = "Insert INTO kurs (titel, beschreibung, kTyp,kursToken) VALUES ('" . mysqli_real_escape_string($verbindung, htmlentities($_POST['kurstitel'], ENT_QUOTES, "UTF-8")) . "','" . mysqli_real_escape_string($verbindung, htmlentities($_POST['beschreibung'], ENT_QUOTES, "UTF-8")) . "','" . intval($_POST['kTyp']) . "','" . uniqid() . "')";
		mysqli_query($verbindung, $query) or die(mysqli_error($verbindung));
		$kursID = mysqli_insert_id($verbindung);
		$query = "Insert INTO kurs_uID_match (uID, kursID) VALUES ('$uID','$kursID')";
		mysqli_query($verbindung, $query) or die(mysqli_error($verbindung));

		set_preview_teilnehmer_if_not_exist($kursID, $uID);
	}
	unset($_POST);
}
if (isset($_POST['k'])) {
	$kursID = intval($_POST['k']);
	$_SESSION['k_edit'] = $kursID;
	if (Check_if_kurs_edit_allowed($kursID, $uID)) {
		$KursInfo = GetKursInfos($kursID);
	}
}





?>
<html>

<head>
	<?php include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/includes/head_main.php"); ?>
	<?php include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/includes/head_backend.php"); ?>
</head>

<body>
	<?php include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/includes/header_bar.php"); ?>

	<div class="container">
		<div class="row" style='margin-top:50px;'>
			<div class="col-md-1"></div>
			<div class="col-md-5">
				<p class="lead">Neuen Kurs erstellen</p>
				<form class='' method="POST" action="">
					<input type="hidden" value="<?php if (isset($_SESSION['k_edit'])) {
													echo $_SESSION['k_edit'];
												} ?>" name="k">
					<div class="form-group">
						<label for="KT">Bitte geben Sie den Titel des Kurses ein</label>
						<input id='KT' type="text" class="form-control" name="kurstitel" placeholder="Kurstitel" required value='<?php if (isset($KursInfo['titel'])) {
																																		echo $KursInfo['titel'];
																																	} ?>'>
					</div>

					<div class="form-group">
						<label for="KB">Beschreiben Sie den Kurs</label>
						<textarea id="KB" class="form-control" name="beschreibung" rows="3"><?php if (isset($KursInfo['beschreibung'])) {
																								echo $KursInfo['beschreibung'];
																							} ?></textarea>
					</div>

					<div class="form-group">
						<label for="kTypID">Wählen Sie den Modus des Kurses</label>
						<select class="form-control" id="kTypID" name="kTyp" required>
							<?php
							$user_UserGroups = GetUserGroup($uID);
							if (in_array(1, $user_UserGroups) || in_array(4, $user_UserGroups)) {
							?>
								<option value=1 <?php if (isset($KursInfo['kTyp'])) {
													if ($KursInfo['kTyp'] == 1) {
														echo "selected";
													}
												} ?>>Einzelaufgaben (auch mehrere)</option>
							<?php } ?>

							<option value=2 <?php if (isset($KursInfo['kTyp'])) {
												if ($KursInfo['kTyp'] == 2) {
													echo "selected";
												}
											} ?>>Mehrere zusammenhängende/aufeinander aufbauende Aufgaben</option>
						</select>
					</div>
					<button type="submit" class="btn btn-primary">Eintragen</button>
				</form>
			</div>
			<div class="col-md-5">
				<p class="lead">Ihre Kurse:</p>
				<?php
				$Kurse = GetKursListeInfos($uID, 1, 1);
				if (count($Kurse) == 0) {
				?>
					<div class="alert alert-info">Keine Kurse gefunden!</div>
				<?php
				}
				foreach ($Kurse as $KursInfo) {
					// 						var_dump($KursInfo);
				?>
					<div class="row" style="margin-bottom:3px;">
						<div class="col-md-11" style='padding-right:0; padding-left:10px;'>
							<form action='' method="POST" style='margin:0;'>
								<input type=hidden value='<?php echo $KursInfo['kursID']; ?>' name='k'>
								<input type="submit" class="btn <?php if (isset($_SESSION['k_edit']) && $_SESSION['k_edit'] == $KursInfo['kursID']) {
																	echo "btn-primary";
																} else {
																	echo "btn-default";
																} ?>" style='width:100%' value="<?php echo $KursInfo['titel']; ?>">
							</form>
						</div>
						<div class="col-md-1 dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-cog"></span> <span class="caret"></span></a>
							<ul class="dropdown-menu nav">
								<li>
									<div class="col-md-12" style=''>
										<form action='' method="POST" style='display: inline-block; margin:0; width:100%;' onsubmit="return confirm('Sind Sie sicher?\n\n Alle mit diesem Kurs verbundenen Folien und Einstellungen werden unwiederruflich gelöscht!');">
											<input type=hidden value='<?php echo $KursInfo['kursID']; ?>' name='delKurs'>
											<input type="submit" class="btn btn-danger" value="Löschen" style='width:100%;'>
										</form>
									</div>
								</li>
								<li role="separator" class="divider"></li>
								<li>
									<?php
									if ($KursInfo['kTyp'] == 2) {
									?>
										<div class="col-md-12">
											<form action='' method="POST" style='display: inline-block; margin:0; width:100%;'>
												<input type=hidden value='<?php echo $KursInfo['kursID']; ?>' name='share_KursID'>
												<?php if (check_share_kurs($KursInfo['kursID']) == false) { ?>
													<input type="hidden" name="action" value="Share">
													<a data-toggle="modal" data-id='<?php echo $KursInfo['kursID']; ?>' href="#normalModal" class="btn btn-success share_btn" style='width:100%;'>Teilen</a>
												<?php } else { ?>
													<input type="hidden" name="action" value="noShare">
													<button class="btn btn-warning share_btn btn-block" type="submit">Nicht mehr teilen</button>
												<?php } ?>
											</form>
										</div>
									<?php
									}
									?>
								</li>
								<li role="separator" class="divider"></li>

								<li>
									<div class="col-md-12">
										<form action='' method="POST" style='display: inline-block; margin:0; width:100%;'>
											<input type=hidden value='<?php echo $KursInfo['kursID']; ?>' name='shareKurs'>
											<a data-toggle="modal" data-id='<?php echo $KursInfo['kursID']; ?>' href="#normalModalInclude" class="btn btn-primary embed_btn" style='width:100%;'>Einbinden</a>
										</form>
									</div>

								</li>
							</ul>

						</div>
						<hr class="hr_mobile">
					</div>
				<?php
				}
				?>
			</div>
			<div class="col-md-1"></div>
		</div>
	</div>

	<?php include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/includes/bottom_main.php"); ?>

	<script>
		$(".modal-wide").on("show.bs.modal", function() {
			var height = $(window).height() - 200;
			$(this).find(".modal-body").css("max-height", height);
		});

		$(".share_btn").on("click", function() {
			var KursID = $(this).data('id');
			$(".modal-body #KursID").val(KursID);
		});

		$(".embed_btn").on("click", function() {
			var KursID = $(this).data('id');
			console.log("Start");
			$.ajax({
				type: "POST",
				data: {
					PostFktn: "get_Embed_Link",
					kursID: KursID
				},
				dataType: 'text',
				url: "/php/kursInfos.php",
				/* contentType: "application/json; charset=utf-8", */
				success: function(data) {
					$("#embedLink").val(data);
					console.log(data);
				}
			});

			// 				$(".modal-body #KursID").val( KursID );
		});
	</script>

	<div id="normalModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form method="post" action="">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Kurs teilen</h4>
					</div>
					<div class="modal-body">
						<input type="hidden" name="action" value="Share">
						<input type="hidden" id="KursID" name="share_KursID" value="">
						<p>Wählen Sie aus, für welche Gruppen dieser Kurs sichtbar sein soll:</p>
						<select class="form-control" name="share_group" required>
							<option value="">Bitte auswählen</option>
							<option value="1">eigene Fachschaft</option>
							<option value="2">für alle Kolleginnen und Kollegen</option>
							<!--	<option value="3">per Email teilen</option>//-->
						</select>
						<!--							<h3>
ODER
</h3>
<p>Geben Sie die Email-Adresse der Kollegin / des Kollegen an, der/dem Sie diesen Kurs freigeben möchten:</p>
<input type="email" placeholder="Email eingeben" name="share_to_email" class="form-control">
<hr>//-->
						<p>
							Wenn Sie einen Kurs teilen, können andere Ihren Kurs kopieren und die Kopie im Anschluss editieren. Ihre Folien bleiben unangetastet!
						</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
						<button type="submit" class="btn btn-primary">Kurs teilen</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div id="normalModalInclude" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Kurs einbetten</h4>
				</div>
				<div class="modal-body">
					<p>Nachfolgenden Link können Sie auf einer beliebigen Webseite einbinden oder per Email versenden. Derjenige, der auf diesen Link klickt erstellt sich einen neuen Teilnehmer und hat im Anschluss Zugriff auf diesen Kurs.</p>
					<input type="text" class="form-control" value="<?php ?>" id='embedLink'>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
				</div>
			</div>
		</div>
	</div>
</body>

</html>