<?php
// echo "==>".$_SESSION['Baustein_'.$Block]."<==";
if(isset($_SESSION['Baustein_'.$Block])){
	// 					echo $iLauf.": ".$_SESSION['Baustein_'.$iLauf];



	switch($_SESSION['Baustein_'.$Block]){
		case 1:
?>

<div id="inhalt_<?php echo $Block;?>" class="inhalt_Wrap">
	<?php if(isset($AufgabeInfo["inhalt_$Block"])){echo html_entity_decode ($AufgabeInfo["inhalt_$Block"], ENT_QUOTES , "UTF-8");} ?>
</div>
<style>


</style>
<script>
	var MarkImg_Json_<?php echo $Block; ?>="<?php echo json_encode($AufgabeInfo["ImgMark_$Block"]); ?>;
	var DivInhaltBlock = document.getElementById("inhalt_<?php echo $Block;?>");
	var images = DivInhaltBlock.getElementsByTagName('img');

	$( document ).ready(function() {
		for(i=0; i<images.length;i++){
			var filename=images[i]['src'].match(/([^\/]+)(?=\.\w+$)/)[0];
			images[i].setAttribute('id',filename);
			$('#'+filename).wrap( "<div class='ImgWrap cont' id='image_"+filename+"'></div>" );
		}


		if(!jQuery.isEmptyObject(MarkImg_Json_<?php echo $Block;?>)){
			var MarkIDTmp;
			$.each(MarkImg_Json_<?php echo $Block;?>, function(MarkID,arr){ 
				filename=arr['fn'];
				MarkIDTmp=MarkID;
				SetMark(arr['x'],arr['y'],filename,MarkID,arr['txt'],"<?php echo $Block;?>");
			});
			$("#AnzMark_<?php echo $Block;?>").val(MarkIDTmp);
		}
	});



</script>

<?php
			break;
		case 2:  // Videos einblenden
			if(isset($_POST['tem_vID_'.$Block]) || isset($_SESSION['tem_vID_'.$Block])){
				if(isset($_POST['tem_vID_'.$Block])){
					$_SESSION['tem_vID_'.$Block]=intval($_POST['tem_vID_'.$Block]);
				}
				$videoInfo=Get_VideoInfos_By_vID($videos,$_SESSION['tem_vID_'.$Block]);
				$link_src=get_video_link($videoInfo,"sd");

?>
<video width="100%" muted controls>
	<source src="<?php echo $link_src; ?>" type="video/mp4">
	Ihr Browser unterstützt den Video Tag nicht. Bitte aktualisieren Sie Ihren Browser.
</video>
<?php
			}
			break;


		case 3:  // Simulationen einblenden
			if(isset($_POST['tem_simID_'.$Block]) || isset($_SESSION['tem_simID_'.$Block])){
				if(isset($_POST['tem_simID_'.$Block])){
					$_SESSION['tem_simID_'.$Block]=intval($_POST['tem_simID_'.$Block]);
				}
				$simInfo=Get_SimInfos_By_vID($Sims,$_SESSION['tem_simID_'.$Block]);
				// 									$link_src=get_Sim_link($simInfo->link_src,"vid_m");

?>
<div class="iframe_container">

	<iframe id='iframe_<?php echo $Block;?>' class='iframe_window' src="<?php echo $simInfo->url; ?>"></iframe>
</div>
<p>Die Seite wird nicht richtig dargestellt? Dann klicken Sie bitte <a href="<?php echo $simInfo->url; ?>" target="_blank">hier</a></p>
<?php
			}
			break;

		case 4:   // Eingabefeld einblenden
			$abgabeErforderlich=1;

?>
<script>
	tinymce.init({
		// 				selector: 'textarea',
		/* 				editor_selector : "mceEditor",
				editor_deselector : "mceNoEditor",*/
		// 				selector : "textarea.editor",
		selector : "textarea",
		language: 'de',
		height: 400,
		theme: 'modern',
		plugins: [
			'advlist autolink lists link charmap print preview hr anchor powerpaste',
			'searchreplace wordcount visualblocks visualchars code fullscreen',
			'insertdatetime nonbreaking save table contextmenu directionality',
			'emoticons textcolor colorpicker textpattern codesample toc'
		],
		toolbar1: 'undo redo | bold italic underline | bullist numlist outdent indent | link',
		toolbar2: 'forecolor | codesample',
		image_advtab: true,
		content_css: [
			'//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
			'//www.tinymce.com/css/codepen.min.css'
		],

	});
</script>

<div class="form-group">
	<?php
			// 			if($abgegeben!=1){
			switch($abgegeben){
				default:
	?>
	<textarea name="<?php echo 'txt_'.$Block; ?>"><?php if(isset($AbgabeInfo['txt_'.$Block])){echo $AbgabeInfo['txt_'.$Block];}?></textarea>
	<?php
					break;
				case 1:
	?>
	<div class='textarea_div_abgegeben editor'>
		<p class="lead">Deine Abgabe:</p>
		<?php if(isset($AbgabeInfo['txt_'.$Block])){echo  html_entity_decode ($AbgabeInfo['txt_'.$Block], ENT_QUOTES , "UTF-8");}?>
	</div>
	<?php 
					break;
				case 2:
	?>
	<div class=''>
		<p class="lead">Abgaben aller Schüler:
			<a class="btn btn-default" href="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/module/mod_preasentation/print_ausw_textblock.php?b="<?php echo $Block; ?>" target="_blank" style="margin-left:10px;"><span class="glyphicon glyphicon-print"> alle</span></a>
			<a class="btn btn-default" href="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/module/mod_preasentation/print_ausw_textblock.php?b="<?php echo $Block; ?>&s=1" target="_blank" style="margin-left:10px;"><span class="glyphicon glyphicon-print"> einzeln</span></a>		
		</p>
		<?php 
					include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/module/mod_preasentation/print_ausw_textblock.php");
		?>
	</div>
	<?php 

					break;
			}
	?>
</div>
<?php
			break;

		case 5:   // Bausteine einblenden
?>
<div class="form-group">
	<?php 
			$abgabeErforderlich=1;
			$bID=$_SESSION['bID_'.$Block];
			// 			if($abgegeben!=1){ 
			// 			echo $abgegeben;
			switch($abgegeben){
				default:
	?>
	<div class=''>
		<?php 
					include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/module/mod_bausteine/show_baustein.php");?>
	</div>
	<?php
					break;
				case 1:
					// 			}else{ ?>
	<div class='textarea_div_abgegeben'>
		<?php 
					include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/module/mod_bausteine/show_baustein_loe.php");
		?>
	</div>
	<?php
					break;
				case 2:
					include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/module/mod_bausteine/show_baustein_ausw.php");
					break;
					// 			}
			}
	?>

</div>
<?php
			break;

		case 6:
?>
<div class="form-group">
	<?php 
			$abgabeErforderlich=0;
			$bID=$_SESSION['bID_'.$Block];
	?>
	<div class=''>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/module/mod_bausteine/show_baustein.php");?>
	</div>
</div>
<?php
			break;

	}
}

?>