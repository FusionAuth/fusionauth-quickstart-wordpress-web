<?php

namespace WPCoder;

use WPCoder\Admin\AdminInitializer;
use WPCoder\Dashboard\DashboardInitializer;

defined( 'ABSPATH' ) || exit;

class WOWP_Dashboard {

	public function __construct() {
		add_action( WOW_Plugin::PREFIX . '_admin_load_styles_scripts', [ $this, 'load_styles_scripts' ] );
		add_action( WOW_Plugin::PREFIX . '_admin_page', [ $this, 'dashboard' ] );
		add_action( WOW_Plugin::PREFIX . '_admin_header_links', [ $this, 'header_links' ] );
		add_filter( WOW_Plugin::PREFIX . '_save_settings', [ $this, 'save_settings' ], 10, 2 );
		add_filter( WOW_Plugin::PREFIX . '_default_custom_post', [ $this, 'default_custom_post' ] );

		AdminInitializer::init();
	}

	public function default_custom_post( $display_def ) {
		if ( str_contains( $display_def, 'custom_post_selected' ) ) {
			return 'post_selected';
		}
		if ( str_contains( $display_def, 'custom_post_tax' ) ) {
			return 'post_category';
		}
		if ( str_contains( $display_def, 'custom_post_all' ) ) {
			return 'post_all';
		}

		return $display_def;
	}

	private function allowed_html() {
		$tags = wp_kses_allowed_html( 'post' );

		$additional_tags = [
			'input'  => [
				'accept',
				'alt',
				'autocomplete',
				'autofocus',
				'checked',
				'dirname',
				'disabled',
				'form',
				'formaction',
				'formenctype',
				'formmethod',
				'formnovalidate',
				'formtarget',
				'height',
				'inputmode',
				'list',
				'max',
				'maxlength',
				'min',
				'minlength',
				'multiple',
				'name',
				'pattern',
				'placeholder',
				'readonly',
				'required',
				'size',
				'src',
				'step',
				'type',
				'value',
				'width'
			],
			'select' => [
				'autofocus',
				'disabled',
				'form',
				'multiple',
				'name',
				'required',
				'size'
			],
			'option' => [
				'disabled',
				'label',
				'selected',
				'value'
			],
			'form'   => [
				'action',
				'accept',
				'accept-charset',
				'enctype',
				'method',
				'name',
				'target'
			],
			'iframe' => [
				'align',
				'allow',
				'allowfullscreen',
				'allowpaymentrequest',
				'allowusermedia',
				'csp',
				'height',
				'importance',
				'loading',
				'name',
				'referrerpolicy',
				'sandbox',
				'src',
				'srcdoc',
				'width',
				'frameborder',
				'longdesc',
				'marginheight',
				'marginwidth',
				'scrolling'
			],
		];

		foreach ( $additional_tags as $tag => $attributes ) {
			$tags[ $tag ] = array_fill_keys( $attributes, true );
		}

		return $tags;
	}

	public function save_settings( $settings, $request ): array {
		$param = ! empty( $request['param'] ) ? map_deep( $request['param'], [ $this, 'sanitize_param' ] ) : [];

		$settings['data']['title']     = ! empty( $request['title'] ) ? sanitize_text_field( wp_unslash( $request['title'] ) ) : '';
		$settings['formats'][]         = '%s';
		$settings['data']['html_code'] = ! empty( $request['html_code'] ) ?  wp_unslash( $request['html_code'] ) : '';
		$settings['formats'][]         = '%s';
		$settings['data']['css_code']  = ! empty( $request['css_code'] ) ?  wp_unslash( $request['css_code'] ) : '';
		$settings['formats'][]         = '%s';
		$settings['data']['js_code']   = ! empty( $request['js_code'] ) ?  wp_unslash( $request['js_code'] ) : '';
		$settings['formats'][]         = '%s';
		$settings['data']['status']    = ! empty( $request['status'] ) ? sanitize_textarea_field( wp_unslash( $request['status'] ) ) : '';
		$settings['formats'][]         = '%d';
		$settings['data']['mode']      = ! empty( $request['mode'] ) ? sanitize_textarea_field( wp_unslash( $request['mode'] ) ) : '';
		$settings['formats'][]         = '%d';
		$settings['data']['tag']       = ! empty( $request['tag'] ) ? sanitize_textarea_field( wp_unslash( $request['tag'] ) ) : '';
		$settings['formats'][]         = '%s';

		if ( ! empty( $request['param']['include_file'] ) ) {
			$param['include_file'] = ! empty( $request['param']['include_file'] ) ? map_deep( $request['param']['include_file'],
				'esc_url' ) : [];
		}

		$settings['data']['param'] = maybe_serialize( $param );
		$settings['formats'][]     = '%s';

		return $settings;
	}

	public function sanitize_param( $value ) {
		return wp_unslash( sanitize_text_field( $value ) );
	}

	public function load_styles_scripts(): void {
		$assets_url = WOW_Plugin::url() . 'assets/';
		$version    = WOW_Plugin::VERSION;
		$slug       = WOW_Plugin::SLUG;

		wp_enqueue_style( $slug . '-admin', $assets_url . 'css/admin.css', null, $version );

		wp_enqueue_style( $slug . '-admin-icons', $assets_url . 'icons/wowpicon/css/style.css', null, $version );

		wp_enqueue_script( 'code-editor' );
		wp_enqueue_style( 'code-editor' );
		wp_enqueue_script( 'htmlhint' );
		wp_enqueue_script( 'csslint' );
		wp_enqueue_script( 'jshint' );

		wp_enqueue_script( $slug . '-admin', $assets_url . 'js/admin.js', array( 'jquery' ), $version );
	}

	public function dashboard(): void {
		DashboardInitializer::init();
	}


	public function header_links(): void {
		$logo = WOW_Plugin::url() . 'assets/img/wow-icon.png';
		?>
        <div class="wowp-links">
            <a href="https://wow-estore.com/" target="_blank">
                <img src="<?php
				echo esc_url( $logo ); ?>" alt="Logo Wow-Estore.com">
                <span>Wow-Estore</span>
            </a>
            <a href="https://wow-estore.com/guides/wp-coder/" target="_blank">
                <span class="dashicons dashicons-book-alt"></span>
                <span>Docs</span>
            </a>
            <a href="https://wordpress.org/support/plugin/wp-coder/reviews/" target="_blank">
                <span class="dashicons dashicons-star-filled"></span>
                <span>Reviews</span>
            </a>
        </div>

		<?php
	}


}