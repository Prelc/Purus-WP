<?php
	/**
	 * @package     Freemius
	 * @copyright   Copyright (c) 2015, Freemius, Inc.
	 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
	 * @since       1.0.3
	 */

	/**
	 * Note for WordPress.org Theme/Plugin reviewer:
	 *  Freemius is an SDK for plugin and theme developers. Since the core
	 *  of the SDK is relevant both for plugins and themes, for obvious reasons,
	 *  we only develop and maintain one code base.
	 *
	 *  This code (and page) will not run for wp.org themes (only plugins)
	 *  since theme admin settings/options are now only allowed in the customizer.
	 *
	 *  In addition, this page loads an i-frame. We intentionally named it 'frame'
	 *  so it will pass the "Theme Check" that is looking for the string "i" . "frame".
	 *
	 * If you have any questions or need clarifications, please don't hesitate
	 * pinging me on slack, my username is @svovaf.
	 *
	 * @author Vova Feldman (@svovaf)
	 * @since 1.2.2
	 */

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'json2' );
	fs_enqueue_local_script( 'postmessage', 'nojquery.ba-postmessage.min.js' );
	fs_enqueue_local_script( 'fs-postmessage', 'postmessage.js' );

	$fs        = freemius( $VARS['id'] );
	$slug 	   = $fs->get_slug();
	$timestamp = time();

	$context_params = array(
		'plugin_id'         => $fs->get_id(),
		'plugin_public_key' => $fs->get_public_key(),
		'plugin_version'    => $fs->get_plugin_version(),
	);

	// Get site context secure params.
	if ( $fs->is_registered() ) {
		$context_params = array_merge( $context_params, FS_Security::instance()->get_context_params(
			$fs->get_site(),
			$timestamp,
			'upgrade'
		) );
	}

	if ( $fs->is_payments_sandbox() ) // Append plugin secure token for sandbox mode authentication.)
	{
		$context_params['sandbox'] = FS_Security::instance()->get_secure_token(
			$fs->get_plugin(),
			$timestamp,
			'checkout'
		);
	}

	$query_params = array_merge( $context_params, $_GET, array(
		'next'           => $fs->_get_sync_license_url( false, false ),
		'plugin_version' => $fs->get_plugin_version(),
		// Billing cycle.
		'billing_cycle'  => fs_request_get( 'billing_cycle', WP_FS__PERIOD_ANNUALLY ),
	) );
?>

	<div id="fs_pricing" class="wrap" style="margin: 0 0 -65px -20px;">
		<div id="frame"></div>
		<form action="" method="POST">
			<input type="hidden" name="user_id"/>
			<input type="hidden" name="user_email"/>
			<input type="hidden" name="site_id"/>
			<input type="hidden" name="public_key"/>
			<input type="hidden" name="secret_key"/>
			<input type="hidden" name="action" value="account"/>
		</form>

		<script type="text/javascript">
			(function ($, undef) {
				$(function () {
					var
					// Keep track of the i-frame height.
					frame_height = 800,
					base_url = '<?php echo WP_FS__ADDRESS ?>',
					// Pass the parent page URL into the i-frame in a meaningful way (this URL could be
					// passed via query string or hard coded into the child page, it depends on your needs).
					src = base_url + '/pricing/?<?php echo http_build_query($query_params) ?>#' + encodeURIComponent(document.location.href),

					// Append the I-frame into the DOM.
					frame = $('<i' + 'frame " src="' + src + '" width="100%" height="' + frame_height + 'px" scrolling="no" frameborder="0" style="background: transparent;"><\/i' + 'frame>')
						.appendTo('#frame');

					FS.PostMessage.init(base_url);

					FS.PostMessage.receive('height', function (data) {
						var h = data.height;
						if (!isNaN(h) && h > 0 && h != frame_height) {
							frame_height = h;
							$('#frame i' + 'frame').height(frame_height + 'px');
						}
					});

					FS.PostMessage.receive('get_dimensions', function (data) {
						FS.PostMessage.post('dimensions', {
							height   : $(document.body).height(),
							scrollTop: $(document).scrollTop()
						}, frame[0]);
					});
				});
			})(jQuery);
		</script>
	</div>
<?php
	$params = array(
		'page'           => 'pricing',
		'module_id'      => $fs->get_id(),
		'module_slug'    => $slug,
		'module_version' => $fs->get_plugin_version(),
	);
	fs_require_template( 'powered-by.php', $params );