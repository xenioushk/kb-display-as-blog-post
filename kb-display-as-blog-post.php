<?php
/**
 * Plugin Name:    KB Display As Blog Post Addon
 * Plugin URI:       https://1.envato.market/bkbm-wp
 * Description:      This Addon automatically include KB posts in you're blog listings according to date order.
 * Version:           1.1.0
 * Author:            Mahbub Alam Khan
 * Author URI:      https://bluewindlab.net
 * WP Requires at least: 6.0+
 * Text Domain:    bkb-kbdabp
 * Domain Path:     /languages/
 *
 * @package KBDABP
 * @author Mahbub Alam Khan
 * @license GPL-2.0+
 * @link https://codecanyon.net/user/xenioushk
 * @copyright 2025 BlueWindLab
 */

namespace KBDABP;

// security check.
defined( 'ABSPATH' ) || die( 'Unauthorized access' );

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
    require_once __DIR__ . '/vendor/autoload.php';
}


// Load the plugin constants
if ( file_exists( __DIR__ . '/includes/Helpers/DependencyManager.php' ) ) {
    require_once __DIR__ . '/includes/Helpers/DependencyManager.php';
    Helpers\DependencyManager::register();
}

use KBDABP\Base\Activate;
use KBDABP\Base\Deactivate;

/**
 * Function to handle the activation of the plugin.
 *
 * @return void
 */
function activate_plugin() { // phpcs:ignore
    $activate = new Activate();
    $activate->activate();
}

/**
 * Function to handle the deactivation of the plugin.
 *
 * @return void
 */
function deactivate_plugin() { // phpcs:ignore
	Deactivate::deactivate();
}

register_activation_hook( __FILE__, __NAMESPACE__ . '\\activate_plugin' );
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\\deactivate_plugin' );

/**
 * Function to handle the initialization of the plugin.
 *
 * @return void
 */
function init_kbdabp() {

    // Check if the parent plugin installed.
    if ( ! class_exists( 'BwlKbManager\\Init' ) ) {
        add_action( 'admin_notices', [ Helpers\DependencyManager::class, 'notice_missing_main_plugin' ] );
        return;
    }

    // Check parent plugin activation status.
    if ( ! ( Helpers\DependencyManager::get_product_activation_status() ) ) {
        add_action( 'admin_notices', [ Helpers\DependencyManager::class, 'notice_missing_purchase_verification' ] );
        return;
    }

    if ( class_exists( 'KBDABP\\Init' ) ) {
        Init::register_services();
    }
}

add_action( 'init', __NAMESPACE__ . '\\init_kbdabp' );


return;

use BkbDabpAddon\Frontend\BkbDabpAddonFrontend;
use BkbDabpAddon\Admin\BkbDabpAddonAdmin;



define( 'BKBDABP_PARENT_PLUGIN_INSTALLED_VERSION', get_option( 'bwl_kb_plugin_version' ) );
define( 'BKBDABP_ADDON_PARENT_PLUGIN_TITLE', 'BWL Knowledge Base Manager Plugin' );
define( 'BKBDABP_ADDON_TITLE', 'KB Display As Blog Post Addon' );
define( 'BKBDABP_PARENT_PLUGIN_REQUIRED_VERSION', '1.4.2' ); // change plugin required version in here.
define( 'BKBDABP_ADDON_CURRENT_VERSION', '1.0.9' ); // change plugin current version in here.

define( 'BKBDABP_ADDON_INSTALLATION_TAG', 'bkbm_dabp_installation_' . str_replace( '.', '_', BKBDABP_ADDON_CURRENT_VERSION ) );

define( 'BKBDABP_ADDON_PREFIX', 'bkb-kbdabp' ); // Addon Data Prefix. It must be simmilar with $plugin slug (kb-display-as-blog-post\public\class-kbdabp-addon.php).

define( 'BKBDABP_DIR', plugin_dir_path( __FILE__ ) );
define( 'BKBDABP_ADDON_UPDATER_SLUG', plugin_basename( __FILE__ ) ); // change plugin current version in here.

define( 'BKBDABP_ADDON_CC_ID', '11245275' ); // Plugin codecanyon Id.

define( 'BKBDABP_PLUGIN_DIR', plugins_url() . '/kb-display-as-blog-post/' );

register_activation_hook( __FILE__, [ BkbDabpAddonFrontend::class, 'activate' ] );
register_deactivation_hook( __FILE__, [ BkbDabpAddonFrontend::class, 'deactivate' ] );

add_action( 'plugins_loaded', [ BkbDabpAddonFrontend::class, 'get_instance' ] );

if ( is_admin() ) {
    add_action( 'plugins_loaded', [ BkbDabpAddonAdmin::class, 'get_instance' ] );
}
