<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package purus
 */

get_header(); ?>

	<div class="content-area  container">
		<main class="site-main">

		<?php
		while ( have_posts() ) : the_post();

			get_template_part( 'template-parts/content', 'single' );

			?>

			<?php if ( 'hide' !== get_theme_mod( 'meta_tags', 'show' ) ) : ?>
				<?php if ( has_tag() ) { ?>
					<div class="tags">
						<h2 class="tags__title"><?php esc_html_e( 'Tags', 'purus' ); ?></h2>
						<div class="tags__items">
							<?php the_tags( '', '' ); ?>
						</div>
					</div>
					<?php } ?>
		  <?php endif; ?>

			<?php if ( 'hide' !== get_theme_mod( 'meta_author_description', 'show' ) ) : ?>
				<?php
				$author_description = get_the_author_meta( 'description' );

				if ( ! empty ( $author_description ) ) {
				?>
				<div class="description">
					<h2 class="description__title">
						<?php esc_html_e( 'Author', 'purus' ); ?>
					</h2>
					<div class="description__container">
						<?php echo get_avatar( get_the_author_meta( 'ID' ), 80 ); ?>
						<h4 class="description__author"><?php echo get_the_author_meta( 'display_name' ) ?></h4>
						<div class="description__text">
							<?php echo $author_description ?>
						</div>
					</div>
				</div>
				<?php } ?>
			<?php endif; ?>

			<?php
			// If comments are open or we have at least one comment, load up the comment template.
			 if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer();
