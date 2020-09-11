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
			'textcolor colorpicker textpattern toc'
		],
		toolbar1: 'undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link hr',
		toolbar2: 'fontsizeselect forecolor backcolor | code preview',
		automatic_uploads: false,
		paste_data_images: false,

		image_advtab: true,

		content_css: [
			'//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
			'//www.tinymce.com/css/codepen.min.css'
		],
	});
</script>