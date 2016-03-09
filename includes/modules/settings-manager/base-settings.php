<?php
//************************************************************************************************
// Section: 		Settings Manager Module - Base Settings
// Description:		Component that creates the basic settings for this site
//************************************************************************************************

// TODO: Register settings based on theme support for them
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
						'gtag-manager-id' => array(
							'type'		=>	'text',							// Possible values are text, textarea, TODO ADD MORE
							'name'		=>	'Google Tag Manager ID',		// Title of option
							'std'		=>	'',								// Placeholder content of option
							'desc'		=>	'',								// Description of option
							'style'		=>	'',								// Inline Styles
						),
						'ga-property-id' => array(
							'type'		=>	'text',							// Possible values are text, textarea, TODO ADD MORE
							'name'		=>	'Google Analytics Property ID',	// Title of option
							'std'		=>	'',								// Placeholder content of option
							'desc'		=>	'',								// Description of option
							'style'		=>	'',								// Inline Styles
						),
						'gmaps-api-key' => array(
							'type'		=>	'text',							// Possible values are text, textarea, TODO ADD MORE
							'name'		=>	'Google Maps API Key',			// Title of option
							'std'		=>	'',								// Placeholder content of option
							'desc'		=>	'',								// Description of option
							'style'		=>	'',								// Inline Styles
						),
					),
				),
				'contact'	=>	array(
					'link_text'		=>	'Contact',					// Tab button text
					'title'			=>	'',									// Can be blank for no header or contains the title shown at the top of the tab page (below the tab selector)
					'fields'		=>	array(
						'contact_address' => array(
							'type'		=>	'text',							// Possible values are text, textarea, TODO ADD MORE
							'name'		=>	'Address',						// Title of option
							'std'		=>	'',								// Placeholder content of option
							'desc'		=>	'',								// Description of option
							'style'		=>	'',								// Inline Styles
						),
						'contact_phone' => array(
							'type'		=>	'text',							// Possible values are text, textarea, TODO ADD MORE
							'name'		=>	'Phone',						// Title of option
							'std'		=>	'',								// Placeholder content of option
							'desc'		=>	'',								// Description of option
							'style'		=>	'',								// Inline Styles
						),
						'contact_email' => array(
							'type'		=>	'text',							// Possible values are text, textarea, TODO ADD MORE
							'name'		=>	'Email',						// Title of option
							'std'		=>	'',								// Placeholder content of option
							'desc'		=>	'',								// Description of option
							'style'		=>	'',								// Inline Styles
						),
					),
				),
				'social'	=>	array(
					'link_text'		=>	'Social',					// Tab button text
					'title'			=>	'',									// Can be blank for no header or contains the title shown at the top of the tab page (below the tab selector)
					'fields'		=>	array(
						'facebook_url' => array(
							'type'		=>	'text',							// Possible values are text, textarea, TODO ADD MORE
							'name'		=>	'Facebook URL',					// Title of option
							'std'		=>	'',								// Placeholder content of option
							'desc'		=>	'',	// Description of option
							'style'		=>	'',								// Inline Styles
						),
						'instagram_url' => array(
							'type'		=>	'text',							// Possible values are text, textarea, TODO ADD MORE
							'name'		=>	'Instagram URL',				// Title of option
							'std'		=>	'',								// Placeholder content of option
							'desc'		=>	'',								// Description of option
							'style'		=>	'',								// Inline Styles
						),
						'linkedin_url' => array(
							'type'		=>	'text',							// Possible values are text, textarea, TODO ADD MORE
							'name'		=>	'LinkedIn URL',					// Title of option
							'std'		=>	'',								// Placeholder content of option
							'desc'		=>	'',								// Description of option
							'style'		=>	'',								// Inline Styles
						),
						'twitter_handle' => array(
							'type'		=>	'text',							// Possible values are text, textarea, TODO ADD MORE
							'name'		=>	'Twitter Handle',				// Title of option
							'std'		=>	'',								// Placeholder content of option
							'desc'		=>	'Twitter handle without the @',	// Description of option
							'style'		=>	'',								// Inline Styles
						),
						'google_plus_url' => array(
							'type'		=>	'text',							// Possible values are text, textarea, TODO ADD MORE
							'name'		=>	'Google+ URL',					// Title of option
							'std'		=>	'',								// Placeholder content of option
							'desc'		=>	'',								// Description of option
							'style'		=>	'',								// Inline Styles
						),
					),
				),
				'publisher'	=>	array(
					'link_text'		=>	'Publisher (Organization)',			// Tab button text
					'title'			=>	'',									// Can be blank for no header or contains the title shown at the top of the tab page (below the tab selector)
					'fields'		=>	array(
						'publisher_name' => array(
							'type'		=>	'text',							// Possible values are text, textarea, TODO ADD MORE
							'name'		=>	'Name',						// Title of option
							'std'		=>	'',								// Placeholder content of option
							'desc'		=>	'',								// Description of option
							'style'		=>	'',								// Inline Styles
						),
						'publisher_legal_name' => array(
							'type'		=>	'text',							// Possible values are text, textarea, TODO ADD MORE
							'name'		=>	'Legal Name',						// Title of option
							'std'		=>	'',								// Placeholder content of option
							'desc'		=>	'',								// Description of option
							'style'		=>	'',								// Inline Styles
						),
						'publisher_contact_phone' => array(
							'type'		=>	'text',							// Possible values are text, textarea, TODO ADD MORE
							'name'		=>	'Contact Phone',				// Title of option
							'std'		=>	'',								// Placeholder content of option
							'desc'		=>	'',								// Description of option
							'style'		=>	'',								// Inline Styles
						),
						'publisher_contact_email' => array(
							'type'		=>	'text',							// Possible values are text, textarea, TODO ADD MORE
							'name'		=>	'Contact Email',				// Title of option
							'std'		=>	'',								// Placeholder content of option
							'desc'		=>	'',								// Description of option
							'style'		=>	'',								// Inline Styles
						),
						'publisher_logo' => array(
							'type'		=>	'image',						// Possible values are text, textarea, TODO ADD MORE
							'name'		=>	'Logo',							// Title of option
							'std'		=>	'',								// Placeholder content of option
							'desc'		=>	'',								// Description of option
							'style'		=>	'width: auto !important; height: auto !important;',								// Inline Styles
						),
					),
				),
			),
		),
	);
	
		
	return $options_layout;
}