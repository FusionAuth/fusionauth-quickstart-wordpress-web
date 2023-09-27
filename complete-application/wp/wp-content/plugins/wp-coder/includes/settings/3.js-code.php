<?php
/*
 * Page Name: JS Code
 */

use WPCoder\Dashboard\Field;
use WPCoder\Dashboard\FolderManager;

defined( 'ABSPATH' ) || exit;

$default = Field::getDefault();

$js_link = '';
if ( ! empty( $default['js_code'] ) ) {
	$js_link = FolderManager::path_upload_url() . 'script-' . $default['id'] . '.js';
}

?>
    <h4>
        <span class="wowp-icon wowp-icon-js"></span>
		<?php esc_html_e( 'JavaScript Code', 'wpcoder' ); ?>
    </h4>

    <fieldset>
        <legend><?php esc_html_e( 'Settings', 'wpcoder' ); ?></legend>

        <div class="wowp-field has-chackbox">
            <span class="label"><?php esc_html_e( 'JQuery Dependency', 'wpcoder' ); ?></span>
			<?php Field::checkbox( '[jquery_dependency]' ); ?>
            <label for="jquery_dependency">Disable</label>
        </div>

        <div class="wowp-field has-chackbox">
            <span class="label"><?php esc_html_e( 'Inline', 'wpcoder' ); ?></span>
			<?php Field::checkbox( '[inline_js]' ); ?>
            <label for="inline_js">Enable</label>
        </div>

        <div class="wowp-field">
            <label for="js_attributes" class="label"><?php esc_html_e( 'Minified', 'wpcoder' ); ?></label>
			<?php Field::select( '[minified_js]', 'obfuscate', [
				'none'      => 'none',
				'minify'    => 'Minify',
				'obfuscate' => 'Obfuscate'
			] ); ?>
        </div>

        <div class="wowp-field">
            <label for="js_attributes" class="label"><?php esc_html_e( 'Attribute', 'wpcoder' ); ?></label>
			<?php Field::select( '[js_attributes]', null, [
				0       => 'none',
				'defer' => 'defer',
				'async' => 'async'
			] ); ?>
        </div>

    </fieldset>


<?php Field::textarea( 'js_code' ); ?>

<?php if ( ! empty( $js_link ) ): ?>
    <div class="wowp-fields-group has-mt">
        <div class="wowp-field is-full has-addon border-default">
            <label for="url-css-file" class="is-addon">
                <span class="dashicons dashicons-admin-links"></span>
            </label>
            <input type="url" id="url-css-file" readonly="readonly" value="<?php echo esc_url( $js_link ); ?>">
            <span class="label"><?php esc_html_e( 'URL to the JS file', 'wpcoder' ); ?></span>
        </div>
    </div>
<?php endif; ?>


<?php
