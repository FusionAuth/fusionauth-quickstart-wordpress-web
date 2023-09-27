<?php
/*
 * Page Name: Include files
 */

use WPCoder\Dashboard\Field;

defined( 'ABSPATH' ) || exit;

$default = Field::getDefault();
$count   = ! empty( $default['param']['include'] ) ? count( $default['param']['include'] ) : 0;

?>

    <h4>
        <span class="wowp-icon wowp-icon-plus"></span>
		<?php esc_html_e( 'Includes', 'wpcoder' ); ?>
    </h4>

    <fieldset id="includes-files">

		<?php if ( $count > 0 ) :
			for ( $i = 0; $i < $count; $i ++ ):
                $css_class = ($default['param']['include'][$i] !== 'css') ? ' is-hidden' : '';
                $js_class = ($default['param']['include'][$i] !== 'js') ? ' is-hidden' : '';
                ?>

                <div class="wowp-fields-group">
                    <div class="wowp-field">
                        <label class="label"
                               id="include_<?php echo absint( $i ); ?>"><?php esc_html_e( 'Type', 'wpcoder' ); ?></label>
						<?php Field::select( '[include][' . $i . ']', null, [ 'css' => 'css', 'js' => 'js' ] ); ?>
                    </div>
                    <div class="wowp-field">
                        <label class="label"
                               id="include_file_<?php echo absint( $i ); ?>"><?php esc_html_e( 'URL', 'wpcoder' ); ?></label>
						<?php Field::text( '[include_file][' . $i . ']', null, 'url' ); ?>
                    </div>

                    <div class="wowp-field wowp-include-js<?php echo esc_attr($js_class);?>">
                        <label for="file_js_att_<?php echo absint( $i ); ?>"
                               class="label"><?php esc_html_e( 'Attribute', 'wpcoder' ); ?></label>
						<?php Field::select( '[file_js_att][' . $i . ']', null, [
							0       => 'none',
							'defer' => 'defer',
							'async' => 'async'
						] ); ?>
                    </div>
                </div>

			<?php
			endfor;
		endif; ?>


    </fieldset>

    <div class="wowp-fields-group">
		<?php submit_button( 'Add new', 'primary small', 'add-include', false ); ?>
		<?php submit_button( 'Remove Last', 'small delete', 'remove-include', false ); ?>
    </div>

    <template id="clone-includes">
        <div class="wowp-fields-group">
            <div class="wowp-field">
                <label class="label"><?php esc_html_e( 'Type', 'wpcoder' ); ?></label>
                <select name="param[include][]">
                    <option value="css">css</option>
                    <option value="js">js</option>
                </select>
            </div>
            <div class="wowp-field">
                <label class="label"><?php esc_html_e( 'URL', 'wpcoder' ); ?></label>
                <input type="url" name="param[include_file][]">
            </div>

            <div class="wowp-field wowp-include-js is-hidden">
                <label class="label"><?php esc_html_e( 'Attribute', 'wpcoder' ); ?></label>
                <select name="param[file_js_att][]">
                    <option value="0">none</option>
                    <option value="defer">defer</option>
                    <option value="async">async</option>
                </select>
            </div>

        </div>

    </template>

<?php
