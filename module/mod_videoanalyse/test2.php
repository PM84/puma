<!DOCTYPE html>

<?php
$uID=1;

if(isset($_POST['fileID'])){
?>
<script>
	alert("<?php echo $_POST['fileID']; ?>");
</script>
<?php
						   }
?>
<!-- release v4.3.9, copyright 2014 - 2017 Kartik Visweswaran -->
<!--suppress JSUnresolvedLibraryURL -->
<html lang="en">
	<head>
		<meta charset="UTF-8"/>
		<link href="/plugins/fileUpload/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
		<link href="/plugins/fileUpload/themes/explorer/theme.css" media="all" rel="stylesheet" type="text/css"/>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="/plugins/fileUpload/js/plugins/sortable.js" type="text/javascript"></script>
		<script src="/plugins/fileUpload/js/fileinput.js" type="text/javascript"></script>
		<script src="/plugins/fileUpload/js/locales/fr.js" type="text/javascript"></script>
		<script src="/plugins/fileUpload/js/locales/es.js" type="text/javascript"></script>
		<script src="/plugins/fileUpload/themes/explorer/theme.js" type="text/javascript"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
	</head>
	<body>
		<div class="container kv-main">
			<form enctype="multipart/form-data" method="post"  action="postAcceptor.php">
				<div class="form-group">
					<label>Preview File Icon</label>
					<input id="file-3" type="file" multiple>
				</div>
				<hr>
				<div class="form-group">
					<input id="file-4" type="file" class="file" data-upload-url="#">
				</div>
			</form>
		</div>
	</body>
	<script>
		$("#file-3").fileinput({
			showUpload: false,
			showCaption: false,
			browseClass: "btn btn-primary btn-lg",
			fileType: "any",
			previewFileIcon: "<i class='glyphicon glyphicon-king'></i>",
			overwriteInitial: false,
			initialPreviewAsData: true,
			initialPreview: [
				<?php
				$fileList=getFileList();
				$iLauf=1;
				$fileCount=count($fileList);
				foreach($fileList as $file){
				?>
				"/module/mod_videoanalyse/uploads/<?php echo $uID."/".$file['dateiname'];?>" <?php if($iLauf<$fileCount){echo ",";} ?>

				<?php
					$iLauf++;
				}
				?>
			],
			initialPreviewConfig: [
				<?php
				$iLauf=1;
				$fileCount=count($fileList);
				foreach($fileList as $file){
				?>
				{type: "video", size: <?php echo $file['size'] ?>, filetype: "video/mp4", caption: "<?php echo setInsertButton($file['id']);?><b><?php echo $file['titel'];?></b><?php echo $file['dateiname']; ?>", url: "/module/mod_videoanalyse/uploads/<?php echo $uID; ?>", key: <?php echo $iLauf; ?>}<?php if($iLauf<$fileCount){echo ",";} ?>

				<?php
					$iLauf++;
				}
				?>
			],

		});
		$("#file-4").fileinput({
			uploadExtraData: {kvId: '10'}
		});
		$(document).ready(function () {
			var footerTemplate = '<div class="file-thumbnail-footer" style ="height:94px">\n<div style="margin:5px 0">\n<input class="kv-input kv-new form-control input-sm text-center {TAG_CSS_NEW}" value="{caption}" placeholder="Enter caption...">\n<input class="kv-input kv-init form-control input-sm text-center {TAG_CSS_INIT}" value="{TAG_VALUE}" placeholder="Enter caption...">\n</div>\n {size} {progress} {actions}\n</div>';
			$("#kv-explorer").fileinput({
				'theme': 'explorer',
				'uploadUrl': '#',
				overwriteInitial: false,
				initialPreviewAsData: true,

				initialPreview: [
					<?php
					$fileList=getFileList();
					$iLauf=1;
					$fileCount=count($fileList);
					foreach($fileList as $file){
					?>
					"/module/mod_videoanalyse/uploads/<?php echo $uID."/".$file['dateiname'];?>" <?php if($iLauf<$fileCount){echo ",";} ?>

					<?php
						$iLauf++;
					}
					?>


				],
				initialPreviewConfig: [
					<?php
					$iLauf=1;
					$fileCount=count($fileList);
					foreach($fileList as $file){
					?>
					{type: "video", size: <?php echo $file['size'] ?>, filetype: "video/mp4", caption: "<b><?php echo $file['titel'];?></b><br><?php echo $file['dateiname']; ?>", url: "/module/mod_videoanalyse/uploads/<?php echo $uID; ?>", key: <?php echo $iLauf; ?>}<?php if($iLauf<$fileCount){echo ",";} ?>

					<?php
						$iLauf++;
					}
					?>
				]
			});
		});

		$(".verwenden").click(function() {
			$("#verw_fileID").val($(this).val());
			$("#verwendenForm").submit();
		})
	</script>
	<form method='post' action='' id='verwendenForm'><input type='hidden' value='' id='verw_fileID' name='fileID'></form>
</html>


<?php

echo setInsertButton(10);

function getFileList(){
	include($_SERVER['DOCUMENT_ROOT']."/config.php");
	$query="SELECT * from va_video WHERE uID=1";
	$ergebnis=mysqli_query($verbindung,$query);
	$FileList=array();
	while($row=mysqli_fetch_assoc($ergebnis)){
		array_push($FileList,$row);
	}
	return $FileList;
}

function setInsertButton($fileID){
	// 	return "<form method='post' action=''><input type='hidden' value='$fileID' name='fileID'><input type='submit' value='Verwenden' class='btn btn-success'></form>";
	return "<button class='btn btn-success verwenden' name='fileID' value='$fileID'>Verwenden</button>";
}

?>