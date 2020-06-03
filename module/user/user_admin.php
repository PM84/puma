<?php
session_start();
include($_SERVER['DOCUMENT_ROOT']."/php/user_login.php");

$UserListe=GetUserList();

?>

<html>
	<head>
		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/head_main.php");?>
	</head>
	<body>
		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/header_bar.php");?>

		<div class="container">
			<div class="row" style=''>
				<div class="col-md-1"></div>
				<div class="col-md-10">
					<div class="row" style=''>
						<div class="col-md-8" style="">
							<?php 
							if(in_array(1,GetUserGroup($_SESSION['uID']))){
							?>
							<a class="btn btn-success" style="font-weight:bold;" href='/module/user/user_edit.php'><span class="glyphicon glyphicon-plus"></span> Benutzer hinzufügen</a>
							<?php 
							}
							?>
						</div>
						<div class="col-md-4">
							<form action="" method="post">
								<div class="input-group mb-2 mr-sm-2 mb-sm-0">
									<div class="input-group-addon"><button type="submit" style="background:none; border:none;" ><span class="glyphicon glyphicon-search"></span></button></div>
									<input class="form-control" type="search" value="" id="search-input">
								</div>

							</form>
						</div>
					</div>

					<div class="row" style=''>
						<div class="col-md-12">
							<table class="table table-striped">
								<thead>
									<tr>
										<th>#</th>
										<th>Name</th>
										<th>Vorname</th>
										<th class="hidden-sm hidden-xs">Username</th>
										<th class="hidden-sm hidden-xs">Email</th>
										<th>Schule</th>
										<th class="usergroupEllipsis hidden-sm hidden-xs">Gruppen</th>
										<th class="hidden-sm hidden-xs"></th>
									</tr>
								</thead>
								<tbody>
									<?php
									$iLauf=1;
									foreach($UserListe as $user){
										$GroupInfos=array();
										// 										var_dump($user);
										foreach($user['uGroups'] as $GroupID){
											$GroupInfo=GetUserGroupInfo($GroupID);
											array_push($GroupInfos,$GroupInfo['titel']);
										}
										$GroupString=join(', ', $GroupInfos);
										$SchulInfos=getSchulInfos($user['SchulNr']);

									?>
									<tr>
										<th scope="row"><?php echo $iLauf; ?></th>
										<td><a href='/module/user/user_edit.php?u=<?php echo $user['uID']; ?>'><?php echo $user['name']; ?></a></td>
										<td><a href='/module/user/user_edit.php?u=<?php echo $user['uID']; ?>'><?php echo $user['vname']; ?></a></td>
										<td class="hidden-sm hidden-xs"><?php echo $user['username']; ?></td>
										<td class="hidden-sm hidden-xs"><?php echo $user['email']; ?></td>
										<td class="schuleEllipsis hidden-sm hidden-xs"><?php echo $SchulInfos['Name']; ?></td>
										<td class="schuleEllipsis visible-sm visible-xs"><?php echo $user['SchulNr']; ?></td>
										<td class="usergroupEllipsis hidden-sm hidden-xs"><?php echo $GroupString; ?></td>
										<td class="hidden-sm hidden-xs">
											<?php 
										if($user['uID']!=$_SESSION['uID']){
											?>
											<button style="height:1.5em;padding: 0 10px;" class="btn btn-danger glyphicon glyphicon-trash"></button>
											<?php 
										}
											?>
										</td>
									</tr>
									<?php
										$iLauf++;
									}
									?>

								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="col-md-1"></div>
			</div>
		</div>

		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/bottom_main.php");?>
	</body>
</html>