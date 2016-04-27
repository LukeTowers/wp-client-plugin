<?php
//************************************************************************************************
// Section: 		SEO Metaboxes
// Description:		Module for managing the SEO Manager related metaboxes
//************************************************************************************************

// Register the metaboxes
function add_seo_metaboxes($posttype, $post) {
	// Get the supported post types
	$supported_post_types = current_theme_supports('seo-metabox', '__return_args');
	
	if (!empty($supported_post_types) && is_array($supported_post_types)) {
		// General SEO
		add_meta_box(
			'seo_options_metabox',					// ID of the metabox
			'SEO Options',							// Title of the metabox
			'render_seo_options_metabox',			// Callback function to print out the html for the metabox
			$supported_post_types,					// "Screen" to display metabox on, i.e. post type
			'normal',								// Context of the metabox
			'core'									// Priority of the metabox being displayed
		);
	}
}
add_action('add_meta_boxes', 'add_seo_metaboxes', 10, 2);



// Save the seo options
function update_seo_options($post_id) {
	if (empty($post_id)) {
		return $post_id;
	}
	
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}
	
	// Check if the nonce is set.
	if (!isset($_POST['seo_options_nonce'])) {
		return $post_id;
	}
	$nonce = $_POST['seo_options_nonce'];

	// Verify that the nonce is valid.
	if (!wp_verify_nonce($nonce, 'seo_options')) {
		return $post_id;
	}
	
	// Get the current post object
	$post = get_post($post_id);
					
	// Initialize the working variables
	$seo_options = array();
	
	// Process the seo options
	$seo_options['meta_description'] = htmlspecialchars(@$_POST['meta_description']) ?: htmlspecialchars(lai_get_excerpt_content_by_id($post_id, 20));
	$seo_options['social_title']     = htmlspecialchars(@$_POST['social_title']) ?: htmlspecialchars($post->post_title);
	
	// Update the header options
	update_post_meta($post_id, 'seo_options', $seo_options);
}
add_action('save_post', 'update_seo_options', 10);



// Renders the SEO Options metabox
function render_seo_options_metabox($post) {
	$seo_options = get_post_meta($post->ID, 'seo_options', true);
	
	if (empty($seo_options) || !is_array($seo_options)) {
		$seo_options = array();
	}
	
	wp_nonce_field('seo_options', 'seo_options_nonce');
	?>
	<style>
		#seo_options_metabox .row {
			margin-bottom: 15px;
		}
		#seo_options_metabox .row * {
			display: block;
			width: 100%;
		}
		#meta_description {
			min-height: 100px;
			min-width: 100%;
		}
	</style>
	<div class="row">
		<label for="meta_description">Description:</label>
		<textarea id="meta_description" name="meta_description"><?php echo @$seo_options['meta_description']; ?></textarea>
	</div>
	<div class="row">
		<label for="social_title">Social Title:</label>
		<input name="social_title" id="social_title" value="<?php echo @$seo_options['social_title']; ?>" type="text" placeholder="Title to use on FB & Twitter if different from main title.">
	</div>
	<?php
}