<?php

// Export Settings
add_action('wp_ajax_export_flipbooks', 'rfbwp_export_flipbooks');
function rfbwp_export_flipbooks() {
	$option_name = 'rfbwp_options';
	$options = get_option($option_name);

	if(isset($_GET['book_id']) && isset($options['books'][$_GET['book_id']])) {
		$book_id = $_GET['book_id'];

		if(is_multisite()) {
			$url = wp_upload_dir();
			$old_url = $url['baseurl'];
		} else {
			$old_url = content_url();
		}

		array_walk_recursive($options['books'][$book_id], 'replace_base_url', array($old_url, '__BASE_URL__'));

		$book_options = json_encode($options['books'][$book_id]);

		header('Content-Disposition: attachment; filename="rfbwp_options.rfs"');

		echo $book_options;
	}

	die();
}

function replace_base_url(&$item, $key, $urls) {
	$item = str_replace($urls[0], $urls[1], $item);
}

// Import Settings
add_action('wp_ajax_import_flipbooks', 'rfbwp_import_flipbooks');
function rfbwp_import_flipbooks() {
	try{
		$import_file_path = $_FILES["import_flipbooks_file"]["tmp_name"];

		if(file_exists($import_file_path) == false) {
			echo '<h3>' . __('Wrong file uploaded.', 'mpcth') . '</h3>';
		}
		else {
			$import_data = @file_get_contents($import_file_path);

			$import_array = json_decode($import_data, true);

			if(is_multisite()) {
				$url = wp_upload_dir();
				$new_url = $url['baseurl'];
			} else {
				$new_url = content_url();
			}

			array_walk_recursive($import_array, 'replace_base_url', array('__BASE_URL__', $new_url));

			if(empty($import_array))
				echo '<h3>' . __('Empty file content.', 'mpcth') . '</h3>';
			else {
				echo '<h3>' . __('Importing...', 'mpcth') . '</h3>';
				$book_id = $_POST['book_id'];
				$option_name = 'rfbwp_options';
				$options = get_option($option_name);

				if(isset($options['books'][$book_id])) {
					unregister_setting($option_name, $option_name, 'mp_validate_options');

					$book_name = $options['books'][$book_id]['rfbwp_fb_name'];

					$import_array['rfbwp_fb_name'] = $book_name;

					$options['books'][$book_id] = $import_array;

					update_option($option_name, $options);

					register_setting($option_name, $option_name, 'mp_validate_options');

					echo '<h4>' . __('All settings were imported.', 'mpcth') . '</h4>';
					echo '<script>location.href = "' . $_REQUEST['back_url'] . '"</script>';
				} else {
					echo __('Something went wrong. Please try again.', 'mpcth');
				}
			}

		}
	} catch(Exception $error) {
		echo __('Something went wrong. Please try again.', 'mpcth');
	}

	if(!empty($_REQUEST['back_url']))
		echo '<a href="' . $_REQUEST['back_url'] . '">' . __('Return to panel', 'mpcth') . '</a>';

	die();
}

// Preview Page
add_action( 'wp_ajax_preview_page', 'rfbwp_preview_page' );
function rfbwp_preview_page() {
	if(!isset($_POST['book_id'])) {
		echo 'error-book-id';
		die();
	}

	if(!isset($_POST['page_id'])) {
		echo 'error-page-id';
		die();
	}

	global $shortname;
	$option_name = 'rfbwp_options';
	$options = get_option($option_name);

	$book_id = $_POST['book_id'];
	$page_id = $_POST['page_id'];

	$book_options = $options['books'][$book_id];

	$book_width = $book_options['rfbwp_fb_width'];
	$book_height = $book_options['rfbwp_fb_height'];

	$book_outer_width = $book_width + 10;
	$book_outer_height = $book_height + 20;

	$page_options = $options['books'][$book_id]['pages'][$page_id];

	$is_single_page = $page_options['rfbwp_fb_page_type'] == 'Single Page';

	$custom_class = '';
	$custom_css = '';
	if(!empty($page_options['rfbwp_fb_page_custom_class']) && !empty($page_options['rfbwp_page_css'])) {
		$custom_class = ' ' . $page_options['rfbwp_fb_page_custom_class'];

		$custom_css = '<style>' . PHP_EOL;
		$custom_css .= $page_options['rfbwp_page_css'] . PHP_EOL;
		$custom_css .= '</style>' . PHP_EOL;
	}

	if($is_single_page) {
		$book_outer_width = $book_outer_width + 10;
		?>
		<div id="flipbook-container-0" class="flipbook-container single-preview" style="background-image: none;">
			<div id="flipbook-0" class="flipbook" style="position: relative; -webkit-transform: translate3d(0px, 0px, 0px); width: <?php echo $book_outer_width; ?>px; height: <?php echo $book_outer_height; ?>px; left: 0px;">
				<div class="turn-page-wrapper first" style="position: absolute; top: 0px; right: 0px; width: <?php echo $book_outer_width; ?>px; height: <?php echo $book_outer_height; ?>px; z-index: 4;">
					<div style="position: absolute; top: 0px; left: 0px; overflow: hidden; z-index: auto; width: <?php echo $book_outer_width; ?>px; height: <?php echo $book_outer_height; ?>px;">
						<div class="fb-page single turn-page" style="position: absolute; top: 0px; left: 0px; bottom: auto; right: auto; width: <?php echo $book_outer_width; ?>px; height: <?php echo $book_outer_height; ?>px;">
							<div class="fb-inside-shadow-right" style="height: <?php echo $book_height; ?>px;"></div>
							<div class="page-content first" style="width: <?php echo $book_width; ?>px; height: <?php echo $book_height; ?>px;">
								<div class="container">
									<?php echo $custom_css; ?>
									<div class="page-html<?php echo $custom_class; ?>">
										<?php echo do_shortcode(stripslashes(stripslashes($page_options['rfbwp_page_html']))); ?>
									</div>
									<img src="<?php echo $page_options['rfbwp_fb_page_bg_image']; ?>" class="bg-img" style="height: <?php echo $book_outer_height; ?>px; width: <?php echo $book_width * 2; ?>px; visibility: visible;">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	} else {
		?>
		<div id="flipbook-container-0" class="flipbook-container" style="background-image: none;">
			<div id="flipbook-0" class="flipbook" style="position: relative; -webkit-transform: translate3d(0px, 0px, 0px); width: <?php echo $book_outer_width * 2; ?>px; height: <?php echo $book_outer_height; ?>px; left: 0px;">
				<div class="turn-page-wrapper even" style="position: absolute; top: 0px; left: 0px; width: <?php echo $book_outer_width; ?>px; height: <?php echo $book_outer_height; ?>px; z-index: 4;">
					<div style="position: absolute; top: 0px; left: 0px; overflow: hidden; z-index: auto; width: <?php echo $book_outer_width * 2; ?>px; height: <?php echo $book_outer_height; ?>px;">
						<div class="fb-page double turn-page" style="position: absolute; top: 0px; left: 0px; bottom: auto; right: auto; width: <?php echo $book_outer_width; ?>px; height: <?php echo $book_outer_height; ?>px;">
							<div class="fb-inside-shadow-left" style="height: <?php echo $book_height; ?>px;"></div>
							<div class="page-content even" style="width: <?php echo $book_width; ?>px; height: <?php echo $book_height; ?>px;">
								<div class="container">
									<?php echo $custom_css; ?>
									<div class="page-html<?php echo $custom_class; ?>">
										<?php echo do_shortcode(stripslashes(stripslashes($page_options['rfbwp_page_html']))); ?>
									</div>
									<img src="<?php echo $page_options['rfbwp_fb_page_bg_image']; ?>" class="bg-img" style="height: <?php echo $book_height; ?>px; width: <?php echo $book_width * 2; ?>px; visibility: visible;">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="turn-page-wrapper odd" style="position: absolute; top: 0px; right: 0px; width: <?php echo $book_outer_width; ?>px; height: <?php echo $book_outer_height; ?>px; z-index: 4;">
					<div style="position: absolute; top: 0px; left: 0px; overflow: hidden; z-index: auto; width: 547px; height: 547px;">
						<div class="fb-page double turn-page" style="position: absolute; top: 0px; left: 0px; bottom: auto; right: auto; width: <?php echo $book_outer_width; ?>px; height: <?php echo $book_outer_height; ?>px;">
							<div class="fb-inside-shadow-right" style="height: <?php echo $book_height; ?>px;"></div>
							<div class="page-content odd" style="width: <?php echo $book_width; ?>px; height: <?php echo $book_height; ?>px;">
								<div class="container">
									<div class="page-html<?php echo $custom_class; ?>">
										<?php echo do_shortcode(stripslashes(stripslashes($page_options['rfbwp_page_html']))); ?>
									</div>
									<img src="<?php echo $page_options['rfbwp_fb_page_bg_image']; ?>" class="bg-img" style="margin-left: 0px; height: <?php echo $book_height; ?>px; width: <?php echo $book_width * 2; ?>px; visibility: visible;">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	rfbwp_print_css(0, $options);

	die();
}

// Batch Import
add_action('wp_ajax_batch_import', 'rfbwp_batch_import');
function rfbwp_batch_import() {
	if(!isset($_POST['book_id'])) {
		echo 'error-book-id';
		die();
	}

	if(!isset($_POST['images_ids']) || !isset($_POST['images_ids_large'])) {
		echo 'error-images-ids';
		die();
	}

	global $shortname;
	$option_name = 'rfbwp_options';
	$options = get_option($option_name);

	$book_id = $_POST['book_id'];
	$images_ids = !empty($_POST['images_ids']) ? $_POST['images_ids'] : '';
	$images_ids_large = !empty($_POST['images_ids_large']) ? $_POST['images_ids_large'] : '';

	if(empty($images_ids))
		$images_ids = $images_ids_large;

	$images_ids = explode(',', $images_ids);
	$images_ids_large = explode(',', $images_ids_large);
	$page_type = isset($_POST['double_page']) && $_POST['double_page'] == 'true' ? 'Double Page' : 'Single Page';

	if(isset($options['books'][$book_id])) {
		if(!isset($options['books'][$book_id]['pages']))
			$options['books'][$book_id]['pages'] = array();

		$pages = $options['books'][$book_id]['pages'];

		$index = 0;
		if(!empty($pages)) {
			$end = end($pages);
			$index = (int)($end['rfbwp_fb_page_index']) + 2;
		}

		for ($i = 0, $count = count($images_ids); $i < $count; $i++) {
			$url = wp_get_attachment_url($images_ids[$i]);
			$url_large = !empty($images_ids_large[$i]) ? wp_get_attachment_url($images_ids_large[$i]) : '';

			$page = array();
			$page['rfbwp_fb_page_type'] = $page_type;
			$page['rfbwp_fb_page_bg_image'] = $url;
			$page['rfbwp_fb_page_bg_image_zoom'] = $url_large;
			$page['rfbwp_fb_page_index'] = $index;
			$page['rfbwp_fb_page_custom_class'] = '';
			$page['rfbwp_page_css'] = '';
			$page['rfbwp_page_html'] = '';

			$pages[] = $page;

			if($page_type == 'Double Page')
				$index += 2;
			else
				$index++;
		}

		$options['books'][$book_id]['pages'] = $pages;

		unregister_setting($option_name, $option_name, 'mp_validate_options');

		update_option($option_name, $options);

		register_setting($option_name, $option_name, 'mp_validate_options');
	}
	die();
}