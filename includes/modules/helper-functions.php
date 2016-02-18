<?php
//************************************************************************************************
// Section: 		Helper Functions Module
// Description:		Module that manages the helper functions for this plugin
//************************************************************************************************




//************************************************************************************************
// Section: 		Mobile Detection Class
// Description:		Third party class for detecting mobile devices
//************************************************************************************************

require_once(LAI_PLUGIN_PATH . 'includes/modules/libraries/mobile-detection.php');


function lai_mobile_visitor() {
	$detect = new Mobile_Detect();
	
	if ($detect->isMobile()) { return true; } else { return false; }
}

function lai_tablet_visitor() {
	$detect = new Mobile_Detect();
	
	if ($detect->isTablet()) { return true; } else { return false; }
}