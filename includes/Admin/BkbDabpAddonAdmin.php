<?php

/**
 * @package BkbDabpAddon
 */

namespace BkbDabpAddon\Admin;

use BkbDabpAddon\Admin\Metabox\KbdabpMetaBox;
use BkbDabpAddon\Frontend\BkbDabpAddonFrontend;
// use BkbDabpAddon\Admin\Metabox;

class BkbDabpAddonAdmin
{
    protected static $instance = null;

    public $plugin_slug;
    protected $plugin_screen_hook_suffix = null;

    private function __construct()
    {
        if (!class_exists('BwlKbManager\\Init') || BKBDABP_PARENT_PLUGIN_REQUIRED_VERSION < '1.0.5') {
            add_action('admin_notices', array($this, 'kbdabp_version_update_admin_notice'));
            return false;
        }

        $plugin = BkbDabpAddonFrontend::get_instance();
        $this->plugin_slug = $plugin->get_plugin_slug();


        // META BOX START EXECUTION FROM HERE.

        add_action('admin_init', [new KbdabpMetaBox(), 'bkb_kbdabp_custom_meta_init']);
    }

    public static function get_instance()
    {

        // If the single instance hasn't been set, set it now.
        if (null == self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    //Version Manager Update Checking

    public function kbdabp_version_update_admin_notice()
    {
        echo '<div class="updated"><p>You need to download & install '
            . '<b><a href="https://1.envato.market/bkbm-wp" target="_blank">' . BKBDABP_ADDON_PARENT_PLUGIN_TITLE . '</a></b> '
            . 'to use <b>' . BKBDABP_ADDON_TITLE . '</b>. </p></div>';
    }
}
