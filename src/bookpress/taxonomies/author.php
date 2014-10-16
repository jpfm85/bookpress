<?php

namespace BookPress\Taxonomies;

class Author {

	public function __construct() {

// Hook into the 'init' action
		add_action( 'init', array( __CLASS__, 'init' ), 0 );
	}

	// Register Custom Taxonomy
	public static function init() {

		$labels	 = array(
			'name'						 => _x( 'Authors', 'Taxonomy General Name', 'bookpress' ),
			'singular_name'				 => _x( 'Author', 'Taxonomy Singular Name', 'bookpress' ),
			'menu_name'					 => __( 'Authors', 'bookpress' ),
			'all_items'					 => __( 'All Authors', 'bookpress' ),
			'parent_item'				 => __( 'Parent Author', 'bookpress' ),
			'parent_item_colon'			 => __( 'Parent Author:', 'bookpress' ),
			'new_item_name'				 => __( 'New Author', 'bookpress' ),
			'add_new_item'				 => __( 'Add New Author', 'bookpress' ),
			'edit_item'					 => __( 'Edit Author', 'bookpress' ),
			'update_item'				 => __( 'Update Author', 'bookpress' ),
			'separate_items_with_commas' => __( 'Separate authors with commas', 'bookpress' ),
			'search_items'				 => __( 'Search Authors', 'bookpress' ),
			'add_or_remove_items'		 => __( 'Add or remove authors', 'bookpress' ),
			'choose_from_most_used'		 => __( 'Choose from the most used authorr', 'bookpress' ),
			'not_found'					 => __( 'Author Not Found', 'bookpress' ),
		);
		$rewrite = array(
			'slug'			 => 'autores',
			'with_front'	 => true,
			'hierarchical'	 => false,
		);
		$args	 = array(
			'labels'			 => $labels,
			'hierarchical'		 => true,
			'public'			 => true,
			'show_ui'			 => true,
			'show_admin_column'	 => true,
			'show_in_nav_menus'	 => false,
			'show_tagcloud'		 => false,
			'rewrite'			 => $rewrite,
		);
		register_taxonomy( 'author', array( 'item' ), $args );
	}

}

return new Author();

