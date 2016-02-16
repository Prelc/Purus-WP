<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package purus
 */

get_header(); ?>

	<div class="content-area  container">
		<main class="site-main">

			<section class="error-404">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Error 404 - Page not found', 'purus' ); ?></h1>
				</header><!-- .page-header -->

				<p>
					<?php
						printf(
							/* translators: the first %s for line break, the second and third %s for link to home page wrap */
							esc_html__( 'Oops! That page is not here. %s Go %s Home %s or try to search:' , 'purus' ),
							'<br>',
							'<b><a href="' . esc_url( home_url( '/' ) ) . '">',
							'</a></b>'
						);
					?>
				</p>

				<div class="widget_search">
					<?php get_search_form(); ?>
				</div>

			</section><!-- .error-404 -->

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php
get_footer();
