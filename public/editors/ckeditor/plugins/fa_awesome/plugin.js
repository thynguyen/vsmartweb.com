CKEDITOR.dtd.$removeEmpty.span = 0;
CKEDITOR.dtd.$removeEmpty.em = 0;
CKEDITOR.dtd.$removeEmpty.i = 0;

CKEDITOR.plugins.add('fa_awesome', {
	icons : 'fa_awesome',
	init : function(editor) {
		editor.addCommand('fa_awesome', new CKEDITOR.dialogCommand('ckeditorFaDialog', {
			allowedContent : 'i(!fa)',
		}));
		editor.ui.addButton('fa_awesome', {
			label : 'Chèn biểu tượng Font Awesome',
			command : 'fa_awesome',
			toolbar : 'insert',
			icon : this.path + 'icons/fa_awesome.png',
		});
		CKEDITOR.dialog.add('ckeditorFaDialog', this.path + 'dialogs/fa_awesome.js?v=9.2.0');
		CKEDITOR.document.appendStyleSheet(this.path + 'css/fa_awesome.css?v=9.2.0');

		editor.addContentsCss(nv_ckeditor_cdnfontawesome);
	}
}); 