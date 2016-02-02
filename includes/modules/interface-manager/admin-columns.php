<?php
//************************************************************************************************
// Section: 		Admin Columns Component
// Description:		Component that manages the columns for post types in the backend
//************************************************************************************************

// TODO: Add ability to remove metaboxes based on roles of current user
function get_base_columns_to_remove() {
	$columns = array(
		'edit-post'	=>	array(
			!current_theme_supports('post-comments') ? 'comments' : '',
			!current_theme_supports('post-tags') ? 'tags' : '',
			'qppr_redirect',
		),
		'edit-page'	=>	array(
			'comments',
			'qppr_redirect',
		),
		'media'	=>	array(
			'comments',
		),
	);
	
	return $columns;
}

function look_remove_columns() {
	// Get the base columns to be removed
	$default_columns = get_base_columns_to_remove();
	
	// Modify the columns as requested by look Add-ons
	$columns = apply_filters('look-remove-columns', $default_columns);

	if (!empty($columns)) {
		foreach ($columns as $posttype => $columns_to_remove) {
			if (empty($columns_to_remove)) { continue; }
			
			if (version_compare(phpversion(), '5.3.0', '<')) {
				$function_name = create_function(
					'$columns', 
					'$columns_to_remove = '.var_export($columns_to_remove, true).'; 
					foreach ($columns_to_remove as $column) { 
						unset($columns[$column]);
					}
					return $columns;'
				);
				
				add_filter("manage_{$posttype}_posts_columns", $function_name, 9999);
				add_filter("manage_{$posttype}_columns", $function_name, 9999);
			} else {
				add_filter(
					"manage_{$posttype}_posts_columns", 
					function($columns) use ($columns_to_remove) {						
						foreach ($columns_to_remove as $column) { 
							unset($columns[$column]);
						}
						
						return $columns;
					}
				);
				
				add_filter(
					"manage_{$posttype}_columns", 
					function($columns) use ($columns_to_remove) {						
						foreach ($columns_to_remove as $column) { 
							unset($columns[$column]);
						}
						
						return $columns;
					}
				);
			}
		}
	}
}
add_action('admin_init', 'look_remove_columns', 9998); // Lower than add so that we can re-add date column to keep it last



function look_add_columns() {
	// Get the base columns to be added
	$default_columns = get_base_columns_to_add();
	
	// Modify the columns as requested by look Platform Add-ons
	$columns = apply_filters('look-add-columns', $default_columns);

	if (!empty($columns)) {
		foreach ($columns as $posttype => $columns_to_add) {
			if (empty($columns_to_add)) { continue; }
			
			// Add columns to the page
			if (version_compare(phpversion(), '5.3.0', '<')) {
				$function_name = create_function(
					'$columns', 
					'$columns_to_add = '.var_export($columns_to_add, true).'; 
					foreach ($columns_to_add as $id => $column) {
						$columns[$id] = $column[\'title\'];
					}
					return $columns;'
				);
				
				add_filter("manage_{$posttype}_posts_columns", $function_name, 9999);
			} else {
				add_filter(
					"manage_{$posttype}_posts_columns", 
					function($columns) use ($columns_to_add) {						
						foreach ($columns_to_add as $id => $column) {
							$columns[$id] = $column['title'];
						}
						
						return $columns;
					}
				);
			}
			
			// Setup callbacks to displaying content of columns
			foreach ($columns_to_add as $column_id => $column_info) {
				
				if (!empty($column_info['callback'])) {
					add_action("manage_{$posttype}_posts_custom_column", $column_info['callback'], 9999, 2);
				}
			}
		}
	}
}
add_action('admin_init', 'look_add_columns', 9999); // Higher than remove so that we can re-add date column to keep it last

function get_base_columns_to_add() {
	/*
		$columns = array(
			// Remember, post type can change if you can't add and remove columns with the same post type 
			// (variants like posts, post_posts, edit-posts, and posts all affecting the same page, but 
			// removing only works with edit-posts and adding only works with posts
			'posts'	=>	array( 
				'example_column_id' => array(
					'title'		=>	'Example Column',
					'callback'	=>	'callback_function_name',
				),
			),
		);
	*/
	
	return array();
}