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
		<title>Krajee JQuery Plugins - &copy; Kartik</title>
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
			<div class="page-header">
				<h1>Bootstrap File Input Example
					<small><a href="https://github.com/kartik-v/bootstrap-fileinput-samples"><i
																								class="glyphicon glyphicon-download"></i> Download Sample Files</a></small>
				</h1>
			</div>
			<form enctype="multipart/form-data"  method="post"  action="postAcceptor.php">
				<input id="kv-explorer" type="file" name="userfile" multiple>
				<br>
				<!--<input id="file-0a" class="file" name="userfile" type="file" multiple data-min-file-count="1">//-->
				<br>
				<button type="submit" class="btn btn-primary">Submit</button>
				<button type="reset" class="btn btn-default">Reset</button>
			</form>
			<hr>
			<form enctype="multipart/form-data">
				<label for="file-0b">Test invalid input type</label>
				<input id="file-0b" name="file-0b" class="file" type="file" multiple data-min-file-count="1">
				<script>
					$(document).on('ready', function () {
						$("#file-0b").fileinput();
					});
				</script>
			</form>
			<hr>
			<form enctype="multipart/form-data" method="post"  action="postAcceptor.php">
				<input id="file-0c" class="file" type="file" multiple data-min-file-count="3">
				<hr>
				<div class="form-group">
					<input id="file-0d" class="file" type="file">
				</div>
				<hr>
				<div class="form-group">
					x<input id="file-1" type="file" multiple name="userfile" class="file" data-overwrite-initial="false" data-min-file-count="2">
				</div>
				<hr>
				<div class="form-group">
					<input id="file-2" type="file" class="file" readonly data-show-upload="false">
				</div>
				<hr>
				<div class="form-group">
					<label>Preview File Icon</label>
					<input id="file-3" type="file" multiple>
				</div>
				<hr>
				<div class="form-group">
					<input id="file-4" type="file" class="file" data-upload-url="#">
				</div>
				<hr>
				<div class="form-group">
					<button class="btn btn-warning" type="button">Disable Test</button>
					<button class="btn btn-info" type="reset">Refresh Test</button>
					<button class="btn btn-primary">Submit</button>
					<button class="btn btn-default" type="reset">Reset</button>
				</div>
				<hr>
				<div class="form-group">
					<input type="file" class="file" id="test-upload" multiple>
					<div id="errorBlock" class="help-block"></div>
				</div>
				<hr>
				<div class="form-group">
					<input id="file-5" class="file" type="file" multiple data-preview-file-type="any" data-upload-url="#">
				</div>
			</form>
			<hr>
			<h4>Multi Language Inputs</h4>
			<form enctype="multipart/form-data">
				<label>French Input</label>
				<input id="file-fr" name="file-fr[]" type="file" multiple>
				<hr style="border: 2px dotted">
				<label>Spanish Input</label>
				<input id="file-es" name="file-es[]" type="file" multiple>
			</form>
			<hr>
			<br>
		</div>
	</body>
	<script>
		$('#file-fr').fileinput({
			language: 'fr',
			uploadUrl: '#',
			allowedFileExtensions: ['jpg', 'png', 'gif']
		});
		$('#file-es').fileinput({
			language: 'es',
			uploadUrl: '#',
			allowedFileExtensions: ['jpg', 'png', 'gif']
		});
		$("#file-0").fileinput({
			'allowedFileExtensions': ['jpg', 'png', 'gif']
		});
		$("#file-1").fileinput({
			uploadUrl: '#', // you must set a valid URL here else you will get an error
			allowedFileExtensions: ['jpg', 'png', 'gif'],
			overwriteInitial: false,
			maxFileSize: 1000,
			maxFilesNum: 10,
			//allowedFileTypes: ['image', 'video', 'flash'],
			slugCallback: function (filename) {
				return filename.replace('(', '_').replace(']', '_');
			}
		});
		/*
     $(".file").on('fileselect', function(event, n, l) {
     alert('File Selected. Name: ' + l + ', Num: ' + n);
     });
     */
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
		$(".btn-warning").on('click', function () {
			var $el = $("#file-4");
			if ($el.attr('disabled')) {
				$el.fileinput('enable');
			} else {
				$el.fileinput('disable');
			}
		});
		$(".btn-info").on('click', function () {
			$("#file-4").fileinput('refresh', {previewClass: 'bg-info'});
		});
		/*
     $('#file-4').on('fileselectnone', function() {
     alert('Huh! You selected no files.');
     });
     $('#file-4').on('filebrowse', function() {
     alert('File browse clicked for #file-4');
     });
     */
		$(document).ready(function () {
			$("#test-upload").fileinput({
				'showPreview': false,
				'allowedFileExtensions': ['jpg', 'png', 'gif'],
				'elErrorContainer': '#errorBlock'
			});
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
			/*
         $("#test-upload").on('fileloaded', function(event, file, previewId, index) {
         alert('i = ' + index + ', id = ' + previewId + ', file = ' + file.name);
         });
         */
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