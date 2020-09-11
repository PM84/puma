<?php 
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/module/mod_klassenbesuch/fkt_buchung.php");

?>
<html>
	<head>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/head_main.php");?>
	</head>
	<body>
		<div class="navmenu navmenu-default navmenu-fixed-left">
			<div style='width:100%; display:block;text-align:center;'>
				<img src="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/images/PumaLMU_LS_Logo.png" alt="" height="50">
			</div>
			<ul class="nav navmenu-nav"  style='margin-top:10px;'></ul>
			<ul class="nav navmenu-nav"></ul>
		</div>

		<!--<div class="loginCanv navmenu-default navmenu-fixed-right ">
<?php 

?>
</div>//-->

		<div class="canvas" style="">
			<div class="navbar navbar-default navbar-fixed-top" style="width:100%">
				<div class='row'>
					<div class="col-sm-6" style="height: 55px; text-align:left;">
						<span style="font-size: 24px; font-family: inherit; text-align:left;"><img src="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/images/LMU_Logo.png" style="margin:10px;"><span style="margin-top:10px;">Klassenbesuche</span></span>
					</div><div class="col-sm-6" style="text-align:center;">
					</div>

				</div>
			</div>
			<div class="container">

				<h3>
					Buchen Sie einen Klassenbesuch am Lehrstuhl für Didaktik der Physik
				</h3>
				<p>
					Sollte Ihr Wunschtermin bereits gebucht sein, können Sie sich in die Warteliste eintragen. Sollte ein Termin frei werden, werden wir uns umgehend mit Ihnen in Verbindung setzen.
				</p>

				<table class="table table-responsive">
					<thead>
						<tr>
							<!--<th>ID</th>//-->
							<th>Datum</th>
							<th>Beginn</th>
							<th>Ende</th>
							<th>Thema</th>
							<th>maximale<br>Schülerzahl</th>
							<th>empfohlene<br>JgSt</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php
						$TerminListe=getTerminListe();
						if(count($TerminListe)>0){
							foreach($TerminListe as $Termin){
								$parameter=json_decode($Termin['parameter'],true);
								$jgStArr=array();
								 if(isset($parameter['Gym']) && count($parameter['Gym'])>0){array_push($jgStArr,"Gym: ".join(",",$parameter['Gym']));}
								 if(isset($parameter['RS']) && count($parameter['RS'])>0){array_push($jgStArr,"RS: ".join(",",$parameter['RS']));}
								 if(isset($parameter['MS']) && count($parameter['MS'])>0){array_push($jgStArr,"MS: ".join(",",$parameter['MS']));}
								 if(isset($parameter['GS']) && count($parameter['GS'])>0){array_push($jgStArr,"GS: ".join(",",$parameter['GS']));}



						?>
						<tr>
<!--							<th scope="row"><?php echo $Termin['TerminID'];?></th>
//-->							<td><?php echo date("d.m.Y",strtotime ($Termin['start']));?></td>
							<td><?php echo date("H:i",strtotime ($Termin['start']));?></td>
							<td><?php echo date("H:i",strtotime ($Termin['ende']));?></td>
							<th><?php echo $Termin['titel'];?></th>
							<th><?php echo $parameter['maxTN'];?></th>
							<th><?php echo join("<br>",$jgStArr);?></th>
							<td>
								<form action="buchung.php" method="POST" style="margin:0;">
									<?php
								switch(count(getBuchungen_by_TerminID($Termin['TerminID']))){
									case 0;
									?>
									<input type="hidden" name=TerminID value="<?php echo $Termin['TerminID'];?>">
									<button type='submit' class="btn btn-primary">Buchen</button>
									<?php
										break;
									case 1:
									?>
									<input type="hidden" name=TerminID value="<?php echo $Termin['TerminID'];?>">
									<button type='submit' class="btn btn-warning">Warteliste</button>
									<?php 
										break;
									case 2:
									?>
									<input type="hidden" name=TerminID value="<?php echo $Termin['TerminID'];?>">
									<button type='submit' class="btn btn-warning">Warteliste (>2 Bewerber)</button>
									<?php 
										break;
									default:
									?>
									<span class="btn btn-danger">Warteliste bereits voll</span>
									<?php }?>
								</form>
							</td>
						</tr>
						<?php
							}
						}else{
						?>
						<th scope="row" colspan=5>Aktuell sind noch keine Termine zur Auswahl freigegeben. Bitte kommen Sie später nochmal zurück!</th>

						<?php
						}
						?>
					</tbody>
				</table>
			</div>

		</div>
	</body>
</html>