<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT']."/php/system.php");

?>

<html>
	<head>
		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/head_main.php");?>
	</head>
	<body>
		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/header_bar.php");?>
		<div class="container">

			<h1>PUMA UPDATE SYSTEM</h1>
			<?php
			ini_set('max_execution_time',60);


			//Check for an update. We have a simple file that has a new release version on each line. (1.00, 1.02, 1.03, etc.)
			$getVersions = file_get_contents('http://www.jdev.pemasoft.de/zCMS-UPDATE-PACKAGES/current-release-versions.txt') or die ('ERROR');
			if ($getVersions != '')
			{
				$found="";
				$updated=false;
				//If we managed to access that file, then lets break up those release versions into an array.
				echo '<p>AKTUELLE VERSION: '.get_siteInfo('CMS-Version').'</p>';
				// 				echo '<p>Aktuelle Version wird gelesen</p>';
				$versionList = explode("n", $getVersions);    
				foreach ($versionList as $aV)
				{
					if ( $aV > get_siteInfo('CMS-Version')) {
						echo '<p  class="alert alert-success">Neues Update gefunden: v'.$aV.'</p>';
						$found = true;

						//Download The File If We Do Not Have It
						if ( !is_file(  $_SERVER['DOCUMENT_ROOT'].'/zUPDATES/MTv4-update-'.$aV.'.zip' )) {
							echo '<p  class="alert alert-info">Update wird heruntergeladen.</p>';
							$newUpdate = file_get_contents('http://www.jdev.pemasoft.de/zCMS-UPDATE-PACKAGES/MTv4-update-'.$aV.'.zip');
							if ( !is_dir( $_SERVER['DOCUMENT_ROOT'].'/zUPDATES/' ) ) mkdir ( $_SERVER['DOCUMENT_ROOT'].'/zUPDATES/' );
							$dlHandler = fopen($_SERVER['DOCUMENT_ROOT'].'/zUPDATES/MTv4-update-'.$aV.'.zip', 'w');
							if ( !fwrite($dlHandler, $newUpdate) ) { echo '<p  class="alert alert-danger">Das Update konnte nicht gespeichert werden. Vorgang abgebrochen</p>'; exit(); }
							fclose($dlHandler);
							echo '<p>Das Update-Packet wurde heruntergeladen und gespeichert.</p>';
						} else echo '<p class="alert alert-info">Das Update wurde bereits heruntergeladen.</p>';    

						if (isset($_GET['doUpdate']) && $_GET['doUpdate'] == true) {

							$filename = $_SERVER['DOCUMENT_ROOT'].'/zUPDATES/MTv4-update-'.$aV.'.zip';
							$dest_folder = $_SERVER['DOCUMENT_ROOT'];

							$zip = new ZipArchive();
							$result = $zip->open($filename);
							if ($result) {
								$zip->extractTo($dest_folder);
								$zip->close();
								echo '<p class="alert alert-success" >Update wurde erfolgreich installiert</p>';

							}else{
								echo "<p class='alert alert-danger'>Es ist ein Fehler aufgetreten!</p>";
							}

							// 			}
							
							include($_SERVER['DOCUMENT_ROOT']."/update/update.php");
							$updated = TRUE;
						}
						else echo '<p>Update ready. <a class="btn btn-success" href="?doUpdate=true">&raquo; Jetzt installieren?</a></p>';
						break;
					}
				}

				if ($updated == true)
				{
					set_setting('site','CMS',$aV);
					echo '<p class="success">&raquo; CMS Updated to v'.$aV.'</p>';
				}
				else if ($found != true) echo '<p class="alert alert-info">&raquo; Es ist bereits die aktuellste Version installiert.</p>';


			}
			else echo '<p>Could not find latest realeases.</p>';
			?>
		</div>

	</body>
</html>

