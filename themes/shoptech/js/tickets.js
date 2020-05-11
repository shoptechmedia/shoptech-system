$(function(){

	function tinySetup(config) {
		if (typeof tinyMCE === 'undefined') {
			setTimeout(function () {
				tinySetup(config);
			}, 100);

			return;
		}

		if (!config) {
			config = {};
		}

		if (typeof config.editor_selector !== 'undefined') {
			config.selector = '.' + config.editor_selector;
		}

		window.default_config = {
			selector: ".rte",
			plugins: "colorpicker link image paste pagebreak table contextmenu filemanager table code media autoresize textcolor anchor directionality",
			browser_spellcheck: true,
			toolbar1: "code,|,bold,italic,underline,strikethrough,|,alignleft,aligncenter,alignright,alignfull,rtl,ltr,formatselect,|,blockquote,colorpicker,pasteword,|,bullist,numlist,|,outdent,indent,|,link,unlink,|,anchor,|,media,image",
			toolbar2: "",
			external_filemanager_path: ad + "/filemanager/",
			filemanager_title: "File manager",
			external_plugins: { "filemanager": ad + "/filemanager/plugin.min.js" },
			language: iso,
			skin: "prestashop",
			statusbar: false,
			relative_urls: false,
			convert_urls: false,
			entity_encoding: "raw",
			extended_valid_elements: "em[class|name|id]",
			valid_children: "+*[*]",
			valid_elements: "*[*]",

			menu: {
				edit: { title: 'Edit', items: 'undo redo | cut copy paste | selectall' },
				insert: { title: 'Insert', items: 'media image link | pagebreak' },
				view: { title: 'View', items: 'visualaid' },

				format: {
					title: 'Format',
					items: 'bold italic underline strikethrough superscript subscript | formats | removeformat'
				},

				table: { title: 'Table', items: 'inserttable tableprops deletetable | cell row column' },
				tools: { title: 'Tools', items: 'code' }
			}
		};

		$.each(window.default_config, function (index, el) {
			if (typeof config[index] === 'undefined') {
				config[index] = el;
			}
		});

		tinyMCE.init(config);
	}

	tinySetup({
		editor_selector :"autoload_rte",

		setup : function(ed) {
			ed.on('keydown', function(ed, e) {
				tinyMCE.triggerSave();
				textarea = $('#'+tinymce.activeEditor.id);
				var max = textarea.parent('div').find('span.counter').data('max');
				if (max != 'none')
				{
					count = tinyMCE.activeEditor.getBody().textContent.length;
					rest = max - count;
					if (rest < 0)
						textarea.parent('div').find('span.counter').html('<span style="color:red;">Maximum '+ max +' characters : '+rest+'</span>');
					else
						textarea.parent('div').find('span.counter').html(' ');
				}
			});
		}
	});
});