<?php
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/kursInfos.php");
if(!isset($abgabeErforderlich)){$abgabeErforderlich=0;}
if(isset($ausserhalbKurs) && $ausserhalbKurs=1){}else{

	include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/module/mod_preasentation/praesentationseinstellungen.php");
	// var_dump($FolienListe_Praes);

	$zurueck_btn_aktiv=1;
	$weiter_btn_aktiv=1;
	// 	$FolieInfoAkt=getFolieInfo($_SESSION['fID']);
	if(isset($_SESSION['fID'])){
		$next_fID_Arr=get_next_fID_Arr($_SESSION['kursID'],$_SESSION['fID']);
		//    		var_dump($next_fID_Arr);
		if(isset($next_fID_Arr['previous'])){
			if($next_fID_Arr['previous']!=$next_fID_Arr['aktuell']){
				$FolieInfo=getFolieInfo($next_fID_Arr['previous']);
				$parameterFolie=json_decode($FolieInfo['parameter']);
				$modID=$FolieInfo['modID'];
				$modInfo=getModulInfos($modID);
				$zurueck_href=$_SESSION['DOCUMENT_ROOT_DIR']."/".$modInfo['mod_dir']."/".$modInfo['mod_show']."?f=".$next_fID_Arr['previous'];
				$zurueck_btn_class="btn-warning";
				$zurueck_btn_aktiv=1;
			}else{
				$zurueck_href="";
				$zurueck_btn_class="btn-default";
				if($next_fID_Arr['first']==$next_fID_Arr['aktuell']){
					$zurueck_btn_aktiv=0;

				}else{
					$zurueck_btn_aktiv=1;
				}
			}
		}else{
			$zurueck_href="";
			$zurueck_btn_class="btn-default";
			if($next_fID_Arr['first']==$next_fID_Arr['aktuell']){
				$zurueck_btn_aktiv=0;

			}else{
				$zurueck_btn_aktiv=1;
			}
		}

		if(
			(
				(isset($next_fID_Arr['next']) && $next_fID_Arr['next']!=$next_fID_Arr['aktuell']) 
				/* || ((isset($_SESSION['uID']) && Check_if_kurs_edit_allowed($_SESSION['kursID'],intval($_SESSION['uID']))==1)) */
			)
			/* 			&& ($next_fID_Arr['aktuell']<$next_fID_Arr['last'])
			&& (isset($next_fID_Arr['next']) || isset($next_fID_Arr['wait_for_fID'])) */
		){

			if(isset($next_fID_Arr['next'])){
				$next_fID=$next_fID_Arr['next'];
			}/* elseif(isset($next_fID_Arr['wait_for_fID'])){
				$next_fID=$next_fID_Arr['wait_for_fID'];
			} */
			$FolieInfo=getFolieInfo($next_fID);
			$parameterFolie=json_decode($FolieInfo['parameter']);
			$modID=$FolieInfo['modID'];
			$modInfo=getModulInfos($modID);
			$weiter_href=$_SESSION['DOCUMENT_ROOT_DIR']."/".$modInfo['mod_dir']."/".$modInfo['mod_show']."?f=".$next_fID;
			$weiter_btn_class="btn-success";
			$weiter_btn_aktiv=1;
		}else{
			$weiter_href="";
			$weiter_btn_class="btn-default";
			// 			$fID_Arr['next_freigabeStatus']
			if($next_fID_Arr['aktuell']==$next_fID_Arr['last']){
				//Ende erreicht
				$weiter_btn_aktiv=2;
			}elseif($next_fID_Arr['wait']==1){
				//warten auf Freigabe
				$weiter_btn_aktiv=3;
			}elseif($next_fID_Arr['next_show_freigabe']==0 && $next_fID_Arr['next_show_freigabe']==1){
				//warten auf Freigabe
				$weiter_btn_aktiv=3;
			}else{
				//normaler Ablauf
				$weiter_btn_aktiv=0;
			}
		}
	}
	if(isset($redirect_next_folie) && $redirect_next_folie==1){
		echo "<script>window.location = '" . $_SESSION['DOCUMENT_ROOT_DIR']."$weiter_href';</script>";

	}

?>

<script>
	function SetSyncStatus(){
		$.post("<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/module/mod_preasentation/praesentationseinstellungen.php", { fkt: "SetLehrerSync", kursID: <?php echo $_SESSION['kursID']; ?>, fID: <?php echo $_SESSION['fID']; ?> })
			.done(function(data){
			console.log(data);
		});
	}

	function SetFreigabeStatus(){
		$.post("<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/module/mod_preasentation/praesentationseinstellungen.php", { fkt: "SetFreigabeStatus", kursID: <?php echo $_SESSION['kursID']; ?>, fID: <?php echo $_SESSION['fID']; ?> })
			.done(function(data){
			console.log(data);
		});
	}
</script>

<span style=''>
	<?php 
	if(!isset($backend) || $backend==0) {
	?>
	<?php 
		switch($zurueck_btn_aktiv){
			case 0:
	?>
	<button type="button" class="PraesNavBarButtons btn btn-default" >Start</button>
	<?php
				break;

			default:
	?>
	<a href="<?php echo $zurueck_href; ?>" style='color: black;'>
		<button type="button" class="PraesNavBarButtons btn <?php echo $zurueck_btn_class; ?> btn-arrow-left"><span class="hidden-md hidden-lg">&nbsp;</span><span class="hidden-xs hidden-sm">vorherige Folie</span></button>
	</a>
	<?php
				break;
		}


		if(isset($_SESSION['fID'])){
			// 			$maxOrderID=getMaxOrderID($_SESSION['kursID'],1);
			// 			$aktOrderID=getOrderID($_SESSION['fID'],$_SESSION['kursID']);
			// echo "$maxOrderID==$aktOrderID" ;
			// 			if((($_SESSION['kTyp']==2 && $weiter_href!=="")||($_SESSION['kTyp']==2 && $maxOrderID==$aktOrderID)) ){}else{
			if($abgabeErforderlich==1 && $abgegeben!=1 ){
	?>
	<button style="margin-right: 15px;" type="submit" form="praesForm" value="1" name="abgegeben" class="btn btn-primary jsIESupport" id="btn_abgabe"><span class="hidden-xs hidden-sm">Abgeben</span><span class="hidden-md hidden-lg glyphicon glyphicon-save"></span></button>
	<?php
			}elseif(isset($abgegeben) && $abgegeben==1 ){
	?>
	<span style="margin-right:15px;"class="btn btn-success hidden-md hidden-lg glyphicon glyphicon-ok" ></span>
	<span class="btn btn-success hidden-xs hidden-sm " style="margin-right: 15px;" >Bereits abgegeben</span>
	<?php
			}
		}


	?>
	<?php 
		switch($weiter_btn_aktiv){
			case 0:
	?>
	<button type="submit" form="praesForm" value="goToNext_fID" name="SaveAndNext" class="PraesNavBarButtons btn btn-primary btn-arrow-right jsIESupport">
		<span style="font-size: 19px;"class="hidden-md hidden-lg glyphicon glyphicon-ok" ></span>
		<span style="" class="hidden-xs hidden-sm "  >Abgeben und weiter</span>
	</button>
	<?php 
				break;
			case 1:
	?>
	<a href="<?php echo $weiter_href; ?>" style='color: black;'>
		<button type="button" class="PraesNavBarButtons btn <?php echo $weiter_btn_class; ?> btn-arrow-right"><span class="hidden-md hidden-lg">&nbsp;</span><span class="hidden-xs hidden-sm">nächste Folie</span></button>
	</a>
	<?php
				break;
			case 2:
	?>
	<span class="PraesNavBarButtons btn-default"><span class="hidden-md hidden-lg glyphicon glyphicon-remove"></span><span class="hidden-xs hidden-sm">ENDE</span></span>
	<?php
				break;
			case 3:
	?>
	<span class="PraesNavBarButtons btn btn-info btn-arrow-right"><span style="font-size: 19px;" class="hidden-md hidden-lg glyphicon glyphicon-hourglass"></span><span class="hidden-xs hidden-sm">Warten auf Freigabe</span></span>
	<script>

		window.setInterval(function(){
			$.post("<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/module/mod_preasentation/praesentationseinstellungen.php", { fkt: "CheckFreigabeStatus", kursID: <?php echo $_SESSION['kursID']; ?>, fID: <?php echo $next_fID_Arr['wait_for_fID']; ?> })
				.done(function(data){
				console.log(data);
				if(data==1){
					location.reload();
				}
			});
		}, 5000);

	</script>
	<?php
				break;
		}
		if(isset($_SESSION['uID']) && isset($_SESSION['kursID']) && Check_if_kurs_edit_allowed($_SESSION['kursID'],$_SESSION['uID'])==1){
			$syncRow=getLehrerSync($_SESSION['kursID']);
	?>
	<button style="float:right;" type="button" class="navbar-toggle glyphicon glyphicon-cog"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
	<a style="float:right;" class="navbar-toggle" style="color:black;" href="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/module/mod_preasentation/add_task.php?f="<?php echo $_SESSION['fID']; ?>" target="blank"><span class="glyphicon glyphicon-pencil"></span></a>
	<ul class="dropdown-menu" style="left:auto; right:20px; padding:15px;">
		<li>
			<div class="checkbox">
				<label>
					<input name='show_auto'  type="hidden" value=0>
					<input name='show_auto' id='show_auto'  type="checkbox" data-toggle="toggle" data-on="Ja" data-off="Nein" data-onstyle="success" data-offstyle="danger" data-size="small" onchange="SetSyncStatus()" 
						   <?php if(isset($syncRow['fID']) && $syncRow['fID']==$_SESSION['fID'] && $syncRow['aktiv']==1){echo "checked";}?>
						   >Schüler auf diese Folie anheften</label>
				<script>
					if("<?php if($syncRow['fID']==$_SESSION['fID'] && $syncRow['aktiv']==1){echo "on";}else{echo "off";}?>"=="on"){
						// 						$('#show_auto').bootstrapToggle('on')
					}else{
						// 						$('#show_auto').bootstrapToggle('off')
					}
				</script>
			</div>
		</li>
		<li role="separator" class="divider"></li>
		<li>
			<div class="checkbox">
				<label><?php //var_dump($next_fID_Arr);?>
					<input name='show_freigabe'  type="hidden" value=0>
					<input name='show_freigabe' id='show_freigabe'  type="checkbox" data-toggle="toggle" data-on="Ja" data-off="Nein" data-onstyle="success" data-offstyle="danger" value=1 data-size="small" onchange="SetFreigabeStatus()" <?php if(isset($next_fID_Arr['freigabeStatus']) && $next_fID_Arr['freigabeStatus']==1){echo "checked";}?>>Diese Folie freigeben.</label>
				<script>
					if("<?php if(isset($next_fID_Arr['freigabeStatus']) && $next_fID_Arr['freigabeStatus']==1){echo "on";}else{echo "off";}?>"=="on"){
						// 						$('#show_freigabe').bootstrapToggle('on')
					}else{
						// 						$('#show_freigabe').bootstrapToggle('off')
					}
				</script>

			</div>
		</li>
		<li role="separator" class="divider"></li>
		<li>
			<div class="checkbox">
				<?php $FolieInfo=getFolieInfo($next_fID_Arr['aktuell']);  if($FolieInfo['modID']==1){ $_SESSION['last_shown_page']=$_SERVER["REQUEST_URI"]; ?>
				<a class="btn btn-default" href="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/module/mod_videovertonung/show_abgabe_uebersicht.php">Auswertung der Videovertonungen</a>
				<?php }else{ ?>
				<a class="btn btn-default" href="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/module/mod_preasentation/show_auswertung.php">Auswertung dieser Folie zeigen</a>
				<?php } ?>
			</div>
		</li>

	</ul>
	<?php } ?>
	<?php
	}
	?>

</span>
<?php
}