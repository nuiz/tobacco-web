<?php

//global $settings;
global $book_id;
global $shortname;

$shortname = 'rfbwp';
$book_id = 0;

function rfbwp_get_option_name() {
	global $shortname;
	
	// get the settings section array
	$settings_output	= mp_get_settings();
	$mp_option_name		= $settings_output[$shortname.'_option_name'];
	$mp_settings		= get_option($mp_option_name);
	
	if(isset($mp_settings['id'])) {
		$option_name = $mp_settings['id'];
	} else {
		$option_name = $mp_option_name;
	}

	return $option_name;
}

function rfbwp_get_settings() {
	$option_name = rfbwp_get_option_name();
	$settings = get_option($option_name);
	
	return $settings;
}

function mp_duplicate_options($options, $addNew = 'true', $addNewPage = 'false', $activeBook = '') {
	global $settings;
	
	$duplicate = false;
	$duplicate_pages  = false;
	$add = false;
	$temp = array();
	$temp_pages = array();
	$options_new = array();
	 
	foreach($options as $option) {
		// duplicate book and keep it in the $temp section
		if($duplicate && $option['type'] != 'section') {
			array_push($temp, $option);		
		} elseif ($duplicate && $option['type'] == 'section') {
			$duplicate = false;
			$duplicate_pages = false;
			$add = true;
			
			if($addNew == 'delete' && $_POST['delete'] == '0') {
				$first_book = 1;
			} else {
				$first_book = 0;
			}
						
			if($addNewPage == 'true' && isset($settings['books'][$first_book]['pages']) && $activeBook == 0)
				$page_limiter = count($settings['books'][$first_book]['pages']);
			elseif($addNewPage == 'delete' && isset($settings['books'][$first_book]['pages']) && $activeBook == 0)
				$page_limiter = count($settings['books'][$first_book]['pages']) - 2;
			elseif(isset($settings['books'][$first_book]['pages'])) 
				$page_limiter = count($settings['books'][$first_book]['pages']) - 1;
			else
				$page_limiter = -1;
			
			// duplicate pages for the first book
			for($p = 0; $p < $page_limiter; $p++ ) {
				foreach($temp_pages as $page) {
					if($page['type'] == 'separator'){
						$heading = $page;
						$name = preg_split('/_/', $heading['name']);
						$heading['name'] = $name[0].'_'.($p + 1);
						array_push($options_new, $heading);	
					} elseif($page['type'] == 'token') {
						$upload = $page;
						$token = preg_split('/_/', $upload['token']);
						$upload['token'] = $token[0].'_'.$i;
						array_push($options_new, $upload);	
					} else {
						array_push($options_new, $page);
					}
				}		
			}
		} 
		
		if($duplicate_pages && $option['type'] != 'section') {
			array_push($temp_pages, $option);
		}
		
		// add duplicated book
		if($addNew == 'true')
			$limiter = count($settings['books']);
		// elseif($addNew == 'false' || $first_book == 1)
		elseif($addNew == 'false')
			$limiter = count($settings['books']) - 1;
		elseif($addNew == 'delete')
			$limiter = count($settings['books']) - 1;
			
		if($add) {
			for($i = $first_book + 1; $i < $limiter+1; $i++) {
		
				if($addNew == 'delete' && $_POST['delete'] == $i)
					$i++;
				
				if($i >= $limiter+1)
					continue;
					
				if($addNewPage == 'true' && isset($settings['books'][$i]['pages']) && $activeBook == $i)
					$page_limiter = count($settings['books'][$i]['pages']);
				elseif($addNewPage == 'delete' && isset($settings['books'][$i]['pages']) && $activeBook == $i)
					$page_limiter = count($settings['books'][$i]['pages']) - 2;
				elseif(isset($settings['books'][$i]['pages'])) 
					$page_limiter = count($settings['books'][$i]['pages']) - 1;
				else
					$page_limiter = -1;
								
				foreach($temp as $value) {
					if($value['type'] == 'heading'){
						$heading = $value;
						$name = preg_split('/_/', $heading['name']);
						$heading['name'] = $name[0].'_'.($i);
						array_push($options_new, $heading);	
					} else {
						array_push($options_new, $value);
					}
				}
				
				// duplicate pages
				for($p = 0; $p < $page_limiter; $p++ ) {
					$uploader = 0;
					foreach($temp_pages as $page) {
						if($page['type'] == 'separator'){
							$heading = $page;
							$name = preg_split('/_/', $heading['name']);
							$heading['name'] = $name[0].'_'.($p + 1);
							array_push($options_new, $heading);	
						} elseif($page['type'] == 'token') {
							$upload = $page;
							$token = preg_split('/_/', $upload['token']);
							$upload['token'] = $token[0].'_'.$i;
							array_push($options_new, $upload);	
						} else {
							array_push($options_new, $page);
						}
					}		
				}	
			}
						
			$add = false;
		}
		
		// check if this is a begening of books section
		if($option['type'] == 'books') {
			$duplicate = true;
		} elseif($option['type'] == 'pages'){
			$duplicate_pages = true;
		}
		
		
		array_push($options_new, $option);
	}

	return $options_new;
}

function mp_display_content($update = false, $get_page_form = false) {
	// variables
	global $allowedtags;
	global $shortname;
	global $settings;
	
	$option_name = rfbwp_get_option_name();
	$settings = rfbwp_get_settings();
	$options = mpcrf_options();
	
	if(isset($settings['books']) && count($settings['books']) > 0) 
		$options = mp_duplicate_options($options, 'true', 'false');

	$rfbwp_page_form = '';
	$book_id = -1;
	$form_id = -1;
	$page_id = -1;
	$counter = 0;
	$menu = '<ul>';
	$tabs = '';
	$output = '';
	$header = '';
	$section_name = '';
	$begin_tabs = true;
	$begin_page_form = false;
	$create_page_form = false;
	$desc = '';
	$hide = 'false';
	$type = '';
	$path_prefix = '';
	$add_button = false;
	$separator = false;
	$stacked = false;
	$toggle = false;
	$test = true;
	
	foreach($options as $value) {
		$counter++;
		$val = ''; // used to store save value of a field;
		$select_value = '';
		$checked = ''; 
		$desc = 'right';
		$hide = 'false';
		
		if( isset($value['sub']) && $value['sub'] == 'settings' )
			$type = 'books';
		elseif( isset($value['sub']) && $value['sub'] == 'pages' )
			$type = 'pages';
		elseif( $value['type'] == 'section' )
			$type = '';
		
		if($type == 'books' && $value['type'] == 'heading'  && isset($value['sub']) && $value['sub'] == 'settings') {
			$book_id ++;
			$page_id = -1;
			$add_button = true;
			$begin_page_form = false;
		} 
		
		if($type == 'pages' && $begin_page_form && !isset($settings['books'][$book_id]['pages']) || 
			$type == 'pages' && $begin_page_form && isset($settings['books'][$book_id]['pages']) && count($settings['books'][$book_id]['pages']) < 1 ) {

			if($add_button) {
				$output .= '<img class="rfbwp-first-page" src="'.MP_ROOT.'/massive-panel/images/ui/first_page.png" />';
				$add_button = false;
			}
			
			if($form_id == -1 || $form_id == $book_id) {
				$create_page_form = true;
				$form_id = $book_id;
			} else {  
				continue;
			}
	
		} else {
			$create_page_form = false;
		}
		
		if($type == 'pages' && $value['type'] == 'separator') {
			$begin_page_form = true;
			$page_id++;
		} 
				
		
		if($value['type'] == 'separator') {
			if($separator){
				$output .= '</div>';
				$output .= '<div id="ps_'.$page_id.'" class="page-settings">';
			} else {
				$output .= '<div id="ps_'.$page_id.'" class="page-settings">';
				$separator = true;
			}
		} elseif($separator && $value['type'] == 'section' || $separator && $value['type'] == 'heading') {
			$separator = false;
			$output .= '</div>';
			
		}

		if($type == 'books') 
			$path_prefix = $option_name.'[books]['.$book_id.']';
		elseif($type == 'pages')
			$path_prefix = $option_name.'[books]['.$book_id.'][pages]['.$page_id.']';

		if (isset($value['desc-pos'])) 
			$desc = $value['desc-pos'];
		
		// Wrap all options
		if (($value['type'] != "heading") && ($value['type'] != "section")  && 
			($value['type'] != "top-header") && ($value['type'] != "top-socials")) {

			// convert ids to lowercase with no spaces
			$value['id'] = preg_replace('/\W/', '', strtolower($value['id']) );
			$id = 'field-' . $value['id'];
			$class = 'field ';
			
			if(isset($value['float']))
				$class .= $value['float'].' ';
			
			if ( isset($value['type']) ) 
				$class .= ' field-'.$value['type'];
				
			if ( isset($value['class']) ) 
				$class .= ' '.$value['class'];
			
			if(!$create_page_form) {
			
				if(isset($value['toggle']) && $value['toggle'] == 'begin') {
					$toggle = true;
					$output .= '<div class="mp-toggle-header"><span class="toggle-name">'.$value['toggle-name'].'</span><span class="toggle-arrow"></span></div><div class="mp-toggle-content">';
				} 
				
				if(isset($value['stack']) && $value['stack'] == 'begin') {
					$stacked = true;

					if($value['id'] == 'rfbwp_fb_page_bg_image')
						$output .= '<div class="stacked-fields no-border">';
					else 
						$output .= '<div class="stacked-fields">';
						
					if(isset($value['help']) && $value['help'] == 'true')
						$output .= '<div class="help-icon"><span class="mp-tooltip '.(isset($value['help-pos']) ? $value['help-pos'] : 'top').'"><span class="arrow"></span>'.$value['help-desc'].'</span></div>';
					
					$output .= '<div id="' . esc_attr( $id ) .'" class="' . esc_attr( $class ) . '">'."\n";
				} else {
					$output .= '<div id="' . esc_attr( $id ) .'" class="' . esc_attr( $class ) . '">'."\n";
				}
			} else {
				
				if(isset($value['toggle']) && $value['toggle'] == 'begin') {
					$toggle = true;
					$rfbwp_page_form .= '<div class="mp-toggle-header"><span class="toggle-name">'.$value['toggle-name'].'</span><span class="toggle-arrow"></span></div><div class="mp-toggle-content">';
				}
				
				if(isset($value['stack']) && $value['stack'] == 'begin') {
					$stacked = true;
					
					if($value['id'] == 'rfbwp_fb_page_bg_image')
						$rfbwp_page_form .= '<div class="stacked-fields no-border">';
					else
						$rfbwp_page_form .= '<div class="stacked-fields">';
					
					if(isset($value['help']) && $value['help'] == 'true')
						$rfbwp_page_form .= '<div class="help-icon"><span class="mp-tooltip '.(isset($value['help-pos']) ? $value['help-pos'] : 'top').'"><span class="arrow"></span>'.$value['help-desc'].'</span></div>';
					$rfbwp_page_form .= '<div id="' . esc_attr( $id ) .'" class="' . esc_attr( $class ) . '">'."\n";
				} else {
					$rfbwp_page_form .= '<div id="' . esc_attr( $id ) .'" class="' . esc_attr( $class ) . '">'."\n";
				}
			}				
				
			if($value['type'] == "choose-sidebar") {
				$output .= '<div class="option">' . "\n" . '<div class="controls controls-sidebar">' . "\n";
			} elseif ($value['type'] == "choose-portfolio") {
				$output .= '<div class="option">' . "\n" . '<div class="controls controls-portfolio">' . "\n";
			} else {
				if(!$create_page_form)
					$output .= '<div class="option">' . "\n" . '<div class="controls">' . "\n";
				else
					$rfbwp_page_form .= '<div class="option">' . "\n" . '<div class="controls">' . "\n";
			}
			
		 }
		 
		 // Set default value to $val
		if (isset($value['std'])) 
			$val = $value['std'];
		
		// If the option is already saved, ovveride $val
		if (($value['type'] != 'heading') && ($value['type'] != "section") && 
			($value['type'] != 'info') && ($value['type'] != "top-header") && 
			($value['type'] != "top-socials") && $value['type'] != "separator") {
			
			if ( $type == 'books' && isset($settings['books'][$book_id][$value['id']]) ) {
					$val = $settings['books'][$book_id][($value['id'])];
					// Striping slashes of non-array options
					if (!is_array($val)) $val = stripslashes($val);	
			} elseif ( $type == 'pages' && isset($settings['books'][$book_id]['pages'][$page_id][$value['id']])) {
					$val = $settings['books'][$book_id]['pages'][$page_id][$value['id']];
					// Striping slashes of non-array options
					if (!is_array($val)) $val = stripslashes($val);	
			}
		}
			
		$description = '';
		if ( isset($value['desc'])) $description = $value['desc'];
			
		if($desc == 'top' && !isset($value['class'])) {
			if(!$create_page_form)
				$output .= '<div class="description-top">'.$description.'</div>'."\n";
			else
				$rfbwp_page_form .= '<div class="description-top">'.$description.'</div>'."\n";
				
			if($value['id'] == 'rfbwp_page_html') {
					if(!$create_page_form)
						$output .= '<div class="help-icon"><span class="mp-tooltip '.(isset($value['help-pos']) ? $value['help-pos'] : 'top').'"><span class="arrow"></span>'.$value['help-desc'].'</span></div>';
					else
						$rfbwp_page_form .= '<div class="help-icon"><span class="mp-tooltip '.(isset($value['help-pos']) ? $value['help-pos'] : 'top').'"><span class="arrow"></span>'.$value['help-desc'].'</span></div>';
			}
		}
		
		switch ($value['type']) {
			// Basic text input
			case 'text-small':
				if(isset($value['class']))
					$class = $value['class'];
				else
					$class = '';

				if(!$create_page_form) {
					if($value['id'] == 'rfbwp_fb_margin_top') 
						$output .= '<span class="mp-fb-margins"></span>';
					
					$output .= '<input id="' . esc_attr( $value['id'] ) . '" class="mp-input-small mp-input-border '.$class.'" name="' . esc_attr( $path_prefix.'[' . $value['id'] . ']' ) . '" type="text" value="' . esc_attr( $val ) . '" />';
					
					if(isset($value['unit']))
						$output .= '<span class="mp-unit">'.$value['unit'].'</span>';
						
				} else { 
				
					if($value['id'] == 'rfbwp_fb_margin_top') 
						$rfbwp_page_form .= '<span class="mp-fb-margins"></span>';
						
					$rfbwp_page_form .= '<input id="' . esc_attr( $value['id'] ) . '" class="mp-input-small mp-input-border '.$class.'" name="' . esc_attr( $path_prefix.'[' . $value['id'] . ']' ) . '" type="text" value="' . esc_attr( $val ) . '" />';
					
					if(isset($value['unit']))
						$rfbwp_page_form .= '<span class="mp-unit">'.$value['unit'].'</span>';
				}
			break;
			
			case 'text-medium':
				if(isset($value['class']))
					$class = $value['class'];
				else
					$class = '';
			
				if(!$create_page_form)
					$output .= '<input id="' . esc_attr( $value['id'] ) . '" class="mp-input-medium mp-input-border '.$class.'" name="' . esc_attr( $path_prefix.'[' . $value['id'] . ']' ) . '" type="text" value="' . esc_attr( $val ) . '" />';
				else
					$rfbwp_page_form .= '<input id="' . esc_attr( $value['id'] ) . '" class="mp-input-medium mp-input-border '.$class.'" name="' . esc_attr( $path_prefix.'[' . $value['id'] . ']' ) . '" type="text" value="' . esc_attr( $val ) . '" />';
			break;
			
			case 'text-big':
				if(!$create_page_form)
					$output .= '<input id="' . esc_attr( $value['id'] ) . '" class="mp-input-big mp-input-border" name="' . esc_attr( $path_prefix.'[' . $value['id'] . ']' ) . '" type="text" value="' . esc_attr( $val ) . '" />';
				else
					$rfbwp_page_form .= '<input id="' . esc_attr( $value['id'] ) . '" class="mp-input-big mp-input-border" name="' . esc_attr( $path_prefix.'[' . $value['id'] . ']' ) . '" type="text" value="' . esc_attr( $val ) . '" />';
			break;
		
			// Textarea
			case 'textarea':
				$cols = '35';
				$ta_value = '';
				$val = stripslashes($val);
				
				if(isset($value['class']))
					$class = $value['class'];
				else
					$class = '';
			
				if(!$create_page_form) {
					$output .= '<textarea id="' . $value['id'] . '" class="mp-textarea mp-input-border displayall '.$class.'" name="' . $path_prefix.'[' . $value['id'] . ']' . '" cols="'. $cols. '" rows="8">' . $val . '</textarea>';
					
				} else {
					$rfbwp_page_form .= '<textarea id="' . $value['id'] . '" class="mp-textarea mp-input-border displayall '.$class.'" name="' . $path_prefix.'[' . $value['id'] . ']' . '" cols="'. $cols. '" rows="8">' . $val . '</textarea>';
					
				}
			break;
			
			// Textarea Big
			case 'textarea-big':
				$cols = '86';
				$ta_value = '';
				$val = stripslashes($val);
				
				if(isset($value['class']))
					$class = $value['class'];
				else
					$class = '';
			
				if(!$create_page_form) {
					if($class == $shortname."-page-html")
						$output .= '<a class="add-shortcode" href="#'.$bookID.'"><span class="normal"></span><span class="hover"></span></a>';
					$output .= '<textarea id="' . $value['id'] . '" class="mp-textarea mp-input-border displayall '.$class.'" name="' . $path_prefix.'[' . $value['id'] . ']' . '" cols="'. $cols. '" rows="15">' . $val . '</textarea>';
					
				} else {
					if($class == $shortname."-page-html")
						$rfbwp_page_form .= '<a class="add-shortcode" href="#'.$bookID.'"><span class="normal"></span><span class="hover"></span></a>';
						
					$rfbwp_page_form .= '<textarea id="' . $value['id'] . '" class="mp-textarea mp-input-border displayall '.$class.'" name="' . $path_prefix.'[' . $value['id'] . ']' . '" cols="'. $cols. '" rows="8">' . $val . '</textarea>';
					
				}
				
			break;
			
			// Select Box
			case "select":
				if(isset($value['class']))
					$class = $value['class'];
				else
					$class = '';
					
				if(!$create_page_form) {
					$output .= '<select class="mp-dropdown '.$class.'" name="' . esc_attr( $path_prefix.'[' . $value['id'] . ']' ) . '" id="' . esc_attr( $value['id'] ) . '">';
				} else { 
					$rfbwp_page_form .= '<select class="mp-dropdown '.$class.'" name="' . esc_attr( $path_prefix.'[' . $value['id'] . ']' ) . '" id="' . esc_attr( $value['id'] ) . '">';
				}
			
				foreach ($value['options'] as $key => $option ) {
					$selected = '';
					 if( $val != '' ) {
						 if ( $val == $key) { 
						 	$selected = ' selected="selected"';
						 } 
			     }
			     if(!$create_page_form)
					 $output .= '<option'. $selected .' value="' . esc_attr( $key ) . '">' . esc_html( $option ) . '</option>';
				 else
					$rfbwp_page_form .= '<option'. $selected .' value="' . esc_attr( $key ) . '">' . esc_html( $option ) . '</option>';
			 } 
			 	if(!$create_page_form)
					$output .= '</select>';
				else
					$rfbwp_page_form .= '</select>';
					
				if($value['id'] == 'rfbwp_fb_page_type') {
					if(!$create_page_form)
						$output .= '<div class="help-icon"><span class="mp-tooltip '.(isset($value['help-pos']) ? $value['help-pos'] : 'top').'"><span class="arrow"></span>'.$value['help-desc'].'</span></div>';
					else
						$rfbwp_page_form .= '<div class="help-icon"><span class="mp-tooltip '.(isset($value['help-pos']) ? $value['help-pos'] : 'top').'"><span class="arrow"></span>'.$value['help-desc'].'</span></div>';
				}
				
			break;
		
			// Checkbox
			case "checkbox":
				if(!$create_page_form)
					$output .= '<input id="' . esc_attr( $value['id'] ) . '" class="checkbox of-input" type="checkbox" name="' . esc_attr( $path_prefix.'[' . $value['id'] . ']' ) . '" '. checked($val, 1, false) .' />';
				else
					$rfbwp_page_form .= '<input id="' . esc_attr( $value['id'] ) . '" class="checkbox of-input" type="checkbox" name="' . esc_attr( $path_prefix.'[' . $value['id'] . ']' ) . '" '. checked($val, 1, false) .' />';
			break;
			
			// Uploader
			case "upload":
				
				if(isset($value['class']))
					$class = $value['class'];
				else
					$class = '';
				
				if(!$create_page_form)
					$output .= mp_medialibrary_uploader($value['id'], $class, $value['token'], $book_id, $page_id, $val, null, $value['desc'], $value['help-desc']); // New AJAX Uploader using Media Library	
				else
					$rfbwp_page_form .= mp_medialibrary_uploader($value['id'], $class, $value['token'], $book_id, $page_id, $val, null, $value['desc'], $value['help-desc']);
			break;
			
			// Button Grey Preview
			case "button" :
				
				if(!$create_page_form) {
					$output .= '<a class="'.$value['class'].' mp-'.$value['color'].'-button" href="#'.$page_id.'"><span class="left"><span class="icon-'.(isset($value['icon']) ? $value['icon'] : '').'"></span><span class="desc">'.$value['name'].'</span></span><span class="right"></span><span class="left-hover"><span class="icon-'.(isset($value['icon']) ? $value['icon'] : '').'"></span><span class="desc">'.$value['name'].'</span></span><span class="right-hover"></span></a>';
				} else {
					$rfbwp_page_form .= '<a class="'.$value['class'].' mp-'.$value['color'].'-button" href="#'.$page_id.'"><span class="left"><span class="icon-'.(isset($value['icon']) ? $value['icon'] : '').'"></span><span class="desc">'.$value['name'].'</span></span><span class="right"></span><span class="left-hover"><span class="icon-'.(isset($value['icon']) ? $value['icon'] : '').'"></span><span class="desc">'.$value['name'].'</span></span><span class="right-hover"></span></a>';
				}
				
				if($value['id'] == 'rfbwp_fb_page_preview' || $value['id'] == 'rfbwp_fb_page_shortcodes') {
					if(!$create_page_form)
						$output .= '<div class="help-icon"><span class="mp-tooltip '.(isset($value['help-pos']) ? $value['help-pos'] : 'top').'"><span class="arrow"></span>'.$value['help-desc'].'</span></div>';
					else
						$rfbwp_page_form .= '<div class="help-icon"><span class="mp-tooltip '.(isset($value['help-pos']) ? $value['help-pos'] : 'top').'"><span class="arrow"></span>'.$value['help-desc'].'</span></div>';
				}
			break;
			
			// Color picker
			case "color":	
				if(!$create_page_form)
					$output .= '<input class="mp-color mp-input-border" name="' . esc_attr( $path_prefix.'[' . $value['id'] . ']' ) . '" id="' . esc_attr( $value['id'] ) . '" type="text" value="' . esc_attr( $val ) . '" />';
				else
					$rfbwp_page_form .=	'<input class="mp-color mp-input-border" name="' . esc_attr( $path_prefix.'[' . $value['id'] . ']' ) . '" id="' . esc_attr( $value['id'] ) . '" type="text" value="' . esc_attr( $val ) . '" />';
					
				if(!$create_page_form)
					$output .= '<div id="' . esc_attr( $value['id'] . '_picker' ) . '" class="colorSelector"><div style="' . esc_attr( 'background-color:' . $val ) . '"></div></div>';
				else
					$rfbwp_page_form .=	'<div id="' . esc_attr( $value['id'] . '_picker' ) . '" class="colorSelector"><div style="' . esc_attr( 'background-color:' . $val ) . '"></div></div>';
	
			break; 
			
			// Info
			case "info":
				if(!$create_page_form)
					$output .= '<span id="' .esc_attr( $value['id']). '" class="info box-' .$value['color']. '">' .$value['desc']. '</span>';
				else
					$rfbwp_page_form .=	'<span id="' .esc_attr( $value['id']). '" class="info box-' .$value['color']. '">' .$value['desc']. '</span>';

			break;
			
			// Books (modul for flip book plugin)
			case "books":
				// display books in a table on front page
				$output .= get_books_table();
			break;
			
			case "pages":
				// dispaly pages
				$output .= get_books_pages_table($book_id);
			break;
		
			// Heading for Tabs
			case "heading":
				if($counter >= 2){
					if(!$create_page_form)
			  			$output .= '</div>'."\n";
			  		else
			  			$rfbwp_page_form .= '</div>'."\n";
				}
				
				$jquery_click_hook = preg_replace('/\W/', '', strtolower($value['name']) );
				$jquery_click_hook = "mp-option-" . $jquery_click_hook;
				
				if($begin_tabs){
					$tabs .= '<ul class="tab-group" id="' .$section_name. '-tab">';
					$begin_tabs = false;
				}
				
				$class = preg_split('/_/', esc_attr($value['name']));
				$class = strtolower($class[0]);
				
				$tabs .= '<li class="button-tab"><a id="'.  esc_attr( $jquery_click_hook ) . '-tab" class="'.$class.'" title="' . esc_attr( $value['name'] ) . '" href="' . esc_attr( '#'.  $jquery_click_hook ) . '"><span class="tab-bg-left"></span><span class="tab-bg-center"><span class="tab-text">' . esc_html( $value['name'] ) . '</span></span><span class="tab-bg-right"></span></a></li>';
				
				if(!$create_page_form) {
					$output .= '<div class="group '.$class.'" id="' . esc_attr( $jquery_click_hook ) . '">';
					$output .= '<div class="breadcrumbs"><span class="breadcrumb-1 breadcrumb"><span class="inactive"></span><span class="active"></span></span><span class="breadcrumb-2 breadcrumb"><span class="inactive"></span><span class="active"></span></span><span class="breadcrumb-3 breadcrumb"><span class="inactive"></span><span class="active"></span></span></div>';
				} else { 
			  		$rfbwp_page_form .= '<div class="group '.$class.'" id="' . esc_attr( $jquery_click_hook ) . '">';
			  		$rfbwp_page_form .= '<div class="breadcrumbs"><span class="breadcrumb-1 breadcrumb"></span><span class="breadcrumb-1-active breadcrumb"></span><span class="breadcrumb-2 breadcrumb"></span><span class="breadcrumb-2-active breadcrumb"></span><span class="breadcrumb-3 breadcrumb"></span><span class="breadcrumb-3-active breadcrumb"></span></div>';
			  	}
			  			
				break;
				
			// Sidebar navigation
			case "section":
				if($counter >= 2) {
			  		$output .= '</div>'."\n";
			  		$tabs .= '</ul>'; // end tabs;
			  		$begin_tabs = true;
				}
				
				$jquery_click_hook = preg_replace('/\W/', '', strtolower($value['name']) );
				$jquery_click_hook = "mp-section-" . $jquery_click_hook;
				$section_name = $jquery_click_hook;
				$menu .= '<li class="button-sidebar"><a id="'.  esc_attr( $jquery_click_hook ) . '-button" title="' . esc_attr( $value['name'] ) . '" href="' . esc_attr( '#'.  $jquery_click_hook ) . '"><span class="active"><img class="button-icon-selected" src="'.MP_ROOT.'/massive-panel/images/icons/'. $value['icon-active'] .'"/><label class="name-selected">' . esc_html( $value['name'] ) . '</label><label class="sub-name-selected">'. esc_html( $value['sub-name'] ) .'</label></span><img class="button-icon" src="'.MP_ROOT.'/massive-panel/images/icons/'. $value['icon'] .'"/><img class="button-icon-active" src="'.MP_ROOT.'/massive-panel/images/icons/'. $value['icon-active'] .'"/><label class="name">' . esc_html( $value['name'] ) . '</label><label class="sub-name">'. esc_html( $value['sub-name'] ) .'</label></a></li>';
				$output .= '<div class="section-group" id="' . esc_attr( $jquery_click_hook ) . '">';
			break;
					
			case "top-socials":
				$header .= '<ul class="socials">';
				foreach($value['options'] as $key => $val) {
					$header .= '<li class="social"><a href="' .($key == 'email' ? 'mailto:' : '').$val[3]. '"><img class="normal" src="' .MP_ROOT.'/massive-panel/images/icons/social/' . $val[0] . '"/><img class="hover" src="' .MP_ROOT.'/massive-panel/images/icons/social/' . $val[1] . '"/></a><span class="mp-tooltip"><span class="arrow"></span>' . $val[2] . '</span></li>';
				}
				
				$header .= '</ul>';
			break;

		
			case "top-header":
				$header .= '<h2 class="main-header">' . esc_attr( $value['name'] ) . '</h2>';
				$header .= '<h3 class="main-desc">' . esc_attr( $value['desc'] ) . '</h3>';
			break;
			
		}

		if (($value['type'] != "heading") && ($value['type'] != "section")  && ($value['type'] != "top-header") && ($value['type'] != "top-socials")) {
			
			if ($value['type'] != "checkbox") {
				if(!$create_page_form)
					$output .= '<br/>';
				else
					$rfbwp_page_form .= '<br/>';
			}
			// this code is for the descript & help
			if (isset($value['help']) && $value['help'] == "true" && !isset($value['stack'])) {
				if(!$create_page_form)
					$output .= '<div class="help-icon"><span class="mp-tooltip '.(isset($value['help-pos']) ? $value['help-pos'] : 'top').'"><span class="arrow"></span>'.$value['help-desc'].'</span></div></div>';
				else
					$rfbwp_page_form .= '<div class="help-icon"><span class="mp-tooltip '.(isset($value['help-pos']) ? $value['help-pos'] : 'top').'"><span class="arrow"></span>'.$value['help-desc'].'</span></div></div>';
			} else {
				if(!$create_page_form)
					$output .= '</div>';
				else
					$rfbwp_page_form .= '</div>';
			}
			
			$description = '';
			if ( isset( $value['desc'] ) ) {
				$description = $value['desc'];
			}
						
			if($desc == 'bottom' && ($value['type'] != "info") && !isset($value['class'])) {
				if(!$create_page_form)
					$output .= '<div class="description-bottom">' . wp_kses( $description, $allowedtags) . '</div>'."\n";
				else
					$rfbwp_page_form .= '<div class="description-bottom">' . wp_kses( $description, $allowedtags) . '</div>'."\n";
			} elseif($desc == 'right' && ($value['type'] != "info") && !isset($value['class'])) {
				if(!$create_page_form)
					$output .= '<div class="description">' . wp_kses( $description, $allowedtags) . '</div>'."\n";
				else
					$rfbwp_page_form .= '<div class="description">' . wp_kses( $description, $allowedtags) . '</div>'."\n";
			}
			// the end of description code
			if($hide == 'true') {
				$output .= '</div>';
			}
			
			
			if(!$create_page_form) {
				if(isset($value['toggle']) && $value['toggle'] == 'end' && $stacked) {
					$output .= '<div class="clear"></div></div></div></div></div>';
					$toggle = false;
					$stacked = false;
				} else if(isset($value['toggle']) && $value['toggle'] == 'end' && !$stacked) {
					$output .= '<div class="clear"></div></div></div></div>';
					$toggle = false;
				} else if(isset($value['stack']) && $value['stack'] == 'end') {
					$output .= '<div class="clear"></div></div></div></div>';
					$stacked = false;
				} elseif(!$stacked) {
					$output .= '<div class="clear"></div></div></div>';
				} elseif($stacked) {
					$output .= '</div></div>';
				}
					
			} else {
				if(isset($value['toggle']) && $value['toggle'] == 'end' && $stacked) {
					$rfbwp_page_form .= '<div class="clear"></div></div></div></div></div>';
					$toggle = false;
					$stacked = false;
				} else if(isset($value['toggle']) && $value['toggle'] == 'end' && !$stacked) {
					$output .= '<div class="clear"></div></div></div></div>';
					$toggle = false;
				} else if(isset($value['stack']) && $value['stack'] == 'end') {
					$rfbwp_page_form .= '<div class="clear"></div></div></div></div>';
					$stacked = false;
				} elseif(!$stacked) {
					$rfbwp_page_form .= '<div class="clear"></div></div></div></div>';
				} elseif($stacked) {
					$rfbwp_page_form .= '</div></div>';
				}
			}
		}
	}
	$tabs .= '</ul>';
	$menu .= '</ul>';
	
	if(!$create_page_form)
   		$output .= '</div>';
   	else
		$rfbwp_page_form .= '</div>';
    
 	$output .= '<div class="group shortcode"><div class="breadcrumbs"><span class="breadcrumb-1 breadcrumb"><span class="inactive"></span><span class="active"></span></span><span class="breadcrumb-2 breadcrumb"><span class="inactive"></span><span class="active"></span></span><span class="breadcrumb-3 breadcrumb"><span class="inactive"></span><span class="active"></span></span></div><img src="'.MP_ROOT.'/massive-panel/images/ui/insert-shortcode.png"/></div>'; 

	$_POST['page_form'] = $rfbwp_page_form;

	
    return array($output, $menu, $tabs, $header);
}

function get_books_table() {
	global $settings;
	global $shortname;
	$output = '';
	$settings = rfbwp_get_settings();
	

	$output .= '<div class="add-new-book-wrap">';
	$output .= '<a class="add-book mp-grey-button" href="#"><span class="left"><span class="icon-add-book"></span><span class="desc">Create New Book</span></span><span class="right"></span><span class="left-hover"><span class="icon-add-book"></span><span class="desc">Create New Book</span></span><span class="right-hover"></span></a>';
	$output .= '</div>';
	
	$output .= '<table class="books"><tbody>';
	
	if(isset($settings['books']))
		$books_count = count($settings['books']);
	else
		$books_count = 0;
		
	
	if($books_count == 0) {
		$output .= '<img class="rfbwp-first-book" src="'.MP_ROOT.'/massive-panel/images/ui/first_book.png'.'"/>';
	}
				
	for($i = 0; $i < $books_count; $i++) {
		$output .= '<tr><td>';
		if(isset($settings['books'][$i]['pages'][0]) && $settings['books'][$i]['pages'][0]['rfbwp_fb_page_bg_image'] != '')
			$output .= '<img class="img-border" src="'.$settings['books'][$i]['pages'][0][$shortname.'_fb_page_bg_image'].'" alt=""/>';
		else
			$output .= '<img src="'.MP_ROOT.'/massive-panel/images/no-cover.png'.'"/>';
			
		if($settings['books'][$i][$shortname.'_fb_name'] != '')
			$output .= '<span class="book-name"><span class="distinction">Book Name: </span> '.$settings['books'][$i][$shortname.'_fb_name'].'</span>';
		else
			$output .= '<span class="book-name"><span class="distinction"> <font color="#FD8A00">ERROR: Give your book a unique name!</font> </span> </span>';
			
		if($settings['books'][$i][$shortname.'_fb_name'] != '')
			$output .= '<span class="book-shortcode"><span class="distinction">Book Shortcode: '.strtolower(str_replace(" ", "_", $settings['books'][$i][$shortname.'_fb_name'])).'</span></span>';
		else
			$output .= '<span class="book-shortcode"><span class="distinction"> Shortcode cannot be generated because Flip Book does not have a name.</span></span>';

		$output .= '<span class="book-error"><span class="distinction"></span></span>';
			
		$output .= '<a class="book-settings" href="#mp-option-settings_'.$i.'"><span class="normal"></span><span class="hover"></span></a>'; // edit-page
		$output .= '<a class="view-pages" href="#mp-option-pages_'.$i.'"><span class="normal"></span><span class="hover"></span></a>'; // view-pages
		$output .= '<a class="delete-book" href="#'.$i.'"><span class="normal"></span><span class="hover"></span></a>'; // delete-page

		$output .= '</td></tr>';
	}
	
	$output .= '</tbody></table>';
	
				
	return $output;
}

function get_books_pages_table($bookID) {
	global $settings;
	global $shortname;
	$output = '';
	$settings = rfbwp_get_settings();

	$output .= '<table class="pages-table"><tbody>';

	
	if(isset($settings['books'][$bookID]['pages']))
		$page_count = count($settings['books'][$bookID]['pages']);
	else
		$page_count = 0;
	
	$j = -1;
				
	for($i = 0; $i < $page_count; $i++) {
		$j++;
		$output .= '<tr id="page-display_'.$j.'" class="display"><td class="thumb-preview">';
	
		if(isset($settings['books'][$bookID]['pages'][$i][$shortname.'_fb_page_bg_image']) && $settings['books'][$bookID]['pages'][$i][$shortname.'_fb_page_bg_image'] != '')
			$output .= '<img src="'.$settings['books'][$bookID]['pages'][$i][$shortname.'_fb_page_bg_image'].'" alt=""/>';
			// $output .= '<img src="'.MP_ROOT.'/massive-panel/timthumb.php?src='.$settings['books'][$bookID]['pages'][$i][$shortname.'_fb_page_bg_image'].'&w=0&h=105&zc=0" alt=""/>';
		else
			$output .= '<img src="'.MP_ROOT.'/massive-panel/images/default-thumb.png"/>';
			
		$output .= '<span class="page-type">'.$settings['books'][$bookID]['pages'][$i][$shortname.'_fb_page_type'].'</span>';
		$output .= '<a class="add-page mp-grey-button" href="#'.$bookID.'"><span class="left"><span class="icon-add"></span><span class="desc">Add Page</span></span><span class="right"></span><span class="left-hover"><span class="icon-add"></span><span class="desc">Add Page</span></span><span class="right-hover"></span></a>';
		$output .= '<a class="edit-page" href="#'.$bookID.'"><span class="normal"></span><span class="hover"></span></a>';
		$output .= '<a class="delete-page" href="#'.$bookID.'"><span class="normal"></span><span class="hover"></span></a>';
		$output .= '<a class="preview-page" href="#'.$bookID.'"><span class="normal"></span><span class="hover"></span></a>';
		
		$output .= '</td><td class="navigation">';
		$output .= '<a class="up-page" href="#'.$bookID.'"><span class="normal"></span><span class="hover"></span></a>';
		$output .= '<input type="checkbox" class="page-checkbox"/>';
		$output .= '<span class="desc">page</span>';
		if($settings['books'][$bookID]['pages'][$i][$shortname.'_fb_page_type'] != 'Double Page')
			$output .= '<span class="page-index">'.$settings['books'][$bookID]['pages'][$i][$shortname.'_fb_page_index'].'</span>';
		else 
			$output .= '<span class="page-index">'.$settings['books'][$bookID]['pages'][$i][$shortname.'_fb_page_index'].' - '.(int)($settings['books'][$bookID]['pages'][$i][$shortname.'_fb_page_index']+1).'</span>';
		$output .= '<a class="down-page" href="#'.$bookID.'"><span class="normal"></span><span class="hover"></span></a>';
		$output .= '</td></tr><tr id="pset_'.$j.'" class="page-set"><td></td></tr>';
	}
	
	if($page_count == 0) {
		$output .= '<tr id="pset_0" class="page-set"><td></td></tr>';
	}
	
	$output .= '</tbody></table>';
			
	return $output;
}


// refresh panel
add_action( 'wp_ajax_rfbwp_refresh_books', 'rfbwp_books_refresh' );

function rfbwp_books_refresh() {
	print_r(get_books_table());
	die();
}

// refresh tabs
add_action( 'wp_ajax_rfbwp_refresh_tabs', 'rfbwp_tabs_refresh' );

function rfbwp_tabs_refresh() {
	$content = mp_display_content();
	$tabs_refresh = preg_split('/<\/ul>(.*?)<\/ul>$/', $content[2]);
	$tabs_refresh = preg_split('/<ul(.*?)<\/li>/', $tabs_refresh[0]);
	$tabs_refresh = $tabs_refresh[1];

	print_r($tabs_refresh);
	
	die();
}

// refresh tabs content
add_action( 'wp_ajax_rfbwp_refresh_tabs_content', 'rfbwp_tabs_content_refresh' );

function rfbwp_tabs_content_refresh() {

	$content = mp_display_content(true);
	$content_refresh = preg_split('/<div class="group settings" id="mp-option-settings_0">/' , $content[0]);
	$content_refresh = '<div class="group settings" id="mp-option-settings_0">'.$content_refresh[1];
	$content_refresh = preg_split('/<div class="section-group"/', $content_refresh);
	$content_refresh = $content_refresh[0];

	print_r($content_refresh);
	
	die();
}


// delete assets
add_action( 'wp_ajax_delete_attachment', 'rfbwp_delete_attachment' );

function rfbwp_delete_attachment() {
   
   $attachmentid = $_POST['id'];
   echo wp_delete_attachment( $attachmentid );
   die();
}

// add new book
add_action( 'wp_ajax_add_new_book', 'rfbwp_add_new_book' );

function rfbwp_add_new_book() {
	global $book_id;
	global $addNewBook;
	
	set_add_book('true');
	
	$settings = rfbwp_get_settings();
 	
 	if(isset($settings['books']) && count($settings['books']) > 0) {
   		$book_id = count($book_id = $settings['books']);
   	} else {
   		$book_id = 0;
	}
	
	echo $book_id;
  	
	die();
} 

add_action('wp_ajax_page_form', 'rfbwp_page_form');

function rfbwp_page_form() {
	mp_display_content(false, true);
	$page_form = $_POST['page_form'];
	
	echo $page_form;
	
	die();
}

// get books page count
add_action('wp_ajax_get_books_page_count', 'rfbwp_get_books_page_count');

function rfbwp_get_books_page_count() {
	global $settings;
	
	$id = $_POST['book_id'];
	$settings = rfbwp_get_settings();
	
	if(isset($settings['books'][$id]['pages']))
		echo count($settings['books'][$id]['pages']);
	else
		echo 0;
		
	die();
}

// set add book
function set_add_book($val) {
	$_POST['add_new_book'] = $val;
}

function get_add_book() {
	return $_POST['add_new_book'];
}
	
?>