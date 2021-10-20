<?php defined( 'ABSPATH' ) or exit; ?>
<div class="wrap" id="boxzilla-admin" class="boxzilla-settings">

	<div class="boxzilla-row">
		<div class="boxzilla-col-two-third">

			<h2><?php _e( 'Settings', 'boxzilla' ); ?></h2>

			<?php do_action( 'boxzilla_before_settings' ); ?>

			<form action="<?php echo admin_url( 'options.php' ); ?>" method="post">

				<?php settings_fields( 'boxzilla_settings' ); ?>

				<table class="form-table">

					<?php do_action( 'boxzilla_before_settings_rows' ); ?>

					<tr valign="top">
						<th><label for="boxzilla_test_mode"><?php _e( 'Enable test mode?', 'boxzilla' ); ?></label></th>
						<td>
							<label><input type="radio" id="boxzilla_test_mode_1" name="boxzilla_settings[test_mode]" value="1" <?php checked( $opts['test_mode'], 1 ); ?> /> <?php _e( 'Yes', 'boxzilla' ); ?></label> &nbsp;
							<label><input type="radio" id="boxzilla_test_mode_0" name="boxzilla_settings[test_mode]" value="0" <?php checked( $opts['test_mode'], 0 ); ?> /> <?php _e( 'No', 'boxzilla' ); ?></label> &nbsp;
							<p class="help"><?php _e( 'If test mode is enabled, all boxes will show up regardless of whether a cookie has been set.', 'boxzilla' ); ?></p>
						</td>
					</tr>

					<?php do_action( 'boxzilla_after_settings_rows' ); ?>
				</table>

				<?php submit_button(); ?>
			</form>

			<?php do_action( 'boxzilla_after_settings' ); ?>
		</div>

		<div class="boxzilla-sidebar boxzilla-col-one-third">

			<div class="boxzilla-box">
				<h3><?php echo __( 'Looking for help?', 'boxzilla' ); ?></h3>
				<?php include __DIR__ . '/metaboxes/need-help.php'; ?>
			</div>

			<div class="boxzilla-box">
				<h3><?php echo __( 'Our other plugins', 'boxzilla' ); ?></h3>
				<?php include __DIR__ . '/metaboxes/our-other-plugins.php'; ?>
			</div>

			<div class="boxzilla-box">
				<h3><?php echo __( 'Subscribe to our newsletter', 'boxzilla' ); ?></h3>
				<?php include __DIR__ . '/metaboxes/email-optin.php'; ?>
			</div>
		</div>
	</div>

	<br style="clear: both;" />

</div>
