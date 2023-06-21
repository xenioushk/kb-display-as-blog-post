<?php

/**
 * @package BkbDabpAddon
 */

namespace BkbDabpAddon\Admin;

use BkbDabpAddon\Frontend\BkbDabpAddonFrontend;

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

        require_once(BKBDABP_DIR . 'admin/metabox/KbdabpMetaBox.php');
    }

    public static function get_instance()
    {

        /*
         * @TODO :
         *
         * - Uncomment following lines if the admin class should only be available for super admins
         */
        /* if( ! is_super_admin() ) {
          return;
          } */

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
