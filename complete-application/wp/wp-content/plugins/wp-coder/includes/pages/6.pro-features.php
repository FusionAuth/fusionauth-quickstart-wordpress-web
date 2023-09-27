<?php
/**
 * Page Name: PRO Features
 *
 */

defined( 'ABSPATH' ) || exit;

$features = [
	'page'      => [
		__( 'WP Coder Page Template' ),
		__( 'Whether you need a unique landing page, a distinct layout for a specific post, or a specialized page for an event, our WP Coder Page Template feature allows you to break free from the constraints of your theme\'s predefined templates. The page you create will be fully compatible with WordPress and seamlessly integrate with your existing site.', 'wpcoder' ),
	],
    'brackets' => [
	    __( 'Custom Shortcodes' ),
	    __( 'You can insert the WP Coder shortcodes for: check users, uses the custom fields and other.', 'wpcoder' ),
    ],
	'play'      => [
		__( 'Display Rules', 'wpcoder' ),
		__( 'Choose to display or hide the element on specific parts of your site, such as home page, blog page, archive pages, individual posts or pages, custom post types.', 'wpcoder' ),
	],
	'devices'   => [
		__( 'Devices Rules', 'wpcoder' ),
		__( 'Adjust visibility based on the device the visitor is using, such as desktop or mobile.', 'wpcoder' ),
	],
	'users-cog' => [
		__( 'Users Rules', 'wpcoder' ),
		__( 'Control visibility based on the user\'s status. For example, you might show or hide elements depending on whether a user is logged in, what user role they have (like Subscriber, Contributor, Administrator), or even target specific users.', 'wpcoder' ),
	],
	'browser'   => [
		__( 'Browsers Rules', 'wpcoder' ),
		__( 'This powerful feature allows you to tailor your content to the specific browser your visitor is using. With Browser Rules, you can create unique experiences for users depending on their browser type, such as Chrome, Firefox, Safari, or Edge.', 'wpcoder' ),
	],
	'language'  => [
		__( 'Language Rule', 'wpcoder' ),
		__( 'If your site is multilingual, you can decide which elements appear for each language.', 'wpcoder' ),
	],
	'schedule'  => [
		__( 'Schedule', 'wpcoder' ),
		__( 'Set the element to appear or disappear during certain timeframes. This can be useful for time-limited offers or seasonal events.', 'wpcoder' ),
	],

];

?>

    <div class="w_block w_has-border">

        <div class="w_block-titles">
            <div class="w_block-subtitle"><?php esc_html_e('what you get', 'wpcoder');?></div>
            <h3 class="w_block-title"><?php esc_html_e('PRO Features', 'wpcoder');?></h3>
        </div>

        <div class="w_block-btns">
            <a href="https://wow-estore.com/item/wp-coder-pro/" class="w_btn-pro" target="_blank"><?php esc_html_e('Get More with Pro', 'wpcoder');?></a>
            <a href="https://wow-estore.com/guides/wp-coder/" class="w_btn-demo" target="_blank"><?php esc_html_e('Docs', 'wpcoder');?></a>
        </div>

        <div class="w_boxes__3-col">

			<?php foreach ( $features as $icon => $text ): ?>
                <div class="w_box">

                    <div class="w_card">
                        <figure class="w_card-media">
                            <span class="wowp-icon wowp-icon-<?php echo esc_attr( $icon ); ?>"></span>
                        </figure>
                        <div class="w_card-content">
                            <h5 class="w_card-title"><?php echo esc_html( $text[0] ); ?></h5>
                            <p class="w_card-description">
								<?php echo esc_html( $text[1] ); ?>
                            </p>
                        </div>
                    </div>

                </div>

			<?php endforeach; ?>

        </div>


    </div>


<?php
