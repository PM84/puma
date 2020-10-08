<?php
include_once($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/php/user_login.php");
include_once($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/php/system.php");
include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");

$SchulListeInfos = getSchulListe();
$Edit_uID = null;


// ========================
// ====== User speichern
// ========================

if (isset($_POST['name'])) {
	if ($Edit_uID == null) {
		
		$name = mysqli_real_escape_string($verbindung, htmlentities(mynl2br($_POST['name']), ENT_QUOTES, "UTF-8"));
		$vname = mysqli_real_escape_string($verbindung, htmlentities(mynl2br($_POST['vname']), ENT_QUOTES, "UTF-8"));
		$geschlecht = mysqli_real_escape_string($verbindung, htmlentities(mynl2br($_POST['geschlecht']), ENT_QUOTES, "UTF-8"));
		$email = mysqli_real_escape_string($verbindung, htmlentities(mynl2br($_POST['email']), ENT_QUOTES, "UTF-8"));
		$username = mysqli_real_escape_string($verbindung, htmlentities(mynl2br($_POST['username']), ENT_QUOTES, "UTF-8"));
		if ($_POST['passwort'] != "") {
			$password = hash("sha512", mysqli_real_escape_string($verbindung, htmlentities(mynl2br($_POST['passwort']), ENT_QUOTES, "UTF-8")));
		} else {
			$password = "";
		}
		$bundesland = intval(1);
		$SchulNr = intval($_POST['SchulNr']);
		if ($SchulNr == 0) {
			$SchulNr = intval($_POST['SchulName']);
		}
		if (!isset($Edit_uID)) {
			$Edit_uID = null;
		}
		// 		if(!isset($Edit_uID) && $SchulNr!=$my_userInfo['SchulNr']){$SchulNr=$my_userInfo['SchulNr'];}

		addUser($name, $vname, $geschlecht, $email, $username, $password, $bundesland, $SchulNr, $Edit_uID);

		if ($Edit_uID == null) {
			$Edit_uID = GetLast_uID();
		}

		$userGroup_default = 2; // LEHRER GRUPPE
		$_SESSION['reg'] = 1;

		SetUserGroup($Edit_uID, intval($userGroup_default));
	}
}

if (isset($_SESSION['reg']) && $_SESSION['reg'] == 1) {
?>
	<div class="col-md-10">
		<div class="alert alert-success" style="text-align:center; padding:50px;">
			<h2 style="padding:0; margin:0">Die Registrierung war erfolgreich!</h2> Sie können sich nun mit Ihrem Benuezernamen und Passwort anmelden
		</div>
	</div>
<?php
} else {
?>
	<div class="col-md-10">
		<form id="editUserForm" action="" method="post">
			<div class="row" style='border-bottom: 1px lightgray solid; padding-bottom: 10px;margin-bottom:10px;'>
				<div class="col-md-12">
					<button type="submit" value="Speichern" class="btn btn-success btn-block">Regiestrierung absenden</button>
				</div>
			</div>

			<div class="row" style=''>
				<div class="col-md-12">

					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" class="form-control" id="name" name='name' placeholder="Name" required value="<?php if (isset($userInfo['name'])) {
																																echo $userInfo['name'];
																															} ?>">
					</div>
					<div class="form-group">
						<label for="vname">Vorname</label>
						<input type="text" class="form-control" id="vname" name='vname' placeholder="Vorname" required value="<?php if (isset($userInfo['vname'])) {
																																	echo $userInfo['vname'];
																																} ?>">
					</div>
					<div class="form-group">
						<label for="email">Email Adresse</label>
						<input type="email" class="form-control" id="email" name=email placeholder="Email" required value="<?php if (isset($userInfo['email'])) {
																																echo $userInfo['email'];
																															} ?>">
					</div>
					<div class="form-group">
						<select class="form-control" id="geschlecht" name="geschlecht" required>
							<?php if ($userInfo['geschlecht'] == "m") {
								$selected = "selected";
							} else {
								$selected = "";
							} ?>
							<option value="m" <?php echo $selected; ?>>männlich</option>
							<?php if ($userInfo['geschlecht'] == "w") {
								$selected = "selected";
							} else {
								$selected = "";
							} ?>
							<option value="w" <?php echo $selected; ?>>weiblich</option>
							<?php if ($userInfo['geschlecht'] == "k") {
								$selected = "selected";
							} else {
								$selected = "";
							} ?>
							<option value="k" <?php echo $selected; ?>></option>
						</select>
					</div>
					<div class="form-group">
						<label for="schule">Schulnummer oder Schulname</label>
						<div class="form-horizontal">
							<div class="col-sm-2" style="padding:0;">
								<select class="form-control" id="SchulNr" name="SchulNr">
									<option value="">Bitte auswählen</option>
									<?php
									foreach ($SchulListeInfos as $schule) {
										if ($schule['SchulNr'] == $userInfo['SchulNr']) {
											$selected = "selected";
										} else {
											$selected = "";
										}
									?>
										<option value="<?php echo $schule['SchulNr']; ?>" <?php echo $selected; ?>><?php echo str_pad($schule['SchulNr'], 4, 0, STR_PAD_LEFT); ?></option>
									<?php
									}
									?>
								</select>
							</div>
							<div class="col-sm-10" style="padding:0;">
								<select class="form-control" id="SchulName" name="SchulName">
									<option value="">Bitte auswählen</option>
									<?php

									foreach ($SchulListeInfos as $schule) {
										if ($schule['SchulNr'] == $userInfo['SchulNr']) {
											$selected = "selected";
										} else {
											$selected = "";
										}
									?>
										<option value="<?php echo $schule['SchulNr']; ?>" <?php echo $selected; ?>><?php echo $schule['Name']; ?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group" style="margin-top:50px;padding-top:15px; border-top: lightgray 1px solid;">
						<label for="username">Benutzername (nötig für den Login)</label>
						<input type="text" class="form-control" id="username" name='username' placeholder="Benutzername" required value="<?php if (isset($userInfo['username'])) {
																																				echo $userInfo['username'];
																																			} ?>">
					</div>

					<div class="form-group">
						<label for="exampleInputEmail1">Passwort</label>
						<input type="password" class="form-control" id="password" name=passwort placeholder="Passwort">
					</div>

					<div class="form-group">
						<label for="exampleInputEmail1">Passwort wiederholen</label>
						<input type="password" class="form-control" id="confirm_password" name=confirm_passwort placeholder="Passwort wiederholen">
					</div>


				</div>
			</div>
		</form>
	</div>
	<script>
		var password = document.getElementById("password"),
			confirm_password = document.getElementById("confirm_password");
		var username = document.getElementById("username");
		var usernameResp;

		password.onchange = validatePassword;
		confirm_password.onkeyup = validatePassword;
		username.onchange = validateUserName;

		function validatePassword() {
			if (password.value != confirm_password.value) {
				confirm_password.setCustomValidity("Passwörter stimmen nicht überein");
			} else {
				confirm_password.setCustomValidity('');
			}
		}


		$(document).ready(function() {
			$("#editUserForm").submit(function() {
				if ($("#username").val().length >= 3) {
					return true;
				} else {
					username.setCustomValidity("Der Benutzername ist zu kurz!");
					return false;
				}
			});
		});

		function validateUserName() {
			username.setCustomValidity("");
			$.ajax({
				type: 'POST',
				url: '/php/user_login.php',
				data: {
					PostFktn: "validateUsername",
					username: username.value,
					Edit_uID: <?php if (!isset($Edit_uID) || $Edit_uID == null) {
									echo 0;
								} else {
									echo $Edit_uID;
								} ?>
				},
				dataType: 'text',
				success: function(data) {

					if (data == true) {
						username.setCustomValidity("");
					} else {
						username.setCustomValidity("Benutzername existiert bereits!");
					}
					usernameResp = data;
					// 							return data;
				},
				error: function(data) {
					alert("Es ist ein Fehler aufgetreten! \nBitte informieren Sie den Administrator! \nFehler Code: 1000\n" + data);
				},
				async: false
			});
		}
	</script>
<?php
}
