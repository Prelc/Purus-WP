<?php
	/**
	 * @package     Freemius
	 * @copyright   Copyright (c) 2015, Freemius, Inc.
	 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
	 * @since       1.1.9
	 */

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	/**
	 * @var Freemius $fs
	 */
	$fs   = freemius( $VARS['id'] );
	$slug = $fs->get_slug();

	if ($fs->is_registered()) {
		// The URL to redirect to after successfully activating the license from the "Plugins" page.
		if ( $fs->is_addon() ) {
			$sync_license_url = $fs->get_parent_instance()->_get_sync_license_url( $fs->get_id(), true );
		} else {
			$sync_license_url = $fs->_get_sync_license_url( $fs->get_id(), true );
		}

		/**
		 * Trigger license sync after valid license activation.
		 */
		$after_license_activation_url = $sync_license_url;
	}
	else
	{
		/**
		 * If user not yet registered, the license activation triggers
		 * an opt-in, which automatically sync the license.
		 */
		$after_license_activation_url = $fs->get_account_url();
	}

	$cant_find_license_key_text = __fs( 'cant-find-license-key', $slug );
	$message_above_input_field  = __fs( 'activate-license-message', $slug );
	$message_below_input_field  = '';

	$header_title = __fs( $fs->is_free_plan() ? 'activate-license' : 'update-license', $slug );

	if ( $fs->is_registered() ) {
		$activate_button_text = $header_title;
	} else {
		$freemius_site_url = $fs->has_paid_plan() ?
			'https://freemius.com/wordpress/' :
			// Insights platform information.
			'https://freemius.com/wordpress/usage-tracking/';

		$freemius_link = '<a href="' . $freemius_site_url . '" target="_blank" tabindex="0">freemius.com</a>';

		$message_below_input_field = sprintf( __fs( 'license-sync-disclaimer', $slug ),
				$fs->get_module_type(),
				$freemius_link,
				$fs->get_module_type()
			);

		$activate_button_text = __fs( 'agree-activate-license', $slug );
	}

	$license_key_text = __fs(  'license-key' , $slug );

	$modal_content_html = <<< HTML
	<div class="notice notice-error inline license-activation-message"><p></p></div>
	<p>{$message_above_input_field}</p>
	<input class="license_key" type="text" placeholder="{$license_key_text}" tabindex="1" />
	<a class="show-license-resend-modal show-license-resend-modal-{$fs->get_unique_affix()}" href="!#" tabindex="2">{$cant_find_license_key_text}</a>
	<p>{$message_below_input_field}</p>
HTML;

	fs_enqueue_local_style( 'dialog-boxes', '/admin/dialog-boxes.css' );
?>
<script type="text/javascript">
(function( $ ) {
	$( document ).ready(function() {
		var modalContentHtml = <?php echo json_encode($modal_content_html); ?>,
			modalHtml =
				'<div class="fs-modal fs-modal-license-activation">'
				+ '	<div class="fs-modal-dialog">'
				+ '		<div class="fs-modal-header">'
				+ '		    <h4><?php echo $header_title ?></h4>'
				+ '         <a href="!#" class="fs-close"><i class="dashicons dashicons-no" title="<?php _efs( 'dismiss' ) ?>"></i></a>'
				+ '		</div>'
				+ '		<div class="fs-modal-body">'
				+ '			<div class="fs-modal-panel active">' + modalContentHtml + '</div>'
				+ '		</div>'
				+ '		<div class="fs-modal-footer">'
				+ '			<button class="button button-secondary button-close" tabindex="4"><?php _efs('deactivation-modal-button-cancel', $slug); ?></button>'
				+ '			<button class="button button-primary button-activate-license"  tabindex="3"><?php echo $activate_button_text; ?></button>'
				+ '		</div>'
				+ '	</div>'
				+ '</div>',
			$modal = $(modalHtml),
			$activateLicenseLink      = $('span.activate-license.<?php echo $fs->get_unique_affix() ?> a, .activate-license-trigger.<?php echo $fs->get_unique_affix() ?>'),
			$activateLicenseButton    = $modal.find('.button-activate-license'),
			$licenseKeyInput          = $modal.find('input.license_key'),
			$licenseActivationMessage = $modal.find( '.license-activation-message' ),
			afterActivationUrl        = '<?php echo html_entity_decode( $after_license_activation_url ) ?>';

		$modal.appendTo($('body'));

		function registerEventHandlers() {
			$activateLicenseLink.click(function (evt) {
				evt.preventDefault();

				showModal();
			});

			$modal.on('input propertychange', 'input.license_key', function () {

				var licenseKey = $(this).val().trim();

				/**
				 * If license key is not empty, enable the license activation button.
				 */
				if (licenseKey.length > 0) {
					enableActivateLicenseButton();
				}
			});

			$modal.on('blur', 'input.license_key', function () {
				var licenseKey = $(this).val().trim();

				/**
				 * If license key is empty, disable the license activation button.
				 */
				if (0 === licenseKey.length) {
					disableActivateLicenseButton();
				}
			});

			$modal.on('click', '.button-activate-license', function (evt) {
				evt.preventDefault();

				if ($(this).hasClass('disabled')) {
					return;
				}

				var licenseKey = $licenseKeyInput.val().trim();

				disableActivateLicenseButton();

				if (0 === licenseKey.length) {
					return;
				}

				$.ajax({
					url: ajaxurl,
					method: 'POST',
					data: {
						action     : '<?php echo $fs->get_action_tag( 'activate_license' ) ?>',
						license_key: licenseKey,
						module_id  : '<?php echo $fs->get_id() ?>'
					},
					beforeSend: function () {
						$activateLicenseButton.text( '<?php _efs( 'activating-license', $slug ); ?>' );
					},
					success: function( result ) {
						var resultObj = $.parseJSON( result );
						if ( resultObj.success ) {
							closeModal();

							// Redirect to the "Account" page and sync the license.
							window.location.href = afterActivationUrl;
						} else {
							showError( resultObj.error );
							resetActivateLicenseButton();
						}
					}
				});
			});

			// If the user has clicked outside the window, close the modal.
			$modal.on('click', '.fs-close, .button-secondary', function () {
				closeModal();
				return false;
			});
		}

		registerEventHandlers();

		function showModal() {
			resetModal();

			// Display the dialog box.
			$modal.addClass('active');
			$('body').addClass('has-fs-modal');

			$licenseKeyInput.focus();
		}

		function closeModal() {
			$modal.removeClass('active');
			$('body').removeClass('has-fs-modal');
		}

		function resetActivateLicenseButton() {
			enableActivateLicenseButton();
			$activateLicenseButton.text( '<?php echo $activate_button_text; ?>' );
		}

		function resetModal() {
			hideError();
			resetActivateLicenseButton();
			$licenseKeyInput.val( '' );
		}

		function enableActivateLicenseButton() {
			$activateLicenseButton.removeClass( 'disabled' );
		}

		function disableActivateLicenseButton() {
			$activateLicenseButton.addClass( 'disabled' );
		}

		function hideError() {
			$licenseActivationMessage.hide();
		}

		function showError( msg ) {
			$licenseActivationMessage.find( ' > p' ).html( msg );
			$licenseActivationMessage.show();
		}
	});
})( jQuery );
</script>
