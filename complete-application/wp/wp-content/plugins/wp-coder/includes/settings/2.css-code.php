<?php
/*
 * Page Name: CSS Code
 */

use WPCoder\Dashboard\Field;
use WPCoder\Dashboard\FolderManager;

defined( 'ABSPATH' ) || exit;

$default = Field::getDefault();

$css_link = '';
if ( ! empty( $default['css_code'] ) ) {
	$css_link = FolderManager::path_upload_url() . 'style-' . $default['id'] . '.css';
}

?>

    <h4>
        <span class="wowp-icon wowp-icon-css3"></span>
		<?php esc_html_e( 'CSS Code', 'wpcoder' ); ?>
    </h4>

    <fieldset>
        <legend><?php esc_html_e( 'Settings', 'wpcoder' ); ?></legend>

        <div class="wowp-field has-chackbox">
            <span class="label"><?php esc_html_e( 'Inline', 'wpcoder' ); ?></span>
			<?php Field::checkbox( '[inline_css]' ); ?>
            <label for="inline_css">Enable</label>
        </div>

        <div class="wowp-field has-chackbox">
            <span class="label"><?php esc_html_e( 'Minified', 'wpcoder' ); ?></span>
			<?php Field::checkbox( '[minified_css]' ); ?>
            <label for="minified_css">Enable</label>
        </div>

    </fieldset>


<?php Field::textarea( 'css_code' ); ?>

<?php if ( ! empty( $css_link ) ): ?>
    <div class="wowp-fields-group has-mt">
        <div class="wowp-field is-full has-addon border-default">
            <label for="url-css-file" class="is-addon">
                <span class="dashicons dashicons-admin-links"></span>
            </label>
            <input type="url" id="url-css-file" readonly="readonly" value="<?php echo esc_url( $css_link ); ?>">
            <span class="label"><?php esc_html_e( 'URL to the CSS file', 'wpcoder' ); ?></span>
        </div>

    </div>
<?php endif;

