<?php
//************************************************************************************************
// Section: 		Theme Helper Module
// Description:		Module that manages the theme helper components of this plugin
//************************************************************************************************



//************************************************************************************************
// Section: 		Theme Support Component
// Description:		Component that handles custom theme support aspects
//************************************************************************************************

require_once(LAI_PLUGIN_PATH . 'includes/modules/theme-helper/theme-support.php');



function lai_is_front_page_in_admin($post = null) {
	$current_post = lai_get_current_post_id($post);

	if (!empty($current_post)) {
		$frontpage_post = (int) get_option('page_on_front');

		if ($current_post === $frontpage_post) {
			return true;
		}
	}

	return false;
}



function lai_current_page_template($post = null) {
	$current_post = get_current_post_id($post);

	if (!empty($current_post)) {
		$page_template = get_post_meta($current_post, '_wp_page_template', true);

		if (!empty($page_template)) {
			return $page_template;
		} else {
			return false;
		}
	}
}

function lai_get_current_post_id($post = null) {
	if (!empty($post) && !empty($post->ID)) {
		$current_post = $post->ID;
	} elseif (!empty($post) && filter_var($post, FILTER_VALIDATE_INT)) {
		$current_post = filter_var($post, FILTER_VALIDATE_INT);
	} else {
		$current_post = filter_var(@$_GET['post'], FILTER_VALIDATE_INT) ?: filter_var(@$_POST['post_ID'], FILTER_VALIDATE_INT);
	}

	if (!empty($current_post)) {
		return (int) $current_post;
	} else {
		return false;
	}
}

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

function lai_get_excerpt_by_id($post_id, $excerpt_length = 35) {
	return '<p>' . lai_get_excerpt_content_by_id($post_id, $excerpt_length) . '</p>';
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
			'2' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAACAQAAAACx+ouKAAAAAnRSTlMAAQGU/a4AAAAMSURBVHgBY2hgaAAAAgQBAd+xkbMAAAAASUVORK5CYII=',
			'1.9' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAATCAQAAAAD4lRlAAAADklEQVQYV2NgGAWDCAAAAY8AARRFezEAAAAASUVORK5CYII=',
			'1.8' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAASAQAAAABKzHLmAAAAAnRSTlMAAQGU/a4AAAANSURBVHgBY/h/gAwEAFM0H285la/DAAAAAElFTkSuQmCC',
			'1.7' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAARAQAAAADMWABIAAAAAnRSTlMAAQGU/a4AAAANSURBVHgBY/h/gFQEAPdXHbCFbV7/AAAAAElFTkSuQmCC',
			'1.6' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAAQAQAAAAAHBNPtAAAAAnRSTlMAAQGU/a4AAAANSURBVHgBY/h/gCQEAKDGG/GUj72IAAAAAElFTkSuQmCC',
			'1.5' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAAPAQAAAAD1hGOjAAAAAnRSTlMAAQGU/a4AAAANSURBVHgBY/h/gHgEAE9yGjInx5uiAAAAAElFTkSuQmCC',
			'1.4' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAAOAQAAAAA+2LAGAAAAAnRSTlMAAQGU/a4AAAANSURBVHgBY/h/gEgEAANbGHNaF7eeAAAAAElFTkSuQmCC',
			'1.3' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAANAQAAAAC4TMKoAAAAAnRSTlMAAQGU/a4AAAANSURBVHgBY/h/gBgEALxyFrSQzAcXAAAAAElFTkSuQmCC',
			'1.2' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAAMAQAAAABzEBENAAAAAnRSTlMAAQGU/a4AAAANSURBVHgBY/h/gCACAHrVFPVh5eaEAAAAAElFTkSuQmCC',
			'1.1' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAALAQAAAABuFSG1AAAAAnRSTlMAAQGU/a4AAAANSURBVHgBY/h/AD8CAD51EzYjahi+AAAAAElFTkSuQmCC',
			'1' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQAAAAA3bvkkAAAAAnRSTlMAAQGU/a4AAAAKSURBVHgBY2gAAACCAIFMF9ffAAAAAElFTkSuQmCC',
			'0.7' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAAHAQAAAAAZ1+HOAAAAAnRSTlMAAQGU/a4AAAANSURBVHgBY/h/ABMBAIFIDDoArVNCAAAAAElFTkSuQmCC',
			'0.64' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAABAAQAAAADEpO/ZAAAAAnRSTlMAAHaTzTgAAAAQSURBVHgBYxgwMApGwSgAAAOAAAFJNyFvAAAAAElFTkSuQmCC',
			'0.6'  => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAAGAQAAAADSizJrAAAAAnRSTlMAAQGU/a4AAAANSURBVHgBY/h/AA0BAF8ZCnvLOOh8AAAAAElFTkSuQmCC',
			'0.5'  => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAAFAQAAAABUH0DFAAAAAnRSTlMAAQGU/a4AAAANSURBVHgBY/h/ABkBAEInCLzjGSLoAAAAAElFTkSuQmCC',
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
