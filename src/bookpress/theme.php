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
		add_action( 'template_redirect', array( __CLASS__, 'template_redirect' ) );

		add_filter( 'search_queries', array( __CLASS__, 'search_queries' ), 10, 1 );
		add_filter( 'comment_form_default_fields', array( __CLASS__, 'comment_form_default_fields' ) );
		add_filter( 'author_like_get_posts', array( __CLASS__, 'author_like_get_posts' ), 10, 1 );

		require_once get_template_directory() . '/src/bookpress/types/item.php';
		require_once get_template_directory() . '/src/bookpress/taxonomies/author.php';
		require_once get_template_directory() . '/src/bookpress/taxonomies/type.php';
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

	public static function comment_form_default_fields( $fields ) {
		unset( $fields [ 'url' ] );
		return $fields;
	}

	private static function tax_query_name_like( $taxonomy, $term ) {
		global $wpdb;
		$statement = $wpdb->prepare(
		"
	SELECT	term_taxonomy_id
	FROM	$wpdb->terms
	JOIN	$wpdb->term_taxonomy
	USING	(term_id)
	WHERE	name
	LIKE	%s
	AND		taxonomy = %s
	", '%' . $term . '%', $taxonomy );
		return $wpdb->get_col( $statement );
	}

	public static function author_like_get_posts( $query ) {

		if ( is_search() && $query[ 'post_type' ] !== 'nav_menu_item' ) {
			/* @var $author_like string Retorna o nome do autor, caso o usuario tenha usado a busca avancada */
			$author_like		 = filter_input( INPUT_GET, 'author_like', FILTER_SANITIZE_STRING );
			/* @var $author_query_string string As palavras-chave da busca normal ou o nome do autor da avancada */
			$author_query_string = empty( $author_like ) ? get_search_query() : $author_like;
			/* @var $term_ids array Um vetor com os IDs de todos os autores que possuam nome parecido com o buscado */
			$term_ids			 = static::tax_query_name_like( 'author', $author_query_string );

			if ( count( $term_ids ) > 0 ) {
				$author_query_args		 = array(
					array(
						'taxonomy'			 => 'author',
						'field'				 => 'term_id',
						'include_children'	 => false,
						'operator'			 => 'IN',
						'terms'				 => $term_ids
					)
				);
				$query[ 'tax_query' ]	 = $author_query_args;
			}
		}
		return $query;
	}

	public static function template_redirect() {
		$current_user_id = get_current_user_id();

		if ( is_search() && is_user_logged_in() ) {

			$search_query			 = get_search_query();
			$last_search_queries	 = get_user_meta( $current_user_id, 'last_search_queries', true );
			$last_search_queries[]	 = $search_query;
			$last_search_queries	 = apply_filters( 'search_queries', $last_search_queries );
			$update_user_meta		 = update_user_meta( $current_user_id, 'last_search_queries', $last_search_queries, false );
		} if ( is_singular( 'item' ) && is_user_logged_in() ) {
			$the_id		 = intval( get_the_ID() );
			$user_meta	 = get_user_meta( $current_user_id, 'last_visited_items', true );
			if ( is_array( $user_meta ) ) {
				$user_meta [] = $the_id;
			} else {
				$user_meta = array( $the_id );
			}
			$user_meta = array_unique( $user_meta );
			update_user_meta( $current_user_id, 'last_visited_items', $user_meta, false );

			$the_terms					 = get_the_terms( get_the_ID(), 'category' );
			$user_last_categories_meta	 = get_user_meta( $current_user_id, 'user_last_categories', true );

			$the_terms_ids = array();
			foreach ( $the_terms as $term ) {
				$the_terms_ids[] = $term->term_id;
			}

			if ( is_array( $user_last_categories_meta ) ) {
				$user_last_categories_meta = array_merge( $user_last_categories_meta, $the_terms_ids );
			} else {
				$user_last_categories_meta = $the_terms_ids;
			}
			$user_last_categories_meta = array_unique( $user_last_categories_meta );
			update_user_meta( $current_user_id, 'user_last_categories', $user_last_categories_meta, false );
		}
	}

	public static function search_queries_filter_callback( $search_query ) {
		return !empty( $search_query ) && strlen( $search_query ) > 1;
	}

	public static function search_queries( $search_queries ) {

		if ( !is_array( $search_queries ) ) {
			$search_queries = array( $search_queries );
		} else {
			$search_queries = array_unique( $search_queries );
		}
		return array_filter( $search_queries, array( __CLASS__, 'search_queries_filter_callback' ) );
		//return $search_queries;
	}

}

return new Theme();
