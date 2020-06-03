<?php
include($_SERVER['DOCUMENT_ROOT']."/config.php");
include($_SERVER['DOCUMENT_ROOT']."/module/mod_kontakt/fkt_buchung.php");




?>

<html>
	<head>
		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/head_main.php");?>
		<script src="/plugins/tinymce/js/tinymce/tinymce.min.js"></script>
	</head>
	<body>
		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/header_bar.php");?>
		<div class="container">
			<div class="row" style='margin:30 0;'>
				<div class="col-md-1"></div>
				<div class="col-md-10">
					<p class="lead">Kontakt</p>
					<p>StR Peter Mayer</p>
					<p>pe.mayer@lmu.de</p>
				</div>
				<div class="col-md-1"></div>
			</div>
			<hr>
			<div class="row" style='margin:30 0;'>
				<div class="col-md-1"></div>
				<div class="col-md-10">
					<h4>Demo - PUMA@LMU</h4>
					<a href="/module/mod_kontakt/create_new_demo_account.php" class="btn btn-primary">zur Demo wechseln</a>
				</div>
				<div class="col-md-1"></div>
			</div>
			<hr>

			<div class="row" style='margin:30 0;'>
				<div class="col-md-1"></div>
				<div class="col-md-10">
					<h2>
						Hinweis
					</h2>
					<h3>PUMA@LMU ist für Sie und Ihre Kollegen dauerhaft <span style="color:#137f14; font-weight:bold;">kostenlos</span>!</h3>
					<p>Ferner loggen wir keinerlei Nutzer- oder Nutzungsdaten.<br>Wenn wir etwas über die Verwendung von PUMA@LMU erfahren möchten würden wir Sie direkt fragen.</p>
					<h3>Informations Blatt zu PUMA@LMU</h3>
					<a class="btn btn-success" href="/vorlagen/Handout_PUMA@LMU.pdf" target="_blank"><span class="glyphicon glyphicon-download-alt" style="margin-right:10px;"></span>Download</a>

				</div>
				<div class="col-md-1"></div>
			</div>
			<hr>

			<div class="row" style='margin:30 0;'>
				<div class="col-md-1"></div>
				<div class="col-md-10">

					<h3>
						SchILF  buchen
					</h3>
					<h4>
						Hinweise:
					</h4>
					<ul>
						<li>Alle aufgeführten Termine haben das gleiche Programm.</li> 
						<li>Zum Workshop werde ich zu Ihnen an die Schule kommen.</li>
						<li>Sie benötigen für jeden Teilnehmer einen PC mit Internetzugang. (PC-Raum)</li>
						<li>Der Workshop ist für Sie kostenlos! Ich wäre Ihnen jedoch dankbar, wenn Sie mir während und nach dem Workshop einige Fragen, anonym beantworten würden.</li>
						<li>Der Workshop dauert c.a. 2 Stunden und kann innerhalb des Zeitfensters frei gewählt werden.</li>
						<li>Die Absprache von Details zum Termin erfolgt im Anschluss per E-Mail.</li>
						<li>Sollte ein Termin bereits gebucht worden sein, können Sie sich in die jeweilige <button class="btn btn-warning">Warteliste</button> des entsprechenden Termins eintragen</li>
					</ul>
					<br>
					<table class="table table-responsive">
						<thead>
							<tr>
								<th>ID</th>
								<th>Datum</th>
								<th>Zeitfenster<br>ab</th>
								<th>Zeitfenster<br>bis</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php
							$TerminListe=getTerminListe();
							if(count($TerminListe)>0){
								foreach($TerminListe as $Termin){
							?>
							<tr>
								<th scope="row"><?php echo $Termin['TerminID'];?></th>
								<td><?php echo Wochentag(date("N",strtotime ($Termin['start'])))." ". date("d.m.Y",strtotime ($Termin['start']));?></td>
								<td><?php echo date("H:i",strtotime ($Termin['start']));?></td>
								<td><?php echo date("H:i",strtotime ($Termin['ende']));?></td>
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
<!--					<h4>Keinen passenden Termin gefunden?</h4>
					<p><strong>Auch im Wintersemester werden nochmals Termine angeboten.</strong><br>Diese Termine werden etwa im Oktober und November stattfinden. Die Anmeldung erfolgt dann ab etwa Schuljahresbeginn und wird durch eine weitere Email angekündigt.</p>
//-->				</div>
				<div class="col-md-1"></div>
			</div>
		</div>
	</body>
</html>

<?php

function Wochentag($dayofWeek){
	switch($dayofWeek){
		case 1:
			$retval="Mo.";
			break;
		case 2:
			$retval="Di.";
			break;
		case 3:
			$retval="Mi.";
			break;
		case 4:
			$retval="Do.";
			break;
		case 5:
			$retval="Fr.";
			break;
		case 6:
			$retval="Sa.";
			break;
		case 7:
			$retval="So.";
			break;

	}
	return $retval;
}


