<?php
/*
Plugin Name: Look Agency Inc.
Plugin URI: http://www.lookagency.com/
Description: Client site plugin for sites built / managed by Look Agency
Version: 0.0.1
Author: Look Agency
Author URI: http://www.lookagency.com/
Plugin Prefix: LAI
*/

//************************************************************************************************
// Section: 		Plugin Setup
// Description:		
//************************************************************************************************

// Setup plugin path
define('LAI_PLUGIN_PATH', plugin_dir_path(__FILE__));

// Setup plugin url
define('LAI_PLUGIN_URL', plugin_dir_url(__FILE__));

// Setup main plugin file path
define('LAI_PLUGIN_FILE', __FILE__);



//************************************************************************************************
// Section: 		Update Manager
// Description:		Module that handles the updating and upgrading of the plugin
//************************************************************************************************

require_once(LAI_PLUGIN_PATH . 'includes/modules/update-manager/update-manager.php');




//************************************************************************************************
// Section: 		Settings Manager Module
// Description:		Module that manages the settings pages
//************************************************************************************************

require_once(LAI_PLUGIN_PATH . 'includes/modules/settings-manager/settings-manager.php');



//************************************************************************************************
// Section: 		User Interface Manager Module
// Description:		Module that manages the general interface for sites
//************************************************************************************************

require_once(LAI_PLUGIN_PATH . 'includes/modules/interface-manager/interface-manager.php');