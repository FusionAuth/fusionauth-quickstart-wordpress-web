<?php

use WPCoder\Dashboard\DBManager;
use WPCoder\Dashboard\Field;
use WPCoder\Dashboard\Link;
use WPCoder\WOW_Plugin;

defined( 'ABSPATH' ) || exit;

$default = Field::getDefault();

$link = ! empty( $default['param']['link'] ) ? $default['param']['link'] : '';

$shortcode = '';
if ( ! empty( $default['id'] ) ) {
	$shortcode = '[' . WOW_Plugin::SHORTCODE . ' id="' . absint( $default['id'] ) . '"]';
}

?>

<div class="postbox ">
    <div class="postbox-header">
        <h2 class="hndle">
			<?php esc_html_e( 'Publish', 'wpcoder' ); ?>
        </h2>
    </div>

    <div class="inside">

        <div class="submitbox wowp-sidebar" id="submitpost">

            <div id="minor-publishing">
                <div class="misc-pub-section wowp-sidebar-pub-section">

                    <div class="wowp-field has-chackbox">
                        <span class="label"><?php esc_html_e( 'Status', 'wpcoder' ); ?></span>
						<?php Field::checkbox( 'status' ); ?>
                        <label for="status"><?php esc_html_e( 'Deactivate', 'wpcoder' ); ?></label>
                    </div>

                    <div class="wowp-field has-chackbox">
                        <span class="label"><?php esc_html_e( 'Test mode', 'wpcoder' ); ?></span>
						<?php Field::checkbox( 'mode' ); ?>
                        <label for="mode"><?php esc_html_e( 'Activate', 'wpcoder' ); ?></label>
                    </div>

                    <div class="wowp-field has-addon border-default">
                        <label for="tag" class="is-addon"><span class="dashicons dashicons-tag"></span></label>
                        <input list="wowp-tags" type="text" name="tag" id="tag"
                               value="<?php echo esc_attr( $default['tag'] ); ?>">
                        <datalist id="wowp-tags">
							<?php DBManager::display_tags(); ?>
                        </datalist>
                    </div>

                    <div class="wowp-field has-addon border-default">
                        <label for="link" class="is-addon">
							<?php if ( ! empty( $link ) ): ?>
                                <a href="<?php echo esc_url( $link ); ?>" target="_blank">
                                    <span class="dashicons dashicons-admin-links"></span>
                                </a>
							<?php else: ?>
                                <span class="dashicons dashicons-admin-links"></span>
							<?php endif; ?>
                        </label>
                        <input type="url" name="param[link]" id="link"
                               value="<?php echo esc_url( $link ); ?>">
                    </div>

					<?php if ( ! empty( $shortcode ) ) : ?>
                        <div class="wowp-field has-addon border-default">
                            <label for="shortcode" class="is-addon">
                                <span class="dashicons dashicons-shortcode"></span>
                            </label>
                            <input type="text" id="shortcode" readonly value="<?php echo esc_attr( $shortcode ); ?>">
                        </div>
					<?php endif; ?>

                </div>
            </div>
            <div class="major-publishing-actions" id="major-publishing-actions">
				<?php if ( ! empty( $default['id'] ) ): ?>
                    <div id="delete-action">
                        <a class="submitdelete deletion"
                           href="<?php echo esc_url( Link::remove( $default['id'] ) ); ?>">
							<?php esc_html_e( 'Delete', 'wpcoder' ); ?>
                        </a>
                    </div>
				<?php endif; ?>

                <div id="publishing-action">
					<?php submit_button( null, 'primary', 'submit_settings', false ); ?>
                </div>
                <div class="clear"></div>

            </div>

        </div>
    </div>
</div>
