<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package purus
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="hentry__header">
		<?php the_title( '<h1 class="hentry__title">', '</h1>' ); ?>
	</header>

	<div class="hentry__content">
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
</article>
