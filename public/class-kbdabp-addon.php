<?php

class BKB_kbdabp {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	const VERSION = '1.0.3';

	/**
	 * @TODO - Rename "plugin-name" to the name your your plugin
	 *
	 * Unique identifier for your plugin.
	 *
	 *
	 * The variable name is used as the text domain when internationalizing strings
	 * of text. Its value should match the Text Domain file header in the main
	 * plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'bkb-kbdabp';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {
            
                    if( class_exists( 'BWL_KB_Manager' ) && BKBDABP_PARENT_PLUGIN_REQUIRED_VERSION > '1.0.5' ) {
                        
                        add_filter( 'pre_get_posts', array( $this, 'bkb_kbdabp_filter_posts' ),10 ); 
                        
                        $bkb_data = get_option('bkb_options');
                        
                        if (isset($bkb_data['bkb_kb_blog_feed_status']) && $bkb_data['bkb_kb_blog_feed_status'] == 1) {
                            
                            add_filter('request', array( $this, 'bkb_kbdabp_include_feed' ));
                            
                        }
                        
                    }

	}

	/**
	 * Return the plugin slug.
	 *
	 * @since    1.0.0
	 *
	 *@return    Plugin slug variable.
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Activate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       activated on an individual blog.
	 */
	public static function activate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide  ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_activate();
				}

				restore_current_blog();

			} else {
				self::single_activate();
			}

		} else {
			self::single_activate();
		}

	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Deactivate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_deactivate();

				}

				restore_current_blog();

			} else {
				self::single_deactivate();
			}

		} else {
			self::single_deactivate();
		}

	}

	/**
	 * Fired when a new site is activated with a WPMU environment.
	 *
	 * @since    1.0.0
	 *
	 * @param    int    $blog_id    ID of the new blog.
	 */
	public function activate_new_site( $blog_id ) {

		if ( 1 !== did_action( 'wpmu_new_blog' ) ) {
			return;
		}

		switch_to_blog( $blog_id );
		self::single_activate();
		restore_current_blog();

	}

	/**
	 * Get all blog ids of blogs in the current network that are:
	 * - not archived
	 * - not spam
	 * - not deleted
	 *
	 * @since    1.0.0
	 *
	 * @return   array|false    The blog ids, false if no matches.
	 */
	private static function get_blog_ids() {

		global $wpdb;

		// get an array of blog ids
		$sql = "SELECT blog_id FROM $wpdb->blogs
			WHERE archived = '0' AND spam = '0'
			AND deleted = '0'";

		return $wpdb->get_col( $sql );

	}

	/**
	 * Fired for each blog when the plugin is activated.
	 *
	 * @since    1.0.0
	 */
	private static function single_activate() {
		// @TODO: Define activation functionality here
	}

	/**
	 * Fired for each blog when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 */
	private static function single_deactivate() {
		// @TODO: Define deactivation functionality here
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );

	}
        
                public function bkb_kbdabp_include_feed( $qv ) {
                    if  (isset( $qv['feed'] ) && !isset( $qv['post_type'] ) )
                        $qv['post_type'] = array('bwl_kb');
                    return $qv;
                }
            
              public function bkb_kbdabp_filter_posts($query) {

                if ( is_home() && !is_admin() && !is_search() && $query->is_main_query() ) {
                    
                    $args = array(
                            'post_status'       => 'publish',
                            'post_type'         => 'bwl_kb',
                            'ignore_sticky_posts' => 1,
                            'posts_per_page' => -1
                        );
                    
                    $args ['meta_query'] =  array(
                        array(
                         'key' => 'bkb_kbdabp_status',
                         'compare' => '=',
                         'value' => '1' 
                        )
                     );
                    
                    $loop = new WP_Query($args);
                    
                    $bkb_kbdabp_excluded_posts = array();

                    if (count($loop->posts) > 0) {
                        
                        foreach ($loop->posts as $posts) {
                      
                                $bkb_kbdabp_excluded_posts[] = $posts->ID;
                            
                        }
                        
                    }
                    
                wp_reset_query();

                $query->set('post_type', array('post', 'bwl_kb')); 
                $query->set( 'post__not_in', apply_filters( 'bkb_rkb_blog_query_filter',$bkb_kbdabp_excluded_posts ) );  
                return $query;
                
                } else {
                    return $query;
                }
            }

}