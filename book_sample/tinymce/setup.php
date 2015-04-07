<?php

/*-----------------------------------------------------------------------------------*/
/*	Flip Book Shortcode
/*-----------------------------------------------------------------------------------*/

global $mpcrf_options;

$books = array();

foreach($mpcrf_options['books'] as $book) {
	if($book['rfbwp_fb_name'] != '')
		$books[strtolower(str_replace(" ", "_", $book['rfbwp_fb_name']))] = $book['rfbwp_fb_name'];
}

$mpc_shortcodes['fb'] = array(
	'preview' => 'false',
	'shortcode' => '[responsive-flipbook id="{{id}}"]',
	'title' => __('Insert Flip Book', 'rfbwp'),
	'fields' => array(
		'id' => array(
			'type' => 'select',
			'title' => __('Select flip book', 'rfbwp'),
			'desc' => __('Select which flip book you would like to display', 'rfbwp'),
			'options' => $books
		)
	)
);

/*--------------------------- END Flip Book -------------------------------- */

?>