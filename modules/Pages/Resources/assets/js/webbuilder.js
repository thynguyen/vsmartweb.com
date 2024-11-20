$(document).ready(function() 
{
	$(".component-properties-tab").show();
	$("#filemanager").hide();
   	Vvveb.Builder.init(linktemplates, function() {});
	Vvveb.Gui.init();
	Vvveb.FileManager.init();
	Vvveb.Sections.init();
});