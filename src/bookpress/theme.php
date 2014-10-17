<?php

namespace BookPress;

/**
 * Description of theme
 *
 * @author User
 */
class Theme {

	public function __construct() {
		add_action( 'after_setup_theme', array( __CLASS__, 'after_setup_theme' ) );
		require_once get_template_directory() . '/src/bookpress/types/item.php';
		require_once get_template_directory() . '/src/bookpress/taxonomies/author.php';
		require_once get_template_directory() . '/src/bookpress/metaboxes/item-info.php';
	}

	public static function after_setup_theme() {
		add_editor_style();
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'custom-background' );
		add_theme_support( 'custom-header' );
		add_theme_support( 'post-thumbnails' );
		load_theme_textdomain( 'bookpress', get_template_directory() . '/languages' );
	}

}

return new Theme();
