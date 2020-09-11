<div class="">
	<form style='margin:0 15px;' method="POST" action="#">
		<h2>
			Login
		</h2>
		<input type="text" class="TotalWidth form-margin form-control" name="username" placeholder="Benutzername">
		<br>
		<input type="password" class="TotalWidth form-margin form-control" name="password" placeholder="Passwort">
		<br>
		<button type="submit" class="TotalWidth form-margin btn btn-default">Anmelden</button><br>

	</form>
	<br><a style='margin:0 15px;' href="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/module/user/PasswortReset.php">Passwort vergessen?</a>
	<br><a style='margin:0 15px;' href="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/module/user/user_registration.php">Noch keinen Account?</a>
</div>

<style>
	.form-margin {
		margin-top: 4px;
	}
</style>

<?php

if (isset($_POST['username']) && isset($_POST['password'])) {
	include($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/config.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/php/system.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/php/user_login.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . $_SESSION['DOCUMENT_ROOT_DIR'] . "/php/agb.php");
	$username = mysqli_real_escape_string($verbindung, htmlentities(mynl2br($_POST['username']), ENT_QUOTES, "UTF-8"));
	$password = hash("sha512", mysqli_real_escape_string($verbindung, htmlentities(mynl2br($_POST['password']), ENT_QUOTES, "UTF-8")));
	if (checkLogin($username, $password) <= 0) {
		session_destroy();
		echo "<script>alert('Zugangsdaten falsch oder unbekannt!');</script>";
	} elseif (isset($stayOnSite) && $stayOnSite == 1) {
		//  		echo "<script>window.location = '" . $_SESSION['DOCUMENT_ROOT_DIR']."/module/admin/kurs_erstellen.php';</script>"; 
	} else {
		$checkConf = check_confirmed_last_agb();
		if (count($checkConf) > 0) {
			echo "<script>window.location = '" . $_SESSION['DOCUMENT_ROOT_DIR'] . "/module/admin/kurs_erstellen.php';</script>";
		} elseif (count($checkConf) == 0 || $checkConf['status'] == 0) {
			echo "<script>window.location = '" . $_SESSION['DOCUMENT_ROOT_DIR'] . "/module/user/rules.php';</script>";
		}
	}
}

?>