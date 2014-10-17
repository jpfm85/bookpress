<!DOCTYPE html>
<html <?php \language_attributes(); ?>>
<?php
if ( is_singular() ) {
	\wp_enqueue_script( 'comment-reply' );
}
\wp_head();
?>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php wp_title(); ?></title>
<body <?php \body_class(); ?>>