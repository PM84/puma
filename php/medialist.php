<?php
session_start();
$uID=$_SESSION['uID'];
// $uID=1;
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
$query="SELECT * FROM media WHERE uID=$uID and (dateiname LIKE '%png%' or dateiname LIKE '%jpg%' or dateiname LIKE '%gif%' )";
$ergebnis=mysqli_query($verbindung,$query);
while($row=mysqli_fetch_assoc($ergebnis)){
	echo "<div style='cursor:pointer; float:left; border: solid gray 1px; border-radius:5px; width:80px; height:80px; margin:5px; padding:5px; box-shadow: 0px 0px 5px #888' class='PUMAMediaLIst' data-src='/media/uploads/".$row['dateiname']."' data-mediaID='".$row['mediaID']."'><img style='width:100%; max-height:70px;' src='/media/uploads/".$row['dateiname']."'></div>";
}

?>
<script src="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/js/jquery311.min.js"></script>

<script type="text/javascript" language="javascript">
	$(document).on("click","div.PUMAMediaLIst",function(){
		item_url = $(this).data("src");
		mediaID = $(this).attr("data-mediaID");
// 		alert(mediaID);
		var args = top.tinymce.activeEditor.windowManager.getParams();
		win = (args.window);
		input = (args.input);
		win.document.getElementById(input).value = item_url;
		$.post( "/php/media.php", { PostFktn: "add_file_to_kurs", mediaID: mediaID },function( data ) {alert( "Data Loaded: " + data );}   );
		top.tinymce.activeEditor.windowManager.close();
	});
</script>