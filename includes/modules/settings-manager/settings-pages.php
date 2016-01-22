<?php
//************************************************************************************************
// Section: 		Settings Pages Component
// Description:		Component that generates the backend setting pages
//************************************************************************************************

// Build the settings page
function render_site_settings_pages($pages_config) {
	// Load the AdminPageClass code
	require_once(LAI_PLUGIN_PATH . 'includes/modules/settings-manager/admin-page-class/admin-page-class.php');
	
	
	// Instantiate the default page config
	$default_config = array(
		'menu'				=> 'look-agency-settings',		// Top level settings page in admin sidebar
		'page_title'		=> 'Site settings',				// Title of the settings page 
		'capability'		=> 'remove_users',			// The capability needed to view the page 
		'option_group'		=> 'look-agency-settings',		// Name of the option created in the database, access with get_option('saskbrokers_site_options');
		'id'				=> 'look-agency-settings',		// meta box id, unique per page, used to access page through /wp-admin/admin.php?page=page_id
		'fields'			=> array(),						// list of fields - If fields are defined here, then this is assumed to be a single tab page and the other fields array is not searched
		'local_images'		=> false,						// Use local or hosted images (meta box images for add/remove)
		'use_with_theme'	=> false,						// change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
		'icon_url'			=> '',							//  - (string) (optional) - URL to the icon, decorating the Top-Level-Menu (Top level Only)
		'position'			=> null,						//  - (string) (optional) - The position of the Menu in the admin menu(Top level Only)
		'desc_above_items' 	=> true,						// Display the description above item. If false or not set, displays below.
	);
	
	
	// TODO: $pages_config validation
	foreach ($pages_config as $page_id => $page_config) {
		
		// Fill in default values
		$prepared_config = array_merge($default_config, $page_config['config']);
		
		// Create the page with the specified configuration options
		$settings_pages[$page_id] = new BF_Admin_Page_Class($prepared_config);
				
		// Create tabs if they were specified - TODO: Check if array, not just !empty?
		if (!empty($page_config['tabs'])) {
			
			// Prepare the current page to have tabs added to it
			$settings_pages[$page_id]->OpenTabs_container('');
			
			
			// Prepare the list of tabs to be added
			// Initialize the tab links
			$page_tab_links = array('links' => array());
			
			// Loop through the specified tabs and add them to the links array
			foreach ($page_config['tabs'] as $tab_id => $tab_config) {
				$page_tab_links['links'][$tab_id] = $tab_config['link_text'];
			}
			
			// Add the tabs to the current page
			$settings_pages[$page_id]->TabsListing($page_tab_links);
  
  
			// Add the fields to each tab
			foreach ($page_config['tabs'] as $tab_id => $tab_config) {
				// Open this tab to write to it
				$settings_pages[$page_id]->OpenTab($tab_id);
				
				// Set the tab's title
				$settings_pages[$page_id]->Title($tab_config['title']);
				
				// Add all the fields to the tab
				foreach ($tab_config['fields'] as $field_id => $field_config) {
					$settings_pages[$page_id]->addField($field_id, $field_config);
				}
					
				// Close this tab now that we have finished setting it up
				$settings_pages[$page_id]->CloseTab();
			}
		}
	}
}