<?php
//************************************************************************************************
// Section: 		Clean WordPress Component
// Description:		Component that manages modifying the WordPress defaults - purpose to clean up
//************************************************************************************************

function clean_wordpress() {
	disable_emojis();
	remove_wp_head_traces();
}
add_action('init', 'clean_wordpress', 100);


// Disable all traces of WP emojis
function disable_emojis() {
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_action('admin_print_styles', 'print_emoji_styles');
	remove_filter('the_content_feed', 'wp_staticize_emoji');
	remove_filter('comment_text_rss', 'wp_staticize_emoji');
	remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
	add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
}

// Disable tinymce emojis plugin
function disable_emojis_tinymce($plugins) {
	if (is_array($plugins)) {
		return array_diff($plugins, array('wpemoji'));
	} else {
		return array();
	}
}


// Remove meta information added to <head> by WordPress
function remove_wp_head_traces() {
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'rsd_link');
}


// Remove unwanted dashboard widgets
function look_remove_dashboard_widgets() {
	remove_action('welcome_panel', 'wp_welcome_panel');						// Remove the welcome panel
	remove_meta_box('dashboard_primary', 'dashboard', 'side');				// Remove the wordpress news
}
add_action('wp_dashboard_setup', 'look_remove_dashboard_widgets');



// Remove the WordPress dashboard footer text
function modify_dashboard_footer() {
	echo '<span id="footer-thankyou">Website powered by <a href="https://luketowers.ca" target="_blank">Luke Towers Consulting</a></span>';
}
add_filter('admin_footer_text', 'modify_dashboard_footer');
