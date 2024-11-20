/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.height = 100,
	config.language = langsite;
	// config.filebrowserImageBrowseUrl = vsw_filemanager+'?type=Images';
	// config.filebrowserImageUploadUrl = vsw_filemanager+'/upload?type=Images&_token='+csrf_token;
	// config.filebrowserBrowseUrl = vsw_filemanager+'?type=Files';
	// config.filebrowserUploadUrl = vsw_filemanager+'/upload?type=Files&_token='+csrf_token;

	config.filebrowserBrowseUrl = vsw_filemanager+'/dialog.php?&akey='+akeyfilemanager+'&type=2&editor=ckeditor&fldr='+userid;
	config.filebrowserUploadUrl = vsw_filemanager+'/dialog.php?&akey='+akeyfilemanager+'&type=2&editor=ckeditor&fldr='+userid;
	config.filebrowserImageBrowseUrl = vsw_filemanager+'/dialog.php?&akey='+akeyfilemanager+'&type=1&editor=ckeditor&fldr='+userid;
	config.extraPlugins = 'sourcearea,clipboard,cleanlink,video,collapsibleItem,eqneditor,switchbar,googledocs,youtube,codesnippet,widget,lineutils,btgrid,widgetbootstrap,glyphicons,notification,toolbar,panelbutton,button,bootstrapTabs,uploadwidget,notificationaggregator,filetools,uploadfile,tableresize,wordcount,autoembed,emojione,accordionList,autolink,ckawesome,find,yaqr,fontawesome5';
	config.removePlugins = 'autosave,about,tbvdownload';
	config.entities = false;
	// config.image2_altRequired = true;
	config.youtube_width = '640';
	config.youtube_height = '480';
	config.youtube_related = false;
	config.youtube_older = false;
	config.youtube_privacy = false;
	config.youtube_autoplay = true;
	config.codeSnippet_theme = 'github';
	/*config.autosave_SaveKey = 'autosaveKey';
	config.autosave_NotOlderThen = 1440;
	config.autosave_saveOnDestroy = false;
	config.autosave_saveDetectionSelectors = "a[href^='javascript:__doPostBack'][id*='Save'],a[id*='Cancel']";*/
	config.skin = 'moono-lisa';
	// config.imgurClientID = nv_imgurclientid;
	// config.imgurClientSecret = nv_imgurclientsecret;
	// config.imgurRefreshToken = nv_imgurrefreshtoken; //'769b5d1279ee9b4b64fa3d3d4407d990cdda9b2b'
	config.wordcount = {
	
	    // Whether or not you want to show the Word Count
	    showWordCount: true,
	
	    // Whether or not you want to show the Char Count
	    showCharCount: true,
	    
	    // Maximum allowed Word Count
	    //maxWordCount: 400,
	
	    // Maximum allowed Char Count
	    //maxCharCount: 1000
	};
	config.toolbarGroups = [
		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
		{ name: 'insert' },
		{ name: 'others' },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
		{ name: 'links' },
		'/',
		{ name: 'styles' },
		{ name: 'colors' },
		{ name: 'editing', groups: [ 'find', 'selection'] },
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'tools' },
		{ name: 'about' }
	];
	config.toolbar_Basic =
	[
		{ name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
		{ name: 'insert', items : [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe', 'Glyphicons', 'Source' ] },
		{ name: 'links', items : [ 'Link','Unlink','Anchor' ] },
		'/',
		{ name: 'basicstyles', items : [ 'Bold','Italic','Strike','-','RemoveFormat', 'WidgetTemplateMenu' ] },
		{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote' ] },
		{ name: 'styles', items : [ 'Font', 'FontSize', 'TextColor', 'BGColor' ] },
		{ name: 'tools', items : ['SwitchBar',  'Maximize'] },
		{ name: 'others', items: [ 'Youtube' ] },
	];
	// Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.
	config.removeButtons = 'Underline,Subscript,Superscript';

	// Set the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';

	// Simplify the dialog windows.
	config.removeDialogTabs = 'image:advanced;link:advanced';
	// config.uiColor = '#AADC6E';
	config.allowedContent = true;
	config.extraAllowedContent = 'p(*)[*]{*};div(*)[*]{*};li(*)[*]{*};ul(*)[*]{*}';
	config.fontawesome = {'path':'/css/all.min.css','version':'5.15.0','edition':'pro','element':'i'};
};

CKEDITOR.dtd.$removeEmpty['span'] = false;
CKEDITOR.dtd.$removeEmpty['i'] = false;
