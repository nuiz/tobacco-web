// create new scope

( function () {

	/*-----------------------------------------------------------------------------------*/
	/*	jQuery
	/*-----------------------------------------------------------------------------------*/

	jQuery(document).ready(function($) {

		/*-----------------------------------------------------------------------------------*/
		/*	Responsive Flip Book scripts & Massive Panel logic
		/*-----------------------------------------------------------------------------------*/

		/* Hide all of the Massive Panel content */
		$('.group').hide();
		$('.section-group').hide();
		$('.tab-group').hide();

		var curtain = $('<div id="curtain"><div class="curtain_loader"></div></div>');
		$('#bg-content').append(curtain);

		var activetab		 = '';
		var activesection	 = '';

		/* Buttons Icons Hover */
		$('.rfbwp-icon').hover(function() {
			$(this).stop(true, true).animate({ opacity: 0.8 } , 200);
		}, function() {
			$(this).animate({ opacity: 1 } , 200);
		});

		// Update Warning
		$('#confirm_update').on('click', function(e) {
			$('#update_warning').slideUp(function() {
				$('#update_warning').remove();
			});

			$.post(ajaxurl, {action: 'disable_warning'});

			e.preventDefault();
		})

		// edit page
		$('.wrap').on('click', 'table.pages-table a.edit-page', function(e) {
			var $this = $(this);

			if($this.parents('tr.display').next().next().hasClass('page-set') && $this.parents('tr.display').next().next().css('display') != 'none') {
				$this.parents('tr.display').next().next().slideUp('slow', function(){
					$(this).remove();
					check_pages_index($this.parents('table.pages-table'));
				})
			}

			if($this.parent().parent().next().css('display') == 'none')
				$this.parent().parent().next().slideDown();
			else
				$this.parent().parent().next().slideUp();

			$this.parents('tr.display').next().find('a.rfbwp-page-save span.desc').text('Save Changes');
			$this.parents('tr.display').next().find('a.rfbwp-page-save').attr('href', '#Save Changes');

			e.preventDefault();
		});

		// delete page
		$('.wrap').on('click', 'table.pages-table a.delete-page', function() {
			var $this = $(this),
				activeBook = $this.parents('div.pages').attr('id'),
				activePage = $this.parents('tr.display').attr('id'),
				parent = $this.parents('div.pages'),
				delay_interval;

			curtain.stop(true).fadeIn(200);
			$this.parents('tr.display').slideUp('slow', function(){
				var data = $this.parents('tr.display').next('tr.page-set').find('input, select, textarea').serializeArray();

				if($this.parents('tr.display').next().hasClass('page-set'))
					$this.parents('tr.display').next().remove();

				$this.parents('tr.display').remove();

				page_id = get_index(activePage);
				id_active = get_index(activeBook);

				$.post(ajaxurl, {
					action: 'save_settings',
					data: data,
					value: 'Delete Page',
					activeID: id_active,
					pageID: page_id,
					curPageID: page_id,
					updating: 'delete_page'
				}, function(response) {
					if(response.indexOf('mpc_data_size_exceeded') != -1) {
						display_alert('red', 'We are sorry but your changes weren\'t saved. Please increase "max_input_vars" value in your "php.ini" file.', 15000);
					}

					curtain.stop(true).fadeOut(200);

					check_pages_index(parent);
					update_page_display(parent);
					if(parent.find('table.pages-table tr.page-set').length == 0) {
						$('li.button-sidebar.selected a').trigger('click');
						$('.books').hide();
						delay_interval = setInterval(function() {
							var id = parent.attr('id');
							id = get_index(id);

							remove_active_breadcrumbs();
							$('.books tr:nth-child('+ (parseInt(id)+1) +')').find('a.view-pages').trigger('click');
							clearInterval(delay_interval);
						}, 150);
					}
				});
			});
		});

		// move page up and down
		$('.wrap').on('click', 'table.pages-table tr.display a.down-page, table.pages-table tr.display a.up-page', function() {
			var $this = $(this),
				parent = $this.parents('tr.display'),
				next = parent.next(),
				index,
				data,
				type,
				change;

			if($this.hasClass('up-page'))
				type = 'up';
			else
				type = 'down';

			if(type == 'up') {
				if(next.hasClass('page-set')) {
					index = parseInt(next.find('input#rfbwp_fb_page_index').attr('value'));
					if(parent.prev().find('select.rfbwp-page-type option:selected').text() == 'Double Page')
						index -= 2;
					else
						index -= 1;
				}
			} else if(type == 'down') {
				if(next.hasClass('page-set')) {
					index = parseInt(next.find('input#rfbwp_fb_page_index').attr('value'));
					if(next.next().next().find('select.rfbwp-page-type option:selected').text() == 'Double Page')
						index += 2;
					else
						index += 1;
				}
			}

			if(type == 'down') {
				if(next.next().hasClass('display')) {
					target = next.next().next();
				} else {
					target = 'error';
					display_alert('orange', 'Oops! It looks like this page is already at the bottom..', 3000);
					// Hmmm
					// We're sorry…
					// BUMMER
				}

				if(target != 'error') {
					parent.find('span.page-index').text(index);
					next.find('input#rfbwp_fb_page_index').attr('value', index);

					var i = parseInt(next.next().next().find('input#rfbwp_fb_page_index').attr('value'), 10);
					if(next.find('select.rfbwp-page-type option:selected').text() == 'Double Page')
						i -= 2;
					else
						i -= 1;
					next.next().next().find('input#rfbwp_fb_page_index').attr('value', i);

					parent.slideUp('fast', function() {
						target.after(next);
						target.after(parent);
						parent.slideDown();

						update_pages_order($(this).parents('div.pages'));
						update_page_display($(this).parents('div.pages'));
						next.find('a.rfbwp-page-save').attr('href', '#Save Changes');
						next.find('a.rfbwp-page-save').trigger('click', ['move_down']);
					});
				}

			} else if (type == 'up') {
				if(parent.prev().prev().hasClass('display')) {
					target = parent.prev().prev();
				} else {
					target = 'error';
					display_alert('orange', 'Oops! It looks like this page is already at the top..', 3000);
				}

				if(target != 'error') {
					parent.find('span.page-index').text(index);
					next.find('input#rfbwp_fb_page_index').attr('value', index);

					var i = parseInt(parent.prev().find('input#rfbwp_fb_page_index').attr('value'), 10);
					if(next.find('select.rfbwp-page-type option:selected').text() == 'Double Page')
						i += 2;
					else
						i += 1;
					parent.prev().find('input#rfbwp_fb_page_index').attr('value', i);

					parent.slideUp('fast', function() {
						target.before(parent);
						target.before(next);
						parent.slideDown();

						update_pages_order($(this).parents('div.pages'));
						update_page_display($(this).parents('div.pages'));
						next.find('a.rfbwp-page-save').attr('href', '#Save Changes');
						next.find('a.rfbwp-page-save').trigger('click', ['move_up']);
					});
				}
			}

		});

		/*
		*	This function is run after the page index has changed
		*	inside it's settings, it is not responsible for the
		*	Up & Down buttons.
		*/
		function index_update(parent) {
			var next = parent.next(),
				direction,
				indexDisplay,
				indexSettings = parseInt(next.find('input#rfbwp_fb_page_index').attr('value'));

			indexDisplay = parent.find('span.page-index').text();
			indexDisplay = indexDisplay.split('-');
			indexDisplay = parseInt(indexDisplay[0]);

			if(indexDisplay > indexSettings)
				direction = 'up';
			else
				direction = 'down';

			if(indexDisplay != indexSettings) {
				var target;

				parent.slideUp();
				next.remove();
				parent.parents('table.pages-table').find('tr.page-set').each(function() {
					var $this = $(this);

					if(direction == 'down') {
						if(indexSettings >= parseInt($this.find('input#rfbwp_fb_page_index').attr('value'))) {
							target = $this;
						}
					} else {
						if(indexSettings >= parseInt($this.find('input#rfbwp_fb_page_index').attr('value'))) {
							target = $this;
						}
					}
				});

				if(direction == 'down') {
					parent.find('span.page-index').text(indexSettings);
					parent.slideUp('fast', function(){
						target.after(next);
						target.after(parent);
						parent.slideDown();
						update_pages_order($(this).parents('div.pages'));
						update_page_display($(this).parents('div.pages'));
					});
				} else {
					parent.find('span.page-index').text(indexSettings);
					parent.slideUp('fast', function(){
						target.prev().before(parent);
						target.prev().before(next);
						parent.slideDown();
						update_pages_order($(this).parents('div.pages'));
						update_page_display($(this).parents('div.pages'));
					});
				}
			} else {
				update_pages_order($(this).parents('div.pages'));
				update_page_display($(this).parents('div.pages'));
			}
		}

		// add new book
		$('.wrap').on('click', 'a.add-book', function() {
			$.post(ajaxurl, {
				action: 'add_new_book'
			}, function(response) {
				var id = parseInt(response);
				$('a#mp-option-settings_' + id + '-tab').addClass('add');
				$('a#mp-option-settings_' + id + '-tab').click(); // call the settings tab
				remove_active_breadcrumbs();
				$('div.breadcrumbs span.breadcrumb-1 span.active').fadeIn();
				$('div.breadcrumbs span.breadcrumb-1').addClass('selected').blur();
				setup_footer('book-settings', id);
				$('div.bottom-nav').find('a.edit-button').attr('value', 'Save Settings');

			});
		});

		$('.wrap').on('click', 'div.pages a.add-page', function(e) {
			e.preventDefault();

			var $this = $(this),
				clone =	$this.parents('tr.display').next().clone(true);

			if($this.parents('tr.display').next().next().hasClass('page-set') && $this.parents('tr.display').next().next().css('display') != 'none') {
				$this.parents('tr.display').next().next().slideUp('slow', function(){
					$(this).remove();
					check_pages_index($this.parents('table.pages-table'));
				});
				return;
			}

			if($this.parents('tr.display').next().css('display') != 'none')
				$this.parents('tr.display').next().slideUp('slow');

			var i = 0;
			$this.parents('tr.display').next().after(clone);

			$this.parents('tr.display').next().next().find('select.rfbwp-page-type option').each(function() {

				if(i == 0)
					$(this).attr('selected', 'selected');
				else
					$(this).removeAttr('selected');

				i++;
			});

			i = 0;

			$this.parents('tr.display').next().next().find('div.screenshot img').each(function() {
				if(i == 2)
					i = 0;

				if(i == 0){
					$(this).css('display', 'block');
				} else {
					$(this).remove();
				}

				i++;
			});

			$this.parents('tr.display').next().next().slideDown('slow');

			$this.parents('tr.display').next().next().find('a.rfbwp-page-save span.desc').text('Save Page');
			$this.parents('tr.display').next().next().find('a.rfbwp-page-save').attr('href', '#Save Page');

			// change page index
			check_pages_index($this.parents('table.pages-table'));
			clear_page_form($this.parents('tr.display').next().next().attr('id'));
		});

		$('.wrap').on('click', 'img.rfbwp-first-book', function() {
			$(this).parent().find('a.add-book').trigger('click');
		})


		// add page, display the page add form
		$('.wrap').on('click', 'div.pages img.rfbwp-first-page', function() {
			var $this = $(this),
				page_count,
				page_form,
				book_id;

			curtain.stop(true).fadeIn(200);

			$('.page-settings').css( {'display' : 'block' } );
			$.post(ajaxurl, {
				action: 'page_form'
			}, function(response) {
				book_id = get_index($this.parents('div.pages').attr('id'));
				page_form = '<div class="rfbwp-add-page-form">';
				page_form += response;

				$.post(ajaxurl, {
				action: 'get_books_page_count',
				book_id: book_id
				}, function(response) {
					page_count = parseInt(response);
					$this.prev().find('#pset_' + page_count).css( { 'display': 'block' } );
					page_form = page_form.replace(/\[books]\[0]/g, "[books]["+book_id+"]");
					page_form = page_form.replace(/\[pages\]\[0\]/g, "[pages]["+page_count+"]");
					$this.prev().find('div#ps_' + page_count).append(page_form);
					$this.fadeOut();
					$this.prev().find('div#ps_' + page_count).find('div.rfbwp-add-page-form').find('input#rfbwp_fb_page_index').attr('value', '0');

					//update each of the fields
					$this.prev().find('div#ps_' + page_count).find('div.controls').children().each(function() {
						var $this = $(this),
							name,
							pages;

						if($this.attr('name') != undefined && $this.attr('name') != '') {
							name = $this.attr('name');
							name = name.split('[books][');
							pages = name[1].split('[pages]')
							name = name[0] + '[books][' + book_id + '][pages]' + pages[1];

							$this.attr('name', name);
						}
					});

					$this.prev().find('div#ps_' + page_count).find('div.rfbwp-add-page-form').slideDown();

					curtain.stop(true).fadeOut(200);
				});
			});
		});

		// save settings
		$('form#options-form').submit(function() { return false });

		$('.wrap').on('click', 'form#options-form input.save-button, form#options-form a.edit-button, a.rfbwp-page-save', function(e, move_dir) {
			var $this = $(this),
				data,
				id,
				delay_interval,
				href,
				val,
				activeBook,
				id_active;

			curtain.stop(true).fadeIn(200);

			if($this.parents('div.page-settings').attr('id') != undefined) {
				id = $this.parents('div.page-settings').attr('id');
				id = get_index(id);
			}

			href = $this.attr('href').toString();
			href = href.split('#');
			href = href[1];

			val = href;

			if($this.parents('div.pages').attr('id') != undefined) {
				activeBook = $this.parents('div.pages').attr('id');
			} else {
				$this.parents('form').find('div.settings').each(function(){
					if($(this).css('display') == 'block')
						activeBook = $(this).attr('id');
				});
			}

			id_active = get_index(activeBook);

			var updating = '',
				have_display = $this.parents('.page-set').siblings('#page-display_' + id).length != 0;

			if(move_dir != undefined) {
				updating = 'move_page';
			} else if(id == undefined) {
				updating = 'book';
			} else if(id == 0) {
				updating = 'first_page';
			} else if(id != undefined && have_display) {
				updating = 'edit_page';
			} else {
				updating = 'new_page';
			}

			if($this.hasClass('rfbwp-page-save') && id != '0') { // save, edit and add page != first
				$this.parents('tr.page-set').slideUp('down', function() {
					sort_page_index($(this).attr('id'));

					if(href == "Save Changes") {
						index_update($this.parents('tr.page-set').prev());
						update_page_display($this.parents('div.pages'));
					} else {
						update_page_display($this.parents('div.pages'));
						update_pages_order($this.parents('div.pages'));
						update_page_display($this.parents('div.pages'));
					}

					data = $this.parents('tr.page-set').find('input, select, textarea').serializeArray();

					ajax_request();
				});
			} else {
				if(id == '0') { // save, edit and add first page
					$this.parents('tr.page-set').slideUp('down', function() {
						if(href == "Save Changes") {
							index_update($this.parents('tr.page-set').prev());
							update_page_display($this.parents('div.pages'));
						} else {
							update_page_display($this.parents('div.pages'));
						}

						val = 'Edit Settings';

						data = $this.parents('tr.page-set').find('input, select, textarea').serializeArray();

						ajax_request();
					});
				} else { // save book and add new book
					val = $this.val();

					if(val == '' && $this.hasClass('edit-button') || val == undefined && $this.hasClass('edit-button')) {
						val = "Edit Settings";
					}

					data = $('#mp-option-settings_' + id_active).find('input, select, textarea').serializeArray();

					ajax_request();
				}
			}

			function ajax_request() {
				$.post(ajaxurl, {
					action: 'save_settings',
					data: data,
					activeID: id_active,
					curPageID: id,
					updating: updating,
					value: val,
					moveDir: move_dir
				}, function(response) {
					if(response.indexOf('mpc_data_size_exceeded') != -1) {
						display_alert('red', 'We are sorry but your changes weren\'t saved. Please increase "max_input_vars" value in your "php.ini" file.', 15000);
					}

					curtain.stop(true).fadeOut(200);

					if(updating == 'book') {
						$('div.group').each(function() {
							var $this = $(this),
							id,
							delay_interval;
							if($this.css('display') == 'block' && $this.hasClass('settings')) {
								id = get_index($this.attr('id'));
								// mp-option-books
								$('li.button-sidebar.selected a').trigger('click', id);
								$('.books').stop(true).hide();
								display_alert('green', 'Book settings saved successfully.', 3000);

								$this.fadeOut('slow');

								return false;
							}
						});
					}
				});
			}

			return false;
		});

		$('.wrap').on('rfbwp.firstTabReady', function(e, id) {
			$('.books tr:nth-child('+ (parseInt(id) + 1) +')').find('a.view-pages').trigger('click');
			curtain.stop(true).fadeOut(200);
		});

		// delete book
		$('.wrap').on('click', 'table.books a.delete-book', function(e) {
			var form = $('form#options-form');
			var data = form.serializeArray();
			var $this = $(this),
				parent = $this.parents('table.books'),
				id = $this.attr('href').split('#');

				id = id[1];

			curtain.stop(true).fadeIn(200);
			$.post(ajaxurl, {
				action: 'delete_book',
				id: id,
				data: data
			}, function(response) {
				if(response.indexOf('mpc_data_size_exceeded') != -1) {
					display_alert('red', 'We are sorry but your changes weren\'t saved. Please increase "max_input_vars" value in your "php.ini" file.', 15000);
				}

				curtain.stop(true).fadeOut(200);
				$this.parent().parent().slideUp(300, function() {
					$this.parent().parent().remove();
					parent.parents('form').find('div#mp-option-pages_' + id).remove();
					parent.parents('form').find('div#mp-option-settings_' + id).remove();
				});
			});
		});

		// update books table
		$('.wrap').on('click', 'div#bg-content div#sidebar ul > li:first-child', function(e, id) {
			var respond1 = false,
				respond2 = false,
				respond3 = false;

			$('div.field-books').css('min-height', $('div.field-books').height());
			$('div.field-books span').remove();
			$('div.field-books table.books').remove();
			$('div.field-books a.add-book').remove();

			$('div#top-nav ul#mp-section-flipbooks-tab li').each(function(){
				var $this = $(this);
				if($this.find('a').hasClass('settings') || $this.find('a').hasClass('pages'))
					$this.remove();
			});

			$('form#options-form div.group').each(function(){
				var $this = $(this);
				if($this.hasClass('settings') || $this.hasClass('pages'))
					$this.remove();
			});

			$.post(ajaxurl, {
				action: 'rfbwp_refresh_books'
			}, function(response) {
				$('div.field-books div.controls').children().remove();
				$('div.field-books div.controls').append(response);
				respond1 = true;
				if(id != undefined && id > -1 && respond1 && respond2 && respond3)
					$('.wrap').trigger('rfbwp.firstTabReady', id);
			});

			$.post(ajaxurl, {
				action: 'rfbwp_refresh_tabs'
			}, function(response) {
				$('div#top-nav ul#mp-section-flipbooks-tab').append(response);
				respond2 = true;
				if(id != undefined && id > -1 && respond1 && respond2 && respond3)
					$('.wrap').trigger('rfbwp.firstTabReady', id);
			});

			$.post(ajaxurl, {
				action: 'rfbwp_refresh_tabs_content'
			}, function(response) {
				curtain.stop(true).fadeOut(200);
				$('form#options-form div.group.books').after(response);

				$('form#options-form div.group').each(function(){
				var $this = $(this);
				if($this.hasClass('settings') || $this.hasClass('pages'))
					$this.hide();
				});
				$('#mp-option-books').trigger('rfbwp.ajaxReady');
				respond3 = true;
				if(id != undefined && id > -1 && respond1 && respond2 && respond3)
					$('.wrap').trigger('rfbwp.firstTabReady', id);
			});

		});

		/* Pages buttons hovers */
		$('.wrap').on('mouseenter', 'table.pages-table a.edit-page, table.pages-table a.delete-page, table.pages-table a.up-page, table.pages-table a.down-page, a.book-settings, a.view-pages, a.delete-book', function() {
			var $this = $(this);

			$this.find('span.normal').stop().animate( { opacity: 0 }, 300);
			$this.find('span.hover').stop().animate( { opacity: 1 }, 200);
		}).on('mouseleave', 'table.pages-table a.edit-page, table.pages-table a.delete-page, table.pages-table a.up-page, table.pages-table a.down-page, a.book-settings, a.view-pages, a.delete-book', function() {
			var $this = $(this);

			$this.find('span.normal').stop().animate( { opacity: 1 }, 200);
			$this.find('span.hover').stop().animate( { opacity: 0 }, 300);
		});

		/* grey button hovers */
		$('.wrap').on('mouseenter', 'a.mp-grey-button, a.mp-orange-button', function() {
			var $this = $(this);

			$this.find('span.left').stop().animate( { opacity: 0 }, 400);
			$this.find('span.right').stop().animate( { opacity: 0 }, 400);
			$this.find('span.left-hover').stop().animate( { opacity: 1 }, 300);
			$this.find('span.right-hover').stop().animate( { opacity: 1 }, 300);
		}).on('mouseleave', 'a.mp-grey-button, a.mp-orange-button', function() {
			var $this = $(this);

			$this.find('span.left').stop().animate( { opacity: 1 }, 300);
			$this.find('span.right').stop().animate( { opacity: 1 }, 300);
			$this.find('span.left-hover').stop().animate( { opacity: 0 }, 400);
			$this.find('span.right-hover').stop().animate( { opacity: 0 }, 400);
		});

		/* Breadcrumb hide */
		$('span.breadcrumb').each(function(){
			$(this).find('span.active').hide();
		});

		$('.hide-checkbox').each(function() {
			var id = $(this).attr('id');
			var idAr = id.split('_checkbox');

			if($(this).attr('checked') == 'checked'){
				$('.'+idAr[0]+'_wrap').show();
			} else {
				$('.'+idAr[0]+'_wrap').hide();
			}
		})

		$('.hide-checkbox').change(function () {
			var id = $(this).attr('id');
			var idAr = id.split('_checkbox');

			if($(this).attr('checked') == 'checked'){
				$('.'+idAr[0]+'_wrap').slideDown();
			} else {
				$('.'+idAr[0]+'_wrap').slideUp();
			}

			if($(this).parent().find('div').hasClass('mp-related-object')){
				var related = $(this).parent().find('div.mp-related-object').text();
				$('#' + related + '_checkbox').attr('checked', false);
				$('.' + related + '_wrap').slideUp();
			}
		});

		$('textarea.displayall').each(function () {
			$(this).val($(this).val());
		});

		$('textarea.displayall-upload').each(function () {
			var taText = $(this).val();
			var urlArray = taText.split('http');
			taText = '';
			$.each(urlArray, function (i, val) {
				if(i != 0)
					taText += "http" + val;
			});
			$(this).val(taText);
		});

		/*-----------------------------------------------------------------------------------*/
		/*	Massive Panel logic
		/*-----------------------------------------------------------------------------------*/

		/* CLICK Handler for:
		*	# button tabs
		*	# book settings button displayed in the books panel
		*	# view pages button displayed inside the books panel
		*/

		$('.wrap').on('click', '.button-tab a, a.book-settings, a.view-pages', function(e) {
			var $this = $(this);
			$('.button-tab a').removeClass('selected');
			$this.addClass('selected').blur();
			$('.button-tab a').trigger('mouseleave');

			var clicked_group = $this.attr('href');

			if($this.hasClass('book-settings'))
				setup_footer('book-settings', get_index($this.attr('href')));
			else if($this.hasClass('books'))
				setup_footer('books');
			else if($this.hasClass('help'))
				setup_footer('help');
			else if($this.hasClass('add'))
				setup_footer('add');
			else if($this.hasClass('view-pages')) {
				setup_footer('view-pages');
			}

			$('.group').stop(true).hide();

			var target;
			$(clicked_group).find('div.page-settings').each(function() {
				var $this = $(this),
					id = $this.attr('id');

				id = get_index(id);
				target = clicked_group + ' tr#pset_' + id + ' td';
				$(target).append($this);
				$(clicked_group + ' tr#pset_' + id).css( { display : 'none' } );
			});

			id_active = get_index(clicked_group);

			if(id_active == undefined) {
				$('#rfbwp_tools').attr('data-book-id', '').stop(true, true).slideUp();
				$('#rfbwp_import_id').val('');
			} else {
				$('#rfbwp_tools').attr('data-book-id', id_active).stop(true, true).slideDown();
				$('#rfbwp_import_id').val(id_active);
			}

			if(id_active != undefined) {
				$.post(ajaxurl, {
					action: 'set_active_book',
					activeID: id_active,
				}, function() {
					$(clicked_group).trigger('rfbwp.ajaxReady');
				});
			}

			if($this.hasClass('view-pages')) {
				var button = $(clicked_group).find('img.rfbwp-first-page').clone(true);
				$(clicked_group).find('img.rfbwp-first-page').remove();
				$(clicked_group).find('table.pages-table').after(button);
				$(clicked_group).find('img.rfbwp-first-page').css( { display: 'inline-block' });
			}

			if($this.hasClass('book-settings')) {
				initColorPicker();
			}

			$(clicked_group).fadeIn();


			e.preventDefault();
		});

		$('.group').on('rfbwp.ajaxReady', rfbwp_ajax_ready);

		function rfbwp_ajax_ready(e) {
			$(this).fadeIn(300);
			curtain.stop(true).fadeOut(200, function() {
				rfbwp_check_books();
			});
		}

		/* Click Section handler for the main sidebar (on the right) */
		$('.wrap').on('click', '.button-sidebar a', function(e, id) {
			var $this = $(this);
			if(!$this.parent().hasClass('selected')) {
				$('.button-sidebar a').parent().find('span.active').fadeOut('fast');
				$('.button-sidebar a').parent().removeClass('selected');
				$this.parent().addClass('selected').blur();
				$this.parent().find('span.active').fadeIn('fast');
				$('.button-sidebar a').trigger('mouseleave')
				$('div.breadcrumbs').fadeOut();
			}

			var clicked_section = $(this).attr('href') + '-tab';

			$('.tab-group').fadeOut('slow');

			var firstTab = $(this).attr('href')  + '-tab' + ' .button-tab:first a';
			$(firstTab).trigger('mouseenter');
			$(firstTab).trigger('click');

			e.preventDefault();
		});

		/* hover navigation tab */
		$('.button-tab a').hover(
			function() {
				$(this).find('span.tab-bg-left').removeClass('tab-bg-left').addClass('tab-bg-left-hover');
				$(this).find('span.tab-bg-center').removeClass('tab-bg-center').addClass('tab-bg-center-hover');
				$(this).find('span.tab-bg-right').removeClass('tab-bg-right').addClass('tab-bg-right-hover');
				$(this).find('span.tab-text').removeClass('tab-text').addClass('tab-text-hover');

		}, function() {
			if(!$(this).hasClass('selected')){
				$(this).find('span.tab-bg-left-hover').removeClass('tab-bg-left-hover').addClass('tab-bg-left');
				$(this).find('span.tab-bg-center-hover').removeClass('tab-bg-center-hover').addClass('tab-bg-center');
				$(this).find('span.tab-bg-right-hover').removeClass('tab-bg-right-hover').addClass('tab-bg-right');
				$(this).find('span.tab-text-hover').removeClass('tab-text-hover').addClass('tab-text');
			}
		});

		/* Breadcrumb hover */
		$('.wrap').on('mouseenter', 'span.breadcrumb', function() {
			var $this = $(this);

			if(!$this.hasClass('selected')){
				$this.find('span.active').fadeIn();
			}
		}).on('mouseleave', 'span.breadcrumb', function() {
			var $this = $(this);

			if(!$this.hasClass('selected')) {
				$this.find('span.active').stop(true,true).fadeOut();
			}
		}).on('click', 'span.breadcrumb', function() {
			var $this = $(this),
				parentGroup = $this.parents('div.group'),
				targetBC,
				groupID;

			if($this.hasClass('selected'))
				if(!$this.hasClass('image-batch'))
					return;
				else
					$this.removeClass('image-batch');

			$('span.breadcrumb').each(function(){
				$(this).removeClass('selected');
				$(this).find('span.active').hide();
			});

			groupID = get_index(parentGroup.attr('id'));
			$('.group').hide();
			if($this.hasClass('breadcrumb-1')) {
				targetBC = '#mp-option-settings_' + groupID;
				setup_footer('book-settings');
				initColorPicker();
				$(targetBC).fadeIn();
			} else if($this.hasClass('breadcrumb-2')) {
				targetBC = '#mp-option-pages_' + groupID;
				setup_footer('view-pages');

				var id = $this.parents('.group').attr('id');
				id = get_index(id);
				$('li.button-sidebar.selected a').trigger('click', id);
				$('.books').hide();
				remove_active_breadcrumbs();

			} else if($this.hasClass('breadcrumb-3')) {
				setup_footer('shortcode');
				targetBC = 'div.shortcode';
				$(targetBC).attr('id', 'shortcode_' + groupID);
				$(targetBC).find('span.breadcrumb-3 span.active').show();
				$(targetBC).find('span.breadcrumb-3').addClass('selected').blur();
				$(targetBC).fadeIn();
			}
		});

		/* hover navigation button */
		$('.button-sidebar a').hover(
			function() {
				var $this = $(this);
				$this.find('span.button-sidebar-bg').removeClass('button-sidebar-bg').addClass('button-sidebar-bg-hover');
				$this.find('span.empty').removeClass('empty').addClass('button-arrow');
				$this.find('label.name').addClass('on-hover');
				$this.find('label.sub-name').addClass('on-hover');
				$this.find('img.button-icon').stop(true, true).animate( { opacity: 0 }, 250);
				$this.find('img.button-icon-active').stop(true, true).fadeIn();
			}, function() {
				var $this = $(this);
				if(!$this.hasClass('selected')) {
					$this.find('span.button-sidebar-bg-hover').removeClass('button-sidebar-bg-hover').addClass('button-sidebar-bg');
					$this.find('span.button-arrow').removeClass('button-arrow').addClass('empty');
					$this.find('label.name').removeClass('on-hover');
					$this.find('label.sub-name').removeClass('on-hover');
					$this.find('img.button-icon').animate( { opacity: 1 }, 250);
					$this.find('img.button-icon-active').fadeOut();
			}
		});

		/*  Color Picker */
		function initColorPicker() {

			$('.colorSelector').each(function(){
				var self = this; //cache a copy of the this variable for use inside nested function
				var initialColor = $(self).prev('input').attr('value');

				$(this).ColorPicker({
					color: initialColor,
					onShow: function (colpkr) {
						$(colpkr).fadeIn(500);
						return false;
					},
					onHide: function (colpkr) {
						$(colpkr).fadeOut(500);
						return false;
					},
					onChange: function (hsb, hex, rgb) {
						$(self).children('div').css('backgroundColor', '#' + hex);
						$(self).prev('input').attr('value','#' + hex.toUpperCase());
					}
				});
			});
		}

		/* open tab */
		$('.button-sidebar:first a').trigger('mouseenter');
		$('.button-sidebar:first a').trigger('click');

		$('.wrap').on('click', 'div.mp-toggle-header', function(e) {
			var $this = $(this);

			if($this.hasClass('open'))
				$this.removeClass('open')
			else
				$this.addClass('open');

			$this.next('div.mp-toggle-content').toggle('slow');
		});

		/* hover social icon */
		$('li.social a').hover(
			function() {
				var $this = $(this).parent();

				$this.find('span').stop().animate({ opacity: 1 }, 'fast');
				$this.find('img.hover').stop().animate({ opacity: 1 }, 'fast');
				$this.find('img.normal').stop().animate({ opacity: 0 }, 'fast');
			}, function() {
				var $this = $(this).parent();

				$this.find('span').stop().animate({ opacity: 0 }, 'fast');
				$this.find('img.hover').stop().animate({ opacity: 0 }, 'fast');
				$this.find('img.normal').stop().animate({ opacity: 1 }, 'fast');
		});

		/* hover help */
		$('.wrap').on('mouseenter', 'div.help-icon', function() {
			var $this = $(this);
			$this.find('span.mp-tooltip').css({ 'margin-left': -$this.find('span.mp-tooltip').width() + 10});

			if($this.find('span.mp-tooltip').hasClass('bottom'))
				$this.find('span.mp-tooltip').css({ 'margin-top': 30 });
			else
				$this.find('span.mp-tooltip').css({ 'margin-top': -20-$this.find('span.mp-tooltip').height() });

			$this.find('span').css({ display: 'block' });
			$this.find('span').stop().animate({ opacity: 1 }, 'fast', function(){
			});
		}).on('mouseleave', 'div.help-icon', function(e) {
			$(this).find('span').stop().animate({ opacity: 0 }, 'fast', function(){
				$(this).css({ display: 'none' });
			});
		});

		$('.wrap').on('click', 'a.rfbwp-page-columns-sc', function() {
			var $this = $(this);

			$this.parents('div.field').next().find('textarea').val($this.parents('div.field').next().find('textarea').val()+'[rfbwp_columns][rfbwp_column class=""]Left page content[/rfbwp_column][rfbwp_column class=""]Right page content[/rfbwp_column][/rfbwp_columns]')
		});

		$('.wrap').on('click', 'a.rfbwp-page-video-sc', function() {
			var $this = $(this);

			$this.parents('div.field').next().next().find('textarea').text($this.parents('div.field').next().next().find('textarea').text()+'[rfbwp_video src_mp4="here_paste_mp4_video_source" src_ogv="here_paste_ogv_video_source_(optional)" video_poster="here_paste_video_poster" width="video_width" height="video_height" top_margin="top_video_margin" left_margin="left_video_margin"]');
		});

		/*-----------------------------------------------------------------------------------*/
		/*	Tools
		/*-----------------------------------------------------------------------------------*/

		var $normal_ids = $('#rfbwp_flipbook_batch_ids'),
			$normal_wrap = $('#rfbwp_flipbook_batch_images_wrap'),
			$normal_select = $('#rfbwp_flipbook_batch_select'),
			$large_ids = $('#rfbwp_flipbook_batch_ids'),
			$large_wrap = $('#rfbwp_flipbook_batch_images_wrap_large'),
			$large_select = $('#rfbwp_flipbook_batch_select_large'),
			$import_btn = $('#rfbwp_flipbook_batch_import');

		// Batch Images Import
		var custom_media = wp.media;
		custom_media.view.Settings.Gallery = custom_media.view.Settings.Gallery.extend({
			render: function() {
				return this;
			}
		} );

		$('#rfbwp_flipbook_batch_import').on('click', function(e) {
			var normal = $('#rfbwp_flipbook_batch_ids').val(),
				large = $('#rfbwp_flipbook_batch_ids_large').val(),
				normal_num = (normal.match(/,/g)||[]).length + 1,
				large_num = (large.match(/,/g)||[]).length + 1,
				can_upload = false;

			if(normal != '' && large != '') {
				if(normal_num != large_num) {
					display_alert('red', 'Number of normal and large images don\'t match.', 5000);
				} else {
					can_upload = true;
				}
			} else if(normal == '' && large != '') {
				can_upload = true;
			} else if(normal != '' && large == '') {
				can_upload = true;
			} else {
				display_alert('red', 'No images selected to upload.', 5000);
			}

			if(can_upload) {
				$.post(ajaxurl, {
					action: 'batch_import',
					book_id: $('#rfbwp_tools').attr('data-book-id'),
					images_ids: $('#rfbwp_flipbook_batch_ids').val(),
					images_ids_large: $('#rfbwp_flipbook_batch_ids_large').val(),
					double_page: $('#rfbwp_flipbook_batch_double').is(':checked')
				}, function(response) {
					$('#mp-option-pages_' + $('#rfbwp_tools').attr('data-book-id')).find('.breadcrumbs .breadcrumb-2').addClass('image-batch').click();

					$('#rfbwp_flipbook_batch_ids').val('');
					$('#rfbwp_flipbook_batch_images_wrap').html('');
					$('#rfbwp_flipbook_batch_ids_large').val('');
					$('#rfbwp_flipbook_batch_images_wrap_large').html('');
					if(response == 'error-book-id') {
						display_alert('red', 'Wrong book ID.', 5000);
					} else if(response == 'error-page-id') {
						display_alert('red', 'Wrong page ID.', 5000);
					}
				});
			}

			e.preventDefault();
		})

		$('#rfbwp_flipbook_batch_select, #rfbwp_flipbook_batch_select_large').on('click', function(e) {
			var large_mod = '';
			if($(this).is('#rfbwp_flipbook_batch_select_large'))
				large_mod = '_large';

			var ids = $('#rfbwp_flipbook_batch_ids' + large_mod).val();
			if(ids == '') ids = ' ';

			var $batch = wp.media.gallery.edit('[gallery ids="' + ids + '"]');
			$batch.on('update', function(obj) {
				var images = obj.models,
					list = [],
					markup = '';

				for(var i = 0; i < images.length; i++) {
					list[i] = images[i].id;
					markup += '<img width="50px" height="50px" src="' + images[i].attributes.sizes.thumbnail.url + '" class="rfbwp-batch-image" alt="Batch image ' + i + '">';
				}

				$('#rfbwp_flipbook_batch_ids' + large_mod).val(list.join(','));
				$('#rfbwp_flipbook_batch_images_wrap' + large_mod).html(markup);
			})

			e.preventDefault();
		})

		$('#rfbwp_flipbook_batch_clear, #rfbwp_flipbook_batch_clear_large').on('click', function(e) {
			var large_mod = '';
			if($(this).is('#rfbwp_flipbook_batch_clear_large'))
				large_mod = '_large';

			$('#rfbwp_flipbook_batch_ids' + large_mod).val('');
			$('#rfbwp_flipbook_batch_images_wrap' + large_mod).fadeOut(function() {
				$('#rfbwp_flipbook_batch_images_wrap' + large_mod).html('').show();
			})

			e.preventDefault();
		})

		// Toogle Header
		$('#rfbwp_tools_toggle_title').on('click', function(e) {
			var $this = $(this),
				$content = $('#rfbwp_tools_toggle_content');

			if($this.is('.option-open')) {
				$this.removeClass('option-open');
				$content.slideUp();
			} else {
				$this.addClass('option-open');
				$content.slideDown();
			}

			e.preventDefault();
		})

		// Preview
		var $preview = $('#rfbwp_page_preview')
			$preview_wrap = $('#rfbwp_page_preview_wrap'),
			$preview_close = $('#rfbwp_page_preview_close');

		$preview.on('click', function(e) {
			$preview.hide(500, function() {
				$preview_wrap.html('');
			});

			e.preventDefault();
		})

		$('#options-form').on('click', '.pages .thumb-preview .preview-page', function(e) {
			var $this = $(this),
				book_id = $this.attr('href').substr(1), // substract '#' from href
				page_id = $this.parents('.display').attr('id').substr(13); // substract 'page-display_' from ID

			$preview.hide(500, function() {
				$.post(ajaxurl, {
					action: 'preview_page',
					book_id: book_id,
					page_id: page_id
				}, function(response) {
					if(response == 'error-book-id') {
						display_alert('red', 'Wrong book ID.', 5000);
					} else if(response == 'error-page-id') {
						display_alert('red', 'Wrong page ID.', 5000);
					} else {
						$preview_wrap.html(response);
						$preview.show(500);
					}
				});
			});

			e.preventDefault();
		})

		// Import
		$('#rfbwp_import_back_url').val(location.href);

		$('#rfbwp_flipbook_import').on('click', function(e) {
			$('#rfbwp_import').click();

			e.preventDefault();
		})

		// Export
		$('#rfbwp_flipbook_export').on('click', function(e) {
			var urlAjaxExport = ajaxurl + "?action=export_flipbooks&book_id=" + $('#rfbwp_tools').attr('data-book-id');
			location.href = urlAjaxExport;

			e.preventDefault();
		})

		/*-----------------------------------------------------------------------------------*/
		/*	Helper Functions
		/*-----------------------------------------------------------------------------------*/

		/* Checks if books are correctly prepared (min 4 pages, first and last page as single) */
		function rfbwp_check_books() {
			var $books = $('#mp-option-books .books td');

			$books.each(function(index, book) {
				var message = 'Error: ';
				var separator = false;
				var count = 0;
				var $pages = $('#mp-option-pages_' + index + ' .pages-table tr:not(.page-set)');

				$pages.each(function(index, page) {
					if($(page).find('.page-type').html() == 'Single Page')
						count++;
					else
						count += 2;
				})

				if($pages.first().find('.page-type').html() != 'Single Page') {
					message += 'first page must by single';
					separator = true;
				}
				if($pages.last().find('.page-type').html() != 'Single Page') {
					if(separator) { message += ', '; separator = false; }
					message += 'last page must by single';
					separator = true;
				}
				if(count < 4) {
					if(separator) { message += ', '; separator = false; }
					message += 'book needs at least 4 pages';
					separator = true;
				}
				if(count % 2 != 0) {
					if(separator) { message += ', '; separator = false; }
					message += 'number of pages must be even';
				}

				message += '.';

				if(message != 'Error: .')
					$(book).find('.book-error .distinction').html(message);
			})
		}

		/* Helps setup footer display for each section */
		function setup_footer(type, bookID) {
			remove_active_breadcrumbs();

			$('div.bottom-nav input').css( { display: 'none' });
			$('div.bottom-nav a.edit-button').css( { display: 'none' });
			$('div.bottom-nav').hide();

			if(type == 'book-settings') { // book settings
				/* open first toggles */
				$('div.bottom-nav').find('a.edit-button').attr('value', 'Edit Settings').attr('href', '#' + bookID);

				$('div.group.settings').each(function(){
					$(this).find('div.mp-toggle-content:first').show();
					$(this).find('div.mp-toggle-header:first').addClass('open').blur();
				});

				$('a.edit-button').css( { display: 'inline-block' });
				$('div.breadcrumbs').fadeIn();
				$('div.breadcrumbs span.breadcrumb-1 span.active').fadeIn();
				$('div.breadcrumbs span.breadcrumb-1').addClass('selected').blur();
				$('div.bottom-nav').fadeIn();
			} else if (type == "books" || type == "help") { // book panel
				$('div.breadcrumbs').hide();
			} else if (type == "add") {
				$('div.breadcrumbs').fadeIn();
				$('div.bottom-nav').fadeIn();
			} else if(type == "view-pages") {
				$('div.breadcrumbs').fadeIn();
				$('div.breadcrumbs span.breadcrumb-2 span.active').fadeIn();
				$('div.breadcrumbs span.breadcrumb-2').addClass('selected').blur();
			} else if (type == "shortcode") {
				$('div.breadcrumbs').fadeIn();
			}
		}

		function sort_page_index(id) {
			appendID = get_index(id);
			appendID = appendID - 1;

			$('table.page-table tr#pset_' + appendID).after($('table.page-table tr#' + id));
		}

		function check_pages_index(parent) {
			var index = -1;
			var index_double = -1;

			parent.find('tr.page-set').each(function(){
				var $this = $(this),
					localID;

				index++;
				index_double++;
				if(get_index($this.attr('id')) != index.toString()) {
					$this.attr('id', 'pset_'+index.toString());
				}

				if($this.prev().hasClass('display') && get_index($this.prev().attr('id')) != index.toString()) {
					$this.prev().attr('id', 'page-display_'+index.toString());
				}

				// update the div.page-settings
				if($this.find('div.page-settings').attr('id') != undefined && get_index($this.find('div.page-settings').attr('id')) != index.toString()) {
					$this.find('div.page-settings').attr('id', 'ps_' + index.toString())
				}

				//update each of the fields
				$this.find('div.controls').children().each(function() {
					var $this = $(this),
						name;

					if($this.attr('name') != undefined && $this.attr('name') != '') {
						name = $this.attr('name');
						name = name.split('[pages]');
						name = name[0] + '[pages][' + index + '][' + $this.attr('id') + ']';

						$this.attr('name', name);
					}
				});

				$this.find('input#rfbwp_fb_page_index').attr('value', index_double);

				if($this.find('div#field-rfbwp_fb_page_type select').attr('value') == 'Double Page')
					index_double ++;
			});

		}

		var baseURL = $('div.mpc-logo').css('background-image');

		var browser = $.browser;

		if(browser.mozilla || browser.msie)
			baseURL = baseURL.split('url("');
		else
			baseURL = baseURL.split('url(');

		baseURL = baseURL[1];
		baseURL = baseURL.split('massive-panel')
		baseURL = baseURL[0] + 'massive-panel/';

		function update_page_display(parent){
			parent.find('tr.page-set').each(function() {
				var $this = $(this),
					pageType = $this.find('select.rfbwp-page-type option:selected').text(),
					pageIndex = $this.find('input#rfbwp_fb_page_index').attr('value'),
					pageImage = $this.find('input#rfbwp_fb_page_bg_image').attr('value');

				if(pageType == undefined || pageIndex == undefined)
					return;

				if($this.prev().hasClass('display')) {
					// we havve to update the table row

					// update page type
					$this.prev().find('span.page-type').text(pageType);

					// update page index
					if(pageType == 'Single Page')
						$this.prev().find('span.page-index').text(pageIndex);
					else
						$this.prev().find('span.page-index').html(pageIndex + ' - ' + (parseInt(pageIndex) + 1));

					// update page image
					if(pageImage != '')
						$this.prev().find('td.thumb-preview img').attr('src', pageImage);
					else
						$this.prev().find('td.thumb-preview img').attr('src', baseURL + 'images/default-thumb.png');


				} else {
					// we have to add the table row
					var book_id = get_index($this.parents('div.pages').attr('id'));
					var output = '';

					output += '<tr id="page-display_'+ $this.parent().find('tr.display').length + '" class="display"><td class="thumb-preview">';
					if(pageImage != '')
						output += '<img src="' + pageImage + '" alt=""/>';
					else
						output += '<img src="' + baseURL + 'images/default-thumb.png"/>';

					output += '<span class="page-type">' + pageType +'</span>';

					output += '<a class="add-page mp-grey-button"><span class="left"><span class="icon-add"></span><span class="desc">Add Page</span></span><span class="right"></span><span class="left-hover"><span class="icon-add"></span><span class="desc">Add Page</span></span><span class="right-hover"></span></a>';

					output += '<a class="edit-page" href="#' + book_id + '"><span class="normal"></span><span class="hover"></span></a>';
					output += '<a class="delete-page" href="#' + book_id + '"><span class="normal"></span><span class="hover"></span></a>';
					output += '<a class="preview-page" href="#' + book_id + '"><span class="normal"></span><span class="hover"></span></a>';
					output += '</td><td class="navigation">';

					output += '<a class="up-page"><span class="normal"></span><span class="hover"></span></a>';
					output += '<input type="checkbox" class="page-checkbox"/>';

					output += '<span class="desc">page</span>';
					if(pageType != 'Double Page')
						output += '<span class="page-index"><span class="index">' + pageIndex + '</span></span>';
					else
						output += '<span class="page-index"><span class="index">' + pageIndex + ' - ' + (parseInt(pageIndex) + 1) + '</span></span>';
					output += '<a class="down-page"><span class="normal"></span><span class="hover"></span></a>';
					output += '</td></tr>';

					$this.before(output);
					$this.prev().css({ display: 'none' });
					$this.prev().slideDown();
				}
			});
		}

		function clear_page_form(id){
			id = get_index(id);

			var parentID = $('table.pages-table tr#pset_' + id).prev().find('#rfbwp_fb_page_index').attr('value'),
				parentType = $('table.pages-table tr#pset_' + id).prev().find('select.rfbwp-page-type option:selected').attr('value');

			$('table.pages-table tr#pset_' + id).find('div.controls').children().each(function(){
				var $this = $(this);

				// set field valu to blank
				if($this.attr('name') != undefined && $this.attr('name') != '')
					$this.attr('value', '');

				// if image then set the image to default
				if($this.attr('id') == 'rfbwp_fb_page_bg_image_image' || $this.attr('id') == 'rfbwp_fb_page_bg_image_zoom_image') {
					$this.children().each(function() {
						var $this = $(this);
						if($this.css('display') == 'none')
							$this.css( { display : 'block' });
						else if($this.hasClass('mp-image-border')) {
							$this.remove();
						}
					});
				}

				// set default id
				if($this.attr('id') == 'rfbwp_fb_page_index') {
					if(parentType == 'Double Page')
						$this.attr('value', parseInt(parentID) + 2);
					else
						$this.attr('value', parseInt(parentID) + 1);
				}
			});
		}

		function update_pages_order(parent){
			parent.find('tr.display').each(function() {
				var $this = $(this),
					index = 0,
					appendAfter,
					temp = $this.next();

				index = parseInt(temp.find('input#rfbwp_fb_page_index').attr('value'));

				if(temp.hasClass('page-set')) {
					index = parseInt(temp.find('input#rfbwp_fb_page_index').attr('value'));

					appendAfter = check_order(index, $this);

					if(appendAfter != undefined) {
						appendAfter.next().after($this);

						if(temp.hasClass('page-set'))
							$this.after(temp);
					}
				}

				check_pages_index($this.parents('table.pages-table'));
			});

		}

		function check_order(index, row) {
			var after;

			if(index == '' || isNaN(index))
				index = 0;

			$('table.pages-table tr.display').each(function() {
				var $this = $(this),
					next = $this.next();

				if(index > parseInt(next.find('input#rfbwp_fb_page_index').attr('value'))) {
					after = $this;
				}

				if(index == next.find('input#rfbwp_fb_page_index').attr('value') && $this.attr('id') != row.attr('id')) {
					if(next.find('select.rfbwp-page-type option:selected').attr('value') == 'Single Page')
						index++;
					else if(next.find('select.rfbwp-page-type option:selected').attr('value') == 'Double Page')
						index += 2;

					row.next().find('input#rfbwp_fb_page_index').attr('value', index);

					after = $this;
				}

			});

			return after;
		}

		/* Add Alert */
		function display_alert(color, message, delay) {
			var wrap = $('div#bg-content'),
				delayInterval;

			// add alert
			wrap.append('<span class="rfbwp-alert ' + color + '">'+ message +'</span>');
			$('span.rfbwp-alert').hide();
			$('span.rfbwp-alert').css( { 'top': $(this).scrollTop() + 10 });

			$('span.rfbwp-alert').fadeIn('slow');

			delayInterval = setInterval(function() {
				$('span.rfbwp-alert').fadeOut('slow', function(){
					$(this).remove();
					clearInterval(delayInterval);
				});
			}, delay);
		}

		/* Add Alert */
		function display_confirmation(color, message, delay) {
			var wrap = $('div#bg-content'),
				delayInterval;

			// add alert
			wrap.append('<span class="rfbwp-alert ' + color + '">'+ message +'</span>');
			$('span.rfbwp-alert').hide();
			$('span.rfbwp-alert').css( { 'top': $(this).scrollTop() + 10 });

			$('span.rfbwp-alert').fadeIn('slow');

			delayInterval = setInterval(function() {
				$('span.rfbwp-alert').fadeOut('slow', function(){
					$(this).remove();
					clearInterval(delayInterval);
				});
			}, delay);
		}

		// fix after refresh
		function getSection() {
			var vars = window.location.href.slice(window.location.href.indexOf('#') + 1).split('&');
			return vars;
		}

		function get_index(id) {

			id = id.toString();
			id = id.split('_');
			id = id[1];

			return id;
		}

		function remove_active_breadcrumbs() {
			$('span.breadcrumb').each(function(){
				var $this = $(this);
				$this.removeClass('selected');
				$this.find('span.active').hide();
			});
		}

		function add_loader() {
			var wrap = $('div#bg-content');
			if($('div#bg-content').find('.rfbwp-loader').length < 1) {
				wrap.append('<span class="rfbwp-loader"></span>');
				$('span.rdbwp-loader').css( { 'top': $(this).scrollTop() + 10 });
				$('span.rdbwp-loader').fadeIn();
			}
		}

		function rfbwp_remove_loader() {
			$('div#bg-content').find('.rfbwp-loader').fadeOut(400, function() {
				$('div#bg-content').find('.rfbwp-loader').remove();
			});
		}

		$('.wrap').delay(1000).fadeIn(1000);
		/*--------------------------- END Helper Functions -------------------------------- */
	});
})();
