<?php
// ========================
// ========================
// ====== VIDEO AUSWAHL PANEL 
// ========================
// ========================


// ========================
// ====== WICHTIG
// ========================

// $themen=Get_VideoThemen();
// $videos=Get_Videos_Liste();

// MÜSSEN AUßERHALB DER SCHLEIFE GESETZT WERDEN DADURCH WIRD DIE GESCHWINDIGKEIT DER SEITE MASSIV ERHÖHT!

// ========================
// ====== WICHTIG - E N D E
// ========================

?>

<p class="lead" style='margin:0'>Video auswählen</p>
<div class="panel-group" id="accordion">
	<?php
	foreach($themen as $thema){
		
		$status=0;
	?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<a data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $tem_vID_Block; ?>_<?php echo $thema->themaID;?>" style='none'>
				<div>
					<h4 class="panel-title">
						<?php echo $thema->titel;?>
						<!--<span class="pull-right clickable"  data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $thema->themaID;?>"><i class="glyphicon glyphicon-chevron-up"></i></span>//-->
					</h4>
				</div>
			</a>
		</div>
		<div id="collapse_<?php echo $tem_vID_Block; ?>_<?php echo $thema->themaID;?>" class="panel-collapse collapse">
			<div class="panel-body">
				<?php
		foreach($videos as $video){
			
			if(in_array($thema->themaID,$video->themen)){
				$status=1;
				?>
				<form action='' method="POST" style='margin:0;' >
					<input type=hidden value='<?php echo $video->vID; ?>' name='tem_vID_<?php echo $tem_vID_Block; ?>'><input type="submit" class="btn btn-default" style='width:100%' value="<?php echo $video->titel; ?>">
				</form>

				<?php
			}
		}
		if($status==0){
			echo "Zu diesem Thema gibt es noch keine Videos.";
		}

				?>
			</div>
		</div>
	</div>
	<?php
	}
	?>
</div>