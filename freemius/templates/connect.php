<?php
	/**
	 * @package     Freemius
	 * @copyright   Copyright (c) 2015, Freemius, Inc.
	 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
	 * @since       1.0.7
	 */

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	$fs                    = freemius( $VARS['id'] );
	$slug                  = $fs->get_slug();
	$is_pending_activation = $fs->is_pending_activation();
	$is_premium_only       = $fs->is_only_premium();
	$has_paid_plans        = $fs->has_paid_plan();
	$is_premium_code       = $fs->is_premium();
	$is_freemium           = $fs->is_freemium();

	$fs->_enqueue_connect_essentials();

	$current_user = Freemius::_get_current_wp_user();

	$first_name = $current_user->user_firstname;
	if ( empty( $first_name ) ) {
		$first_name = $current_user->nickname;
	}

	$site_url     = get_site_url();
	$protocol_pos = strpos( $site_url, '://' );
	if ( false !== $protocol_pos ) {
		$site_url = substr( $site_url, $protocol_pos + 3 );
	}

	$freemius_site_url = $fs->has_paid_plan() ?
		'https://freemius.com/wordpress/' :
		// Insights platform information.
		'https://freemius.com/wordpress/usage-tracking/';

	$freemius_site_url .= '?' . http_build_query( array(
			'id'   => $fs->get_id(),
			'slug' => $slug,
		) );

	$freemius_link = '<a href="' . $freemius_site_url . '" target="_blank" tabindex="1">freemius.com</a>';

	$error = fs_request_get( 'error' );

	$require_license_key = $is_premium_only ||
	                       ( $is_freemium && $is_premium_code && fs_request_get_bool( 'require_license', true ) );

    if ( $is_pending_activation ) {
        $require_license_key = false;
    }

    if ( $require_license_key ) {
        $fs->_require_license_activation_dialog();
    }

	global $pagenow;
	$is_theme_page = ( 'themes.php' === $pagenow );

	$is_optin_dialog = ( $is_theme_page && $fs->is_theme() );
	if ( $is_optin_dialog ) {
		$show_close_button             = false;
		$previous_theme_activation_url = '';

		if ( ! $is_premium_code ) {
			$show_close_button = true;
		} else if ( $is_premium_only ) {
			$previous_theme_activation_url = $fs->get_previous_theme_activation_url();
			$show_close_button = ( ! empty( $previous_theme_activation_url ) );
		}
	}
?>
<?php
if ( $is_optin_dialog ) { ?>
	<div id="fs_theme_connect_wrapper">
		<?php
			if ( $show_close_button ) { ?>
				<button class="close dashicons dashicons-no"><span class="screen-reader-text">Close connect dialog</span></button>
				<?php
			}
		?>
	<?php
}
?>
<div id="fs_connect"
     class="wrap<?php if ( ! $fs->is_enable_anonymous() || $is_pending_activation || $require_license_key ) {
	     echo ' fs-anonymous-disabled';
     } ?>">
	<div class="fs-visual">
		<b class="fs-site-icon"><i class="dashicons dashicons-wordpress"></i></b>
		<i class="dashicons dashicons-plus fs-first"></i>
		<?php
			$vars = array( 'id' => $fs->get_id() );
			fs_require_once_template( 'plugin-icon.php', $vars );
		?>
		<i class="dashicons dashicons-plus fs-second"></i>
		<img class="fs-connect-logo" width="80" height="80" src="//img.freemius.com/connect-logo.png"/>
	</div>
	<div class="fs-content">
		<?php if ( ! empty( $error ) ) : ?>
			<p class="fs-error"><?php echo $error ?></p>
		<?php endif ?>
		<p><?php
				$button_label = 'opt-in-connect';

				if ( $is_pending_activation ) {
					$button_label = 'resend-activation-email';

					echo $fs->apply_filters( 'pending_activation_message', sprintf(
						__fs( 'thanks-x', $slug ) . '<br>' .
						__fs( 'pending-activation-message', $slug ),
						$first_name,
						'<b>' . $fs->get_plugin_name() . '</b>',
						'<b>' . $current_user->user_email . '</b>'
					) );
				} else if ( $require_license_key ) {
					$button_label = 'agree-activate-license';

					echo $fs->apply_filters( 'connect-message_on-premium',
						sprintf( __fs( 'hey-x', $slug ), $first_name ) . '<br>' .
						sprintf( __fs( 'thanks-for-purchasing', $slug ), '<b>' . $fs->get_plugin_name() . '</b>' ),
						$first_name,
						$fs->get_plugin_name()
					);
				} else {
					$filter                = 'connect_message';
					$default_optin_message = 'connect-message';

					if ( $fs->is_plugin_update() ) {
						// If Freemius was added on a plugin update, set different
						// opt-in message.
						$default_optin_message = 'connect-message_on-update';

						// If user customized the opt-in message on update, use
						// that message. Otherwise, fallback to regular opt-in
						// custom message if exist.
						if ( $fs->has_filter( 'connect_message_on_update' ) ) {
							$filter = 'connect_message_on_update';
						}
					}

					echo $fs->apply_filters( $filter,
						sprintf(
							__fs( 'hey-x', $slug ) . '<br>' .
							__fs( $default_optin_message, $slug ),
							$first_name,
							'<b>' . $fs->get_plugin_name() . '</b>',
							'<b>' . $current_user->user_login . '</b>',
							'<a href="' . $site_url . '" target="_blank">' . $site_url . '</a>',
							$freemius_link
						),
						$first_name,
						$fs->get_plugin_name(),
						$current_user->user_login,
						'<a href="' . $site_url . '" target="_blank">' . $site_url . '</a>',
						$freemius_link
					);
				}
			?></p>
		<?php if ( $require_license_key ) : ?>
			<div class="fs-license-key-container">
				<input id="fs_license_key" name="fs_key" type="text" required maxlength="32"
				       placeholder="<?php _efs( 'license-key', $slug ) ?>" tabindex="1"/>
				<i class="dashicons dashicons-admin-network"></i>
				<a class="show-license-resend-modal show-license-resend-modal-<?php echo $fs->get_unique_affix() ?>"
				   href="#"><?php _efs( 'cant-find-license-key' ); ?></a>
			</div>
		<?php endif ?>
	</div>
	<div class="fs-actions">
		<?php if ( $fs->is_enable_anonymous() && ! $is_pending_activation && ! $require_license_key ) : ?>
			<a href="<?php echo wp_nonce_url( $fs->_get_admin_page_url( '', array( 'fs_action' => $fs->get_unique_affix() . '_skip_activation' ) ), $fs->get_unique_affix() . '_skip_activation' ) ?>"
			   class="button button-secondary" tabindex="2"><?php _efs( 'skip', $slug ) ?></a>
		<?php endif ?>

		<?php $fs_user = Freemius::_get_user_by_email( $current_user->user_email ) ?>
		<?php if ( is_object( $fs_user ) && ! $is_pending_activation ) : ?>
			<form action="" method="POST">
				<input type="hidden" name="fs_action" value="<?php echo $fs->get_unique_affix() ?>_activate_existing">
				<?php wp_nonce_field( 'activate_existing_' . $fs->get_public_key() ) ?>
				<button class="button button-primary" tabindex="1"
				        type="submit"<?php if ( $require_license_key ) {
					echo ' disabled="disabled"';
				} ?>><?php _efs( $button_label, $slug ) ?></button>
			</form>
		<?php else : ?>
			<form method="post" action="<?php echo WP_FS__ADDRESS ?>/action/service/user/install/">
				<?php $params = $fs->get_opt_in_params() ?>
				<?php foreach ( $params as $name => $value ) : ?>
					<input type="hidden" name="<?php echo $name ?>" value="<?php echo esc_attr( $value ) ?>">
				<?php endforeach ?>
				<button class="button button-primary" tabindex="1"
				        type="submit"<?php if ( $require_license_key ) {
					echo ' disabled="disabled"';
				} ?>><?php _efs( $button_label, $slug ) ?></button>
			</form>
		<?php endif ?>
	</div><?php

		// Set core permission list items.
		$permissions = array(
			'profile' => array(
				'icon-class' => 'dashicons dashicons-admin-users',
				'label'      => __fs( 'permissions-profile', $slug ),
				'desc'       => __fs( 'permissions-profile_desc', $slug ),
				'priority'   => 5,
			),
			'site'    => array(
				'icon-class' => 'dashicons dashicons-admin-settings',
				'label'      => __fs( 'permissions-site', $slug ),
				'desc'       => __fs( 'permissions-site_desc', $slug ),
				'priority'   => 10,
			),
			'events'  => array(
				'icon-class' => 'dashicons dashicons-admin-plugins',
				'label'      => sprintf( __fs( 'permissions-events', $slug ), ucfirst( $fs->get_module_type() ) ),
				'desc'       => __fs( 'permissions-events_desc', $slug ),
				'priority'   => 20,
			),
//			'plugins_themes' => array(
//				'icon-class' => 'dashicons dashicons-admin-settings',
//				'label'      => __fs( 'permissions-plugins_themes' ),
//				'desc'       => __fs( 'permissions-plugins_themes_desc' ),
//				'priority'   => 30,
//			),
		);

		// Add newsletter permissions if enabled.
		if ( $fs->is_permission_requested( 'newsletter' ) ) {
			$permissions['newsletter'] = array(
				'icon-class' => 'dashicons dashicons-email-alt',
				'label'      => __fs( 'permissions-newsletter', $slug ),
				'desc'       => __fs( 'permissions-newsletter_desc', $slug ),
				'priority'   => 15,
			);
		}

		// Allow filtering of the permissions list.
		$permissions = $fs->apply_filters( 'permission_list', $permissions );

		// Sort by priority.
		uasort( $permissions, 'fs_sort_by_priority' );

		if ( ! empty( $permissions ) ) : ?>
			<div class="fs-permissions">
				<?php if ( $require_license_key ) : ?>
					<p class="fs-license-sync-disclaimer"><?php
						printf( __fs( 'license-sync-disclaimer', $slug ),
							$fs->get_module_type(),
							$freemius_link,
							$fs->get_module_type()
						) ?></p>
				<?php endif ?>
				<a class="fs-trigger" href="#" tabindex="1"><?php _efs( 'what-permissions', $slug ) ?></a>
				<ul><?php
						foreach ( $permissions as $id => $permission ) : ?>
							<li id="fs-permission-<?php echo esc_attr( $id ); ?>"
							    class="fs-permission fs-<?php echo esc_attr( $id ); ?>">
								<i class="<?php echo esc_attr( $permission['icon-class'] ); ?>"></i>

								<div>
									<span><?php echo esc_html( $permission['label'] ); ?></span>

									<p><?php echo esc_html( $permission['desc'] ); ?></p>
								</div>
							</li>
						<?php endforeach; ?>
				</ul>
			</div>
		<?php endif ?>
	<?php if ( $is_premium_code && $is_freemium ) : ?>
		<div class="fs-freemium-licensing">
			<p>
				<?php if ( $require_license_key ) : ?>
					<?php _efs( 'dont-have-license-key', $slug ) ?>
					<a data-require-license="false" tabindex="1"><?php _efs( 'activate-free-version', $slug ) ?></a>
				<?php else : ?>
					<?php _efs( 'have-license-key', $slug ) ?>
					<a data-require-license="true" tabindex="1"><?php _efs( 'activate-license', $slug ) ?></a>
				<?php endif ?>
			</p>
		</div>
	<?php endif ?>
	<div class="fs-terms">
		<a href="https://freemius.com/privacy/" target="_blank"
		   tabindex="1"><?php _efs( 'privacy-policy', $slug ) ?></a>
		&nbsp;&nbsp;-&nbsp;&nbsp;
		<a href="https://freemius.com/terms/" target="_blank" tabindex="1"><?php _efs( 'tos', $slug ) ?></a>
	</div>
</div>
<?php
	if ( $is_optin_dialog ) { ?>
		</div>
		<?php
	}
?>
<script type="text/javascript">
	(function ($) {
		<?php
			if ( $is_optin_dialog && $show_close_button ) { ?>
				var $themeConnectWrapper = $( '#fs_theme_connect_wrapper' );

				$themeConnectWrapper.find( 'button.close' ).on( 'click', function() {
					<?php if ( ! empty( $previous_theme_activation_url ) ) { ?>
						location.href = '<?php echo html_entity_decode( $previous_theme_activation_url ); ?>';
					<?php } else { ?>
						$themeConnectWrapper.remove();
					<?php } ?>
				});
				<?php
			}
		?>

		var $primaryCta = $('.fs-actions .button.button-primary'),
		    $form = $('.fs-actions form'),
		    requireLicenseKey = <?php echo $require_license_key ? 'true' : 'false' ?>,
		    $licenseSecret,
		    $licenseKeyInput = $('#fs_license_key');

		$('.fs-actions .button').on('click', function () {
			// Set loading mode.
			$(document.body).css({'cursor': 'wait'});
		});

		$form.on('submit', function () {
			/**
			 * @author Vova Feldman (@svovaf)
			 * @since 1.1.9
			 */
			if (requireLicenseKey) {
				if (null == $licenseSecret) {
					$licenseSecret = $('<input type="hidden" name="license_secret_key" value="" />');
					$form.append($licenseSecret);
				}

				// Update secret key if premium only plugin.
				$licenseSecret.val($licenseKeyInput.val());
			}

			return true;
		});

		$primaryCta.on('click', function () {
			$(this).addClass('fs-loading');
			$(this).html('<?php _efs( $is_pending_activation ? 'sending-email' : 'activating' , $slug ) ?>...').css({'cursor': 'wait'});
		});

		$('.fs-permissions .fs-trigger').on('click', function () {
			$('.fs-permissions').toggleClass('fs-open');
		});

		if (requireLicenseKey) {
			/**
			 * Submit license key on enter.
			 *
			 * @author Vova Feldman (@svovaf)
			 * @since 1.1.9
			 */
			$licenseKeyInput.keypress(function (e) {
				if (e.which == 13) {
					if ('' !== $(this).val()) {
						$primaryCta.click();
						return false;
					}
				}
			});

			/**
			 * Disable activation button when empty license key.
			 *
			 * @author Vova Feldman (@svovaf)
			 * @since 1.1.9
			 */
			$licenseKeyInput.on('keyup paste delete cut', function () {
				setTimeout(function () {
					if ('' === $licenseKeyInput.val()) {
						$primaryCta.attr('disabled', 'disabled');
					} else {
						$primaryCta.prop('disabled', false);
					}
				}, 100);
			}).focus();
		}

		/**
		 * Set license mode trigger URL.
		 *
		 * @author Vova Feldman (@svovaf)
		 * @since 1.1.9
		 */
		var
			$connectLicenseModeTrigger = $('#fs_connect .fs-freemium-licensing a'),
			href = window.location.href;

		if ( href.indexOf( '?' ) > 0 ) {
			href += '&';
		} else {
			href += '?';
		}

		if ($connectLicenseModeTrigger.length > 0) {
			$connectLicenseModeTrigger.attr('href', href + 'require_license=' + $connectLicenseModeTrigger.attr('data-require-license'))
		}
	})(jQuery);
</script>