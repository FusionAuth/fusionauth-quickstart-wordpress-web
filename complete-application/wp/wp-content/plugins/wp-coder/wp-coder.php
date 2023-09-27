<?php
/**
 * Plugin Name:       WP Coder
 * Plugin URI:        https://wordpress.org/plugins/wp-coder/
 * Description:       Adding custom HTML, CSS, and JavaScript code to your WordPress site.
 * Version:           3.0.5
 * Author:            Wow-Company
 * Author URI:        https://wow-estore.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wpcoder
 * Requires at least: 5.4
 * Requires PHP:      7.4
 */

namespace WPCoder;

// Exit if accessed directly.
use WPCoder\Dashboard\DBManager;
use WPCoder\Dashboard\FolderManager;
use WPCoder\Update\UpdateDB;

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WOW_Plugin' ) ) :

	final class WOW_Plugin {

		public const EMAIl = 'yoda@wow-company.com';
		// Plugin name
		public const NAME = 'WP Coder';

		// Plugin version
		public const VERSION = '3.0.5';

		// Plugin slug
		public const SLUG = 'wp-coder';

		// Plugin prefix
		public const PREFIX = 'wow_coder';

		public const FOLDER = 'wp-coder';

		public const SHORTCODE = 'WP-Coder';

		// Plugin ULR
		public const PluginURL = 'https://wordpress.org/plugins/wp-coder/';

		private static $instance;
		/**
		 * @var Autoloader
		 */
		private $autoloader;
		/**
		 * @var Wow_Dashboard
		 */
		private $dashboard;

		public static function instance(): WOW_Plugin {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof WOW_Plugin ) ) {
				self::$instance = new self;

				self::$instance->includes();
				self::$instance->autoloader = new Autoloader( 'WPCoder' );
				self::$instance->dashboard  = new WOWP_Dashboard();
				self::$instance->public     = new WOWP_Public();

				register_activation_hook( __FILE__, [ self::$instance, 'plugin_activate' ] );
				add_action( 'plugins_loaded', [ self::$instance, 'loaded' ] );
			}


			return self::$instance;
		}

		// Plugin Root File.
		public static function file(): string {
			return __FILE__;
		}

		// Plugin Base Name.
		public static function basename(): string {
			return plugin_basename( __FILE__ );
		}

		// Plugin Folder Path.
		public static function dir(): string {
			return plugin_dir_path( __FILE__ );
		}

		// Plugin Folder URL.
		public static function url(): string {
			return plugin_dir_url( __FILE__ );
		}

		/**
		 * Include required files.
		 *
		 * @access private
		 * @since  1.0
		 */
		private function includes(): void {
			if ( ! class_exists( 'Wow_Company' ) ) {
				require_once self::dir() . 'includes/class-wow-company.php';
			}

			require_once self::dir() . 'classes/Autoloader.php';
			require_once self::dir() . 'includes/class-wowp-dashboard.php';
			require_once self::dir() . 'includes/class-wowp-public.php';
		}

		/**
		 * Throw error on object clone.
		 * The whole idea of the singleton design pattern is that there is a single
		 * object therefore, we don't want the object to be cloned.
		 *
		 * @return void
		 * @access protected
		 */
		public function __clone() {
			// Cloning instances of the class is forbidden.
			_doing_it_wrong( __FUNCTION__, esc_attr__( 'Cheatin&#8217; huh?', 'wpcoder' ), '1.0' );
		}

		/**
		 * Disable unserializing of the class.
		 *
		 * @return void
		 * @access protected
		 */
		public function __wakeup() {
			// Unserializing instances of the class is forbidden.
			_doing_it_wrong( __FUNCTION__, esc_attr__( 'Cheatin&#8217; huh?', 'wpcoder' ), '1.0' );
		}

		public function plugin_activate(): void {
			$columns = "
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			title VARCHAR(200) NOT NULL,
			html_code LONGTEXT,
			css_code LONGTEXT,
			js_code LONGTEXT,
			param LONGTEXT,
			status BOOLEAN,
			mode BOOLEAN,
			tag TEXT,
			UNIQUE KEY id (id)
			";
			DBManager::create( $columns );
			FolderManager::create();

			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			if ( is_plugin_active( 'wp-coder-pro/wp-coder-pro.php' ) ) {
				deactivate_plugins( 'wp-coder-pro/wp-coder-pro.php' );
			}
		}

		/**
		 * Download the folder with languages.
		 *
		 * @access Publisher
		 * @return void
		 */
		public function loaded(): void {
			UpdateDB::init();
			$languages_folder = dirname( plugin_basename( __FILE__ ) ) . '/languages/';
			load_plugin_textdomain( 'wpcoder', false, $languages_folder );
		}

	}

endif;

function wow_plugin_run() {
	return WOW_Plugin::instance();
}

wow_plugin_run();