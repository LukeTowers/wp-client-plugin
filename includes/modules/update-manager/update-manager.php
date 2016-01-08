<?php
//************************************************************************************************
// Section: 		Update Manager
// Description:		Module that handles the updating and upgrading of the plugin
//************************************************************************************************

// AUTO UPDATE FILTERS
add_filter( 'allow_minor_auto_core_updates', '__return_true' );
// add_filter( 'auto_update_plugin', '__return_true' );
// add_filter( 'auto_update_theme', '__return_true' );
// add_filter( 'allow_major_auto_core_updates', '__return_false' );
// add_filter( 'auto_core_update_send_email', '__return_false' );
// add_filter( 'send_core_update_notification_email', '__return_false' );


// Aggragate the components to be managed for updating
function get_components_to_update() {
	/*
		$components = array(
			'demo-theme'	=>	array(
				'type'		=>	'theme',
				'metadata_url'	=>	'http://example.com/themes/demo-theme/metadata.json',
				'upgrade_path'	=>	'PHP_PATH_TO_FOLDER_WHERE_UPGRADE_FUNCTIONS_STORED',
				'upgrades'		=>	array(
					'1.2.0',
					'1.3.4',
					'etc.',
				),
			),
			'demo-plugin'	=>	array(
				'type'			=>	'plugin',
				'metadata_url'	=>	'http://example.com/plugins/demo-plugin',
				'plugin_file'	=>	'DM_PLUGIN_FILE',
				'upgrade_path'	=>	'PHP_PATH_TO_FOLDER_WHERE_UPGRADE_FUNCTIONS_STORED',
				'upgrades'		=>	array(
					'1.2.0',
					'1.3.4',
					'etc.',
				),
			),
		);
	*/
	
	$base_components = array(
		'look-agency'	=>	array(
			'type'			=>	'plugin',
			'metadata_url'	=>	'http://built-by-look.com/plugins/look-agency/metadata.json',
			'plugin_file'	=>	LAI_PLUGIN_FILE,
			'upgrade_path'	=>	LAI_PLUGIN_PATH . 'includes/modules/update-manager/upgrades/',
			'upgrades'		=>	array(),
		),
	);
	
	// Setup the update checkers
	$components = apply_filters('look_component_updates', $base_components);
	
	return $components;
}

// Build the update checkers for the components
function build_update_checkers() {
	
	$components = get_components_to_update();
	
	$update_checkers = array();
	
	foreach ($components as $slug => $component) {
		switch ($component['type']) {
			case "plugin":
				$update_checkers[$slug] = PucFactory::buildUpdateChecker(
				    $component['metadata_url'],
				    $component['plugin_file'],
				    $slug
				);
				break;
			case "theme":
				$update_checkers[$slug] = new ThemeUpdateChecker(
					$slug,
					$component['metadata_url']
				);
				break;
			default:
		}
	}
}
add_action('after_setup_theme', 'build_update_checkers');



//************************************************************************************************
// Section: 		Plugin Update Checker
// Description:		Component that checks for updates to plugins
//************************************************************************************************
require_once(LAI_PLUGIN_PATH . 'includes/modules/update-manager/plugin-update-checker.php');



//************************************************************************************************
// Section: 		Theme Update Checker
// Description:		Component that checks for updates to themes
//************************************************************************************************
require_once(LAI_PLUGIN_PATH . 'includes/modules/update-manager/theme-update-checker.php');



//************************************************************************************************
// Section: 		Upgrade Manager
// Description:		Component that manages the upgrading of a look_component
//************************************************************************************************
require_once(LAI_PLUGIN_PATH . 'includes/modules/update-manager/upgrade-manager.php');