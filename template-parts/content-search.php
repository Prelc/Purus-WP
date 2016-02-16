<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package purus
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="hentry__header">
		<?php
			the_title( sprintf( '<h2 class="hentry__title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
			if ( 'post' === get_post_type() ) : ?>
		<?php
		endif; ?>
	</header>

	<div class="hentry__content">
		<?php the_excerpt(); ?>
	</div>

	<footer class="hentry__footer">
		<!-- Meta -->
		<?php get_template_part( 'template-parts/meta' ); ?>
	</footer>
</article><!-- #post-## -->
