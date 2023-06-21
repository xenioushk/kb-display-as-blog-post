<?php

/**
 * Plugin Name:    KB Display As Blog Post - BWL Knowledge Base Manager Addon
 * Plugin URI:        http://bit.ly/kb-as-blog
 * Description:      This is an Addon for BWL Knowledge Base Manager. It allows you to display your Knowledge Base contents as blog post. This Addon automatically include KB posts in you're blog listings according to date order. Addon comes with Quick and Bulk edit options, so you can easily choose which KB you want to show in blog lists. Addon also allows you to integrate 'featured image' with every KB.
 * Version:           1.0.6
 * Author:             Md Mahbub Alam Khan
 * Author URI:      https://1.envato.market/xenioushk
 */
// If this file is called directly, abort.
if (!defined('WPINC')) {

    die;
}

/* ----------------------------------------------------------------------------*
 * Public-Facing Functionality
 * ---------------------------------------------------------------------------- */

//Version Define For Parent Plugin And Addon.
// @Since: 1.0.2

define('BKBDABP_PARENT_PLUGIN_INSTALLED_VERSION', get_option('bwl_kb_plugin_version'));
define('BKBDABP_ADDON_PARENT_PLUGIN_TITLE', 'BWL Knowledge Base Manager Plugin');
define('BKBDABP_ADDON_TITLE', 'KB Display As Blog Post Addon');
define('BKBDABP_PARENT_PLUGIN_REQUIRED_VERSION', '1.0.9'); // change plugin required version in here.
define('BKBDABP_ADDON_CURRENT_VERSION', '1.0.6'); // change plugin current version in here.

define('BKBDABP_ADDON_PREFIX', 'bkb-kbdabp'); // Addon Data Prefix. It must be simmilar with $plugin slug (kb-display-as-blog-post\public\class-kbdabp-addon.php).

define('BKBDABP_DIR', plugin_dir_path(__FILE__));

require_once(plugin_dir_path(__FILE__) . 'public/class-kbdabp-addon.php');

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 */
register_activation_hook(__FILE__, array('BKB_kbdabp', 'activate'));
register_deactivation_hook(__FILE__, array('BKB_kbdabp', 'deactivate'));

add_action('plugins_loaded', array('BKB_kbdabp', 'get_instance'));

/* ----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 * ---------------------------------------------------------------------------- */

if (is_admin()) {

    require_once(plugin_dir_path(__FILE__) . 'admin/class-kbdabp-addon-admin.php');
    add_action('plugins_loaded', array('BKB_kbdabp_Admin', 'get_instance'));
}
