<?php
//************************************************************************************************
// Section: 		Helper Functions Module
// Description:		Module that manages the helper functions for this plugin
//************************************************************************************************

function lai_get_excerpt_content_by_id($post_id, $excerpt_length = 35) {
	// Get the the post by it's ID
	$the_post = get_post($post_id);
	
	// Load the content
	$the_excerpt = $the_post->post_content;
	
	// Strip tags and shortcodes
	$the_excerpt = strip_tags(strip_shortcodes($the_excerpt));
	
	$words = explode(' ', $the_excerpt, $excerpt_length + 1);
	
	if(count($words) > $excerpt_length) {
		array_pop($words);
		array_push($words, '…');
		$the_excerpt = implode(' ', $words);
	}
		
	return $the_excerpt;
}


function lai_image_sizing_data($width, $height) {
	$image_sizing_data = array(
		'1' => array(
			'0.7' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAAHAQAAAAAZ1+HOAAAAAnRSTlMAAQGU/a4AAAANSURBVHgBY/h/ABMBAIFIDDoArVNCAAAAAElFTkSuQmCC',
			'0.64' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAABAAQAAAADEpO/ZAAAAAnRSTlMAAHaTzTgAAAAQSURBVHgBYxgwMApGwSgAAAOAAAFJNyFvAAAAAElFTkSuQmCC',
			'0.48' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAwAQAAAADPhuIYAAAAAnRSTlMAAHaTzTgAAAAOSURBVHgBYxjEYBSMAgACoAABE794HwAAAABJRU5ErkJggg==',
		)
	);
	
	return @$image_sizing_data[$width][$height];
}


function lai_get_share_link_bases() {
	return array(
		'facebook'    =>  'http://www.facebook.com/sharer.php?u=',
		'twitter'     =>  'http://twitter.com/share?url=',
		'linkedin'    =>  'http://www.linkedin.com/shareArticle?mini=true&url=',
		'google-plus' =>  'https://plus.google.com/share?url=',
	);
}


//************************************************************************************************
// Section: 		Mobile Detection Class
// Description:		Third party class for detecting mobile devices
//************************************************************************************************

require_once(LAI_PLUGIN_PATH . 'includes/modules/libraries/mobile-detection.php');


function lai_mobile_visitor() {
	$detect = new Mobile_Detect();
	
	if ($detect->isMobile()) { return true; } else { return false; }
}

function lai_tablet_visitor() {
	$detect = new Mobile_Detect();
	
	if ($detect->isTablet()) { return true; } else { return false; }
}