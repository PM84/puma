<iframe id="ytplayer" type="text/html" width="100%" height="<?php echo 1/(16/9)*100 ?>%" src="<?php echo "https://www.youtube.com/embed/" . $bInfo['ytID']; ?>?rel=0&showinfo=0&color=white&iv_load_policy=3&start="<?php echo $bInfo['von']; if( isset($bInfo['bis']) && $bInfo['bis']>0){echo "&end=".$bInfo['bis'];} ?>"
		frameborder="0" allowfullscreen>
</iframe> 