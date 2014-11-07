<?php

namespace Bookpress\Taxonomies;

class Type {

	/**
	 * Hook into the 'init' action
	 */
	public function __construct() {
		add_action( 'init', array( __CLASS__, 'init' ), 0 );
	}

	/**
	 * Register Custom Taxonomy
	 */
	public static function init() {

		$labels	 = array(
			'name'						 => __( 'Item types', 'bookpress' ),
			'singular_name'				 => __( 'Item type', 'bookpress' ),
			'menu_name'					 => __( 'Types', 'bookpress' ),
			'all_items'					 => __( 'All Types', 'bookpress' ),
			'parent_item'				 => __( 'Parent Type', 'bookpress' ),
			'parent_item_colon'			 => __( 'Parent Type:', 'bookpress' ),
			'new_item_name'				 => __( 'New Type', 'bookpress' ),
			'add_new_item'				 => __( 'Add New Type', 'bookpress' ),
			'edit_item'					 => __( 'Edit Type', 'bookpress' ),
			'update_item'				 => __( 'Update Type', 'bookpress' ),
			'separate_items_with_commas' => __( 'Separate types with commas', 'bookpress' ),
			'search_items'				 => __( 'Search Types', 'bookpress' ),
			'add_or_remove_items'		 => __( 'Add or remove types', 'bookpress' ),
			'choose_from_most_used'		 => __( 'Choose from the most used types', 'bookpress' ),
			'not_found'					 => __( 'Type Not Found', 'bookpress' ),
		);
		$rewrite = array(
			'slug'			 => 'itens-do-tipo',
			'with_front'	 => true,
			'hierarchical'	 => false,
		);
		$args	 = array(
			'labels'			 => $labels,
			'hierarchical'		 => true,
			'public'			 => true,
			'show_ui'			 => true,
			'show_admin_column'	 => true,
			'show_in_nav_menus'	 => true,
			'show_tagcloud'		 => false,
			'rewrite'			 => $rewrite,
		);
		register_taxonomy( 'item_type', array( 'item' ), $args );
	}

}

return new Type();
