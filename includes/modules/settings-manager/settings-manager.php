<?php
//************************************************************************************************
// Section: 		Settings Manager Module
// Description:		Module that manages the settings page
// TODO:
//	- Need to have capabilities required for different tiers of settings, unit info being high tier (admin access / intervention by us),
//	- contact medium, plugins as required (maybe even set when setting up settings for the individual plugins?)
//	- Note: Some issues are present with options in the gravity form being changed through the gform panel and then being changed through the
//	- updating of the permission slip post. Look into these when possible.
//************************************************************************************************

function look_get_site_settings() {
	// Load the settings from the database
	$site_settings = get_option('look-agency-settings');
	
	// Default site settings
	$site_defaults = array();
	
	$site_info = array(
		'ga_property_id'=>	@$site_settings['ga-property-id'],
	);
	
	$site_info = array_merge($site_defaults, $site_info);
	
	return $site_info;
}


// Build the pages_config variable
function get_settings_config() {
	// Build the default site settings pages - set in base-settings.php
	$default_pages_config = get_base_site_settings_pages();
	
	// Modify the settings pages as requested by Look add ons
	$pages_config = apply_filters('look_settings_pages', $default_pages_config);
	
	return $pages_config;
}

// Build the settings pages
function setup_site_settings() {
	if (!is_admin() || !current_user_can('edit_theme_options')) {
		return;
	}
	
	// Load the pages_config
	$pages_config = get_settings_config();
	
	// Render the settings pages
	render_site_settings_pages($pages_config);
}
add_action('after_setup_theme', 'setup_site_settings');



//************************************************************************************************
// Section: 		Settings Pages
// Description:		Component that generates the backend setting pages
//************************************************************************************************
require_once(LAI_PLUGIN_PATH . 'includes/modules/settings-manager/settings-pages.php');



//************************************************************************************************
// Section: 	 	Base Settings
// Description:		Component that creates the basic settings for this site
//************************************************************************************************

require_once(LAI_PLUGIN_PATH . 'includes/modules/settings-manager/base-settings.php');