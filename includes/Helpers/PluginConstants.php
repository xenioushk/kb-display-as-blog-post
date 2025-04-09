<?php
namespace KBDABP\Helpers;

/**
 * Class for plugin constants.
 *
 * @package KBDABP
 */
class PluginConstants {

		/**
         * Static property to hold plugin options.
         *
         * @var array
         */
	public static $plugin_options = [];

	/**
	 * Initialize the plugin options.
	 */
	public static function init() {

		self::$plugin_options = get_option( 'bkb_options' );
	}

		/**
         * Get the relative path to the plugin root.
         *
         * @return string
         * @example wp-content/plugins/<plugin-name>/
         */
	public static function get_plugin_path(): string {
		return dirname( dirname( __DIR__ ) ) . '/';
	}


    /**
     * Get the plugin URL.
     *
     * @return string
     * @example http://appealwp.local/wp-content/plugins/<plugin-name>/
     */
	public static function get_plugin_url(): string {
		return plugin_dir_url( self::get_plugin_path() . KBDABP_PLUGIN_ROOT_FILE );
	}

	/**
	 * Register the plugin constants.
	 */
	public static function register() {
		self::init();
		self::set_paths_constants();
		self::set_base_constants();
		self::set_assets_constants();
		self::set_options_constants();
		self::set_updater_constants();
		self::set_product_info_constants();
	}

	/**
	 * Set the plugin base constants.
     *
	 * @example: $plugin_data = get_plugin_data( KBDABP_PLUGIN_DIR . '/' . KBDABP_PLUGIN_ROOT_FILE );
	 * echo '<pre>';
	 * print_r( $plugin_data );
	 * echo '</pre>';
	 * @example_param: Name,PluginURI,Description,Author,Version,AuthorURI,RequiresAtLeast,TestedUpTo,TextDomain,DomainPath
	 */
	private static function set_base_constants() {

		$plugin_data = get_plugin_data( KBDABP_PLUGIN_DIR . '/' . KBDABP_PLUGIN_ROOT_FILE );

		define( 'KBDABP_PLUGIN_VERSION', $plugin_data['Version'] ?? '1.0.0' );
		define( 'KBDABP_PLUGIN_TITLE', $plugin_data['Name'] ?? 'KB Display As Blog Post Addon' );
		define( 'KBDABP_TRANSLATION_DIR', $plugin_data['DomainPath'] ?? '/languages/' );
		define( 'KBDABP_TEXT_DOMAIN', $plugin_data['TextDomain'] ?? '' );

		define( 'KBDABP_PLUGIN_FOLDER', 'kb-display-as-blog-post' );
		define( 'KBDABP_PLUGIN_CURRENT_VERSION', KBDABP_PLUGIN_VERSION );
		define( 'KBDABP_PLUGIN_POST_TYPE', 'bwl_kb' );
		define( 'KBDABP_PLUGIN_TAXONOMY_CAT', 'bkb_category' );
		define( 'KBDABP_PLUGIN_TAXONOMY_TAGS', 'bkb_tags' );
	}

	/**
	 * Set the plugin paths constants.
	 */
	private static function set_paths_constants() {
		define( 'KBDABP_PLUGIN_ROOT_FILE', 'kb-display-as-blog-post.php' );
		define( 'KBDABP_PLUGIN_DIR', self::get_plugin_path() );
		define( 'KBDABP_PLUGIN_FILE_PATH', KBDABP_PLUGIN_DIR );
		define( 'KBDABP_PLUGIN_URL', self::get_plugin_url() );
	}

	/**
	 * Set the plugin assets constants.
	 */
	private static function set_assets_constants() {
		define( 'KBDABP_PLUGIN_STYLES_ASSETS_DIR', KBDABP_PLUGIN_URL . 'assets/styles/' );
		define( 'KBDABP_PLUGIN_SCRIPTS_ASSETS_DIR', KBDABP_PLUGIN_URL . 'assets/scripts/' );
		define( 'KBDABP_PLUGIN_LIBS_DIR', KBDABP_PLUGIN_URL . 'libs/' );
	}


	/**
	 * Set the plugin options constants.
	 */
	private static function set_options_constants() {
		define( 'KBDABP_FEED_STATUS', ! empty( self::$plugin_options['bkb_kb_blog_feed_status'] ) ? 1 : 0 );
	}

	/**
	 * Set the updater constants.
	 */
	private static function set_updater_constants() {

		// Only change the slug.
		$slug        = 'bkbm/notifier_bkbm_dabp.php';
		$updater_url = "https://projects.bluewindlab.net/wpplugin/zipped/plugins/{$slug}";

		define( 'KBDABP_PLUGIN_UPDATER_URL', $updater_url ); // phpcs:ignore
		define( 'KBDABP_PLUGIN_UPDATER_SLUG', KBDABP_PLUGIN_FOLDER . '/' . KBDABP_PLUGIN_ROOT_FILE ); // phpcs:ignore
		define( 'KBDABP_PLUGIN_PATH', KBDABP_PLUGIN_DIR );
	}

	/**
	 * Set the product info constants.
	 */
	private static function set_product_info_constants() {
		define( 'KBDABP_PRODUCT_ID', '11245275' ); // Plugin codecanyon/themeforest Id.
		define( 'KBDABP_PRODUCT_INSTALLATION_TAG', 'bkbm_dabp_installation_' . str_replace( '.', '_', KBDABP_PLUGIN_VERSION ) );
	}
}
