<?php
//************************************************************************************************
// Section: 		SEO Manager Module
// Description:		Module that manages the SEO functions of this plugin
//************************************************************************************************

// Generate and output the SEO metatags
function lai_display_seo_metatags($post_id = 0) {
	// If the post ID hasn't been set, attempt to identify it
	if (empty($post_id)) {
		// Attempt to pull it from the global WP_Query object
		global $wp_query;
		$post_id = @$wp_query->post->ID;
		
		if (empty($post_id)) {
			// Attempt to pull it from the global post object
			global $post;
			$post_id = @$post->ID;
			
			// Check if front page
			if (is_front_page()) {
				$post_id = get_option('page_on_front');
			} elseif (is_home()) {
				$post_id = get_option('page_for_posts');
			}
		}
	}
	
	// Verify that we found a post id to use
	if (empty($post_id)) {
		return false;
	}
	
	// Get the current post object
	$current_post = get_post($post_id);
	
	// Get the permalink
	$permalink = get_permalink($post_id);
	
	// Get the seo options for the specified post
	$seo_options = get_post_meta($post_id, 'seo_options', true);
		
	// Get the featured image for the specified post
	$has_image = false;
	$url_array = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'full');
	if (!empty($url_array[0])) {
		$has_image = true;
		$image_url = $url_array[0];
	}
	
	// Get the title to use for OG & Twitter cards
	$social_title = @$seo_options['social_title'] ?: htmlspecialchars($current_post->post_title);
	
	// Determine the page content type
	if ($current_post->post_type === 'post') {
		$content_type = 'article';
	} else {
		$content_type = 'website';
	}
	
	// Display the meta tags ?>
	<!-- General Meta -->
	<meta name="description" content="<?php echo @$seo_options['meta_description']; ?>" />
	<meta name="keywords" content="<?php echo @$seo_options['meta_keywords']; ?>" />
	
	<!-- OpenGraph Meta & Twitter Card Meta -->
	<meta name="og:url" content="<?php echo $permalink; ?>" />
	<meta name="og:title" content="<?php echo $social_title; ?>" />
	<meta name="og:type" content="<?php echo $content_type; ?>" />
	<meta name="og:description" content="<?php echo @$seo_options['meta_description']; ?>" />
	<meta name="og:site_name" content="<?php echo bloginfo('name'); ?>" />
	<?php if ($has_image) { ?>
		<meta name="og:image" content="<?php echo $image_url; ?>" />
		<meta name="twitter:card" content="summary_large_image" />
		<meta name="twitter:image" content="<?php echo $image_url; ?>" />
	<?php } else { ?>
		<meta name="twitter:card" content="summary" />
	<?php } ?>
	<meta name="twitter:site" content="@<?php echo site_setting('twitter_handle'); ?>" />
	<meta name="twitter:title" content="<?php echo $social_title; ?>" />
	<meta name="twitter:description" content="<?php echo @$seo_options['meta_description']; ?>" />
	<?php
}



//************************************************************************************************
// Section: 		SEO Metaboxes
// Description:		Module for managing the SEO Manager related metaboxes
//************************************************************************************************

require_once(LAI_PLUGIN_PATH . 'includes/modules/seo-manager/metaboxes.php');



//************************************************************************************************
// Section: 		SEO SCHEMA.ORG Structured Data
// Description:		Module for managing the structured data output
//************************************************************************************************

require_once(LAI_PLUGIN_PATH . 'includes/modules/seo-manager/schema-data.php');