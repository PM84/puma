tinymce.PluginManager.add('1medialist', function(editor, url) {
	// Add a button that opens a window
	editor.addButton('1medialist', {
		text: '1medialist',
		icon: false,
		onclick: function() {
			// Open window
			editor.windowManager.open({
				title: 'Example plugin',
				body: [
					{type: 'textbox', name: 'title', label: 'Title'}
				],
				onsubmit: function(e) {
					// Insert content when the window form is submitted
					editor.insertContent('Title: ' + e.data.title);
				}
			});
		}
	});

}