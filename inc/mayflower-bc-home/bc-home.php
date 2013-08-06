<?php

#################################
// Small Ads Custom Post Type
#################################

if ( current_user_can('manage_network') ) {
	
	// Register Custom Post Type
	function small_home_ad() {
	
		$labels = array(
			'name'                => 'Small Ads',
			'singular_name'       => 'Small Ad',
			'menu_name'           => 'Small Ads',
			'parent_item_colon'   => 'Parent Small Ad',
			'all_items'           => 'All Small Ads',
			'view_item'           => 'View Small Ad',
			'add_new_item'        => 'Add New Small Ad',
			'add_new'             => 'New Small Ad',
			'edit_item'           => 'Edit Small Ad',
			'update_item'         => 'Update Small Ad',
			'search_items'        => 'Search Small Ads',
			'not_found'           => 'No Small Ads found',
			'not_found_in_trash'  => 'No Small Ads found in trash',
		);
		$args = array(
			'label'               => 'small_ad',
			'description'         => 'Small Ads for college home page',
			'labels'              => $labels,
			'supports'            => array( ),
			'taxonomies'          => array( '' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			//'menu_icon'           => '',
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'page',
		);
		register_post_type( 'small_ad', $args );
	
	}
	
	// Hook into the 'init' action
	add_action( 'init', 'small_home_ad', 0 );	

} // end current_user_can

?>