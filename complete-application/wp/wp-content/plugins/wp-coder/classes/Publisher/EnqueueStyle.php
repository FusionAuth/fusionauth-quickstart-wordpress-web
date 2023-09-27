<?php

namespace WPCoder\Publisher;

defined( 'ABSPATH' ) || exit;

use WPCoder\Dashboard\FolderManager;
use WPCoder\Optimization\CSSMinifier;
use WPCoder\WOW_Plugin;

class EnqueueStyle {

	public static function init( $result ) {
		$param = maybe_unserialize( $result->param );

		self::include_styles( $result );

		if ( ! empty( $result->css_code ) && empty( $param['inline_css'] ) ) {
			self::include_style( $result->id, $param, $result );
		}

	}

	public static function inline($result ): void {
		if ( is_admin() ) {
			return;
		}

		if(empty($result->css_code)) {
			return;
		}

		$param = maybe_unserialize( $result->param );

		if(empty( $param['inline_css'])) {
			return;
		}

		$css = $result->css_code;

		if ( ! empty( $param['minified_css'] ) ) {
			$css = CSSMinifier::minify( $css );
		}

		$slug = WOW_Plugin::SLUG . '-style-' . $result->id . '-inline';
		echo '<style id="' . esc_attr( $slug ) . '">' . wp_kses_post( $css ) . '</style>';
	}

	private static function include_style( $id, $param, $result ) {
		$url  = FolderManager::get_style_url( $result );
		$time = ! empty( $param['time'] ) ? $param['time'] : time();

		wp_enqueue_style( WOW_Plugin::SLUG . '-style-' . $id, $url, null, WOW_Plugin::VERSION . '_' . $time );
	}

	private static function include_styles( $result ) {
		$styles = self::get_styles( $result );
		if ( empty( $styles ) ) {
			return;
		}

		foreach ( $styles as $style ) {
			if ( empty( $style['att'] ) ) {
				wp_enqueue_style( $style['slug'], $style['url'], null, $style['ver'] );
			}
		}
	}

	private static function get_styles( $result ): array {
		$styles = [];

		$param = maybe_unserialize( $result->param );

		$count = ! empty( $param['include'] ) ? count( $param['include'] ) : 0;
		$time  = ! empty( $param['time'] ) ? $param['time'] : time();

		if ( $count < 1 ) {
			return $styles;
		}

		for ( $i = 0; $i < $count; $i ++ ) {
			if ( $param['include'][ $i ] === 'css' && ! empty( $param['include_file'][ $i ] ) ) {
				$styles[] = [
					'url'  => $param['include_file'][ $i ],
					'slug' => WOW_Plugin::SLUG . '-' . $result->id . '-css-' . $i,
					'ver'  => WOW_Plugin::VERSION . '_' . $time,
				];
			}
		}

		return $styles;
	}

}