<html>
	<head>
		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/head_main.php");?>
	</head>
	<body>
		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/header_bar.php");?>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<form role="form">
						<div class="form-group">

							<label for="exampleInputEmail1">
								Email address
							</label>
							<input type="email" class="form-control" id="exampleInputEmail1" />
						</div>
						<div class="form-group">

							<label for="exampleInputPassword1">
								Password
							</label>
							<input type="password" class="form-control" id="exampleInputPassword1" />
						</div>
						<div class="form-group">

							<label for="exampleInputFile">
								File input
							</label>
							<input type="file" id="exampleInputFile" />
							<p class="help-block">
								Example block-level help text here.
							</p>
						</div>
						<div class="checkbox">

							<label>
								<input type="checkbox" /> Check me out
							</label>
						</div> 
						<button type="submit" class="btn btn-default">
							Submit
						</button>
					</form>
				</div>
			</div>
		</div>
		<form action="#" method="POST">
			<input type="text" name="vname" id="vname" class="MeldeForm" placeholder="Vorname" required>
			<br>
			<input type="text" name="name" id="name" class="MeldeForm" placeholder="Name" required>
			<br>
			<input type="text" name="email" id="email" class="MeldeForm" placeholder="Email" required>
			<br>
			<input type="text" name="username" id="username" class="MeldeForm" placeholder="Benutzername" required><div id='user-result' style='display:inline-block;'></div>
			<br>
			<input type="password" name="password" id="password" class="MeldeForm" placeholder="Passwort" required>
			<br>
			<input type="password" id="password2" class="MeldeForm" placeholder="Passwort wiederholen" required>
			<br>

		</form>
		<script>
			var password = document.getElementById("password"), confirm_password = document.getElementById("password2");

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
	</body>
</html>


<?php 
if(isset($_POST['username']) && strlen($_POST['username'])>3){
	$password=hash("sha512", $_POST['password']);
	$username=addslashes($_POST['username']);
	$vname=addslashes($_POST['vname']);
	$name=addslashes($_POST['name']);
	$email=addslashes($_POST['email']);

	include("../config.php");
	$query="INSERT IGNORE INTO users (name, vname, email, username, passwort) VALUES ('$name', '$vname', '$email', '$username', '$password') ";
	echo $query;

}


