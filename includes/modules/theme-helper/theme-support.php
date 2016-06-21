<?php
//************************************************************************************************
// Section: 		Theme Support Component
// Description:		Component that handles custom theme support aspects
//************************************************************************************************	
	
$theme_features = array(
	'favicons',
	'seo-metabox',
);

foreach ($theme_features as $theme_feature) {
	add_filter("current_theme_supports-{$theme_feature}", 'handle_custom_theme_support_args', 10, 3);
}

function handle_custom_theme_support_args($wp_result, $args, $add_theme_support_arg) {
	// current_theme_supports('feature', '__return_args') will return the args passed to add_theme_support('feature', $args);
	if ($args[0] === '__return_args') {
		return $add_theme_support_arg;
	// current_theme_supports('feature', 'type') returns true if 'type' was included in $args when add_theme_support('feature', $args);
	} elseif (in_array($args, (array) $add_theme_support_arg)) {
		return true;
	} else {
		return false;
	}
}


add_action('init', 'lai_check_custom_theme_support');
function lai_check_custom_theme_support() {
	// Enables uploading of .svg files
	if (current_theme_supports('svg-upload')) {
		// TODO: support multiple un-whitelisted filetypes through one function
		add_filter('upload_mimes', function($existing_mimes = array()) {
			// add svg to the list of allowed mimes and return
			$existing_mimes['svg'] = 'mime/type';
			return $existing_mimes;
		});
	}
	
	
	
	// Output contents of favicon file path to head across the site
	$theme_support_args = current_theme_supports('favicons', '__return_args');
	$favicon_tags_path = @$theme_support_args[0];
	if (!empty($favicon_tags_path) && file_exists($favicon_tags_path)) {
		$meta_echo_function = function() use ($favicon_tags_path) {
			echo file_get_contents($favicon_tags_path);
		};
		
		add_action('wp_head', $meta_echo_function);
		add_action('admin_head', $meta_echo_function);
		add_action('login_head', $meta_echo_function);
	}
	
	
	// Output of seo-metaboxes
	if (current_theme_supports('seo-metabox')) {
		add_action('wp_head', 'lai_display_seo_metatags');
	}
	
	
	// Output of Google Analytics
	if (current_theme_supports('google-analytics')) {
		add_action('wp_head', function() {
			if (!empty(site_setting('ga-property-id'))) {
				?><!-- Google Analytics -->
				<script>
					(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
					(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
					m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
					})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
					
					ga('create', '<?php echo site_setting('ga-property-id'); ?>', 'auto');
					ga('send', 'pageview');
				</script>
				<!-- End Google Analytics --><?php
			}
		});
	}
	
	
	// Output of Google Tag Manager
	if (current_theme_supports('google-tag-manager')) {
		add_action('wp_footer', function() {
			if (!empty(site_setting('gtag-manager-id'))) { 
				?><!-- Google Tag Manager -->
				<noscript>
					<iframe src="//www.googletagmanager.com/ns.html?id=<?php echo site_setting('gtag-manager-id'); ?>" height="0" width="0" style="display:none;visibility:hidden"></iframe>
				</noscript>
				<script>
					(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
					new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
					j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
					'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
					})(window,document,'script','dataLayer','<?php echo site_setting('gtag-manager-id'); ?>');
				</script>
				<!-- End Google Tag Manager --><?php
			}
		});
	}
	
	
	// Output of Adobe Typekit
	if (current_theme_supports('typekit')) {
		add_action('wp_footer', function() {
			if (!empty(site_setting('typekit-id'))) {
				echo '<script src="https://use.typekit.net/' . site_setting('typekit-id') . '.js"></script>';
				echo '<script>try{Typekit.load({ async: true });}catch(e){}</script>';
			}
		});
	}
	
	
	// Output of Facebook Tracking Pixel
	if (current_theme_supports('fb-pixel')) {
		add_action('wp_head', function() {
			if (!empty(site_setting('fb-pixel-id'))) {
				?><!-- Facebook Pixel -->
				<script>
					!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
					n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
					n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
					t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
					document,'script','https://connect.facebook.net/en_US/fbevents.js');
					
					fbq('init', '<?php echo site_setting('fb-pixel-id'); ?>');
					fbq('track', "PageView");
				</script>
				<noscript>
					<img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=<?php echo site_setting('fb-pixel-id'); ?>&ev=PageView&noscript=1"/>
				</noscript>
				<!-- End Facebook Pixel --><?php
			}
		});
	}
	
	// Output of Facebook Page ID Meta Tag
	if (current_theme_supports('fb-page-id')) {
		add_action('wp_head', function() {
			if (!empty(site_setting('fb-page-id'))) {
				?><!-- Facebook Page ID -->
				<meta property="fb:pages" content="<?php echo site_setting('fb-page-id'); ?>" />
				<?php
			}
		});
	}
	
	
	// Just output the GlobalSign Metatag if necessary, no need to check for support
	if (!empty(site_setting('globalsign-domain-verification'))) {
		add_action('wp_head', function() {
			echo '<meta name="globalsign-domain-verification" content="' . site_setting('globalsign-domain-verification') . '" />';
		});
	}
}