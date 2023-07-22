CKEDITOR.editorConfig = function(config){
	
	config.language = 'tr';


	config.uiColor = '#211d3b';
	config.height = 300;
	config.toolbarCanCollapse = true;

	
	
	config.toolbarGroups = [
		{ name: 'mode'},			// Displays document group with its two subgroups.
 		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },			// Group's name will be used to create voice label.
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align' ] },
 		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'styles' },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'colors' }
	];
	
	//config.filebrowserBrowseUrl = '../kcfinder/browse.php';
	//config.filebrowserUploadUrl	= '../kcfinder/upload.php';
	config.extraPlugins = 'codemirror';
	config.extraPlugins = 'youtube';

	
	
	

	config.codemirror = {

		theme: 'dark',
		lineNumbers: true,
		lineWrapping: true,
		matchBrackets: true,
		autoCloseTags: true,
		autoCloseBrackets: true,
		enableSearchTools: true,
		enableCodeFolding: false,
		enableCodeFormatting: false,
		autoFormatOnStart: true,
		autoFormatOnModeChange: true,
		autoFormatOnUncomment: true,

		// Define the language specific mode 'htmlmixed' for html including (css, xml, javascript), 'application/x-httpd-php' for php mode including html, or 'text/javascript' for using java script only
		mode: 'htmlmixed',

		showSearchButton: true,
		showTrailingSpace: true,
		highlightMatches: true,
		showFormatButton: true,
		showCommentButton: true,
		showUncommentButton: true,
		showAutoCompleteButton: true,
		styleActiveLine: true
	};

};

