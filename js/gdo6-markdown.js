"use strict";

$(function() {
	$('.wysiwyg').each(function(){
		const id = this.id;
		console.log('Apply markdown editor to #' + id);
		editormd(id, {
			name: id + "-md-editor",
			classPrefix: id + '-mde',
			path: GDO_WEB_ROOT + 'GDO/Markdown/bower_components/editor.md/lib/',
			placeholder: '',
			autoFocus: false,
		});
	}); 
});
