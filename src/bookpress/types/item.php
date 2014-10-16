<?php

namespace BookPress\Types;

class Item {

	public function __construct() {
		// Hook into the 'init' action
		add_action( 'init', array( __CLASS__, 'init' ), 0 );
		add_filter( 'manage_edit-item_columns', array( __CLASS__, 'manage_edit_item_columns' ) );
		add_filter( 'manage_edit-item_sortable_columns', array( __CLASS__, 'manage_edit_item_sortable_columns' ) );
		add_action( 'manage_item_posts_custom_column', array( __CLASS__, 'manage_item_posts_custom_column' ), 10, 2 );
	}

	// Register Custom Post Type
	public static function init() {

		$labels	 = array(
			'name'				 => _x( 'Items', 'Post Type General Name', 'bookpress' ),
			'singular_name'		 => _x( 'Item', 'Post Type Singular Name', 'bookpress' ),
			'menu_name'			 => __( 'Collection', 'bookpress' ),
			'parent_item_colon'	 => __( 'Parent Item:', 'bookpress' ),
			'all_items'			 => __( 'All Items', 'bookpress' ),
			'view_item'			 => __( 'View Item', 'bookpress' ),
			'add_new_item'		 => __( 'Add New Item', 'bookpress' ),
			'add_new'			 => __( 'Add New', 'bookpress' ),
			'edit_item'			 => __( 'Edit Item', 'bookpress' ),
			'update_item'		 => __( 'Update Item', 'bookpress' ),
			'search_items'		 => __( 'Search Item', 'bookpress' ),
			'not_found'			 => __( 'Item not found', 'bookpress' ),
			'not_found_in_trash' => __( 'Item not found in Trash', 'bookpress' ),
		);
		$rewrite = array(
			'slug'		 => 'acervo',
			'with_front' => true,
			'pages'		 => true,
			'feeds'		 => false,
		);
		$args	 = array(
			'label'					 => __( 'item', 'bookpress' ),
			'description'			 => __( 'Library items', 'bookpress' ),
			'labels'				 => $labels,
			'supports'				 => array( 'title', 'editor', 'excerpt', 'thumbnail', 'post-formats', 'comments', ),
			'hierarchical'			 => false,
			'public'				 => true,
			'show_ui'				 => true,
			'show_in_menu'			 => true,
			'show_in_nav_menus'		 => false,
			'show_in_admin_bar'		 => true,
			'menu_position'			 => 5,
			'can_export'			 => true,
			'has_archive'			 => true,
			'exclude_from_search'	 => false,
			'publicly_queryable'	 => true,
			'rewrite'				 => $rewrite,
			'capability_type'		 => 'post',
			'taxonomies'			 => array( 'category', 'post_tag' ),
		);
		register_post_type( 'item', $args );
	}

	public static function manage_edit_item_columns( $columns ) {
		$columns [ 'physical_location' ] = __( 'Physical location', 'bookpress' );
		return $columns;
	}

	public static function manage_edit_item_sortable_columns( $sortable_columns ) {

		$sortable_columns [ 'physical_location' ] = '_physical_location';
		return $sortable_columns;
	}

	public static function manage_item_posts_custom_column( $column, $post_id ) {

		switch ( $column ) {
			case 'physical_location':
				echo get_post_meta( $post_id, '_physical_location', true );
				break;
		}
	}

}

return new Item();

