<?php
/*
 * Page Name: HTML Code
 */

use WPCoder\Dashboard\Field;

defined( 'ABSPATH' ) || exit;
?>

    <h4>
        <span class="wowp-icon wowp-icon-html5"></span>
		<?php esc_html_e( 'HTML Code', 'wpcoder' ); ?>
    </h4>

<?php Field::textarea( 'html_code' ); ?>

<?php

