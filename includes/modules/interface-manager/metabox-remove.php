<?php
//************************************************************************************************
// Section: 		Metaboxes Removal Component
// Description:		Component that manages removing metaboxes
//************************************************************************************************

// TODO: Add ability to remove metaboxes based on roles of current user


function look_remove_metaboxes() {
	// Get the base metaboxes to be removed
	$default_metaboxes = get_base_metaboxes_to_remove();
	
	// Modify the metaboxes as requested by Cadet Platform Add-ons
	$metaboxes = apply_filters('look-remove-metaboxes', $default_metaboxes);
	
	if (!empty($metaboxes)) {
		foreach ($metaboxes as $posttype => $metabox) {
			foreach ($metabox as $id => $context) {
				remove_meta_box($id, $posttype, $context);
			}
		}
	}
}
add_action('admin_menu', 'look_remove_metaboxes', 9999);


function get_base_metaboxes_to_remove() {
	$metaboxes = array(
		'post'	=>	array(
			'tagsdiv-post_tag'	=>	'side',
			'edit-box-ppr'		=>	'normal',
		),
		'page'	=>	array(
			'edit-box-ppr'		=>	'normal',
		),
		'event'	=>	array(
			'postexcerpt'		=>	'normal',
			'postcustom'		=>	'normal',
			'postimagediv'		=>	'side',
			'commentstatusdiv'	=>	'normal',
			'commentsdiv'		=>	'normal',
			'authordiv'			=>	'normal',
			'authordiv'			=>	'normal',
			'event-categorydiv'	=>	'side',
			'tagsdiv-event-tag'	=>	'side',
		),
	);
	
	return $metaboxes;
}


function remove_featured_image_metabox() {
	remove_meta_box('postimagediv', 'event', 'side');
}
add_action('do_meta_boxes', 'remove_featured_image_metabox');