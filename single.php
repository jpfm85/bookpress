<?php
\get_header();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	\the_post();
	\the_post_thumbnail();
?>
	<aside>
		<?php \the_tags(); ?>
	</aside>
	<nav>
		<?php \wp_link_pages(); ?>
	</nav>
</article>
<?php
\paginate_links();
\comments_template();
\get_footer();
