<?php

/**
 * @package BkbDabpAddon
 */

namespace BkbDabpAddon\Frontend;

use \BwlKbManager\Base\BaseController;

class BkbDabpAddonFrontend
{

	const VERSION = BKBDABP_ADDON_CURRENT_VERSION;
	protected $plugin_slug = 'bkb-kbdabp';
	protected static $instance = null;
	public $baseController;

	public function __construct()
	{

		if (class_exists('BwlKbManager\\Init') && BKBDABP_PARENT_PLUGIN_REQUIRED_VERSION > '1.0.5') {

			add_filter('pre_get_posts', [$this, 'bkb_kbdabp_filter_posts'], 10);

			$this->baseController = new BaseController();

			$bkb_data = $this->baseController->bkb_data;

			$this->activateFeaturedImageSupport();

			if (isset($bkb_data['bkb_kb_blog_feed_status']) && $bkb_data['bkb_kb_blog_feed_status'] == 1) {

				add_filter('request', array($this, 'bkb_kbdabp_include_feed'));
			}
		}
	}

	public function get_plugin_slug()
	{
		return $this->plugin_slug;
	}

	public static function get_instance()
	{

		// If the single instance hasn't been set, set it now.
		if (null == self::$instance) {
			self::$instance = new self;
		}

		return self::$instance;
	}


	public static function activate($network_wide)
	{

		if (function_exists('is_multisite') && is_multisite()) {

			if ($network_wide) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ($blog_ids as $blog_id) {

					switch_to_blog($blog_id);
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


	public static function deactivate($network_wide)
	{

		if (function_exists('is_multisite') && is_multisite()) {

			if ($network_wide) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ($blog_ids as $blog_id) {

					switch_to_blog($blog_id);
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


	public function activate_new_site($blog_id)
	{

		if (1 !== did_action('wpmu_new_blog')) {
			return;
		}

		switch_to_blog($blog_id);
		self::single_activate();
		restore_current_blog();
	}

	private static function get_blog_ids()
	{

		global $wpdb;

		// get an array of blog ids
		$sql = "SELECT blog_id FROM $wpdb->blogs
			WHERE archived = '0' AND spam = '0'
			AND deleted = '0'";

		return $wpdb->get_col($sql);
	}

	private static function single_activate()
	{
		// @TODO: Define activation functionality here
	}

	private static function single_deactivate()
	{
		// @TODO: Define deactivation functionality here
	}

	public function load_plugin_textdomain()
	{

		$domain = $this->plugin_slug;
		$locale = apply_filters('plugin_locale', get_locale(), $domain);

		load_textdomain($domain, trailingslashit(WP_LANG_DIR) . $domain . '/' . $domain . '-' . $locale . '.mo');
	}

	public function activateFeaturedImageSupport()
	{
		add_post_type_support($this->baseController->plugin_post_type, 'thumbnail');
	}

	public function bkb_kbdabp_include_feed($qv)
	{
		if (isset($qv['feed']) && !isset($qv['post_type']))
			$qv['post_type'] = array('bwl_kb');
		return $qv;
	}

	public function bkb_kbdabp_filter_posts($query)
	{

		if (is_home() && !is_admin() && !is_search() && $query->is_main_query()) {

			$args = array(
				'post_status'       => 'publish',
				'post_type'         => $this->baseController->plugin_post_type,
				'ignore_sticky_posts' => 1,
				'posts_per_page' => -1
			);

			$args['meta_query'] =  array(
				array(
					'key' => 'bkb_kbdabp_status',
					'compare' => '=',
					'value' => '1'
				)
			);

			$loop = new \WP_Query($args);

			$bkb_kbdabp_excluded_posts = array();

			if (count($loop->posts) > 0) {

				foreach ($loop->posts as $posts) {

					$bkb_kbdabp_excluded_posts[] = $posts->ID;
				}
			}

			wp_reset_query();

			$query->set('post_type', ['post', $this->baseController->plugin_post_type]);
			$query->set('post__not_in', apply_filters('bkb_rkb_blog_query_filter', $bkb_kbdabp_excluded_posts));
			return $query;
		} else {
			return $query;
		}
	}
}
