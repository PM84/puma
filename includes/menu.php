<?php
$bewArr=array();
$FBArr=array();
include_once($_SERVER['DOCUMENT_ROOT']."/php/folie.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/module.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/teilnehmer.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/abgabe.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/Sessions.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/user_login.php");

if(isset($_SESSION['uID'])){
	$UserListe=GetUserList();
	$uID_List=Get_uID_List();
	// $my_userInfo=getUserInfos($_SESSION['uID']);
	$userGroups=GetUserGroup($_SESSION['uID']);
	// var_dump($my_userInfo);
}
if(isset($_SESSION['t'])){
	$token=htmlspecialchars($_SESSION['t'], ENT_QUOTES);
	$tnInfo=getTeilnehmerInfosByToken($token);
	// 	var_dump($tnInfo);
}
?>

<div class="navmenu navmenu-default navmenu-fixed-left">
	<div style='width:100%; display:block;text-align:center;'>
		<a href="/index.php" style='color: black;'><img src="/images/PumaLMU_LS_Logo.png" alt="" height="50"></a>
	</div>
	<ul class="nav navmenu-nav"  style='margin-top:10px;'>
		<?php
		if(isset($_SESSION['uID'])){
		?>
		<li><a href="/module/user/logout.php" class='btn btn-danger btn-margin-menu'>Logout</a></li>
		<?php
		}else{
		?>
		<li class="visible-xs visible-sm"><a href="/module/user/login.php" class='btn btn-default btn-margin-menu'>Login</a></li>
		<?php } ?>
	</ul>
	<ul class="nav navmenu-nav"  style='margin-top:10px;'>
		<?php
		if(isset($_SESSION['uID']) && in_array(2,$userGroups)){
		?>
		<li><a href="/module/user/user_admin.php" class='btn btn-warning btn-margin-menu'>Lehrer verwalten</a></li>
		<li><a href="/module/admin/kurs_shared.php" class='btn btn-warning btn-margin-menu'>Freigegebene Kurse</a></li>
		<li><a href="/module/admin/hilfe.php" class='btn btn-warning btn-margin-menu'>Hilfe & Support</a></li>
		<li><a href="/module/admin/neuerungen.php" class='btn btn-warning btn-margin-menu'>Neuerungen</a></li>
		<li><a href="/module/mod_klassenbesuch/admin.php" class='btn btn-warning btn-margin-menu'>Klassbenbesuche Termine</a></li>
		<?php
		}
		if(isset($_SESSION['s'])){
			$SessionInfos=Get_SessionInfos($_SESSION['s']);
			$GroupArray=json_decode($SessionInfos['uGroupIDs']);
			if(count($GroupArray)>0){
				if(isset($_SESSION['uID']) && in_array ( 1 ,$GroupArray )){
					// Admin Menü
		?>
		<li><a href="/update/index.php" class='btn btn-warning btn-margin-menu'>Update installieren</a></li>
		<li><a href="/module/admin/agb.php" class='btn btn-warning btn-margin-menu'>AGB verwalten</a></li>
		<li><a href="/module/user/user_registration.php" class='btn btn-warning btn-margin-menu'>Registrierung</a></li>
		<li><a href="#" class='btn btn-warning btn-margin-menu'>Inhalte verwalten / moderieren</a></li>
		<li><a href="#" class='btn btn-warning btn-margin-menu'>Einstellungen</a></li>
		<?php
				}
		?>
	</ul>
	<ul class="nav navmenu-nav">
		<?php

				if(isset($_SESSION['uID']) && in_array ( 2 ,$GroupArray )){
		?>
		<li><a href="/module/admin/kurs_erstellen.php" class='btn btn-info btn-margin-menu'>Kurs erstellen</a></li>
		<li><a href="/module/admin/teilnehmer_eintragen.php" class='btn btn-info btn-margin-menu'>Teilnehmer eintragen & editieren</a></li>
		<li><a href="/module/admin/fragen_erstellen.php" class='btn btn-info btn-margin-menu'>Evaluationsfragen erstellen & editieren</a></li>
		<li><a href="/module/admin/baustein_erstellen.php" class='btn btn-info btn-margin-menu'>Bausteine erstellen & editieren</a></li>
		<li><a href="/module/admin/folie_erstellen.php" class='btn btn-info btn-margin-menu'>Folie erstellen & editieren</a></li>
		<li><a href="/module/admin/praesentation.php" class='btn btn-info btn-margin-menu'>Reihenfolge</a></li>
	</ul>
	<ul class="nav navmenu-nav">
		<?php

				}
			}else{
				// 				echo "<script>window.location = '/module/user/logout.php';</script>";  
			}
		}
		if(isset($_SESSION['t']) && isset($_SESSION['kursID']) && isset($_SESSION['kTyp'])){
			switch(intval($_SESSION['kTyp'])){
				case 1:
					include("menu_einzel.php");
					break;
				case 2:
					include("menu_praesentation.php");
					break;
			}
		}
		?>
	</ul>
</div>

<!--<div class="loginCanv navmenu-default navmenu-fixed-right ">
<?php 

?>
</div>//-->

<div class="canvas" style="padding-bottom:100px;">
	<div class="navbar navbar-default navbar-fixed-top" style="width:100%">
		<div class='row'>
			<div class="col-xs-2  col-sm-3" style="height: 55px;">
				<button type="button" class="navbar-toggle" data-toggle="offcanvas" data-recalc="false" data-target=".navmenu" data-canvas=".canvas">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="/index.php" style='color: black;'><button type="button" class="navbar-toggle glyphicon glyphicon-tag hidden-xs" ></button></a>
			</div>
			<div class="col-xs-10 col-sm-9" style="text-align:center;">

				<?php
				$uri=reconstruct_url($_SERVER[REQUEST_URI]);
				if("$uri"=="/module/mod_preasentation/add_task.php" || "$uri"=="/module/mod_videovertonung/add_task.php" || "$uri"=="/module/mod_videovertonung/add_task_stapel.php"){
				?>
				<button type=submit  class='btn btn-danger jsIESupport' name="btn_back" value=1 form="backForm"><span class="glyphicon glyphicon-remove" style="color: white; font-size: 16px;"></span><span class="hidden-xs" style="margin:0 10px;">Abbrechen</span></button>

				<button class="btn btn-default jsIESupport" style="margin-top: 8px; margin: 8px;" name="savePraes" value='2' type="submit" form="praesForm"><span class="glyphicon glyphicon-ok" style=" color: black; font-size: 16px;"></span><span class="hidden-xs" style="margin:0 10px;">Speichern & Schließen</span></button>

				<button class="btn btn-primary jsIESupport" style="margin-top: 8px; margin-right: 15px; margin-bottom: 8px;" name="savePraes" value='1' type="submit" form="praesForm"><span class="glyphicon glyphicon-save" style="color: white; font-size: 16px;"></span><span class="hidden-xs" style="margin:0 10px;">Speichern</span></button>
				<?php if(count(getFolieInfo_bytoken($_GET['ft']))>0 ){ ?>
				<button id="savePreview" class="btn btn-default jsIESupport" form="praesForm" value=3 name="savePraes" type="submit"><span class="glyphicon glyphicon-eye-open" style=" font-size: 16px;"></span><span class="hidden-xs" style="margin:0 10px;">Speichern & Vorschau</span></button>
				<?php } ?>

				<?php
				}

				if(!isset($_SESSION['s'])){
				?>
				<button type="button" class="navbar-toggle glyphicon glyphicon-log-in cls_login hidden-xs hidden-sm" style="float:right" onclick="location.href='/module/user/login.php'"></button>
				<?php 
				}
				if(isset($_SESSION['s'])){
				?>
				<button type="button" class="navbar-toggle glyphicon glyphicon-log-out cls_login hidden-xs hidden-sm" style="float:right" onclick="location.href='/module/user/logout.php'"></button>
				<a class="btn btn-default cls_login navbar-toggle" style="float:right;" href="/module/mod_videoanalyse/RecordVideo.php"><i class="glyphicon glyphicon-record" style="color:red;"></i></a>
				<a class="btn btn-default cls_login navbar-toggle" style="float:right;" href="/module/mod_videovertonung/show_abgabe_uebersicht.php"><i class="glyphicon glyphicon-volume-up" style="color:black;"></i></a>
				<a class="btn btn-default cls_login navbar-toggle" style="float:right;" href="/module/mod_videoanalyse/show_abgabe_uebersicht.php"><i class="glyphicon glyphicon-facetime-video" style="color:black;"></i></a>
				<div id="menuTopRight"></div>
				<?php
				}
				?>

				<?php

				if(isset($_SESSION['t']) && isset($_SESSION['kursID']) && isset($_SESSION['kTyp'])){
					switch(intval($_SESSION['kTyp'])){
						case 1:
							include("menu_einzel_top.php");
							break;
						case 2:
							include("menu_praesentation_top.php");
							break;
					}
				}
				?>
			</div>
			<script>

				/* 				$( ".cls_login" ).click(function() {
					$('.navmenu').offcanvas("hide");
					$('.navbar').offcanvas("show");
				});
 */

			</script>
		</div>
	</div>
	<div class="visible-xs-block" style="height:30px;"></div>
	<?php // Nachfolgender DIV Tag dient als Wrapper für den TinyMCE Editor ?>
	<div id="modalWrapper"></div>
	<?php
	// Der closing - DIV TAG befindet sich in bottom_main.php	
	?>
