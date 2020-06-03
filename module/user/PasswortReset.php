<?php
// session_start();
include($_SERVER['DOCUMENT_ROOT']."/php/mail.php");
include($_SERVER['DOCUMENT_ROOT']."/php/user_login.php");
include($_SERVER['DOCUMENT_ROOT']."/config.php");

$sentMessage="";
if(isset($_POST['action']) && $_POST['action']=="getResetToken"){
	$email=htmlspecialchars($_POST['email'], ENT_QUOTES);
	$UserInfo=getUserInfos_byEmail($email);
	if(count($UserInfo)>0){

	$email=$UserInfo['email'];
	$vName=$UserInfo['vname'];
	$nName=$UserInfo['name'];
	$token=hash ("sha1",uniqid ());
	$Geschlecht=$UserInfo['geschlecht'];
	$uID=$UserInfo['uID'];

	$token=hash ("sha1",uniqid ());
	$query2="UPDATE user SET resetToken='$token'WHERE uID='$uID'";
	mysqli_query($verbindung,$query2);

	switch($Geschlecht){
		case "w";
			$Anrede="Sehr geehrte Frau $nName,";
			break;

		case "m";
			$Anrede="Sehr geehrter Herr $nName,";
			break;
	}


		$MessageArray['from']=$imap_user_name;
		$MessageArray['to']=array($email);
		$MessageArray['betreff']="Passwort Reset Link";
		$MessageArray['nachricht']="<html><head><meta charset='utf-8'><meta name='viewport' content='width=device-width, initial-scale=1.0'></head><body>$Anrede<br><br> Sie haben einen Passwort Reset Link angefordert. Bitte klicken Sie auf nachfolgenden Link um Ihr Passwort zurückzusetzen! <br><br><a href='$ResetLink?r=$token'>$ResetLink?r=$token</a><br><br>Viele Grüße<br>Peter Mayer</body></html>";

		$emailStatus=email_versenden($MessageArray['from'],$MessageArray['to'],$MessageArray['betreff'],$MessageArray['nachricht']);

		if($emailStatus==true){
$sentMessage="<div class='alert alert-success'><h2>Email wurde versendet!</h2></div>";
		}else{
			$sentMessage="<div class='alert alert-danger'><h2>Beim Email Versand ist ein Fehler aufgetreten</h2></div>";
			$sentMessage="<div class='alert alert-danger'><h2>Beim Email Versand ist ein Fehler aufgetreten</h2></div>";

		}
		// 		sentMail($MessageArray);
		// 		mail ( $email , "Passwort Reset Link" , $message );
		// 		echo $message;
	}
	$query="UPDATE user SET resetToken='$token' WHERE email='$email'";
	mysqli_query($verbindung,$query);
	unset($_POST['email']);
}


if(isset($_POST['action']) && $_POST['action']=="setPasswort"){
	$resetToken=addslashes($_POST['resetToken']);
	$password=hash("sha512", $_POST['password']);
	$query="UPDATE user SET password='$password', resetToken='' WHERE resetToken='$resetToken'";
// 	echo $query;
	$ergebnis=mysqli_query($verbindung,$query) or die(mysqli_error($verbindung));
	$affRows=mysqli_affected_rows ( $verbindung );
	if($affRows<0){
		echo "<script>window.location = '/module/user/PasswortReset.php?e=1';</script>";  //Fehler bei der Abfrage aufgetreten
	}elseif($affRows==0){
		echo "<script>window.location = '/module/user/PasswortReset.php?e=2';</script>";  //Nutzer nicht gefunden
	}elseif($affRows>0){
		echo "<script>window.location = '/module/user/PasswortReset.php?e=3';</script>";  //Alles OK
	}
}

?>
<html>
	<head>
		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/head_main.php");?>
		<br>
		<style></style>
	</head>
	<body>
		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/header_bar.php");?>
		<div class="container-fluid">
			<div class="row" style='margin-top:50px;'>
				<div class="col-md-4"></div>
				<div class="col-md-4">
					<?php
					if(isset($_GET['e'])){
						switch($_GET['e']){
							case 1:
					?>
					<div class="alert alert-warning">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Achtung!</strong>Bei der Übermittlung ist ein Fehler aufgetreten!
					</div>
					<?php
								break;

							case 2:
					?>
					<div class="alert alert-warning">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Achtung!</strong>Der Reset-Token ist unbekannt!
					</div>
					<?php
								break;

							case 3:
					?>
					<div class="alert alert-success">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Erfolgreich!</strong><br>Das Passwort wurde zurückgesetzt! Sie können sich nun mit dem neuen Passwort anmelden!
					</div>
					<?php
								break;
						}
					}


					if(isset($_GET['r'])){

					?>
					<p>Sie können nun ein neues Passwort setzen!</p>
					<form action="" method="post" accept-charset="utf-8">
						<input class='form-control' type='hidden' value="setPasswort" name='action'>
						<div class="form-group">
							<label>Passwort Reset Token
								<input class='form-control' type='text' name="resetToken" value='<?php echo $_GET['r']; ?>' Placeholder='Passwort Reset Token'><br>
							</label>
						</div>
						<div class="form-group">
							<label>Neues Passwort eingeben
								<input class='form-control' type='password' id="password" name="password"  Placeholder='Neues Passwort eingeben'><br>
							</label>
						</div>
						<div class="form-group">
							<label>Neues Passwort bestätigen
								<input class='form-control'  type='password' id="passwordConfirm" name="passwordConfirm"  Placeholder='Neues Passwort bestätigen'><br>
							</label>
						</div>
						<input class='btn btn-default TotalWidth'  type="submit" value="Absenden">
					</form>
					<script>
						var password = document.getElementById("password"), confirm_password = document.getElementById("passwordConfirm");

						function validatePassword(){
							if(password.value != confirm_password.value) {
								confirm_password.setCustomValidity("Passwörter stimmen nicht überein");
							} else {
								confirm_password.setCustomValidity('');
							}
						}

						password.onchange = validatePassword;
						confirm_password.onkeyup = validatePassword;

					</script>
					<?php
					}else{

					?>
						<?php echo $sentMessage; ?>
					<form action="" method="post" accept-charset="utf-8">
						<input type="hidden" name="action" value="getResetToken">
						<p>Bitte geben Sie Ihre hinterlegte Email-Adresse ein. Dann wird ein Passwort-Reset-Token an diese Adresse versendet, falls diese Adresse im System bekannt ist!</p>
						<input class='form-control TotalWidth' type='text' name="email"  Placeholder='Email Adresse' required><br><input class='btn btn-default TotalWidth' type="submit" value="Absenden">
					</form>
					<?php
					}
					?>
				</div>
				<div class="col-md-4"></div>
			</div>
		</div>
		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/bottom_main.php");?>

	</body>
</html>

<?php

