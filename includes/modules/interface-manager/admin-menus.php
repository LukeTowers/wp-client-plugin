<?php
//************************************************************************************************
// Section: 		Admin Menus Component
// Description:		Component that manages the backend menus
//************************************************************************************************

function look_remove_admin_menus() {
	remove_menu_page('tools.php');			// Remove the tools menu page
	remove_menu_page('edit-comments.php');	// Remove the comments menu page
	remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=post_tag');	// Remove the post tags page
		
	$user = wp_get_current_user();
	if (!$user->has_cap('publish_pages')) {
		remove_menu_page( 'index.php' );
	}
}
add_action('admin_menu', 'look_remove_admin_menus');



// Remove the WordPress logo button and comments from the admin bar
function remove_wp_logo($wp_admin_bar) {
	$wp_admin_bar->remove_node('wp-logo');
	$wp_admin_bar->remove_node('comments');
}
add_action('admin_bar_menu', 'remove_wp_logo', 9999);