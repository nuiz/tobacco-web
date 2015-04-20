(function () {
	// create button plugin
	tinymce.create("tinymce.plugins.mpcWizard", {
		init: function ( ed, url ) {
			ed.addCommand("shortcodesWindow", function(at, params) { // shortcodesWindow = mpcPopup
				// speficy type and width of the window
				var win_type = params.identifier;
				var win_width = 850;

				// open window for a specific type of shortcode
				tb_show("Insert Shortcode", url + "/window-content.php?type=" + win_type + "&width=" + win_width);
			});

			if (tinymce.majorVersion >= 4) {
				ed.addButton( 'shortcodesButton', {
					title: 'Insert Flipbook',
					image: "../wp-content/plugins/responsive-flipbook/tinymce/images/add.png",
					onclick: function() {
						tinymce.activeEditor.execCommand("shortcodesWindow", false, {
							title: 'Flip Book',
							identifier: 'fb'
						});
					}
				});
			}
		},
		createControl: function(button, e) {
			if(button == "shortcodesButton") {
				var th = this;

				// create and add the button
				button = e.createMenuButton("shortcodesButton", {
					title: "Insert Shortcode",
					image: "../wp-content/plugins/responsive-flipbook/tinymce/images/add.png",
					icons: false,
					onclick: function () {
						tinymce.activeEditor.execCommand("shortcodesWindow", false, {
							title: 'Flip Book',
							identifier: 'fb'
						});
					}
				});

				return button;
			}
			return null;
		},
		addImmediate: function(obj, title, src) {
			obj.add({
				title: title,
				onclick: function() {
					tinyMCE.activeEditor.execCommand("mceInsertContent", false, src)
				}
			})
		},
		getInfo: function() {
			return {
				longname: 'MPC Shortcode Wizard',
				author: 'MassivePixelCreation',
				authorurl: 'http://themeforest.net/user/mpc/',
				infourl: 'http://wiki.moxiecode.com/',
				version: "1.3.3"
			}
		}
	});

	// finally add mpcWizard plugin :)
	tinymce.PluginManager.add("mpcWizard", tinymce.plugins.mpcWizard);
})();