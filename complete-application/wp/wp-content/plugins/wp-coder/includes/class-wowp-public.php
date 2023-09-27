<?php

namespace WPCoder;

defined( 'ABSPATH' ) || exit;

use WPCoder\Dashboard\DBManager;
use WPCoder\Publisher\Conditions;
use WPCoder\Publisher\Display;
use WPCoder\Publisher\EnqueueScript;
use WPCoder\Publisher\EnqueueStyle;
use WPCoder\Publisher\PageTemplate;
use WPCoder\Publisher\Shortcodes;
use WPCoder\Publisher\Singleton;

class WOWP_Public {

	public function __construct() {
		add_shortcode( WOW_Plugin::SHORTCODE, [ $this, 'shortcode' ] );
		add_action( 'wp_footer', [ $this, 'print_footer' ], 50 );
	}

	public function shortcode( $atts ) {
		$atts = shortcode_atts(
			[ 'id' => "", 'title' => '', ],
			$atts,
			WOW_Plugin::SHORTCODE
		);

		if ( ! empty( $atts['id'] ) ) {
			$result = DBManager::get_data_by_id( $atts['id'] );
		} elseif ( ! empty( $atts['title'] ) ) {
			$result = DBManager::get_data_by_title( $atts['title'] );
		} else {
			return false;
		}

		if ( empty( $result ) ) {
			return false;
		}

		if ( Conditions::init( $result ) === false ) {
			return false;
		}

		$html_code = $result->html_code;

		$singleton = Singleton::getInstance();
		$singleton->setValue( $result->id, $result );

		EnqueueStyle::init( $result );
		EnqueueScript::init( $result );

		return do_shortcode( $html_code );
	}

	public function print_footer() {
		$singleton  = Singleton::getInstance();
		$shortcodes = $singleton->getValue();

		foreach ($shortcodes as $id => $result) {
			EnqueueStyle::inline( $result );
			EnqueueScript::inline( $result );
		}


	}


}