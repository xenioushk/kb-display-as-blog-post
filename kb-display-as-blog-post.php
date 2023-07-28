<?php

/**
 * @package BkbDabpAddon
 */

/**
 * Plugin Name:    KB Display As Blog Post - BWL Knowledge Base Manager Addon
 * Plugin URI:       https://1.envato.market/bkbm-wp
 * Description:      This is an Addon for BWL Knowledge Base Manager. It allows you to display your Knowledge Base contents as blog post. This Addon automatically include KB posts in you're blog listings according to date order. Addon comes with Quick and Bulk edit options, so you can easily choose which KB you want to show in blog lists. Addon also allows you to integrate featured image with every KB.
 * Version:           1.0.8
 * Author:            Mahbub Alam Khan
 * Author URI:      https://bluewindlab.net
 */
// security check.
defined('ABSPATH') or die("Unauthorized access");

if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    require_once dirname(__FILE__) . '/vendor/autoload.php';
}

use BkbDabpAddon\Frontend\BkbDabpAddonFrontend;
use BkbDabpAddon\Admin\BkbDabpAddonAdmin;

define('BKBDABP_PARENT_PLUGIN_INSTALLED_VERSION', get_option('bwl_kb_plugin_version'));
define('BKBDABP_ADDON_PARENT_PLUGIN_TITLE', 'BWL Knowledge Base Manager Plugin');
define('BKBDABP_ADDON_TITLE', 'KB Display As Blog Post Addon');
define('BKBDABP_PARENT_PLUGIN_REQUIRED_VERSION', '1.4.2'); // change plugin required version in here.
define('BKBDABP_ADDON_CURRENT_VERSION', '1.0.8'); // change plugin current version in here.

define('BKBDABP_ADDON_INSTALLATION_TAG', 'bkbm_dabp_installation_' . str_replace('.', '_', BKBDABP_ADDON_CURRENT_VERSION));

define('BKBDABP_ADDON_PREFIX', 'bkb-kbdabp'); // Addon Data Prefix. It must be simmilar with $plugin slug (kb-display-as-blog-post\public\class-kbdabp-addon.php).

define('BKBDABP_DIR', plugin_dir_path(__FILE__));
define('BKBDABP_ADDON_UPDATER_SLUG', plugin_basename(__FILE__)); // change plugin current version in here.

define("BKBDABP_ADDON_CC_ID", "11245275"); // Plugin codecanyon Id.

define("BKBDABP_PLUGIN_DIR", plugins_url() . '/kb-display-as-blog-post/');

register_activation_hook(__FILE__, array(BkbDabpAddonFrontend::class, 'activate'));
register_deactivation_hook(__FILE__, array(BkbDabpAddonFrontend::class, 'deactivate'));

add_action('plugins_loaded', array(BkbDabpAddonFrontend::class, 'get_instance'));

if (is_admin()) {
    add_action('plugins_loaded', array(BkbDabpAddonAdmin::class, 'get_instance'));
}