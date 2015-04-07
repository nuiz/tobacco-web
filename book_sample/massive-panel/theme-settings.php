<?php

/*-----------------------------------------------------------------------------------*/
/*	Constants
/*-----------------------------------------------------------------------------------*/

define('MP_SHORTNAME', 'mp'); // this is used to prefix the individual field id
define('MP_PAGE_BASENAME', 'mp-settings'); // settings page slug
define('MP_ROOT', get_bloginfo('wpurl').'/wp-content/plugins/responsive-flipbook');

/*-----------------------------------------------------------------------------------*/
/*	Variables
/*-----------------------------------------------------------------------------------*/

global $shortname;
$shortname = "rfbwp";

/*-----------------------------------------------------------------------------------*/
/*	Specify Hooks
/*-----------------------------------------------------------------------------------*/

add_action('init', 'massivepanel_rolescheck' );

function massivepanel_rolescheck () {
	$role = get_role('editor');
	$role->add_cap('rfbwp_plugin_cap');
	$role = get_role('administrator');
	$role->add_cap('rfbwp_plugin_cap');

	if ( current_user_can('rfbwp_plugin_cap') ) {
		// If the user can edit theme options, let the fun begin!
		add_action('admin_menu', 'mp_add_menu');
		add_action('admin_init', 'mp_register_settings');
		add_action('admin_init', 'mp_mlu_init');
	}
}


/*-----------------------------------------------------------------------------------*/
/*	Scripts (JS & CSS)
/*-----------------------------------------------------------------------------------*/

function mp_settings_scripts(){
	wp_enqueue_media();
	wp_enqueue_style('color_picker_css', MP_ROOT.'/massive-panel/css/colorpicker.css');
	wp_enqueue_style('mp_theme_settings_css', MP_ROOT.'/massive-panel/css/mp-styles.css');
	wp_enqueue_style('flipbook_styles', MP_ROOT.'/css/style.css');

	wp_enqueue_script('color_picker_js', MP_ROOT.'/massive-panel/js/colorpicker.js', array('jquery'));
	wp_enqueue_script('mp_theme_settings_js', MP_ROOT.'/massive-panel/js/mp-scripts.js', array('jquery'));
}

/*-----------------------------------------------------------------------------------*/
/*	Admin Menu Page
/*-----------------------------------------------------------------------------------*/

function mp_add_menu(){
	$settings_output = mp_get_settings();

	// This code displays the link to Admin Menu under "Appearance"
	$mp_settings_page = add_menu_page(__('Massive Panel Options', 'responsive-flipbook'), __('Flip Books', 'responsive-flipbook'), 'rfbwp_plugin_cap', MP_PAGE_BASENAME, 'mp_settings_page_fn');

	// js & css
	add_action('load-'.$mp_settings_page, 'mp_settings_scripts');
}

/*-----------------------------------------------------------------------------------*/
/*	Helper function for defininf variables
/*-----------------------------------------------------------------------------------*/

function mp_get_settings() {
	global $shortname;
	//delete_option($shortname.'_options');
	$output = array();
	$output[$shortname.'_option_name']		= $shortname.'_options'; // option name as used in the get_option() call
	$output['mp_page_title']				=__('Massive Panel Settings Page', 'rfbwp'); // the settings page title

	return $output;
}

// Disable update Warning
add_action('wp_ajax_disable_warning', 'rfbwp_disable_warning');
function rfbwp_disable_warning() {
	global $shortname;

	update_option($shortname . '_ver_1_3', 1);
	die();
}

function mp_settings_page_fn(){
	global $shortname;
	$settings_output = mp_get_settings();
	$content = mp_display_content();

	$disable_warning = get_option($shortname . '_ver_1_3');

	?>
	<div class="wrap">
		<div class="icon32" id="icon-options-general"></div>
		<h2><?php echo $settings_output['mp_page_title']; ?></h2>

		<?php if(!$disable_warning) { ?>
		<div id="update_warning">
			<h3><?php _e('Welcome to Flipbook 1.3 update!', 'rfbwp'); ?></h3>
			<p><?php _e('We have rewrited a lot o things here to improve your experience with our plugin. We try our best to make it issues free but some bugs might still be there waiting to appear. Please backup your Flipbooks before using this new update. You can find all data in <b>wp_options / rfbwp_options</b> table inside Wordpress database.', 'rfbwp'); ?></p>
			<p><?php _e('If you found any issues please feel free to send us a support ticket and we will fix it as soon as possible. Visit ', 'rfbwp'); ?><a href="http://mpc.ticksy.com" target="_blank"><?php _e('our support', 'rfbwp'); ?></a>.</p>
			<a id="confirm_update" class="mp-orange-button" href="#">
				<span class="left" style="opacity: 1;">
					<span class="desc"><?php _e('I understand, close', 'rfbwp'); ?></span>
				</span>
				<span class="right" style="opacity: 1;"></span>

				<span class="left-hover" style="opacity: 0;">
					<span class="desc"><?php _e('I understand, close', 'rfbwp'); ?></span>
				</span>
				<span class="right-hover" style="opacity: 0;"></span>
			</a>
		</div>
		<?php } ?>

		<div id="top">
			<div id="top-nav">
				<div class="mpc-logo"></div>
				<?php echo $content[3]; ?>
				<?php echo $content[2]; ?>
			</div><!-- end topnav -->
		</div> <!-- end top -->
		<div id="bg-content">
			<div id="sidebar"><?php echo $content[1]; ?></div>
			<form action="/" id="options-form" name="options-form" method="post">
				<?php
					settings_fields($settings_output[$shortname.'_option_name']);
					echo $content[0];
				?>
				<div class="bottom-nav">
					<div class="mp-line">
						<div class="mp-line-around">
							<input type="hidden" name="action" value="rfbwp_save_settings" />
							<input type="hidden" name="security" value="<?php echo wp_create_nonce('rfbwp-theme-data'); ?>" />

							<input name="mp-submit" class="save-button" type="submit" value="<?php esc_attr_e('Save Settings', 'rfbwp'); ?>" />

							<a class="edit-button mp-orange-button" href="#"><span class="left"><span class="desc"><?php _e('Save Settings', 'rfbwp'); ?></span></span><span class="right"></span><span class="left-hover"><span class="desc"><?php _e('Save Settings', 'rfbwp'); ?></span></span><span class="right-hover"></span></a>

							<input name="mp-reset" class="reset-button" type="submit" value="<?php esc_attr_e('Reset Settings', 'rfbwp'); ?>" />
						</div>
					</div>
				</div>
			</form>
			<div id="rfbwp_tools">
				<header id="rfbwp_tools_toggle_header">
					<a id="rfbwp_tools_toggle_title" href="#"><?php _e('Tools', 'rfbwp'); ?><span class="toggle-arrow"></span></a>
				</header>
				<div id="rfbwp_tools_toggle_content">
					<div class="field">
						<form action="<?php echo admin_url('admin-ajax.php'); ?>" enctype="multipart/form-data" method="post">
							<div class="description-top"><?php _e('Import Flipbook settings:', 'rfbwp'); ?> </div>
							<input type="hidden" name="action" value="import_flipbooks">
							<input type="hidden" name="back_url" value="" id="rfbwp_import_back_url">
							<input type="hidden" name="mp-settings" value="Save Page">
							<input type="hidden" name="book_id" id="rfbwp_import_id">
							<input type="file" name="import_flipbooks_file" id="rfbwp_import_file">
							<input type="submit" id="rfbwp_import">
							<a id="rfbwp_flipbook_import" class="mp-grey-button" href="#">
								<span class="left">
									<span class="icon-upload"></span>
									<span class="desc"><?php _e('Import', 'rfbwp'); ?></span>
								</span>
								<span class="right"></span>
								<span class="left-hover">
									<span class="icon-upload"></span>
									<span class="desc"><?php _e('Import', 'rfbwp'); ?></span>
								</span>
								<span class="right-hover"></span>
							</a>
							<div class="help-icon">
								<span class="mp-tooltip top" style="margin-left: -190px; margin-top: 30px; display: none; opacity: 0;">
									<span class="arrow" style="display: none; opacity: 0;"></span>
									<?php _e('This will import all Flipbooks and pages settings. Please upload previously created backup (NOTE: File must have .rfb extension).', 'rfbwp'); ?>
								</span>
							</div>
						</form>
					</div>
					<div class="field">
						<div class="description-top"><?php _e('Export Flipbook settings:', 'rfbwp'); ?> </div>
						<a id="rfbwp_flipbook_export" class="mp-grey-button" href="#">
							<span class="left">
								<span class="icon-upload"></span>
								<span class="desc"><?php _e('Export', 'rfbwp'); ?></span>
							</span>
							<span class="right"></span>
							<span class="left-hover">
								<span class="icon-upload"></span>
								<span class="desc"><?php _e('Export', 'rfbwp'); ?></span>
							</span>
							<span class="right-hover"></span>
						</a>
						<div class="help-icon">
							<span class="mp-tooltip top" style="margin-left: -190px; margin-top: 30px; display: none; opacity: 0;">
								<span class="arrow" style="display: none; opacity: 0;"></span>
								<?php _e('This will export all Flipbooks and pages settings (NOTE: This exports only settings. To export used images you will have to use other plugin).', 'rfbwp'); ?>
							</span>
						</div>
					</div>
					<div class="field">
						<div class="description-top"><?php _e('Batch Images upload:', 'rfbwp'); ?> </div>
						<a id="rfbwp_flipbook_batch_import" class="mp-grey-button" href="#">
							<span class="left">
								<span class="icon-upload"></span>
								<span class="desc"><?php _e('Upload', 'rfbwp'); ?></span>
							</span>
							<span class="right"></span>
							<span class="left-hover">
								<span class="icon-upload"></span>
								<span class="desc"><?php _e('Upload', 'rfbwp'); ?></span>
							</span>
							<span class="right-hover"></span>
						</a>
						<div class="description-top batch-double"><?php _e('Double Pages:', 'rfbwp'); ?> </div>
						<input id="rfbwp_flipbook_batch_double" class="checkbox of-input" type="checkbox" name="rfbwp_flipbook_batch_double" checked="checked"/>
						<div class="help-icon">
							<span class="mp-tooltip top" style="margin-left: -190px; margin-top: 30px; display: none; opacity: 0;">
								<span class="arrow" style="display: none; opacity: 0;"></span>
								<?php _e('This will export all Flipbooks and pages settings (NOTE: This exports only settings. To export used images you will have to use other plugin).', 'rfbwp'); ?>
							</span>
						</div>
						<div class="select-section">
							<input type="hidden" id="rfbwp_flipbook_batch_ids" name="rfbwp_flipbook_batch_ids" value="">
							<a id="rfbwp_flipbook_batch_select" class="mp-grey-button" href="#">
								<span class="left">
									<span class="icon-upload"></span>
									<span class="desc"><?php _e('Select Normal', 'rfbwp'); ?></span>
								</span>
								<span class="right"></span>
								<span class="left-hover">
									<span class="icon-upload"></span>
									<span class="desc"><?php _e('Select Normal', 'rfbwp'); ?></span>
								</span>
								<span class="right-hover"></span>
							</a>
							<a id="rfbwp_flipbook_batch_clear" class="delete-page" href="#0">
								<span class="normal" style="opacity: 1;"></span>
								<span class="hover" style="opacity: 0;"></span>
							</a>
							<div id="rfbwp_flipbook_batch_images_wrap"></div>
						</div>
						<div class="select-section">
							<input type="hidden" id="rfbwp_flipbook_batch_ids_large" name="rfbwp_flipbook_batch_ids_large" value="">
							<a id="rfbwp_flipbook_batch_select_large" class="mp-grey-button" href="#">
								<span class="left">
									<span class="icon-upload"></span>
									<span class="desc"><?php _e('Select Large', 'rfbwp'); ?></span>
								</span>
								<span class="right"></span>
								<span class="left-hover">
									<span class="icon-upload"></span>
									<span class="desc"><?php _e('Select Large', 'rfbwp'); ?></span>
								</span>
								<span class="right-hover"></span>
							</a>
							<a id="rfbwp_flipbook_batch_clear_large" class="delete-page" href="#0">
								<span class="normal" style="opacity: 1;"></span>
								<span class="hover" style="opacity: 0;"></span>
							</a>
							<div id="rfbwp_flipbook_batch_images_wrap_large"></div>
						</div>
					</div>
				</div>
			</div>
		</div> <!-- end bg-content -->

		<script type="text/html" id="tmpl-custom-gallery-setting">
			<label class="setting">
				<span>Size</span>
				<select class="type" name="size" data-setting="size">
					<?php

					$sizes = apply_filters( 'image_size_names_choose', array(
						'thumbnail' => __( 'Thumbnail' ),
						'medium'    => __( 'Medium' ),
						'large'     => __( 'Large' ),
						'full'      => __( 'Full Size' ),
					) );

					foreach ( $sizes as $value => $name ) { ?>
						<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $value, 'thumbnail' ); ?>>
							<?php echo esc_html( $name ); ?>
						</option>
					<?php } ?>
				</select>
			</label>
		</script>

		<div id="rfbwp_page_preview">
			<div id="rfbwp_page_preview_wrap"></div>
			<div id="rfbwp_page_preview_close"><?php _e('Click anywhere to close.', 'rfbwp') ?></div>
		</div>
	</div><!-- end wrap -->
<?php

}

/*-----------------------------------------------------------------------------------*/
/*	Register settings
/*	This function registers wordpress settings
/*-----------------------------------------------------------------------------------*/

function mp_register_settings() {
	global $shortname;
	require_once('theme-options.php');
	require_once('theme-interface.php');
	require_once('theme-tools.php');
	require_once('mpc-uploader.php');

	$settings_output	= mp_get_settings();
	$mp_option_name		= $settings_output[$shortname.'_option_name'];

	// register panel settings
	register_setting($mp_option_name, $mp_option_name, 'mp_validate_options');
}

/*-----------------------------------------------------------------------------------*/
/*	Validate Input
/*-----------------------------------------------------------------------------------*/

function mp_validate_options($input) {
	// variable
	global $reset;
	global $book_id;
	global $settings;
	// for enphaced security, create new array
	global $valid_input;
	$valid_input = array();
	$type = '';
	$reset = 'false';
	$settings = rfbwp_get_settings();

	if(isset($_POST['mp-settings']) && ($_POST['mp-settings'] == "Edit Settings" || $_POST['mp-settings'] == "Save Page" || $_POST['mp-settings'] == "Save Changes" || $_POST['mp-settings'] == "Delete Page")) {
		$addNewBook = 'false';
		$addNewPage = 'false';

		if($_POST['mp-settings'] == "Save Page")
			$addNewPage = 'true';
		elseif($_POST['mp-settings'] == "Save Changes")
			$addNewPage = 'false';
		elseif($_POST['mp-settings'] == "Delete Page")
			$addNewPage = 'delete';
	} else {
		$addNewBook = 'true';
		$addNewPage = 'false';
	}

	if(isset($_POST['mp-settings']) && $_POST['mp-settings'] == "delete")
		$addNewBook = 'delete';

	// get the settings section array
	$options = mpcrf_options();

	$active_book = isset($_POST['active-book']) ? $_POST['active-book'] : '';
	// if there is a book add another one
	if(isset($settings['books']) && count($settings['books']) > 0)
		$options = mp_duplicate_options($options, $addNewBook, $addNewPage, $active_book);

	$book_id = -1;
	$page_id = 0;
	$path_prefix = '';
	$input_path_prefix = '';

	if(isset($_POST['delete']))
		$dbook_id = $_POST['delete'];
	else
		$dbook_id = '';

	if(isset($_POST['delete-page'])) {
		$dpage_id = $_POST['delete-page'];
		$dbook_id = $_POST['active-book'];
	} else {
		$dpage_id = '';
	}

	// run a foreach and switch on option type
	foreach($options as $option) {
		if( isset($option['sub']) && $option['sub'] == 'settings' )
			$type = 'books';
		elseif( $option['type'] == 'pages' )
			$type = 'pages';
		elseif( $option['type'] == 'section' )
			$type = '';

		// delete if there is only one book
		if(count($input['books']) < 2 && $dbook_id != '' && $dpage_id == '') {
			continue;
		}

		if($type == 'books' && $option['type'] == 'heading' && isset($option['sub']) && $option['sub'] == 'settings') {
			$book_id ++;
			$page_id = -1;
		}

		if($type == 'pages' && $option['type'] == 'separator')
			$page_id++;

		// delete book id
		if($dbook_id != '' && $book_id >= $dbook_id && $dpage_id == ''){
			$input_book_id = $book_id + 1;
		} else {
			$input_book_id = $book_id;
		}

		// delete page id
		if($dpage_id != '' && $page_id >= $dpage_id && $dbook_id == $book_id) {
			$input_page_id = $page_id + 1;
		} else {
			$input_page_id = $page_id;
		}

		if(isset($option['id']) && $option['type'] != 'separator' && $option['type'] != 'heading' && $option['type'] != 'info' && $option['type'] != 'export-button' && $type != 'pages' && $input_book_id > -1) {
			$input_value = $input['books'][$input_book_id][$option['id']];
		} elseif(isset($option['id']) && $option['type'] != 'separator' && $option['type'] != 'heading' && $option['type'] != 'pages' && $type == 'pages' && $input_book_id > -1) {
			if(isset($input['books'][$input_book_id]['pages'][$input_page_id][$option['id']]))
				$input_value = $input['books'][$input_book_id]['pages'][$input_page_id][$option['id']];
			else
				continue;
		}

		switch($option['type']) {
			case 'text-big':
			case 'text-medium':
			case 'text-small':
				//switch validation based on the class
				switch($option['validation']){
					//for numeric
					case 'numeric':
						if($reset == "true"){
							$valid_input_value = $option['std'];
							set_valid_input($type, $valid_input_value, $book_id, $option['id'], $page_id);
							break;
						}

						$input_value = trim($input_value); // this trims the whitespace
						$valid_input_value = $input_value;
						set_valid_input($type, $valid_input_value, $book_id, $option['id'], $page_id);
					break;

					// multi-numeric values separated by comma
					case 'multinumeric':
						if($reset == "true"){
							$valid_input_value = $option['std'];
							set_valid_input($type, $valid_input_value, $book_id, $option['id'], $page_id);
							break;
						}
						//accept the input only when the numeric values are comma separated
						$input_value = trim($input_value); // trim whitespace
						if($input_value != '') {
							// /^-?\d+(?:,\s?-?\d+)*$/ matches: -1 | 1 | -12,-23 | 12,23 | -123, -234 | 123, 234  | etc.
							$valid_input_value = $valid_input_value = (preg_match('/^-?\d+(?:,\s?-?\d+)*$/', $input_value) == 1) ? $input_value : __('Expecting comma separated numeric values','rfbwp');
						} else {
							$valid_input_value = $input_value;
						}

						// register error
						if($input_value !='' && preg_match('/^-?\d+(?:,\s?-?\d+)*$/', $input_value) != 1) {
							add_settings_error(
								$option['id'], // setting title
								MP_SHORTNAME . '_txt_multinumeric_error', // error ID
								__('Expecting comma separated numeric values!','rfbwp'), // error message
								'error' // type of message
							);
						}
						set_valid_input($type, $valid_input_value, $book_id, $option['id'], $page_id);
					break;

					//no html
					case 'nohtml':
						if($reset == "true"){
							$valid_input_value = $option['std'];
							set_valid_input($type, $valid_input_value, $book_id, $option['id'], $page_id);
							break;
						}
						//accept the input only after stripping out all html, extra white space etc!
						$input_value = sanitize_text_field($input_value); // need to add slashes still before sending to the database
						// FIX
						$input_value = stripslashes($input_value);
						$valid_input_value = addslashes($input_value);
						set_valid_input($type, $valid_input_value, $book_id, $option['id'], $page_id);
					break;

					//for url
					case 'url':
						if($reset == "true"){
							$valid_input_value = $option['std'];
							set_valid_input($type, $valid_input_value, $book_id, $option['id'], $page_id);
							break;
						}
						//accept the input only when the url has been sanited for database usage with esc_url_raw()
						$input_value 		= trim($input_value); // trim whitespace
						$valid_input_value = esc_url_raw($input_value);
						set_valid_input($type, $valid_input_value, $book_id, $option['id'], $page_id);
					break;

					//for email
					case 'email':
						if($reset == "true"){
							$valid_input_value = $option['std'];
							set_valid_input($type, $valid_input_value, $book_id, $option['id'], $page_id);
							break;
						}
						//accept the input only after the email has been validated
						$input_value = trim($input_value); // trim whitespace
						if($input_value != ''){
							if(is_email($input_value)!== FALSE) {
								$valid_input_value = $input_value;
							} else {
								$valid_input_value = __('Invalid email! Please re-enter!','rfbwp');
							}
						} elseif($input_value == '') {
							$valid_input_value = __('This setting field cannot be empty! Please enter a valid email address.','rfbwp');
						}

						// register error
						if(is_email($input_value)== FALSE || $input_value == '') {
							add_settings_error(
								$option['id'], // setting title
								MP_SHORTNAME . '_txt_email_error', // error ID
								__('Please enter a valid email address.','rfbwp'), // error message
								'error' // type of message
							);
						}
						set_valid_input($type, $valid_input_value, $book_id, $option['id'], $page_id);
					break;

					// a "cover-all" fall-back when the class argument is not set
					default:
						if($reset == "true"){
							$valid_input_value = $option['std'];
							set_valid_input($type, $valid_input_value, $book_id, $option['id'], $page_id);
							break;
						}
						// accept only a few inline html elements
						$allowed_html = array(
							'a' => array('href' => array (),'title' => array ()),
							'b' => array(),
							'em' => array (),
							'i' => array (),
							'strong' => array()
						);

						$input_value 		= trim($input_value); // trim whitespace
						$input_value 		= force_balance_tags($input_value); // find incorrectly nested or missing closing tags and fix markup
						$input_value 		= wp_kses( $input_value, $allowed_html); // need to add slashes still before sending to the database
						// FIX
						$input_value = stripslashes($input_value);
						$valid_input_value = addslashes($input_value);
						set_valid_input($type, $valid_input_value, $book_id, $option['id'], $page_id);
					break;
				}
			break;

			case 'textarea-big':
			case 'textarea':
				//switch validation based on the class!
				switch ( $option['validation'] ) {
					//for only inline html
					case 'inlinehtml':
						if($reset == "true"){
							$valid_input_value = $option['std'];
							set_valid_input($type, $valid_input_value, $book_id, $option['id'], $page_id);
							break;
						}
						// accept only inline html
						$input_value 		= trim($input_value); // trim whitespace
						$input_value 		= force_balance_tags($input_value); // find incorrectly nested or missing closing tags and fix markup
						// FIX
						$input_value = stripslashes($input_value);
						$input_value 		= addslashes($input_value); //wp_filter_kses expects content to be escaped!
						$valid_input_value = wp_filter_kses($input_value); //calls stripslashes then addslashes
						set_valid_input($type, $valid_input_value, $book_id, $option['id'], $page_id);
					break;

					//for no html
					case 'nohtml':
						if($reset == "true"){
							$valid_input_value = $option['std'];
							break;
						}
						//accept the input only after stripping out all html, extra white space etc!
						$input_value 		= sanitize_text_field($input_value); // need to add slashes still before sending to the database
						// FIX
						$input_value = stripslashes($input_value);
						$valid_input_value = addslashes($input_value);
						set_valid_input($type, $valid_input_value, $book_id, $option['id'], $page_id);
					break;

					//for allowlinebreaks
					case 'allowlinebreaks':
						if($reset == "true"){
							$valid_input_value = $option['std'];
							break;
						}
						//accept the input only after stripping out all html, extra white space etc!
						$input_value 		= wp_strip_all_tags($input_value); // need to add slashes still before sending to the database
						// FIX
						$input_value = stripslashes($input_value);
						$valid_input_value = addslashes($input_value);
						set_valid_input($type, $valid_input_value, $book_id, $option['id'], $page_id);
					break;

					// a "cover-all" fall-back when the class argument is not set
					default:
						// accept only limited html
						if($reset == "true"){
							$valid_input_value = $option['std'];
							break;
						}

						//my allowed html
						$allowed_html = array(
							'a' 			=> array('href' => array (),'title' => array ()),
							'b' 			=> array(),
							'blockquote' 	=> array('cite' => array ()),
							'br' 			=> array(),
							'dd' 			=> array(),
							'dl' 			=> array(),
							'dt' 			=> array(),
							'em' 			=> array(),
							'i' 			=> array(),
							'li' 			=> array(),
							'ol' 			=> array(),
							'p' 			=> array(),
							'q' 			=> array('cite' => array ()),
							'strong' 		=> array(),
							'ul' 			=> array(),
							'h1' 			=> array('align' => array (),'class' => array (),'id' => array (), 'style' => array ()),
							'h2' 			=> array('align' => array (),'class' => array (),'id' => array (), 'style' => array ()),
							'h3' 			=> array('align' => array (),'class' => array (),'id' => array (), 'style' => array ()),
							'h4' 			=> array('align' => array (),'class' => array (),'id' => array (), 'style' => array ()),
							'h5' 			=> array('align' => array (),'class' => array (),'id' => array (), 'style' => array ()),
							'h6' 			=> array('align' => array (),'class' => array (),'id' => array (), 'style' => array ())
						);

						$input_value 		= trim($input_value); // trim whitespace
						// FIX
						$input_value = stripslashes($input_value);
						$valid_input_value = addslashes($input_value);
						set_valid_input($type, $valid_input_value, $book_id, $option['id'], $page_id);
					break;
				}
			break;

			// settings that doesn't really require validation
			case 'upload':
			case 'info':
			case 'multi-checkbox':
			case 'select':
			case 'choose-portfolio':
			case 'choose-sidebar':
			case 'choose-sidebar-small':
			case 'choose-image':
			case "radio" :
				if($reset == "false"){
					if(isset($option['id']) && isset($input_value))
						$valid_input_value = $input_value;
				} elseif (isset($option['id']) && isset($option['std'])) {
					$valid_input_value = $option['std'];
				} else {
					$valid_input_value = '';
				}
				set_valid_input($type, $valid_input_value, $book_id, $option['id'], $page_id);
			break;

			case 'multi-upload':
				if(isset( $input_value)){
					$valid_input_value = $input_value;
				} else {
					$valid_input_value = '';
				}
				set_valid_input($type, $valid_input_value, $book_id, $option['id'], $page_id);
			break;

			// color picker validation
			case 'color':
				if($reset == "false"){
					if(validate_hex($input_value)) {
						$valid_input_value = $input_value;
					} else {
						$valid_input_value = $option['std'];
						add_settings_error(
						$option['id'], // setting title
							MP_SHORTNAME . '_color_hex_error', // error ID
						__('Please insert HEX value.','rfbwp'), // error message
							'error' // type of message
						);
					}
				} else {
					$valid_input_value = $option['std'];
				}
				set_valid_input($type, $valid_input_value, $book_id, $option['id'], $page_id);
			break;

			// checkbox validation
			case 'checkbox-ios':
			case 'checkbox':
				// if it's not set, default to null!
				if($reset == "true"){
					if(isset($option['std'])) {
						$valid_input_value = $option['std'];
					} else {
						$valid_input_value = "";
					}
					set_valid_input($type, $valid_input_value, $book_id, $option['id'], $page_id);
					break;
				}
				if (!isset($input_value) || $input_value === 0) {
					$input_value = null;
				}
				// Our checkbox value is either 0 or 1
				if($input_value == 1 || $input_value == 'on'){
					$valid_input_value = 1;
				} else {
					$valid_input_value = 0;
				}

				set_valid_input($type, $valid_input_value, $book_id, $option['id'], $page_id);
			break;
		}
	}

	$_POST['delete'] = '';

	return $valid_input; // returns the valid input;
}

function set_valid_input($type, $value, $book_id, $id, $page_id){
	global $valid_input;

	if($type == 'books'){
		$valid_input['books'][$book_id][$id]  = $value;
	} elseif($type == 'pages') {
		$valid_input['books'][$book_id]['pages'][$page_id][$id]  = $value;
	}
}


/* Helper function for HEX validation */
function validate_hex($hex) {
	//echo $hex;
	$hex = trim($hex);
	// Strip recognized prefixes.
	if (0 === strpos( $hex, '#')) {
		$hex = substr( $hex, 1 );
	} elseif ( 0 === strpos( $hex, '%23')) {
		$hex = substr($hex, 3);
	}
	//echo $hex;
	// Regex match.
	if (0 === preg_match('/^[0-9a-fA-F]{6}$/', $hex)) {
		return false;
	} else {
		return true;
	}
}

/*-----------------------------------------------------------------------------------*/
/*	Callback function for displaying admin messages
/*	@return calls mp_show_msg()
/*-----------------------------------------------------------------------------------*/

function mp_admin_msgs(){
	// check for settings page
	if(isset($_GET['page']))
		$mp_settings_pg = strpos($_GET['page'], MP_PAGE_BASENAME);
	else
		$mp_settings_pg = FALSE;

	// collect setting error/notices
	$set_errors = get_settings_errors();

	// display admin message only for the admin to see, only on our settings page and only when setting errors/notices ocur
	if(current_user_can('manage_options') && $mp_settings_pg !== FALSE && !empty($set_errors)){
		// have the settings been updates succesfully
		if($set_errors[0]['code'] == 'settings_updated' && isset($_GET['settings-updated'])) {
			mp_show_msg("<p>".$set_errors[0]['message']."</p>", 'updated');
		} else { // have errors been found?
			// loop through the errors
			foreach($set_errors as $set_error) {
				// set the title attribute to match the error "setting title" - need this in js file
				mp_show_msg("<p class='setting-error-message' title='".$set_error['setting']."'>".$set_error['message']."</p>", "error");

			}
		}
	}
}

// admin hook for notices
add_action('admin_notices', 'mp_admin_msgs');


/*-----------------------------------------------------------------------------------*/
/*	This is Helper function which displayes admin messages
/*	@param (string) $message The echoed message
/*	@param (string) $msgclass The message class: info, error, succes ect.
/*	@return echoes the message
/*-----------------------------------------------------------------------------------*/

function mp_show_msg($message, $msgclass = 'info') {
	echo "<div id='message' class='$msgclass'>$message</div>";
}

// save settings
add_action('wp_ajax_save_settings', 'rfbwp_save_settings');
function rfbwp_save_settings() {
	global $shortname;
	$option_name = 'rfbwp_options';
	$options_new = array();
	$array_names = array();
	$options = get_option($option_name);

	if( isset($_POST['activeID']) ) $_POST['active-book'] = $_POST['activeID'];
	if( isset($_POST['pageID']) ) $_POST['delete-page'] = $_POST['pageID'];
	$data = $_POST['data'];
	$type = $_POST['updating']; // book, edit_page, new_page
	$pageID = isset($_POST['curPageID']) ? $_POST['curPageID'] : 0;
	$bookID = $_POST['activeID'];

	if( isset($_POST['moveDir']) ) $move_dir = $_POST['moveDir'];

	if($_POST['value'] != "")
		$_POST['mp-settings'] = $_POST['value'];

	for($i = 0; $i < count($data); $i++) {
		// get the array names
		$array_names = array();
		$name = preg_split('/rfbwp_options/', $data[$i]['name']);
		if(isset($name[1]))
			$name = preg_split('/[\[\]]+/', $name[1]);

		// remove empty strings
		foreach($name as $na) {
			if($na != '') {
				array_push($array_names, $na);
			}
		}

		if(count($array_names) > 1 && !isset($options_new[$array_names[0]]))
			$options_new[$array_names[0]] = array();

		if(count($array_names) > 2 && !isset($options_new[$array_names[0]][$array_names[1]]))
			$options_new[$array_names[0]][$array_names[1]] = array();

		if(count($array_names) > 3 && !isset($options_new[$array_names[0]][$array_names[1]][$array_names[2]]))
			$options_new[$array_names[0]][$array_names[1]][$array_names[2]] = array();
		elseif(count($array_names) == 3)
			$options_new[$array_names[0]][$array_names[1]][$array_names[2]] = $data[$i]['value'];

		if(count($array_names) > 4 && !isset($options_new[$array_names[0]][$array_names[1]][$array_names[2]][$array_names[3]]))
			$options_new[$array_names[0]][$array_names[1]][$array_names[2]][$array_names[3]] = array();

		if(count($array_names) == 5)
			$options_new[$array_names[0]][$array_names[1]][$array_names[2]][$array_names[3]][$array_names[4]] = $data[$i]['value'];
	}

	if($type == 'edit_page') {
		$options['books'][$bookID]['pages'][$pageID] = $options_new['books'][$bookID]['pages'][$pageID];
	} elseif($type == 'new_page' || $type == 'delete_page') {
		if($type == 'new_page')
			$multi = 1;
		else
			$multi = -1;

		$page_type = $options_new['books'][$bookID]['pages'][$pageID]['rfbwp_fb_page_type'];
		$inc_val = $page_type == 'Double Page' ? 2 : 1;
		$new_index = 0;

		foreach ($options['books'][$bookID]['pages'] as $single_page) {
			if($new_index >= $pageID)
				$options['books'][$bookID]['pages'][$new_index]['rfbwp_fb_page_index'] = (int)$single_page['rfbwp_fb_page_index'] + $inc_val * $multi;

			$new_index++;
		}

		$original = $options['books'][$bookID]['pages'];

		if($type == 'new_page') {
			$inserted = $options_new['books'][$bookID]['pages'];
			array_splice( $options['books'][$bookID]['pages'], $pageID, 0, $options_new['books'][$bookID]['pages'] );
		} else {
			$options['books'][$bookID]['pages'][$pageID] = array();
		}
	} elseif($type == 'first_page') {
		if(!isset($options['books'][$bookID]['pages']))
			$options['books'][$bookID]['pages'] = array();

		$options['books'][$bookID]['pages'][$pageID] = $options_new['books'][$bookID]['pages'][$pageID];
	} elseif($type == 'book') {
		if(isset($options['books'][$bookID])) {
			foreach($options['books'][$bookID] as $key => $value) {
				if($key != 'pages') {
					if(isset($options_new['books'][$bookID][$key]))
						$options['books'][$bookID][$key] = $options_new['books'][$bookID][$key];
					else
						unset($options['books'][$bookID][$key]);
				}
			}
		} else {
			$options['books'][$bookID] = $options_new['books'][$bookID];
		}
	} elseif($type == 'move_page') {
		if($move_dir == 'move_up')
			$multi = 1;
		elseif($move_dir == 'move_down')
			$multi = -1;
		else
			return;

		$page_type = $options_new['books'][$bookID]['pages'][$pageID]['rfbwp_fb_page_type'];
		$inc_val = $page_type == 'Double Page' ? 2 : 1;
		$moved_page = $options['books'][$bookID]['pages'][$pageID];
		$moving_page = $options['books'][$bookID]['pages'][$pageID + $multi];

		$moved_page['rfbwp_fb_page_index'] = (int)$moved_page['rfbwp_fb_page_index'] + $inc_val * $multi;
		$moving_page['rfbwp_fb_page_index'] = $options_new['books'][$bookID]['pages'][$pageID]['rfbwp_fb_page_index'];

		$options['books'][$bookID]['pages'][$pageID] = $moving_page;
		$options['books'][$bookID]['pages'][$pageID + $multi] = $moved_page;
	} elseif($type == 'delete_page') {
		$page_type = $options_new['books'][$bookID]['pages'][$pageID]['rfbwp_fb_page_type'];
		$inc_val = $page_type == 'Double Page' ? 2 : 1;
		$new_index = 0;

		foreach ($options['books'][$bookID]['pages'] as $single_page) {
			if($new_index >= $pageID)
				$options['books'][$bookID]['pages'][$new_index]['rfbwp_fb_page_index'] = (int)$single_page['rfbwp_fb_page_index'] - $inc_val;

			$new_index++;
		}

		$original = $options['books'][$bookID]['pages'];
		array_splice( $options['books'][$bookID]['pages'], $pageID, 1 );
	}
echo $option_name;
	update_option($option_name, $options);

	die();
}

// delete book
add_action( 'wp_ajax_delete_book', 'rfbwp_delete_book' );
function rfbwp_delete_book() {
	global $shortname;
	$option_name = 'rfbwp_options';
	$options = get_option($option_name);

	$_POST['mp-settings'] = 'delete';
	$bookID = $_POST['id'];
	$_POST['delete'] = $bookID;

	$options['books'][$bookID] = array();

	update_option($option_name, $options);

	die();
}

add_action('wp_ajax_set_active_book', 'rfbwp_set_active_book');
function rfbwp_set_active_book() {
	$_POST['active-book'] = $_POST['activeID'];

	die();
}

/*-----------------------------------------------------------------------------------*/
/*	Settings for HTML Flip Book
/*-----------------------------------------------------------------------------------*/

/* Flip Book Variables */

function rfbwp_print_css($id, $options) {
	/* Main */
	$fb_id = "flipbook-".$id; /* flip book id (default flipbook-1) */
	$fb_cont = "flipbook-container-".$id; /* flip book container */
	$fb_width = $options['books'][$id]['rfbwp_fb_width']; /* flip book width in pixels (without border) */
	$fb_height = $options['books'][$id]['rfbwp_fb_height']; /* flip book height in pixels (without border) */

	/* Book Position */
	$margin_top = $options['books'][$id]['rfbwp_fb_margin_top'];
	$margin_left = $options['books'][$id]['rfbwp_fb_margin_left'];
	$margin_right = $options['books'][$id]['rfbwp_fb_margin_right'];
	$margin_bottom = $options['books'][$id]['rfbwp_fb_margin_bottom'];

	/* Book Decoration */
	$border_color = $options['books'][$id]['rfbwp_fb_border_color']; /* border color */
	$border_size = $options['books'][$id]['rfbwp_fb_border_size']; /* size in pixels */
	$border_outline = ($options['books'][$id]['rfbwp_fb_border_size'] == 1)? true : false; /* outline around the pages*/
	$border_outline_color = $options['books'][$id]['rfbwp_fb_outline_color']; /* outline color*/
	$border_radius = $options['books'][$id]['rfbwp_fb_border_radius']; /* border radius */

	/* Page Shadow */
	$inner_page_shadows = ($options['books'][$id]['rfbwp_fb_inner_shadows'] == 1)? true : false; /* shadow displayed on the page, over the page content */
	$page_edge = ($options['books'][$id]['rfbwp_fb_edge_outline'] == 1)? true : false;	/* at the end of each page there is a dark outline that gives the book a 3d look, here you can turn it off */

	/* Zoom Settings */
	$zoom_overlay = ($options['books'][$id]['rfbwp_fb_zoom_overlay'] == 1)? true : false; /* overlay displayed in zoom panel on top of the page */
	$zoom_overlay_opacity = $options['books'][$id]['rfbwp_fb_zoom_overlay_opacity']; /* opacity of the overlay */
	$zoom_border_size = $options['books'][$id]['rfbwp_fb_zoom_border_size']; /* zoom panel border size */
	$zoom_border_color = $options['books'][$id]['rfbwp_fb_zoom_border_color']; /* zoom panel border color */
	$zoom_outline = ($options['books'][$id]['rfbwp_fb_zoom_outline'] == 1)? true : false; /* zoom panel outline */
	$zoom_outline_color = $options['books'][$id]['rfbwp_fb_zoom_outline_color']; /* zoom panel outline color */
	$zoom_border_radius = $options['books'][$id]['rfbwp_fb_zoom_border_radius']; /* zoom panel border radius */

	/* Show All Pages */
	$sa_thumb_width = $options['books'][$id]['rfbwp_fb_sa_thumb_width']; /* show all pages panel, page thumbnail width */
	$sa_thumb_height = $options['books'][$id]['rfbwp_fb_sa_thumb_height']; /* show all pages page panel, thumbnail height */
	$sa_thumb_border_size = $options['books'][$id]['rfbwp_fb_sa_thumb_border_size']; /* show all pages panel, thumbanil border size */
	$sa_thumb_border_color = $options['books'][$id]['rfbwp_fb_sa_thumb_border_color']; /* show all pages panel, thumbanil border color  */
	$sa_padding_vertical = $options['books'][$id]['rfbwp_fb_sa_vertical_padding']; /* show all pages panel thumbnails vertical spacing */
	$sa_padding_horizontal = $options['books'][$id]['rfbwp_fb_sa_horizontal_padding']; /* show all pages panel thumbnails horizontal spacing */
	$sa_border_size = $options['books'][$id]['rfbwp_fb_sa_border_size']; /* show all pages panel border size */
	$sa_border_radius = $options['books'][$id]['rfbwp_fb_sa_border_radius']; /* show all pages panel border radius */
	$sa_bg_color = $options['books'][$id]['rfbwp_fb_sa_border_color']; /* show all pages panel background color */
	$sa_border_outline = ($options['books'][$id]['rfbwp_fb_sa_outline'] == 1)? true : false; /* show all pages panel outline */
	$sa_border_outline_color = $options['books'][$id]['rfbwp_fb_sa_outline_color']; /* show all pages panel outline color */

	$arrows = ($options['books'][$id]['rfbwp_fb_nav_arrows'] == 1)? true : false;

	/* End of Settings - DO NOT EDIT bellow this line! */

	$fb_id = "#".$fb_id;
	$fb_cont = "#".$fb_cont;

	?>
	<style type="text/css">
		<?php echo $fb_id; ?> {
			margin-top: <?php echo $margin_top; ?>px;
			margin-bottom: <?php echo $margin_bottom; ?>px;
			margin-left: <?php echo $margin_left; ?>px;
			margin-right: <?php echo $margin_right; ?>px;

			width: <?php echo (($fb_width * 2) + ($border_size * 2)); ?>px;
			height: <?php echo (($fb_height) + ($border_size * 2)); ?>px;
		}

		<?php echo $fb_id; ?> div.fb-page div.page-content {
			margin: <?php echo $border_size;?>px 0px;
		}

		<?php echo $fb_id; ?> .turn-page {
			width: <?php echo ($fb_width + ($border_size)); ?>px;
			height: <?php echo ($fb_height + ($border_size * 2)); ?>px;
			background: <?php echo $border_color; ?>;
			border-top-right-radius: <?php echo $border_radius; ?>px;
			border-bottom-right-radius: <?php echo $border_radius; ?>px;
			<?php if($border_outline) ?>
				box-shadow: inset -1px 0px 1px 0px <?php echo $border_outline_color; ?>;

		}

		<?php echo $fb_id; ?> .last .turn-page,
		<?php echo $fb_id; ?> .even .turn-page {
			border-radius: 0px;
			border-top-left-radius: <?php echo $border_radius; ?>px;
			border-bottom-left-radius: <?php echo $border_radius; ?>px;
			<?php if($border_outline) ?>
				box-shadow: inset 1px 0px 1px 0px <?php echo $border_outline_color; ?>;
		}

		<?php echo $fb_id; ?> .fpage .turn-page {
			border-radius: 0px;
			border-top-left-radius: <?php echo $border_radius; ?>px;
			border-bottom-left-radius: <?php echo $border_radius; ?>px;
			<?php if($border_outline) ?>
				box-shadow: inset 1px 0px 1px 0px  <?php echo $border_outline_color; ?>;
		}

		<?php echo $fb_id; ?> .last .fpage .turn-page,
		<?php echo $fb_id; ?> .even .fpage .turn-page {
			border-radius: 0px;
			border-top-right-radius: <?php echo $border_radius; ?>px;
			border-bottom-right-radius: <?php echo $border_radius; ?>px;
			<?php if($border_outline) ?>
				box-shadow: inset -1px 0px 1px 0px <?php echo $border_outline_color; ?>;
		}

		<?php echo $fb_cont; ?> div.page-content div.container img.bg-img {
			margin-top: 10px;
			margin-left: 0px;
		}

		<?php echo $fb_cont; ?> div.double div.page-content div.container img.bg-img {
			margin-top: 0px;
		}

		<?php echo $fb_cont; ?> div.page-content.first div.container img.bg-img {
			margin-top: <?php echo $border_size; ?>px;
		}

		<?php echo $fb_cont; ?> div.page-content.even div.container img.bg-img {
			left: 10px;
		}

		<?php echo $fb_cont; ?> div.double div.page-content.even div.container img.bg-img {
			left: 0px;
		}

		<?php echo $fb_cont; ?> div.page-content.last div.container img.bg-img {
			left: <?php echo $border_size; ?>px;
			margin-top: <?php echo $border_size; ?>px;
		}

		<?php echo $fb_id; ?> div.page-transition.last div.page-content,
		<?php echo $fb_id; ?> div.page-transition.even div.page-content,
		<?php echo $fb_id; ?> div.turn-page-wrapper.odd div.page-content {
			margin-left: 0px;
			margin-right: <?php echo ($border_size);?>px;
		}

		<?php echo $fb_id; ?> div.turn-page-wrapper.first div.page-content {
			margin-right: <?php echo ($border_size);?>px;
			margin-left: 0px;
		}

		<?php echo $fb_id; ?> div.page-transition.first div.page-content,
		<?php echo $fb_id; ?> div.page-transition.odd div.page-content,
		<?php echo $fb_id; ?> div.turn-page-wrapper.even div.page-content,
		<?php echo $fb_id; ?> div.turn-page-wrapper.last div.page-content {
			margin-left: <?php echo ($border_size);?>px;
		}

		<?php echo $fb_id; ?> div.fb-page-edge-shadow-left,
		<?php echo $fb_id; ?> div.fb-page-edge-shadow-right,
		<?php echo $fb_id; ?> div.fb-inside-shadow-left,
		<?php echo $fb_id; ?> div.fb-inside-shadow-right {
			top: <?php echo ($border_size);?>px;
			height: <?php echo $fb_height; ?>px;
		}

		<?php echo $fb_id; ?> div.fb-page-edge-shadow-left {
			left: <?php echo ($border_size);?>px;
		}

		<?php echo $fb_id; ?> div.fb-page-edge-shadow-right {
			right: <?php echo ($border_size);?>px;
		}

		/* Arrows */
		<?php if(!$arrows) { ?>
			<?php echo $fb_cont; ?> div.preview,
			<?php echo $fb_cont; ?> div.next {
				display: none;
			}
		<?php } ?>

		/* Zoom */
		<?php if(!$zoom_overlay) { ?>
			<?php echo $fb_cont; ?> div.zoomed-shadow {
				display: none;
			}
		<?php } ?>

		<?php echo $fb_cont; ?> div.zoomed-shadow {
			opacity: <?php echo $zoom_overlay_opacity;?>;
		}

		<?php echo $fb_cont; ?> div.zoomed {
			border: <?php echo $zoom_border_size; ?>px solid <?php echo $zoom_border_color;?>;
			border-radius: <?php echo $zoom_border_radius; ?>px;
			<?php if($zoom_outline) { ?>
				box-shadow: 0px 0px 0px 1px <?php echo $zoom_outline_color; ?>;
			<?php } else { ?>
				box-shadow: 0px 0px 0px 0px <?php echo $zoom_outline_color; ?>;
			<?php } ?>
		}

		/* Show All Pages */
		<?php echo $fb_cont; ?> div.show-all div.show-all-thumb {
			margin-bottom: <?php echo $sa_padding_vertical;?>px;
			height: <?php echo $sa_thumb_height;?>px;
			width: <?php echo $sa_thumb_width;?>px;
			border: <?php echo $sa_thumb_border_size;?>px solid <?php echo $sa_thumb_border_color;?>;
		}

		<?php echo $fb_cont; ?> div.show-all div.show-all-thumb.odd {
			margin-right: <?php echo $sa_padding_horizontal;?>px;
			border-left: none;
		}

		<?php echo $fb_cont; ?> div.show-all div.show-all-thumb.odd img.bg-img {
			padding-left: 0px;
		}

		<?php echo $fb_cont; ?> div.show-all div.show-all-thumb.odd.double img.bg-img {
			padding-left: <?php echo ($sa_thumb_width * 2);?>px;
		}

		<?php echo $fb_cont; ?> div.show-all div.show-all-thumb.odd.first img.bg-img {
			padding-left: 0px;
		}

		<?php echo $fb_cont; ?> div.show-all div.show-all-thumb.even {
			border-right: none;
		}

		<?php echo $fb_cont; ?> div.show-all div.show-all-thumb.last-thumb {
			margin-right: 0px;
		}

		<?php echo $fb_cont; ?> div.show-all {
			background: <?php echo $sa_bg_color; ?>;
			border-radius: <?php echo $sa_border_radius; ?>px;
			<?php if($sa_border_outline) ?>
				border: 1px solid <?php echo $sa_border_outline_color; ?>;
		}

		<?php echo $fb_cont; ?> div.show-all div.content {
			top: <?php echo $sa_border_size; ?>px;
			left: <?php echo $sa_border_size; ?>px;
		}

		/* Inner Pages Shadows */
		<?php if(!$inner_page_shadows) { ?>
			<?php echo $fb_id; ?> div.fb-inside-shadow-right,
			<?php echo $fb_id; ?> div.fb-inside-shadow-left {
				display: none;
			}
		<?php } ?>

		<?php if(!$page_edge) { ?>
			<?php echo $fb_id; ?> div.fb-page-edge-shadow-left,
			<?php echo $fb_id; ?> div.fb-page-edge-shadow-right {
				display: none;
			}
		<?php } ?>
	</style>
<?php
}
?>