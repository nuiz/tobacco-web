<?php

/*-----------------------------------------------------------------------------------*/
/*	This is a setup file for Massive Panel
/*-----------------------------------------------------------------------------------*/

function mpcrf_options() {

	$shortname = "rfbwp";
	// Sidebar Array
	$sidebar_array = array("left" => "Left", "right" => "Right", "none" => "None");
	$template_root = MP_ROOT;
  //  str_replace("localhost", "192.168.0.7", $template_root);

	// Socials Array
	$social_array = array(
		"email" => array("email.png", "email_hover.png", "Email us", "support@mpcreation.pl"),
		"dirbbble" => array("dribbble.png", "dribbble_hover.png", "Follow us on Dribbble", "http://dribbble.com/mpc"),
		"forrst" => array("forrst.png", "forrst_hover.png", "Follow us on Forrst", "http://forrst.com/people/mpc"),
		"facebook" => array("facebook.png", "facebook_hover.png", "Give us a like", "http://www.facebook.com/MassivePixelCreation"),
		"twitter" => array("twitter.png", "twitter_hover.png", "Follow us on Twitter", "http://twitter.com/mpcreation"),
		"blog" => array("website.png", "website_hover.png", "Visit our Blog", "http://www.blog.mpcreation.pl"),
		// "documentation" => array("documentation.png", "documentation_hover.png", "View Documentation", "http://www.mpcreation.pl/themeforest/documentation/flipbook-wp/"),
		"forums" => array("forums.png", "forums_hover.png", "Visit Support Forums", "http://www.support.mpcreation.pl"));

	//number of footer columns
	$number_of_columns = array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5');

	// this array is used for images example (first attribute of the image is used as a description for the image, the second is the path
	$images_array = array("Patern 1" => "patterns/p1.png",
		"Pattern 2" => "patterns/p2.png",
		"Pattern 3" => "patterns/p3.png",
		"Pattern 4" => "patterns/p4.png",
		"Pattern 5" => "patterns/p5.png",
		"Pattern 6" => "patterns/p6.png",
		"Pattern 7" => "patterns/p7.png",
		"Pattern 8" => "patterns/p8.png",
		"Pattern 9" => "patterns/p9.png",
		"Pattern 10" => "patterns/p10.png",
		"Pattern 11" => "patterns/p11.jpg",
		"No Pattern" => "patterns/p12.png");

	// This array is only used as an example
	$test_array = array("one" => "One", "two" => "Two", "three" => "Three", "four" => "Four", "five" => "Five");
	$lbox_or_link_array = array("lightbox" => "Lightbox","post_link" => "Link to Post");

	// this array is used for the portfolio module
	$columns_array = array("1" => "1", "2" => "2", "3" => "3", "4" => "4");

	// Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}

	// Pull all the portfolio categories into an array
	$portfolio_categories = array();
	// $portfolio_categories = $options_categories;
	$portfolio_categories_obj = get_categories(array(
					'taxonomy' => 'portfolio_cat',
					'hide_empty' => 0
					 ));

	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}

	// Options for single page - Portfolio and Blog
	$options_single = array("blog" => "Blog", "portfolio" => "Portfolio");


	// Pull all the pages that are type protfolio
	$portfolio_pages = array();
	$portfolio_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$portfolio_pages[''] = 'Select a page:';
	foreach ($portfolio_pages_obj as $page) {
		if(get_post_meta( $page->ID, '_wp_page_template', true) == "portfolio.php") // nazwe default zmieniamy na nazwe template naprzyklad portfolio.php
			$portfolio_pages[$page->ID] = $page->post_title;
	}


	$options = array();

	// General section
	$options[] = array( "name" => "Flip Books", // When option is type section that mean that it will be displayed as button on the left
						"sub-name" => "All settings",
						"icon" => "star.png", // icon has to be placed in massive-panel/images/icons folder
						"icon-active" => "star-active.png",
						"type" => "section");

	$options[] = array( "name" => "Books", // Options of type heading represent tabs for sections
						"type" => "heading");

	$options[] = array( "name" => "Books",
						"type" => "books",
						"id" => $shortname."_books");

	$options[] = array( "name" => "Settings_0", // Options of type heading represent tabs for sections
						"type" => "heading",
						"sub" => "settings");

	$options[] = array( "name" => "Name", // this defines the heading of the option
						"desc" => "Book name: ", // this is the field/option description
						"desc-pos" => "top",
						"help" => "true", // should the help icon be displayed (not working yet, better add this to your settings)
						"help-desc"  => 'Flip book name is used to generate a unique shortcode for the book (NOTE: Please use only laters, numbers and spaces), width and height are used to specify books dimantions.', // text for the help tool tip
						"help-pos" => "bottom",
						"id"   => $shortname."_fb_name", // the id must be unique, it is used to call back the propertie inside the theme
						"std"  => "", // deafult value of the text
						"validation" => "nohtml", /* Each text field can be specialy validated, if the text wont be using HTML tags you can choose here 'nohtml' ect. Choose Between: numeric, multinumeric, nohtml, url, email or dont set it for standard  validation*/
						"type" => "text-medium",
						"toggle" => "begin",
						"toggle-name" => "Basic Settings");

	$options[] = array( "name" => "Page Width:", // this defines the heading of the option
						"desc" => "Page width:", // this is the field/option description
						"desc-pos" => "top",
						"id"   => $shortname."_fb_width", // the id must be unique, it is used to call back the propertie inside the them
						"std"  => "346", // deafult value of the text
						"validation" => "numeric", /* Each text field can be specialy validated, if the text wont be using HTML tags you can choose here 'nohtml' ect. Choose Between: numeric, multinumeric, nohtml, url, email or dont set it for standard  validation*/
						"type" => "text-small",
						"unit" => "px",
						"stack" => "begin");

	$options[] = array( "name" => "Book Height:", // this defines the heading of the option
						"desc" => "Page height:", // this is the field/option description
						"desc-pos" => "top",
						"id"   => $shortname."_fb_height", // the id must be unique, it is used to call back the propertie inside the them
						"std"  => "490", // deafult value of the text
						"validation" => "numeric", /* Each text field can be specialy validated, if the text wont be using HTML tags you can choose here 'nohtml' ect. Choose Between: numeric, multinumeric, nohtml, url, email or dont set it for standard  validation*/
						"type" => "text-small",
						"unit" => "px",
						"stack" => "end",
						"toggle" => "end");

	$options[] = array( "name" => "Book Top Margin", // this defines the heading of the option
						"desc" => "", // this is the field/option description
						"desc-pos" => "top",
						"id"   => $shortname."_fb_margin_top", // the id must be unique, it is used to call back the propertie inside the them
						"std"  => "20", // deafult value of the text
						"validation" => "numeric", /* Each text field can be specialy validated, if the text wont be using HTML tags you can choose here 'nohtml' ect. Choose Between: numeric, multinumeric, nohtml, url, email or dont set it for standard  validation*/
						"type" => "text-small",
						"help" => "true", // should the help icon be displayed (not working yet, better add this to your settings)
						"help-desc"  => 'Here you can specify margins of the book.', // text for the help tool tip
						"help-pos" => "top",
						"unit" => "px",
						"stack" => "begin",
						"toggle" => "begin",
						"toggle-name" => "Book Margins");

	$options[] = array( "name" => "Book Bottom Margin", // this defines the heading of the option
						"desc" => "", // this is the field/option description
						"desc-pos" => "top",
						"id"   => $shortname."_fb_margin_bottom", // the id must be unique, it is used to call back the propertie inside the them
						"std"  => "0", // deafult value of the text
						"validation" => "numeric", /* Each text field can be specialy validated, if the text wont be using HTML tags you can choose here 'nohtml' ect. Choose Between: numeric, multinumeric, nohtml, url, email or dont set it for standard  validation*/
						"unit" => "px",
						"type" => "text-small");

	$options[] = array( "name" => "Book Left Margin", // this defines the heading of the option
						"desc" => "", // this is the field/option description
						"desc-pos" => "top",
						"id"   => $shortname."_fb_margin_left", // the id must be unique, it is used to call back the propertie inside the them
						"std"  => "0", // deafult value of the text
						"validation" => "numeric", /* Each text field can be specialy validated, if the text wont be using HTML tags you can choose here 'nohtml' ect. Choose Between: numeric, multinumeric, nohtml, url, email or dont set it for standard  validation*/
						"unit" => "px",
						"type" => "text-small");

	$options[] = array( "name" => "Book Right Margin", // this defines the heading of the option
						"desc" => "", // this is the field/option description
						"desc-pos" => "top",
						"id"   => $shortname."_fb_margin_right", // the id must be unique, it is used to call back the propertie inside the them
						"std"  => "0", // deafult value of the text
						"validation" => "numeric", /* Each text field can be specialy validated, if the text wont be using HTML tags you can choose here 'nohtml' ect. Choose Between: numeric, multinumeric, nohtml, url, email or dont set it for standard  validation*/
						"type" => "text-small",
						"unit" => "px",
						"stack" => "end",
						"toggle" => "end");

	/*-----------------------------------------------------------------------------------*/
	/*	Book Decoration
	/*-----------------------------------------------------------------------------------*/

	$options[] = array( "name" => "Border size", // this defines the heading of the option
						"desc" => "Border size:", // this is the field/option description
						"desc-pos" => "top",
						"id"   => $shortname."_fb_border_size", // the id must be unique, it is used to call back the propertie inside the them
						"std"  => "10", // deafult value of the text
						"validation" => "numeric", /* Each text field can be specialy validated, if the text wont be using HTML tags you can choose here 'nohtml' ect. Choose Between: numeric, multinumeric, nohtml, url, email or dont set it for standard  validation*/
						"type" => "text-small",
						"unit" => "px",
						"help" => "true", // should the help icon be displayed (not working yet, better add this to your settings)
						"help-desc"  => 'Setup books border, it\'s color and radius.', // text for the help tool tip
						"help-pos" => "top",
						"stack" => "begin",
						"toggle" => "begin",
						"toggle-name" => "Decorations");

	$options[] = array( "name" => "Border color:",
						"desc" => "Border color: ",
						"desc-pos" => "top",
						"id" => $shortname."_fb_border_color",
						"std" => "#ECECEC",
						"type" => "color");

	$options[] = array( "name" => "Book Border Radius", // this defines the heading of the option
						"desc" => "Border radius: ", // this is the field/option description
						"desc-pos" => "top",
						"id"   => $shortname."_fb_border_radius", // the id must be unique, it is used to call back the propertie inside the them
						"std"  => "10", // deafult value of the text
						"validation" => "numeric", /* Each text field can be specialy validated, if the text wont be using HTML tags you can choose here 'nohtml' ect. Choose Between: numeric, multinumeric, nohtml, url, email or dont set it for standard  validation*/
						"unit" => "px",
						"type" => "text-small",
						"stack" => "end");

	$options[] = array( "name" => "Book Outline",
						"desc" => "Book outline: ",
						"desc-pos" => "top",
						"id" => $shortname."_fb_outline",
						"std" => "1",
						"type" => "checkbox",
						"help" => "true", // should the help icon be displayed (not working yet, better add this to your settings)
						"help-desc"  => 'Setup books outline - it is 1 pixel line that is displayed outside the border.', // text for the help tool tip
						"help-pos" => "top",
						"stack" => "begin");

	$options[] = array( "name" => "Outline Color",
						"desc" => "Outline color:",
						"desc-pos" => "top",
						"id" => $shortname."_fb_outline_color",
						"std" => "#BFBFBF",
						"type" => "color",
						"stack" => "end");

	$options[] = array( "name" => "Book Inner Page Shadows",
						"desc" => "Inner page shadow",
						"desc-pos" => "top",
						"id" => $shortname."_fb_inner_shadows",
						"std" => "1",
						"help" => "true", // should the help icon be displayed (not working yet, better add this to your settings)
						"help-desc"  => 'Enable/Disable books inner shadow', // text for the help tool tip
						"help-pos" => "top",
						"type" => "checkbox");

	$options[] = array( "name" => "Book Edge Page Outline",
						"desc" => "Edge page outline",
						"desc-pos" => "top",
						"id" => $shortname."_fb_edge_outline",
						"std" => "1",
						"help" => "true", // should the help icon be displayed (not working yet, better add this to your settings)
						"help-desc"  => 'Enable/Disable page edge outline - it is used to create 3D like feeling. If you don\'t have border around your book I suggest disabling this feature.', // text for the help tool tip
						"help-pos" => "top",
						"type" => "checkbox",
						"toggle" => "end");

	/*-----------------------------------------------------------------------------------*/
	/*	Zoom Settings
	/*-----------------------------------------------------------------------------------*/

	$options[] = array( "name" => "Zoom Overlay",
						"desc" => "Overlay",
						"desc-pos" => "top",
						"id" => $shortname."_fb_zoom_overlay",
						"std" => "1",
						"type" => "checkbox",
						"help" => "true", // should the help icon be displayed (not working yet, better add this to your settings)
						"help-desc"  => 'When this feature is enabled there will be slight dark overlay on the corners of the zoomed page.', // text for the help tool tip
						"help-pos" => "top",
						"stack" => "begin",
						"toggle" => "begin",
						"toggle-name" => "Zoom Settings");

	$options[] = array( "name" => "Zoom Overlay Opacity", // this defines the heading of the option
						"desc" => "Overlay opacity: ", // this is the field/option description
						"desc-pos" => "top",
						"id"   => $shortname."_fb_zoom_overlay_opacity", // the id must be unique, it is used to call back the propertie inside the them
						"std"  => "0.2", // deafult value of the text
						"validation" => "numeric", /* Each text field can be specialy validated, if the text wont be using HTML tags you can choose here 'nohtml' ect. Choose Between: numeric, multinumeric, nohtml, url, email or dont set it for standard  validation*/
						"type" => "text-small",
						"stack" => "end");

	$options[] = array( "name" => "Zoom Border Size", // this defines the heading of the option
						"desc" => "Border size: ", // this is the field/option description
						"desc-pos" => "top",
						"id"   => $shortname."_fb_zoom_border_size", // the id must be unique, it is used to call back the propertie inside the them
						"std"  => "10", // deafult value of the text
						"validation" => "numeric", /* Each text field can be specialy validated, if the text wont be using HTML tags you can choose here 'nohtml' ect. Choose Between: numeric, multinumeric, nohtml, url, email or dont set it for standard  validation*/
						"type" => "text-small",
						"unit" => "px",
						"help" => "true", // should the help icon be displayed (not working yet, better add this to your settings)
						"help-desc"  => 'Specify parameters for the border that is displayed around the zoomed page.', // text for the help tool tip
						"help-pos" => "top",
						"stack" => "begin");

	$options[] = array( "name" => "Zoom Border Color",
						"desc" => "Border color:",
						"desc-pos" => "top",
						"id" => $shortname."_fb_zoom_border_color",
						"std" => "#ECECEC",
						"type" => "color");


	$options[] = array( "name" => "Zoom Border Radius", // this defines the heading of the option
						"desc" => "Border radius:", // this is the field/option description
						"desc-pos" => "top",
						"id"   => $shortname."_fb_zoom_border_radius", // the id must be unique, it is used to call back the propertie inside the them
						"std"  => "10", // deafult value of the text
						"validation" => "numeric", /* Each text field can be specialy validated, if the text wont be using HTML tags you can choose here 'nohtml' ect. Choose Between: numeric, multinumeric, nohtml, url, email or dont set it for standard  validation*/
						"type" => "text-small",
						"unit" => "px",
						"stack" => "end");

	$options[] = array( "name" => "Zoom Outline",
						"desc" => "Outline: ",
						"desc-pos" => "top",
						"id" => $shortname."_fb_zoom_outline",
						"std" => "1",
						"type" => "checkbox",
						"help" => "true", // should the help icon be displayed (not working yet, better add this to your settings)
						"help-desc"  => 'Enable/Disable zoom panel outline, specify it\'s color.', // text for the help tool tip
						"help-pos" => "top",
						"stack" => "begin");

	$options[] = array( "name" => "Zoom Outline Color",
						"desc" => "Outline color: ",
						"desc-pos" => "top",
						"id" => $shortname."_fb_zoom_outline_color",
						"std" => "#D0D0D0",
						"type" => "color",
						"stack" => "end",
						"toggle" => "end");

	/*-----------------------------------------------------------------------------------*/
	/*	Show All Pages
	/*-----------------------------------------------------------------------------------*/

	$options[] = array( "name" => "Thumbnail Width", // this defines the heading of the option
						"desc" => "Thumbnail width:", // this is the field/option description
						"desc-pos" => "top",
						"id"   => $shortname."_fb_sa_thumb_width", // the id must be unique, it is used to call back the propertie inside the them
						"std"  => "125", // deafult value of the text
						"validation" => "numeric", /* Each text field can be specialy validated, if the text wont be using HTML tags you can choose here 'nohtml' ect. Choose Between: numeric, multinumeric, nohtml, url, email or dont set it for standard  validation*/
						"type" => "text-small",
						"unit" => "px",
						"help" => "true", // should the help icon be displayed (not working yet, better add this to your settings)
						"help-desc"  => 'Show all pages panel contains thumbnails of each page, here you can specify width & height of those thumbnails.', // text for the help tool tip
						"help-pos" => "top",
						"stack" => "begin",
						"toggle" => "begin",
						"toggle-name" => "Show all pages settings");

	$options[] = array( "name" => "Thumbnail Height", // this defines the heading of the option
						"desc" => "Thumbnail height:", // this is the field/option description
						"desc-pos" => "top",
						"id"   => $shortname."_fb_sa_thumb_height", // the id must be unique, it is used to call back the propertie inside the them
						"std"  => "180", // deafult value of the text
						"validation" => "numeric", /* Each text field can be specialy validated, if the text wont be using HTML tags you can choose here 'nohtml' ect. Choose Between: numeric, multinumeric, nohtml, url, email or dont set it for standard  validation*/
						"unit" => "px",
						"type" => "text-small",
						"stack" => "end");

	$options[] = array( "name" => "Thumbnail Border Size", // this defines the heading of the option
						"desc" => "Thumbnail border size:", // this is the field/option description
						"desc-pos" => "top",
						"id"   => $shortname."_fb_sa_thumb_border_size", // the id must be unique, it is used to call back the propertie inside the them
						"std"  => "1", // deafult value of the text
						"validation" => "numeric", /* Each text field can be specialy validated, if the text wont be using HTML tags you can choose here 'nohtml' ect. Choose Between: numeric, multinumeric, nohtml, url, email or dont set it for standard  validation*/
						"type" => "text-small",
						"unit" => "px",
						"help" => "true", // should the help icon be displayed (not working yet, better add this to your settings)
						"help-desc"  => 'Specify thumbnails border parameters: size and color.', // text for the help tool tip
						"help-pos" => "top",
						"stack" => "begin");

	$options[] = array( "name" => "Thumbnail Border Color",
						"desc" => "Border color:",
						"desc-pos" => "top",
						"id" => $shortname."_fb_sa_thumb_border_color",
						"std" => "#878787",
						"type" => "color",
						"stack" => "end");

	$options[] = array( "name" => "Vertical Padding", // this defines the heading of the option
						"desc" => "Vertical padding: ", // this is the field/option description
						"desc-pos" => "top",
						"id"   => $shortname."_fb_sa_vertical_padding", // the id must be unique, it is used to call back the propertie inside the them
						"std"  => "12", // deafult value of the text
						"validation" => "numeric", /* Each text field can be specialy validated, if the text wont be using HTML tags you can choose here 'nohtml' ect. Choose Between: numeric, multinumeric, nohtml, url, email or dont set it for standard  validation*/
						"type" => "text-small",
						"unit" => "px",
						"help" => "true", // should the help icon be displayed (not working yet, better add this to your settings)
						"help-desc"  => 'Specify thumbnails vertical and horizontal padding.', // text for the help tool tip
						"help-pos" => "top",
						"stack" => "begin");

	$options[] = array( "name" => "Horizontal Padding", // this defines the heading of the option
						"desc" => "Horizontal padding:", // this is the field/option description
						"desc-pos" => "top",
						"id"   => $shortname."_fb_sa_horizontal_padding", // the id must be unique, it is used to call back the propertie inside the them
						"std"  => "10", // deafult value of the text
						"validation" => "numeric", /* Each text field can be specialy validated, if the text wont be using HTML tags you can choose here 'nohtml' ect. Choose Between: numeric, multinumeric, nohtml, url, email or dont set it for standard  validation*/
						"type" => "text-small",
						"unit" => "px",
						"stack" => "end");


	$options[] = array( "name" => "Panel Border Size", // this defines the heading of the option
						"desc" => "Border size:", // this is the field/option description
						"desc-pos" => "top",
						"id"   => $shortname."_fb_sa_border_size", // the id must be unique, it is used to call back the propertie inside the them
						"std"  => "10", // deafult value of the text
						"validation" => "numeric", /* Each text field can be specialy validated, if the text wont be using HTML tags you can choose here 'nohtml' ect. Choose Between: numeric, multinumeric, nohtml, url, email or dont set it for standard  validation*/
						"type" => "text-small",
						"unit" => "px",
						"help" => "true", // should the help icon be displayed (not working yet, better add this to your settings)
						"help-desc"  => 'Specify parameters for the show all pages panel border. This border is displayed around all of the thumbnails.', // text for the help tool tip
						"help-pos" => "top",
						"stack" => "begin");

	$options[] = array( "name" => "Panel Border Color",
						"desc" => "Border color:",
						"desc-pos" => "top",
						"id" => $shortname."_fb_sa_border_color",
						"std" => "#F6F6F6",
						"type" => "color");


	$options[] = array( "name" => "Panel Border Radius", // this defines the heading of the option
						"desc" => "Border radius:", // this is the field/option description
						"desc-pos" => "top",
						"id"   => $shortname."_fb_sa_border_radius", // the id must be unique, it is used to call back the propertie inside the them
						"std"  => "10", // deafult value of the text
						"validation" => "numeric", /* Each text field can be specialy validated, if the text wont be using HTML tags you can choose here 'nohtml' ect. Choose Between: numeric, multinumeric, nohtml, url, email or dont set it for standard  validation*/
						"type" => "text-small",
						"unit" => "px",
						"stack" => "end");

	$options[] = array( "name" => "Panel Outline",
						"desc" => "Panel outline: ",
						"desc-pos" => "top",
						"id" => $shortname."_fb_sa_outline",
						"std" => "1",
						"type" => "checkbox",
						"help" => "true", // should the help icon be displayed (not working yet, better add this to your settings)
						"help-desc"  => 'Specify show all pages panel outline - outline is a 1px line displayed around the border.', // text for the help tool tip
						"help-pos" => "top",
						"stack" => "begin");

	$options[] = array( "name" => "Panel Outline Color",
						"desc" => "Outline color:",
						"desc-pos" => "top",
						"id" => $shortname."_fb_sa_outline_color",
						"std" => "#D6D6D6",
						"type" => "color",
						"stack" => "end",
						"toggle" => "end");

	/*-----------------------------------------------------------------------------------*/
	/*	Navigation Settings
	/*-----------------------------------------------------------------------------------*/

	$options[] = array( "name" => "Menu type", // this defines the heading of the option
						"desc" => "Menu type:", // this is the field/option description
						"desc-pos" => "top",
						"id"   => $shortname."_fb_nav_menu_type", // the id must be unique, it is used to call back the propertie inside the them
						"std"  => "1", // deafult value of the text
						"type" => "select",
						"options" => array("Stacked" => "Stacked", "Spread" => "Spread"),
						"help" => "true", // should the help icon be displayed (not working yet, better add this to your settings)
						"help-desc"  => 'Specify menu type:</br> - stacked - menu items are stacked together, </br> - spread - menu items are spread apart.', // text for the help tool tip
						"help-pos" => "top",
						"toggle" => "begin",
						"toggle-name" => "Navigation Settings");

	$options[] = array( "name" => "Table of Content", // this defines the heading of the option
						"desc" => "Table of content:", // this is the field/option description
						"desc-pos" => "top",
						"id"   => $shortname."_fb_nav_toc", // the id must be unique, it is used to call back the propertie inside the them
						"type" => "checkbox",
						"std" => "1",
						"help" => "true", // should the help icon be displayed (not working yet, better add this to your settings)
						"help-desc"  => 'Enable/Disable Table of Content button, specify it\'s menu order and page index (index of a page which contains table of content).', // text for the help tool tip
						"help-pos" => "top",
						"stack" => "begin");

	$options[] = array( "name" => "Menu Order", // this defines the heading of the option
						"desc" => "Menu order:", // this is the field/option description
						"desc-pos" => "top",
						"id"   => $shortname."_fb_nav_toc_order", // the id must be unique, it is used to call back the propertie inside the them
						"std"  => "1", // deafult value of the text
						"validation" => "numeric", /* Each text field can be specialy validated, if the text wont be using HTML tags you can choose here 'nohtml' ect. Choose Between: numeric, multinumeric, nohtml, url, email or dont set it for standard  validation*/
						"type" => "text-small");

	$options[] = array( "name" => "Page Index", // this defines the heading of the option
						"desc" => "Page index:", // this is the field/option description
						"desc-pos" => "top",
						"id"   => $shortname."_fb_nav_toc_index", // the id must be unique, it is used to call back the propertie inside the them
						"std"  => "2", // deafult value of the text
						"validation" => "numeric", /* Each text field can be specialy validated, if the text wont be using HTML tags you can choose here 'nohtml' ect. Choose Between: numeric, multinumeric, nohtml, url, email or dont set it for standard  validation*/
						"type" => "text-small",
						"stack" => "end");

	$options[] = array( "name" => "Zoom", // this defines the heading of the option
						"desc" => "Zoom:", // this is the field/option description
						"desc-pos" => "top",
						"id"   => $shortname."_fb_nav_zoom", // the id must be unique, it is used to call back the propertie inside the them
						"type" => "checkbox",
						"std" => "1",
						"help" => "true", // should the help icon be displayed (not working yet, better add this to your settings)
						"help-desc"  => 'Enable/Disable Zoom feature, specify zoom button menu order.', // text for the help tool tip
						"help-pos" => "top",
						"stack" => "begin");

	$options[] = array( "name" => "Menu Order", // this defines the heading of the option
						"desc" => "Menu order:", // this is the field/option description
						"desc-pos" => "top",
						"id"   => $shortname."_fb_nav_zoom_order", // the id must be unique, it is used to call back the propertie inside the them
						"std"  => "2", // deafult value of the text
						"validation" => "numeric", /* Each text field can be specialy validated, if the text wont be using HTML tags you can choose here 'nohtml' ect. Choose Between: numeric, multinumeric, nohtml, url, email or dont set it for standard  validation*/
						"type" => "text-small",
						"stack" => "end");

	$options[] = array( "name" => "Slide show", // this defines the heading of the option
						"desc" => "Slide show:", // this is the field/option description
						"desc-pos" => "top",
						"id"   => $shortname."_fb_nav_ss", // the id must be unique, it is used to call back the propertie inside the them
						"type" => "checkbox",
						"std" => "1",
						"help" => "true", // should the help icon be displayed (not working yet, better add this to your settings)
						"help-desc"  => 'Enable/Disable slide show feature, specify slide show button menu order.', // text for the help tool tip
						"help-pos" => "top",
						"stack" => "begin");

	$options[] = array( "name" => "Menu Order", // this defines the heading of the option
						"desc" => "Menu order:", // this is the field/option description
						"desc-pos" => "top",
						"id"   => $shortname."_fb_nav_ss_order", // the id must be unique, it is used to call back the propertie inside the them
						"std"  => "3", // deafult value of the text
						"validation" => "numeric", /* Each text field can be specialy validated, if the text wont be using HTML tags you can choose here 'nohtml' ect. Choose Between: numeric, multinumeric, nohtml, url, email or dont set it for standard  validation*/
						"type" => "text-small",
						"stack" => "end");

	$options[] = array( "name" => "Show all pages", // this defines the heading of the option
						"desc" => "Show all pages:", // this is the field/option description
						"desc-pos" => "top",
						"id"   => $shortname."_fb_nav_sap", // the id must be unique, it is used to call back the propertie inside the them
						"type" => "checkbox",
						"std" => "1",
						"help" => "true", // should the help icon be displayed (not working yet, better add this to your settings)
						"help-desc"  => 'Enable/Disable show all pages feature, specify show all pages button menu order.', // text for the help tool tip
						"help-pos" => "top",
						"stack" => "begin");

	$options[] = array( "name" => "Menu Order", // this defines the heading of the option
						"desc" => "Menu order:", // this is the field/option description
						"desc-pos" => "top",
						"id"   => $shortname."_fb_nav_sap_order", // the id must be unique, it is used to call back the propertie inside the them
						"std"  => "4", // deafult value of the text
						"validation" => "numeric", /* Each text field can be specialy validated, if the text wont be using HTML tags you can choose here 'nohtml' ect. Choose Between: numeric, multinumeric, nohtml, url, email or dont set it for standard  validation*/
						"type" => "text-small",

						"stack" => "end");

	$options[] = array( "name" => "Fullscreen", // this defines the heading of the option
						"desc" => "Fullscreen:", // this is the field/option description
						"desc-pos" => "top",
						"id"   => $shortname."_fb_nav_fs", // the id must be unique, it is used to call back the propertie inside the them
						"type" => "checkbox",
						"std" => "1",
						"help" => "true", // should the help icon be displayed (not working yet, better add this to your settings)
						"help-desc"  => 'Enable/Disable Fullscreen feature, specify fullscreen button menu order.', // text for the help tool tip
						"help-pos" => "top",
						"stack" => "begin");

	$options[] = array( "name" => "Menu Order", // this defines the heading of the option
						"desc" => "Menu order:", // this is the field/option description
						"desc-pos" => "top",
						"id"   => $shortname."_fb_nav_fs_order", // the id must be unique, it is used to call back the propertie inside the them
						"std"  => "5", // deafult value of the text
						"validation" => "numeric", /* Each text field can be specialy validated, if the text wont be using HTML tags you can choose here 'nohtml' ect. Choose Between: numeric, multinumeric, nohtml, url, email or dont set it for standard  validation*/
						"type" => "text-small",
						"stack" => "end");

	$options[] = array( "name" => "Next/Previous arrows", // this defines the heading of the option
						"desc" => "Next/Previous arrows:", // this is the field/option description
						"desc-pos" => "top",
						"id"   => $shortname."_fb_nav_arrows", // the id must be unique, it is used to call back the propertie inside the them
						"type" => "checkbox",
						"std" => "1",
						"help" => "true", // should the help icon be displayed (not working yet, better add this to your settings)
						"help-desc"  => 'Enable/Disable Next/Previous arrow buttons.', // text for the help tool tip
						"help-pos" => "top",
						"toggle" => "end");




	/*-----------------------------------------------------------------------------------*/
	/*	Books Pages
	/*-----------------------------------------------------------------------------------*/

	$options[] = array( "name" => "Pages_0", // Options of type heading represent tabs for sections
						"type" => "heading",
						"sub" => "pages");

	$options[] = array( "name" => "Pages",
						"type" => "pages",
						"id" => $shortname."_pages");

	$options[] = array( "name" => "Page_0", // Options of type heading represent tabs for sections
						"type" => "separator",
						"id" => $shortname."_page_separator",
						"sub" => "pages");

	$options[] = array( "name" => "Page Type", // this defines the heading of the option
						"desc" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit.", // this is the field/option description
						"id"   => $shortname."_fb_page_type", // the id must be unique, it is used to call back the propertie inside the them
						"class" => $shortname."-page-type",
						"std"  => "", // deafult value of the text
						"options" => array("Single Page" => "Single Page", "Double Page" => "Double Page"), /* Each text field can be specialy validated, if the text wont be using HTML tags you can choose here 'nohtml' ect. Choose Between: numeric, multinumeric, nohtml, url, email or dont set it for standard  validation*/
						"help" => "false", // should the help icon be displayed (not working yet, better add this to your settings)
						"help-desc"  => "Select page type:</br> - single - normal single page (left or right), </br> - double - one image displayed across both pages (left and right). ", // text for the help tool tip
						"stack" => "begin",
						"type" => "select");


	$options[] = array( "name" => "Page Preview", // this defines the heading of the option
						"id"   => $shortname."_fb_page_preview", // the id must be unique, it is used to call back the propertie inside the them
						"class" => $shortname."-page-preview",
						"help" => "true", // should the help icon be displayed (not working yet, better add this to your settings)
						"help-desc"  => "View page preview", // text for the help tool tip
						"stack" => "end",
						"color" => "grey",
						"icon" => "preview",
						"float" => "right", // default none
						"type" => "button");


	$options[] = array( "name" => "Background Image", // this defines the heading of the option
						"desc" => "Choose page background:", // this is the field/option description
						"id"   => $shortname."_fb_page_bg_image", // the id must be unique, it is used to call back the propertie inside the them
						"help" => "true", // should the help icon be displayed (not working yet, better add this to your settings)
						"help-desc"  => "Specify pages background image.", // text for the help tool tip
						"class" => $shortname."-page-bg-image",
						"token" => $shortname."_0",
						"std"  => "", // deafult value of the text
						"stack" => "begin",
						"float"	=> "left",
						"validation" => "numeric", /* Each text field can be specialy validated, if the text wont be using HTML tags you can choose here 'nohtml' ect. Choose Between: numeric, multinumeric, nohtml, url, email or dont set it for standard  validation*/
						"type" => "upload");


	$options[] = array( "name" => "Background Image Zoom", // this defines the heading of the option
						"desc" => "Choose page hi-res background:", // this is the field/option description
						"id"   => $shortname."_fb_page_bg_image_zoom", // the id must be unique, it is used to call back the propertie inside the them
						"help" => "true", // should the help icon be displayed (not working yet, better add this to your settings)
						"help-desc"  => "Specify hi-res page background images, it is used by the zoom feature (optional).", // text for the help tool tip
						"class" => $shortname."-page-bg-image-zoom",
						"token" => $shortname."_0",
						"stack" => "end",
						"float" => "right",
						"std"  => "", // deafult value of the text
						"validation" => "", /* Each text field can be specialy validated, if the text wont be using HTML tags you can choose here 'nohtml' ect. Choose Between: numeric, multinumeric, nohtml, url, email or dont set it for standard  validation*/
						 "type" => "upload");

	$options[] = array( "name" => "Page Index", // this defines the heading of the option
						"desc" => "Page Index: ", // this is the field/option description
						"desc-pos" => "top",
						"id"   => $shortname."_fb_page_index", // the id must be unique, it is used to call back the propertie inside the them
						/* "class" => $shortname."-page-index", */
						"help" => "true", // should the help icon be displayed (not working yet, better add this to your settings)
						"help-desc"  => "Specify page index (better leave default value).", // text for the help tool tip
						"std"  => "", // deafult value of the text
						"validation" => "", /* Each text field can be specialy validated, if the text wont be using HTML tags you can choose here 'nohtml' ect. Choose Between: numeric, multinumeric, nohtml, url, email or dont set it for standard  validation*/
						"type" => "text-small");

	$options[] = array( "name" => "Page Custom Class", // this defines the heading of the option
						"desc" => "Page Custom Class: ", // this is the field/option description
						"desc-pos" => "top",
						"id"   => $shortname."_fb_page_custom_class", // the id must be unique, it is used to call back the propertie inside the them
						/* "class" => $shortname."-page-index", */
						"help" => "true", // should the help icon be displayed (not working yet, better add this to your settings)
						"help-desc"  => "Specify page custom class (NOTE: Use it in the Page CSS field to target current page).", // text for the help tool tip
						"std"  => "", // deafult value of the text
						"validation" => "", /* Each text field can be specialy validated, if the text wont be using HTML tags you can choose here 'nohtml' ect. Choose Between: numeric, multinumeric, nohtml, url, email or dont set it for standard  validation*/
						"type" => "text-medium");

	// $options[] = array( "name" => "", // this defines the heading of the option
	// 					"id"   => $shortname."_fb_page_video_sc", // the id must be unique, it is used to call back the propertie inside the them
	// 					"class" => $shortname."-page-video-sc",
	// 					"help" => "false", // should the help icon be displayed (not working yet, better add this to your settings)
	// 					"help-desc"  => "View page preview", // text for the help tool tip
	// 				/* 	"stack" => "end", */
	// 					"icon" => "video",
	// 					"color" => "grey",
	// 					"float" => "right", // default none
	// 					"type" => "button");

	$options[] = array( "name" => "Page CSS",
						"desc" => "Page CSS:",
						"desc-pos" => "top",
						"id" => $shortname."_page_css",
						"help" => "true",
						"help-desc"  => "Here you can specify the CSS which will be applied to the page.",
						"std" => "",
						"validation" => "",
						"type" => "textarea");

	$options[] = array( "name" => "", // this defines the heading of the option
						"id"   => $shortname."_fb_page_columns_sc", // the id must be unique, it is used to call back the propertie inside the them
						"class" => $shortname."-page-columns-sc",
						"help" => "false", // should the help icon be displayed (not working yet, better add this to your settings)
						"help-desc"  => "View page preview", // text for the help tool tip
					/* 	"stack" => "end", */
						"icon" => "columns",
						"color" => "grey",
						"float" => "right", // default none
						"type" => "button");

	$options[] = array( "name" => "HTML Content",
						"desc" => "HTML page content:",
						"desc-pos" => "top",
						"id" => $shortname."_page_html",
						"help-desc"  => "Here you can specify the HTML content which will be displayed on the page. To easily place content in two columns (for left and right pages) use the columns shortcode (button to the right).",
						"std" => "",
						"validation" => "",
						"type" => "textarea-big");


	$options[] = array( "name" => "Save Page", // this defines the heading of the option
						"id"   => $shortname."_fb_page_save", // the id must be unique, it is used to call back the propertie inside the them
						"class" => $shortname."-page-save",
						"help" => "false", // should the help icon be displayed (not working yet, better add this to your settings)
						"help-desc"  => "View page preview", // text for the help tool tip
					/* 	"stack" => "end", */
						"color" => "orange",
						"float" => "right", // default none
						"type" => "button");




	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



	/*
$options[] = array( "name" => "Assets", // When option is type section that mean that it will be displayed as button on the left
						"icon" => "layout.png", // icon has to be placed in massive-panel/images/icons folder
						"type" => "section");

	$options[] = array( "name" => "Asset Library", // Options of type heading represent tabs for sections
						"type" => "heading");

	$options[] = array( "name" => "",
						"desc" => "",
						"desc-pos" => "top",
						"id" => $shortname."_assets",
						"type" => "multi-upload",
						"std" => '');
*/


	/////////////////////////////////////////////

	$options[] = array( "name" => "Help", // When option is type section that mean that it will be displayed as button on the left
						"sub-name" => "Support",
						"icon" => "star.png", // icon has to be placed in massive-panel/images/icons folder
						"icon-active" => "star-active.png",
						"type" => "section");

	$options[] = array( "name" => "Help1", // Options of type heading represent tabs for sections
						"type" => "heading");

	$options[] = array( "name" => "Help2", // this defines the heading of the option
						"id"   => $shortname."_notice", // the id must be unique, it is used to call back the propertie inside the them
						"class" => $shortname."-notice",
					/* 	"stack" => "end", */
						"desc" => 'You are using Responsive Flip Book WordPress Plugin v1.3.3.<br><br>If you have a support question please visit our <a href="http://mpc.ticksy.com" target="_blank">support site</a>. If you are looking for a documentation you can find it inside the ZIP file downloaded from CodeCanyon.',
						"color" => "yellow",
						"float" => "right", // default none
						"type" => "info");

	// $options[] = array( "name" => "Export Flipbooks",
	// 					"id" => $shortname."_fb_export",
	// 					"class" => $shortname."-flipbook-export",
	// 					"help" => "false",
	// 					"help-desc" => "View page preview",
	// 					"color" => "grey",
	// 					"float" => "left",
	// 					"type" => "export-button");



	/////////////////////////////////////////////////////////////////////


	// header settings, main heading and socials
	$options[] = array("name" => "Greetings, I am Massive Panel", // this is the main heading from thr header
		"desc" => "use me wisely to customize your plugin.", // this is the line of description used in the header
		"type" => "top-header");

	$options[] = array("options" => $social_array,
		"type" => "top-socials");

	return $options;
}

/* ----------------------------------------------------------------------------------- */
/* 	Contextual Help
  /*----------------------------------------------------------------------------------- */

// function mp_options_page_contextual_help() {
// 	$text = "<h3>" . __('Massive Panel Settings - Contextual Help', 'incorporated') . "</h3>";
// 	$text .= "<p>" . __('Contextual Help Goes Here', 'incorporated') . "</p>";

// 	return $text;
// }


?>