<?php

/**
 * Plugin class. This class should ideally be used to work with the
 * administrative side of the WordPress site.
 *
 * If you're interested in introducing public-facing
 * functionality, then refer to `class-plugin-name.php`
 *
 * @TODO: Rename this class to a proper name for your plugin.

 */
class BKB_kbdabp_Admin {

    /**
     * Instance of this class.
     *
     * @since    1.0.0
     *
     * @var      object
     */
    protected static $instance = null;

    /**
     * Slug of the plugin screen.
     *
     * @since    1.0.0
     *
     * @var      string
     */
    protected $plugin_screen_hook_suffix = null;

    /**
     * Initialize the plugin by loading admin scripts & styles and adding a
     * settings page and menu.
     *
     * @since     1.0.0
     */
    private function __construct() {

        
        //@Description: First we need to check if KB Plugin is activated or not. If not then we display a message and return false.
        //@Since: Version 1.0.5
        
        if( ! class_exists( 'BWL_KB_Manager' ) || BKBDABP_PARENT_PLUGIN_REQUIRED_VERSION < '1.0.5' ) {
            add_action('admin_notices', array($this, 'kbdabp_version_update_admin_notice'));
            return false;
        }
        
        $plugin = BKB_kbdabp::get_instance();
        $this->plugin_slug = $plugin->get_plugin_slug();
        
        require_once( BKBDABP_DIR . 'admin/includes/class-kbdabp-addon-meta-box.php' );
        
    }

    /**
     * Return an instance of this class.
     *
     * @since     1.0.0
     *
     * @return    object    A single instance of this class.
     */
    public static function get_instance() {

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
    
    public function kbdabp_version_update_admin_notice(){
        
        echo '<div class="updated"><p>You need to download & install '
            . '<b><a href="https://1.envato.market/bkbm-wp" target="_blank">'.BKBDABP_ADDON_PARENT_PLUGIN_TITLE.'</a></b> '
                . 'to use <b>'.BKBDABP_ADDON_TITLE.'</b>. </p></div>';
        
    }

}