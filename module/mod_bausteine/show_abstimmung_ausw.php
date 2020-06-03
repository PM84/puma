<?php
include_once($_SERVER['DOCUMENT_ROOT']."/module/mod_bausteine/php/abstimmung.php");
$Abst_name="abstOption";
$jsonStimmen=html_entity_decode (get_abstimmung_OptArray($_SESSION['fID'],$Abst_name,$bID,$Block), ENT_QUOTES , "UTF-8");
// $jsonStimmen=json_decode($jsonStimmen);
$aktNbr=count(json_decode($jsonStimmen));

?>


<div class="row">
	<div class="col-md-12">
		<span><?php if(isset($bInfo['beschreibung'])){echo html_entity_decode ($bInfo['beschreibung'], ENT_QUOTES , "UTF-8");} ?></span>
	</div>
</div>
<div id="chart_div_<?php echo $Block;?>"></div>

<div>
	<p class="lead">Antworten der Schüler
		<a class="btn btn-default" href="/module/mod_bausteine/print_abstimmung_ausw.php?b=<?php echo $Block; ?>" target="_blank" style="margin-left:10px;"><span class="glyphicon glyphicon-print"> alle</span></a>
		<a class="btn btn-default" href="/module/mod_bausteine/print_abstimmung_ausw.php?b=<?php echo $Block; ?>&s=1" target="_blank" style="margin-left:10px;"><span class="glyphicon glyphicon-print"> einzeln</span></a>
	</p>
	<?php
	include($_SERVER['DOCUMENT_ROOT']."/module/mod_bausteine/print_abstimmung_ausw.php");
	?>
</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
	google.charts.load('current', {'packages':['corechart','bar']});
	google.charts.setOnLoadCallback(drawChart);

	function drawChart() {

		var jsonData = <?php echo $jsonStimmen?>;

		// Create our data table out of JSON data loaded from server.
		var data = new google.visualization.DataTable(jsonData);
		var options = {'width':$('#chart_div_<?php echo $Block;?>').width(),
					   'height':$('#chart_div_<?php echo $Block;?>').width()*0.75,
					   legend: {position: 'none'}
					  };

		// Instantiate and draw our chart, passing in some options.
		var chart = new google.visualization.ColumnChart(document.getElementById('chart_div_<?php echo $Block;?>'));
		chart.draw(data, options);
	}
</script>