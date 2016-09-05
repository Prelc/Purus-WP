<?php

/**
 * Customizer
**/

/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */
function purus_customizer( $wp_customize ) {
	/**
	 * Panel
	 */
	$wp_customize->add_panel(
		'panel_theme-options',
		array(
			'priority' => 10,
			'title' => __( 'Theme Options', 'purus' ),
		)
	);

	/**
	 * Sections
	 */
	$wp_customize->add_section(
		'section_theme-colors',
		array(
			'title' => __( 'Theme Colors', 'purus' ),
			'description' => __( 'Change theme colors.', 'purus' ),
			'priority' => 20,
			'panel'  => 'panel_theme-options',
		)
	);

	$wp_customize->add_section(
		'section_header',
		array(
			'title' => __( 'Header', 'purus' ),
			'description' => __( 'Change header colors.', 'purus' ),
			'priority' => 30,
			'panel'  => 'panel_theme-options',
		)
	);

	$wp_customize->add_section(
		'section_navigation',
		array(
			'title' => __( 'Navigation', 'purus' ),
			'description' => __( 'Change colors and settings for navigation.', 'purus' ),
			'priority' => 40,
			'panel'  => 'panel_theme-options',
		)
	);

	$wp_customize->add_section(
		'section_meta',
		array(
			'title' => __( 'Meta', 'purus' ),
			'description' => __( 'Everything related to meta data.', 'purus' ),
			'priority' => 50,
			'panel'  => 'panel_theme-options',
		)
	);

	$wp_customize->add_section(
		'section_footer',
		array(
			'title' => __( 'Footer', 'purus' ),
			'description' => __( 'Settings for the footer.', 'purus' ),
			'priority' => 60,
			'panel'  => 'panel_theme-options',
		)
	);

	$wp_customize->add_section(
		'section_custom_code',
		array(
			'title' => __( 'Custom Code', 'purus' ),
			'description' => __( 'Add custom code. This code will not be affected by updates.', 'purus' ),
			'priority' => 70,
			'panel'  => 'panel_theme-options',
		)
	);

	/**
	 * Settings
	 */

	// Theme Colors Settings
	$wp_customize->add_setting(
		'primary_color',
		array(
			'default' => '#1bbebc',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_setting(
		'headings_color',
		array(
			'default' => '#222222',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_setting(
		'text_color',
		array(
			'default' => '#555555',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_setting(
		'link_color',
		array(
			'default' => '#e44244',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_setting(
		'logo_color',
		array(
			'default' => '#222222',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	// Header Settings
	$wp_customize->add_setting(
		'header_background_color',
		array(
			'default' => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	// Navigation Settings
	$wp_customize->add_setting(
		'navigation_search',
		array(
			'default' => 'show',
			'sanitize_callback' => 'purus_sanitize_select',
		)
	);
	$wp_customize->add_setting(
		'navigation_link_color',
		array(
			'default' => '#555555',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_setting(
		'navigation_link_hover_color',
		array(
			'default' => '#1bbebc',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_setting(
		'navigation_submenu_link_color',
		array(
			'default' => '#555555',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_setting(
		'navigation_submenu_link_hover_color',
		array(
			'default' => '#1bbebc',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_setting(
		'navigation_submenu_background_color',
		array(
			'default' => '#f2f2f2',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_setting(
		'navigation_mobile_link_color',
		array(
			'default' => '#555555',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_setting(
		'navigation_mobile_link_hover_color',
		array(
			'default' => '#1bbebc',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_setting(
		'navigation_mobile_background_color',
		array(
			'default' => '#f2f2f2',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	// Meta settings
	$wp_customize->add_setting(
		'meta_author_avatar',
		array(
			'default' => 'show',
			'sanitize_callback' => 'purus_sanitize_select',
		)
	);
	$wp_customize->add_setting(
		'meta_author',
		array(
			'default' => 'show',
			'sanitize_callback' => 'purus_sanitize_select',
		)
	);
	$wp_customize->add_setting(
		'meta_date',
		array(
			'default' => 'show',
			'sanitize_callback' => 'purus_sanitize_select',
		)
	);
	$wp_customize->add_setting(
		'meta_comment_number',
		array(
			'default' => 'show',
			'sanitize_callback' => 'purus_sanitize_select',
		)
	);
	$wp_customize->add_setting(
		'meta_categories',
		array(
			'default' => 'show',
			'sanitize_callback' => 'purus_sanitize_select',
		)
	);
	$wp_customize->add_setting(
		'meta_tags',
		array(
			'default' => 'show',
			'sanitize_callback' => 'purus_sanitize_select',
		)
	);
	$wp_customize->add_setting(
		'meta_author_description',
		array(
			'default' => 'show',
			'sanitize_callback' => 'purus_sanitize_select',
		)
	);

	// Footer Settings
	$wp_customize->add_setting(
		'footer_left',
		array(
			'default' => esc_html__( 'Purus - WordPress theme made by <a href="https://twitter.com/prelc">Prelc</a>.', 'purus' ),
			'sanitize_callback' => 'wp_kses_post',
		)
	);
	$wp_customize->add_setting(
		'footer_right',
		array(
			'default' => esc_html__( 'Copyright 2016. All rights reserved.', 'purus' ),
			'sanitize_callback' => 'wp_kses_post',
		)
	);
	$wp_customize->add_setting(
		'footer_text_color',
		array(
			'default' => '#555555',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_setting(
		'footer_link_color',
		array(
			'default' => '#e44244',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_setting(
		'footer_background_color',
		array(
			'default' => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	// Custom Code Settings
	$wp_customize->add_setting(
		'custom_css',
		array(
			'sanitize_callback'    => 'wp_filter_nohtml_kses',
			'sanitize_js_callback' => 'wp_filter_nohtml_kses'
		)
	);

	/**
	 * Controls
	 */

	// Theme Colors Controls
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'primary_color',
			array(
				'label' => __( 'Primary Color', 'purus' ),
				'settings' => 'primary_color',
				'section' => 'section_theme-colors',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'headings_color',
			array(
				'label' => __( 'Headings Color', 'purus' ),
				'settings' => 'headings_color',
				'section' => 'section_theme-colors',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'text_color',
			array(
				'label' => __( 'Text Color', 'purus' ),
				'settings' => 'text_color',
				'section' => 'section_theme-colors',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'link_color',
			array(
				'label' => __( 'Link Color', 'purus' ),
				'settings' => 'link_color',
				'section' => 'section_theme-colors',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'logo_color',
			array(
				'label' => __( 'Logo Color', 'purus' ),
				'description' => __( 'Works only if there is no Logo Image.', 'purus' ),
				'settings' => 'logo_color',
				'section' => 'section_theme-colors',
			)
		)
	);

	// Header Controls
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'header_background_color',
			array(
				'label' => __( 'Background Color', 'purus' ),
				'settings' => 'header_background_color',
				'section' => 'section_header',
			)
		)
	);

	// Navigation Controls
	$wp_customize->add_control(
		'navigation_search',
		array(
			'type' => 'select',
			'label' => __( 'Search Field', 'purus' ),
			'section' => 'section_navigation',
			'choices' => array(
				'show' => __( 'Show', 'purus' ),
				'hide' => __( 'Hide', 'purus' ),
			),
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'navigation_link_color',
			array(
				'label' => __( 'Link Color', 'purus' ),
				'settings' => 'navigation_link_color',
				'section' => 'section_navigation',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'navigation_link_hover_color',
			array(
				'label' => __( 'Link Hover Color', 'purus' ),
				'settings' => 'navigation_link_hover_color',
				'section' => 'section_navigation',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'navigation_submenu_link_color',
			array(
				'label' => __( 'Submenu Link Color', 'purus' ),
				'settings' => 'navigation_submenu_link_color',
				'section' => 'section_navigation',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'navigation_submenu_link_hover_color',
			array(
				'label' => __( 'Submenu Link Hover Color', 'purus' ),
				'settings' => 'navigation_submenu_link_hover_color',
				'section' => 'section_navigation',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'navigation_submenu_background_color',
			array(
				'label' => __( 'Submenu Background Color', 'purus' ),
				'settings' => 'navigation_submenu_background_color',
				'section' => 'section_navigation',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'navigation_mobile_link_color',
			array(
				'label' => __( 'Mobile Link Color', 'purus' ),
				'settings' => 'navigation_mobile_link_color',
				'section' => 'section_navigation',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'navigation_mobile_link_hover_color',
			array(
				'label' => __( 'Mobile Link Hover Color', 'purus' ),
				'settings' => 'navigation_mobile_link_hover_color',
				'section' => 'section_navigation',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'navigation_mobile_background_color',
			array(
				'label' => __( 'Mobile Background Color', 'purus' ),
				'settings' => 'navigation_mobile_background_color',
				'section' => 'section_navigation',
			)
		)
	);

	// Meta Controls
	$wp_customize->add_control(
		'meta_author_avatar',
		array(
			'type' => 'select',
			'label' => __( 'Meta Author Avatar', 'purus' ),
			'section' => 'section_meta',
			'choices' => array(
				'show' => __( 'Show', 'purus' ),
				'hide' => __( 'Hide', 'purus' ),
			),
		)
	);
	$wp_customize->add_control(
		'meta_author',
		array(
			'type' => 'select',
			'label' => __( 'Meta Author', 'purus' ),
			'section' => 'section_meta',
			'choices' => array(
				'show' => __( 'Show', 'purus' ),
				'hide' => __( 'Hide', 'purus' ),
			),
		)
	);
	$wp_customize->add_control(
		'meta_date',
		array(
			'type' => 'select',
			'label' => __( 'Meta Date', 'purus' ),
			'section' => 'section_meta',
			'choices' => array(
				'show' => __( 'Show', 'purus' ),
				'hide' => __( 'Hide', 'purus' ),
			),
		)
	);
	$wp_customize->add_control(
		'meta_comment_number',
		array(
			'type' => 'select',
			'label' => __( 'Meta Comment Number', 'purus' ),
			'section' => 'section_meta',
			'choices' => array(
				'show' => __( 'Show', 'purus' ),
				'hide' => __( 'Hide', 'purus' ),
			),
		)
	);
	$wp_customize->add_control(
		'meta_categories',
		array(
			'type' => 'select',
			'label' => __( 'Meta Categories', 'purus' ),
			'section' => 'section_meta',
			'choices' => array(
				'show' => __( 'Show', 'purus' ),
				'hide' => __( 'Hide', 'purus' ),
			),
		)
	);
	$wp_customize->add_control(
		'meta_tags',
		array(
			'type' => 'select',
			'label' => __( 'Meta Tags', 'purus' ),
			'description' => __( 'Tags are at the bottom of the single page.', 'purus' ),
			'section' => 'section_meta',
			'choices' => array(
				'show' => __( 'Show', 'purus' ),
				'hide' => __( 'Hide', 'purus' ),
			),
		)
	);
	$wp_customize->add_control(
		'meta_author_description',
		array(
			'type' => 'select',
			'label' => __( 'Meta Author Description', 'purus' ),
			'description' => __( 'Description is at the bottom of the single page.', 'purus' ),
			'section' => 'section_meta',
			'choices' => array(
				'show' => __( 'Show', 'purus' ),
				'hide' => __( 'Hide', 'purus' ),
			),
		)
	);

	// Footer Controls
	$wp_customize->add_control(
		'footer_left',
		array(
			'type' => 'text',
			'label' => __( 'Footer text on the left', 'purus' ),
			'priority'    => 10,
			'section' => 'section_footer',
		)
	);
	$wp_customize->add_control(
		'footer_right',
		array(
			'type' => 'text',
			'label' => __( 'Footer text on the right', 'purus' ),
			'priority'    => 20,
			'section' => 'section_footer',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'footer_text_color',
			array(
				'label' => __( 'Text Color', 'purus' ),
				'settings' => 'footer_text_color',
				'priority' => 30,
				'section' => 'section_footer',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'footer_link_color',
			array(
				'label' => __( 'Link Color', 'purus' ),
				'settings' => 'footer_link_color',
				'priority' => 40,
				'section' => 'section_footer',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'footer_background_color',
			array(
				'label' => __( 'Background Color', 'purus' ),
				'settings' => 'footer_background_color',
				'priority' => 50,
				'section' => 'section_footer',
			)
		)
	);

	// Custom Code Controls
	$wp_customize->add_control( 'custom_css', array(
		'type'        => 'textarea',
		'label'       => __( 'Custom CSS', 'purus' ),
		'section'     => 'section_custom_code',
	) );

}
add_action( 'customize_register', 'purus_customizer' );


/**
 * Customizer Colors
**/

function customizer_colors() {

	// Logo Color
	$logo_color = get_theme_mod( 'logo_color', '#222222' );

	// Theme Colors
	$primary_color = get_theme_mod( 'primary_color', '#1bbebc' );
	$headings_color = get_theme_mod( 'headings_color', '#222222' );
	$text_color = get_theme_mod( 'text_color', '#555555' );
	$link_color = get_theme_mod( 'link_color', '#e44244' );

	// Header Colors
	$header_background_color = get_theme_mod( 'header_background_color', '#ffffff' );

	// Navigation Colors
	$navigation_link_color = get_theme_mod( 'navigation_link_color', '#555555' );
	$navigation_link_hover_color = get_theme_mod( 'navigation_link_hover_color', '#1bbebc' );
	$navigation_submenu_link_color = get_theme_mod( 'navigation_submenu_link_color', '#555555' );
	$navigation_submenu_link_hover_color = get_theme_mod( 'navigation_submenu_link_hover_color', '#1bbebc' );
	$navigation_submenu_background_color = get_theme_mod( 'navigation_submenu_background_color', '#f2f2f2' );
	$navigation_mobile_link_color = get_theme_mod( 'navigation_mobile_link_color', '#555555' );
	$navigation_mobile_link_hover_color = get_theme_mod( 'navigation_mobile_link_hover_color', '#1bbebc' );
	$navigation_mobile_background_color = get_theme_mod( 'navigation_mobile_background_color', '#f2f2f2' );

	// Footer Colors
	$footer_text_color = get_theme_mod( 'footer_text_color', '#555555' );
	$footer_link_color = get_theme_mod( 'footer_link_color', '#e44244' );
	$footer_background_color = get_theme_mod( 'footer_background_color', '#ffffff' );

	// Colors
	$base_primary_color = new purus_Color( $primary_color );
	$base_logo_color = new purus_Color( $logo_color );
	$base_navigation_submenu_background_color = new purus_Color( $navigation_submenu_background_color );
	$base_navigation_mobile_background_color = new purus_Color( $navigation_mobile_background_color );
	?>

	<style>
		/* Logo Color */
		<?php if ( $logo_color ) : ?>
			.header__heading,
			.header__heading h1 {
				color: <?php echo esc_attr( $logo_color ); ?>;
			}

			.header__heading:focus,
			.header__heading:hover,
			.header__heading:focus h1,
			.header__heading:hover h1 {
				color: <?php echo esc_attr( '#' . $base_logo_color->darken(5) ); ?>;
			}
		<?php endif; ?>

		/* Primary Color */
		<?php if ( $primary_color ) : ?>
			.main-navigation a:hover,
			.hentry__title a:hover {
				color: <?php echo esc_attr( $primary_color ); ?>;
			}

			.hentry .more-link,
			.btn-primary,
			.pagination .current,
			.pagination .current:focus,
			.pagination .current:hover,
			.header__navbar-toggler:focus,
			.comment-respond .submit {
				background-color: <?php echo esc_attr( $primary_color ); ?>;
			}

			.hentry .more-link:hover,
			.btn-primary:hover,
			.comment-respond .submit:focus,
			.comment-respond .submit:hover,
			.header__navbar-toggler:hover {
				background-color: <?php echo esc_attr( '#' . $base_primary_color->darken(5) ); ?>;
			}

			.btn-primary,
			blockquote,
			.header__navbar-toggler:focus,
			.comment-respond .submit {
				border-color: <?php echo esc_attr( $primary_color ); ?>;
			}

			.comment-respond .submit:focus,
			.comment-respond .submit:hover,
			.header__navbar-toggler:hover,
			.btn-primary:hover {
				border-color: <?php echo esc_attr( '#' . $base_primary_color->darken(5) ); ?>;
			}

			.btn-primary:active:hover {
				background-color: <?php echo esc_attr( '#' . $base_primary_color->darken(8) ); ?>;
			}

			.btn-primary:active:hover {
				border-color: <?php echo esc_attr( '#' . $base_primary_color->darken(8) ); ?>;
			}
		<?php endif; ?>

		/* Headings Color */
		<?php if ( $headings_color ) : ?>
			h1, h2, h3, h4, h5, h6,
			.h1, .h2, .h3, .h4, .h5, .h6,
			.hentry__title a {
				color: <?php echo esc_attr( $headings_color ); ?>;
			}
		<?php endif; ?>

		/* Text Color */
		<?php if ( $text_color ) : ?>
			body {
				color: <?php echo esc_attr( $text_color ); ?>;
			}
		<?php endif; ?>

		/* Link Color */
		<?php if ( $link_color ) : ?>
			a,
			a:hover {
				color: <?php echo esc_attr( $link_color ); ?>;
			}
		<?php endif; ?>

		/* Header Background Color */
		<?php if ( $header_background_color ) : ?>
			.header-container {
				background-color: <?php echo esc_attr( $header_background_color ); ?>;
			}

			@media (min-width: 992px) {
				.main-navigation {
					background-color: <?php echo esc_attr( $header_background_color ); ?>;
				}
			}
		<?php endif; ?>

		/* Navigation Link Color */
		<?php if ( $navigation_link_color ) : ?>
			@media (min-width: 992px) {
				.main-navigation a,
				.header__search .search__image {
					color: <?php echo esc_attr( $navigation_link_color ); ?>;
				}
			}
		<?php endif; ?>

		/* Navigation Link Hover Color */
		<?php if ( $navigation_link_hover_color ) : ?>
			@media (min-width: 992px) {
				.main-navigation a:hover,
				.header__search .search__image:hover {
					color: <?php echo esc_attr( $navigation_link_hover_color ); ?>;
				}
			}
		<?php endif; ?>

		/* Navigation Submenu Link Color */
		<?php if ( $navigation_submenu_link_color ) : ?>
			@media (min-width: 992px) {
				.main-navigation .sub-menu a {
					color: <?php echo esc_attr( $navigation_submenu_link_color ); ?>;
				}
			}
		<?php endif; ?>

		/* Navigation Submenu Link Hover Color */
		<?php if ( $navigation_submenu_link_hover_color ) : ?>
			@media (min-width: 992px) {
				.main-navigation .sub-menu a:hover {
					color: <?php echo esc_attr( $navigation_submenu_link_hover_color ); ?>;
				}
			}
		<?php endif; ?>

		/* Navigation Submenu Background Color */
		<?php if ( $navigation_submenu_background_color ) : ?>
			@media (min-width: 992px) {
				.main-navigation .sub-menu a {
					background-color: <?php echo esc_attr( $navigation_submenu_background_color ); ?>;
				}

				.main-navigation .sub-menu a,
				.main-navigation .sub-menu .sub-menu a {
					border-color: <?php echo esc_attr( '#' . $base_navigation_submenu_background_color->lighten(5) ); ?>;
				}
			}
		<?php endif; ?>

		/* Navigation Mobile Link Color */
		<?php if ( $navigation_mobile_link_color ) : ?>
			@media (max-width: 991px) {
				.main-navigation a,
				.header__search .search__image {
					color: <?php echo esc_attr( $navigation_mobile_link_color ); ?>;
				}
			}
		<?php endif; ?>

		/* Navigation Mobile Link Hover Color */
		<?php if ( $navigation_mobile_link_hover_color ) : ?>
			@media (max-width: 991px) {
				.main-navigation a:hover,
				.header__search .search__image:hover {
					color: <?php echo esc_attr( $navigation_mobile_link_hover_color ); ?>;
				}
			}
		<?php endif; ?>

		/* Navigation Mobile Background Color */
		<?php if ( $navigation_mobile_background_color ) : ?>
			@media (max-width: 991px) {
				.main-navigation {
					background-color: <?php echo esc_attr( $navigation_mobile_background_color ); ?>;
				}

				.main-navigation a {
					border-color: <?php echo esc_attr( '#' . $base_navigation_mobile_background_color->lighten(5) ); ?>;
				}
			}
		<?php endif; ?>

		/* Footer Text Color */
		<?php if ( $footer_text_color ) : ?>
			.footer {
				color: <?php echo esc_attr( $footer_text_color ); ?>;
			}
		<?php endif; ?>

		/* Footer Link Color */
		<?php if ( $footer_link_color ) : ?>
			.footer a {
				color: <?php echo esc_attr( $footer_link_color ); ?>;
			}
		<?php endif; ?>

		/* Footer Background Color */
		<?php if ( $footer_background_color ) : ?>
			.footer-container {
				background-color: <?php echo esc_attr( $footer_background_color ); ?>;
			}
		<?php endif; ?>

		<?php if( get_theme_mod( 'custom_css' ) != '' ) {
			echo get_theme_mod( 'custom_css' );
		} ?>
	</style>

	<?php
} // End customizer_colors()
add_action( 'wp_head', 'customizer_colors' );


/**
 * Sanitization functions
**/

/**
 * Select and radio sanitization callback.
 *
 * @source https://github.com/WPTRT/code-examples/blob/master/customizer/sanitization-callbacks.php#L262-L288
 */
if ( ! function_exists( 'purus_sanitize_select' ) ) {
	function purus_sanitize_select( $input, $setting ) {

		// Ensure input is a slug.
		$input = sanitize_key( $input );

		// Get list of choices from the control associated with the setting.
		$choices = $setting->manager->get_control( $setting->id )->choices;

		// If the input is a valid key, return it; otherwise, return the default.
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}
}
