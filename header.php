<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package purus
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'purus' ); ?></a>

	<div class="header-container">
		<div class="container">
			<header class="header">
				<?php
					$purus_logo   = get_theme_mod( 'logo', false );
					$purus_logo2x = get_theme_mod( 'logo2x', false );

					if ( ! empty( $purus_logo ) ) :
				?>
					<!-- Logo -->
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="header__logo">
						<img src="<?php echo esc_url( $purus_logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" srcset="<?php echo esc_attr( $purus_logo ); ?><?php echo empty ( $purus_logo2x ) ? '' : ', ' . esc_url( $purus_logo2x ) . ' 2x'; ?>">
					</a>
				<?php
				else :
				?>
					<!-- Site Title if there is no logo -->
					<?php
						if ( is_front_page() && is_home() ) : ?>
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="header__logo--heading">
								<h1><?php bloginfo( 'name' ); ?></h1>
							</a>
						<?php else : ?>
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="header__logo--heading">
								<p><?php bloginfo( 'name' ); ?></p>
							</a>
						<?php endif; ?>
				<?php
				endif;
				?>

				<!-- Toggle button for Main Navigation on mobile -->
				<button class="btn  btn-primary  header__navbar-toggler  hidden-lg-up" type="button" data-toggle="collapse" data-target="#purus-main-navigation"><span><?php esc_html_e( 'Menu' , 'purus' ); ?></span></button>

				<!-- Navigation -->
				<nav class="header__navigation  collapse  navbar-toggleable-md" id="purus-main-navigation">
					<?php
						if ( has_nav_menu( 'main-menu' ) ) {
							wp_nav_menu( array(
								'theme_location' => 'main-menu',
								'container'      => false,
								'menu_class'     => 'main-navigation'
							) );
						}
					?>

					<!-- Search -->
					<?php if ( 'hide' !== get_theme_mod( 'navigation_search', 'show' ) ) : ?>
						<div class="header__search">
							<div for="s" class="dashicons  dashicons-search  search__image" id="dropdownMenu" width="30px" height="30px" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></div>
							<form class="search  dropdown-menu" aria-labelledby="dropdownMenu" role="search" method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
								<label class="screen-reader-text" for="s"><?php esc_html_e( 'Search for:' , 'purus' ); ?></label>
								<input class="search__input" type="text" name="s" id="s" placeholder="<?php esc_html_e( 'Search and hit enter ...' , 'purus' ); ?>" autofocus>
							</form>
						</div>
				  <?php endif; ?>
				</nav>
			</header>
		</div>
	</div>
