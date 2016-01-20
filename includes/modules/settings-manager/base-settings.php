<?php
//************************************************************************************************
// Section: 		Settings Manager Module - Base Settings
// Description:		Component that creates the basic settings for this site
//************************************************************************************************

function get_base_site_settings_pages() {
	$options_layout = array(
		'look-agency-settings' => array(
			'config' => array(
				'menu'				=> 'options-general.php',			// Top level settings page in admin sidebar
				'page_title'		=> 'Look Settings',					// Title of the settings page 
				'capability'		=> 'remove_users',					// The capability needed to view the page 
				'option_group'		=> 'look-agency-settings',			// Name of the option created in the database, access with get_option('saskbrokers_site_options');
				'id'				=> 'look-agency-settings',			// meta box id, unique per page, used to access page through /wp-admin/admin.php?page=page_id
				'fields'			=> array(),							// list of fields - If fields are defined here, then this is assumed to be a single tab page and the other fields array is not searched
				'local_images'		=> false,							// Use local or hosted images (meta box images for add/remove)
				'use_with_theme'	=> false,							// change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
				'icon_url'			=> '',								//  - (string) (optional) - URL to the icon, decorating the Top-Level-Menu (Top level Only)
				'position'			=> null,							//  - (string) (optional) - The position of the Menu in the admin menu(Top level Only)
				'desc_above_items' 	=> true,							// Display the description above item. If false or not set, displays below.
				'show_in_customizer'=> true,							// Display these settings in the Theme Customizer
			),
			'tabs' => array(		// If the fields array in the config was set, this will be ignored.
				'general'	=>	array(
					'link_text'		=>	'General',					// Tab button text
					'title'			=>	'',									// Can be blank for no header or contains the title shown at the top of the tab page (below the tab selector)
					'fields'		=>	array(
						'ga-property-id' => array(
							'type'		=>	'text',							// Possible values are text, textarea, TODO ADD MORE
							'name'		=>	'Google Analytics Property ID',	// Title of option
							'std'		=>	'',								// Placeholder content of option
							'desc'		=>	'',								// Description of option
							'style'		=>	'',								// Inline Styles
						),
					),
				),
			),
		),
	);
	
		
	return $options_layout;
}