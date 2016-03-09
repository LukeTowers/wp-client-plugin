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


function lai_get_attachment_id_from_url($attachment_url) {
	if (empty($attachment_url)) {
		return;
	}

	global $wpdb;
	$attachment_id = false;

	// Get the upload directory paths
	$upload_dir_paths = wp_upload_dir();

	// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
	if (strpos($attachment_url, $upload_dir_paths['baseurl']) !== false) {
		// If this is the URL of an auto-generated thumbnail, get the URL of the original image
		$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );

		// Remove the upload path base directory from the attachment URL
		$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );

		// Finally, run a custom database query to get the attachment ID from the modified attachment URL
		$attachment_id = $wpdb->get_var($wpdb->prepare("SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url));
	}

	return $attachment_id;
}


function lai_image_sizing_data($width, $height) {
	$image_sizing_data = array(
		'1' => array(
			'0.7' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAAHAQAAAAAZ1+HOAAAAAnRSTlMAAQGU/a4AAAANSURBVHgBY/h/ABMBAIFIDDoArVNCAAAAAElFTkSuQmCC',
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