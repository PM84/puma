<?php if($abgegeben!=1){ ?>
<script>
	$(document).ready(function(){
		// jQuery.noConflict(); 
		$("#myModal").modal();
	});
</script>
<?php } ?>
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Wie bearbeite ich diese Aufgabe?</h4>
			</div>
			<div class="modal-body">
				<?php if(!isset($AufgabeInfo->hinweis) || strlen($AufgabeInfo->hinweis)<10) { ?>
				<div class="alert alert-warning">
					<p>Mit dieser und ähnlicher Aufgaben sollen Sie lernen, wie Sie sich möglichst gut in der Physik ausdrücken können.</p>
					<p>Da dies nicht ganz leicht ist, finden Sie im Folgenden ein paar Hinweise zur Bearbeitung dieser Aufgabe:</p>
					<ol>
						<li>Es wird Ihnen ein Video angezeigt. Schauen Sie sich das Video zunächst (gerne auch mehrfach) an um einen Überblick zu bekommen.</li>
						<li>Schauen Sie sich das Video erneut an und machen Sie sich notizen wann, was zu sehen ist.</li>
						<li>Klicken Sie auf "Aufnahme starten" und sprechen Sie in Ihr Mikrophon.</li>
						<li>Hören und sehen Sie sich Ihre Aufnahme an und machen Sie sich notizen, wo Sie etwas verbessern möchten/können.</li>
						<li>Nehmen Sie eine weitere Version Ihrer Beschreibung auf und hören diese nochmal zur Probe an.</li>
						<li>Sie können beliebig viele Versionen aufzeichnen, so lange, bis Sie denken, dass alles in Ordnung ist.</li>
					</ol>
				</div>
				<?php }else{ 
				?> 	<div class="alert alert-warning">
				<?php	echo html_entity_decode ($AufgabeInfo->hinweis, ENT_QUOTES , "UTF-8");
				?> </div> <?php } ?>
				<div class="alert alert-info">
					<h4>
						Allgemeine Hinweise
					</h4>
					<ul>
						<li>Falls Sie während der Bearbeitung eine Pause machen möchten ist dies ohne Weiteres möglich. Ihre bisherigen Aufnahmen werden automatisch gespeichert. </li>
						<li><b>Am Ende müssen Sie eine Version Ihrer Aufnahme abgeben, indem Sie auf den entsprechenden Button klicken, erst dann können Sie ein Feedback erhalten.</b></li>
						<li>Die Bearbeitung kann sowohl mit Windows, Apple oder Android Geräden auf den jeweiligen stationären oder mobilen Endgeräten erfolgen. Einzige Voraussetzung ist ein aktueller Browser, der nicht älter als September 2017 ist.</li>
						<li>Auf iOS (Apple) Geräten ist zudem mindestens iOS11 notwendig.</li>
					</ul>
				</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Jetzt beginnen</button>
				</div>
			</div>

		</div>
	</div>

	<style>
		.modal-backdrop.fade.in{
			z-index:1;
			display:none;
		}
	</style>