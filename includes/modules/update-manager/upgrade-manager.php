<?php
//************************************************************************************************
// Section: 		Upgrade Manager
// Description:		Component that manages the upgrading of a look_component
//************************************************************************************************

// Check component to see if it needs to be upgraded
function look_check_component() {
	// Load the component versions from the database
	$look_component_versions = get_option('look_component_versions');
	
	// Load the components being checked for upgrades
	$components = get_components_to_update();
	
	// Go through each component
	foreach ($components as $slug => $component) {
		switch ($component['type']) {
			case "plugin":
				$current_plugin = get_plugin_data($component['plugin_file'], false);
				$current_version = $current_plugin['Version'];
				break;
			case "theme":
				$current_theme = wp_get_theme($slug);
				$current_version = $current_theme->get('Version');
				break;
			default:
		}
		
		if (!empty($current_version)) {
			// Load the old version of the component from the database, default to 0.0.1
			$old_version = @$look_component_versions[$slug];
			if (empty($old_version)) {
				$old_version = "0.0.1";
			}
			
			// If the database version is lower than the version detected present now then upgrade the component
			if (version_compare($current_version, $old_version, '>')) {
				look_upgrade_component($component, $old_version);
				look_update_component_version($current_version, $slug);
			}
		}
	}
}
add_action('admin_init', 'look_check_component');



// Run any upgrades that need to be run on this component
function look_upgrade_component($component, $old_version) {
	// Verify that the path to the upgrades is set and there are upgrades to perform
	if (empty($component['upgrade_path']) || empty($component['upgrades']) || empty($old_version)) {
		return;
	}
	
	foreach ($component['upgrades'] as $upgrade) {
		if (version_compare($old_version, $upgrade, '<')) {
			$upgrade_function = 'upgrade_' . str_replace('.', '_', $upgrade);
			$upgrade_file = $component['upgrade_path'] . $upgrade_function . '.php';
			
			if (file_exists($upgrade_file)) {
				require_once($upgrade_file);
				if (function_exists($upgrade_function)) {
					call_user_func($upgrade_function);
				} else {
					echo "Function $upgrade_function doesn't exist in $upgrade_file";
				}
			} else {
				echo "$upgrade_file doesn't exist.";
			}
		}
	}	
}



// Update the component's version in the database
function look_update_component_version($current_version, $slug) {
	// Load the component versions into a working variable
	$look_component_versions = get_option('look_component_versions');
	
	// Update the current component's version in the working variable
	$look_component_versions[$slug] = $current_version;
	
	// Update the component versions in the database
	update_option('look_component_versions', $look_component_versions);
}