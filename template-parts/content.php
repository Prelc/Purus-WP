<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package purus
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="hentry__header">
		<?php
			the_title( '<h2 class="hentry__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			if ( 'post' === get_post_type() ) : ?>
		<?php
		endif; ?>
	</header>

	<div class="hentry__content">
		<!-- Post Thumbnail -->
		<?php if ( has_post_thumbnail() ) : ?>
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'post-thumbnail', array( 'class' => 'hentry__featured-image' ) ); ?>
			</a>
		<?php endif; ?>

		<!-- Content & Read more text -->
		<?php
			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue with reading', 'purus' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );
		?>
	</div>

	<footer class="hentry__footer">
		<!-- Meta -->
		<?php get_template_part( 'template-parts/meta' ); ?>
	</footer>
</article>
