<script src="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/plugins/tinymce/js/tinymce/tinymce.min.js"></script>

<script>
	tinymce.init({
		selector: 'textarea',
		language: 'de',
		height: 300,
		theme: 'modern',
		plugins: [
			'advlist autolink lists link charmap preview hr powerpaste',
			'searchreplace wordcount visualblocks visualchars code fullscreen',
			'insertdatetime nonbreaking save table contextmenu directionality',
			'textcolor colorpicker textpattern toc image'
		],
		toolbar1: 'undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link hr',
		toolbar2: 'fontsizeselect forecolor backcolor | code preview image',
		image_advtab: true,

		external_filemanager_path:"/filemanager/",
		filemanager_title:"Responsive Filemanager" ,
		/* 				external_plugins: { "filemanager" : "/filemanager/plugin.min.js"},
 */
		content_css: [
			'//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
			'//www.tinymce.com/css/codepen.min.css'
		],
		file_browser_callback : 
		function(field_name, url, type, win){
			var filebrowser = "/php/medialist.php";
			filebrowser += (filebrowser.indexOf("?") < 0) ? "?type=" + type : "&type=" + type;
			tinymce.activeEditor.windowManager.open({
				title : "PUMA@LMU Image Browser",
				width : 800,
				height : 400,
				url : filebrowser
			}, {
				window : win,
				input : field_name
			});
			return false;
		},

		images_upload_handler: function (blobInfo, success, failure) {
			var xhr, formData;

			xhr = new XMLHttpRequest();
			xhr.withCredentials = false;
			xhr.open('POST', '/php/postAcceptor.php');

			xhr.onload = function() {
				var json;

				if (xhr.status != 200) {
					failure('HTTP Error: ' + xhr.status);
					return;
				}
				console.log(xhr.responseText);

				json = JSON.parse(xhr.responseText);
				if (!json || typeof json.location != 'string') {
					failure('Invalid JSON: ' + xhr.responseText);
					return;
				}

				success(json.location);
			};

			formData = new FormData();
			formData.append('file', blobInfo.blob(), blobInfo.filename());

			xhr.send(formData);
		}

	});
</script>