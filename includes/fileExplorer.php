<?php
include_once($_SERVER['DOCUMENT_ROOT']."/php/media.php");

?>

<div id="collapse_upload" class="panel-collapse collapse">
	<div class="panel-body">
		<link href="/plugins/fileUpload/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
		<link href="/plugins/fileUpload/themes/explorer/theme.css" media="all" rel="stylesheet" type="text/css"/>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="/plugins/fileUpload/js/plugins/sortable.js" type="text/javascript"></script>
		<script src="/plugins/fileUpload/js/fileinput.js" type="text/javascript"></script>
		<script src="/plugins/fileUpload/js/locales/fr.js" type="text/javascript"></script>
		<script src="/plugins/fileUpload/js/locales/es.js" type="text/javascript"></script>
		<script src="/plugins/fileUpload/themes/explorer/theme.js" type="text/javascript"></script>

		<div class="kv-main">
			<form enctype="multipart/form-data" method="post"  action="postAcceptor.php">
				<input type="hidden" name="MAX_FILE_SIZE" value="53687091200" />
				<div class="form-group">
					<input type="file" name="userfile" class="file">
				</div>
			</form>

			<style>
				.videoExplorerBox{
					background-color:lightgray;
					border-radius:5px;
					display:inline-block;
					margin:5px;
				}

				.videoPrevBox{
					border-radius:5px;
					padding:5px;
				}

			</style>

			<div class="form-group" style="display:block; margin: 0 auto;">
				<?php
				$fileList=getFileList();
				$iLauf=1;
				$fileCount=count($fileList);
				foreach($fileList as $file){
				?>
				<div class="videoExplorerBox">
					<div class="videoPrevBox">
						<video width="190" height="100" controls preload="none">
							<source src="/media/uploads/<?php echo $_SESSION['uID']."/".$file['dateiname'];?>" <?php if($iLauf<$fileCount){echo ",";} ?>>
						</video>
					</div>
					<div style="font-size:10px; text-align:center;">
						<?php echo $file['dateiname'];?><br>
						<b><?php echo $file['titel'];?></b><br>
						<?php echo formatSizeUnits($file['size']);?>
					</div>
					<div style="font-size:10px; text-align:center; margin:3px;">
						<button class="btn btn-success verwenden" value="<?php echo $file['mediaID'];?>">verwenden</button>
						<button class="btn btn-danger">löschen</button>
					</div>
				</div>


				<?php
					$iLauf++;
				}
				?>

			</div>
		</div>
		<script>

			$(".verwenden").click(function() {
				$("#verw_fileID").val($(this).val());
				$("#verwendenForm").submit();
			})
		</script>
		<form method='post' action='' id='verwendenForm'><input type='hidden' value='' id='verw_fileID' name='fileID'></form>
	</div>
</div>