<?php
// ========================
// ========================
// ====== PRÄSENTATION - mehrspaltig - S H O W
// ========================
// ========================

$themen=Get_VideoThemen();
$videos=Get_Videos_Liste();
$Sims=Get_Sim_Liste();

?>
<script src="/plugins/d3Cloud/d3.v3.min.js"></script>
<script src="/plugins/d3Cloud/d3.layout.cloud.js"></script>
<script src="/plugins/d3Cloud/removeStopWords.js"></script>
<script src="/plugins/d3Cloud/underscore-min.js"></script>

<div class="row">
	<!--<div class="col-md-1"></div>//-->
	<div class="row">
		<div class="col-md-12" style=''>
<!--			<p class="lead" style='margin:0 0 20 0'><?php if(isset($AufgabeInfo["titel"])){echo html_entity_decode ($AufgabeInfo["titel"], ENT_QUOTES , "UTF-8");} ?></p>//-->

			<?php
			$Block="top";
			include($_SERVER['DOCUMENT_ROOT']."/module/mod_preasentation/show_praesentation_bloecke_single.php");

			?>
		</div>
	</div>

	<div class="row">
		<?php
		for($jLauf=1;$jLauf<=$_SESSION['DesignTyp'];$jLauf++){
			// var_dump($_SESSION);
		?>
		<div class="col-md-<?php echo 12/$_SESSION['DesignTyp']; ?>" style=''>

			<?php
			$Block=$jLauf;
			include($_SERVER['DOCUMENT_ROOT']."/module/mod_preasentation/show_praesentation_bloecke_single.php");
			?>
		</div>
		<?php
		}				
		?>
	</div>

	<div class="row">
		<div class="col-md-12">
			<?php
			$Block="bottom";
			include($_SERVER['DOCUMENT_ROOT']."/module/mod_preasentation/show_praesentation_bloecke_single.php");
			?>
		</div>
	</div>
</div>
<div class="col-md-1"></div>
