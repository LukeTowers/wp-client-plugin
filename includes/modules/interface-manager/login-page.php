<?php
//************************************************************************************************
// Section: 		Login Page Component
// Description:		Modifies the login page
//************************************************************************************************

// Add Look Logo to login page
// TODO: Should we have the branding being set as the client's branding or Look's branding?
function look_login_logo() { ?>
    <style type="text/css">
        .login #login h1 a {
            background-image: url('<?php echo LAI_PLUGIN_URL . 'includes/images/look-logo.png'; ?>') !important;
            background-size: contain !important;
            width: 175px !important;
            height: 66px !important;
        }
        .login #nav a {
	        float: left !important;
	        margin-left: 5px !important;
        }
        #backtoblog {
	        clear: both !important;
        }
    </style>
<?php }
add_action('login_enqueue_scripts', 'look_login_logo');


// Replace default login page logo link to link to Look. ?replace with link to the homepage?
function look_change_wplogin_url() {
	return 'http://www.lookagency.com/';
}
add_filter('login_headerurl', 'look_change_wplogin_url');


// Replace default login page logo title text for platform branding
function look_change_wplogin_title() {	
	return "Powered by Look Agency";
}
add_filter('login_headertitle', 'look_change_wplogin_title');