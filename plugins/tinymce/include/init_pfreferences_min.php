<script src="/plugins/tinymce/js/tinymce/tinymce.min.js"></script>

<script>

	/* 	if ($('#modalWrapper').is(':empty')){
		$( "#modalWrapper" ).load( "/plugins/tinymce/include/media_include_modal.php" );
	} */
	tinymce.init({
		selector: 'textarea',
		language: 'de',
		height: 600,
		theme: 'modern',
		plugins: [
			'advlist autolink lists link charmap preview hr powerpaste',
			'searchreplace wordcount visualblocks visualchars code fullscreen',
			'insertdatetime nonbreaking save table contextmenu directionality',
			'textcolor colorpicker textpattern toc image media tiny_mce_wiris'
		],
		toolbar1: 'undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link hr',
		toolbar2: 'fontsizeselect forecolor backcolor | code preview image media mediaInclude | tiny_mce_wiris_formulaEditor tiny_mce_wiris_formulaEditorChemistry ',
		image_advtab: true,
		external_filemanager_path:"/filemanager/",
		filemanager_title:"Responsive Filemanager" ,
		/* 				external_plugins: { "filemanager" : "/filemanager/plugin.min.js"},
 */
		content_css: [
			'//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
			'//www.tinymce.com/css/codepen.min.css'
		],
/* 		images_dataimg_filter: function(img) {
		console.log(img);
			return img.hasAttribute('blob/png');
		},
 */		file_browser_callback : 
		function(field_name, url, type, win){
			var filebrowser = "/php/medialist.php";
			filebrowser += (filebrowser.indexOf("?") < 0) ? "?type=" + type : "&type=" + type;
			tinymce.activeEditor.windowManager.open({
				title : "PUMA@LMU Image Browser",
				width : 800,
				height : 500,
				url : filebrowser
			}, {
				window : win,
				input : field_name
			});
			return false;
		},

		images_upload_handler: function (blobInfo, success, failure) {
			var xhr, formData;
			 				console.log(blobInfo);
			// 				console.log(success);
			// 				console.log(failure);

			xhr = new XMLHttpRequest();
			xhr.withCredentials = false;
			xhr.open('POST', '/php/postAcceptor.php');

			xhr.onload = function() {
				var json;
				console.log(xhr.responseText);

				if (xhr.status != 200) {
					//			error message anzeigen -> uncomment
					// 					failure('HTTP Error: ' + xhr.status);
					return;
				}

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
		},

		setup: function (editor) {
			editor.addButton('mediaInclude', {
				text: 'Media Include',
				icon: false,   //you can use an image instead of text
				onclick: function () {
					// 					if ($('#modalWrapper').is(':empty')){
					$( "#modalWrapper" ).empty().load( "/plugins/tinymce/include/media_include_modal.php" );
					$( document ).ajaxComplete(function() {
						$('#MediaIncludeBox').modal('show');
						$(".modal-backdrop").remove();
					});
					// 					}
					/* 					$('#myModal').modal('show');
 */					// JavaScript code to open your Bootstrap modal
					// The modal would use TinyMCE APIs to write data back into the editor
				}
			});
		}
	});
</script>
