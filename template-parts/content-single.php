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
			the_title( '<h1 class="hentry__title">', '</h1>' );
			if ( 'post' === get_post_type() ) : ?>
		<?php
		endif; ?>
	</header>

	<div class="hentry__content">
		<!-- Post Thumbnail -->
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'post-thumbnail', array( 'class' => 'hentry__featured-image' ) ); ?>
		<?php endif; ?>

		<!-- Content -->
		<?php the_content(); ?>

		<!-- Multi Page in One Post -->
		<?php
			$purus_args = array(
				'before'      => '<div class="multi-page  clearfix">' . /* translators: after that comes pagination like 1, 2, 3 ... 10 */ esc_html__( 'Pages:', 'purus' ) . ' &nbsp; ',
				'after'       => '</div>',
				'link_before' => '<span class="btn  btn-primary">',
				'link_after'  => '</span>',
				'echo'        => 1,
			);
			wp_link_pages( $purus_args );
		?>
	</div>

	<footer class="hentry__footer">
		<!-- Meta -->
		<?php get_template_part( 'template-parts/meta' ); ?>
	</footer>
</article>
