<?php
//************************************************************************************************
// Section: 		User Interface Manager Module
// Description:		Module that manages the general interface for sites
//************************************************************************************************




//************************************************************************************************
// Section: 		Clean WordPress Component
// Description:		Component that manages modifying the WordPress defaults - purpose to clean up
//************************************************************************************************

require_once(LAI_PLUGIN_PATH . 'includes/modules/interface-manager/clean-wp.php');



//************************************************************************************************
// Section: 		Metaboxes Removal Component
// Description:		Component that manages removing metaboxes
//************************************************************************************************

require_once(LAI_PLUGIN_PATH . 'includes/modules/interface-manager/metabox-remove.php');



//************************************************************************************************
// Section: 		Admin Menus Component
// Description:		Component that manages the backend menus
//************************************************************************************************

require_once(LAI_PLUGIN_PATH . 'includes/modules/interface-manager/admin-menus.php');



//************************************************************************************************
// Section: 		Admin Columns Component
// Description:		Component that manages the columns for post types in the backend
//************************************************************************************************

require_once(LAI_PLUGIN_PATH . 'includes/modules/interface-manager/admin-columns.php');



//************************************************************************************************
// Section: 		Login Page Component
// Description:		Modifies the login page
//************************************************************************************************

require_once(LAI_PLUGIN_PATH . 'includes/modules/interface-manager/login-page.php');