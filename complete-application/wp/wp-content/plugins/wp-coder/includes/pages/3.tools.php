<?php
/**
 * Page Name: Import/Export
 *
 */

use WPCoder\Dashboard\ImporterExporter;
use WPCoder\WOW_Plugin;

defined( 'ABSPATH' ) || exit;

?>

    <div class="w_block w_has-border">

                <div class="inside">
                    <h3><span><?php esc_attr_e( 'Export Settings', 'wpcoder' ); ?></span></h3>
                    <div class="inside">
                        <p><?php
							printf( esc_attr__( 'Export the  settings for %s as a .json file. This allows you to easily import the configuration into another site.', 'wpcoder' ), '<b>' . esc_attr( WOW_Plugin::NAME ) . '</b>' ); ?></p>
						<?php ImporterExporter::form_export(); ?>
                    </div>
                </div>
                <hr>

                <div class="inside">
                    <h3><span><?php esc_attr_e( 'Import Settings', 'wpcoder' ); ?></span></h3>
                    <div class="inside">
                        <p><?php
							printf( esc_attr__( 'Import the %s settings from a .json file. This file can be obtained by exporting the settings on another site using the form above.', 'wpcoder' ), '<b>' . esc_attr( WOW_Plugin::NAME ) . '</b>    ' ); ?></p>
						<?php ImporterExporter::form_import(); ?>
                    </div>
                </div>



    </div>

<?php
