<?php
namespace KBDABP\Base;

/**
 * Class for plugin support.
 *
 * @since: 1.1.0
 * @package KBDABP
 */
class Support {

	/**
	 * Register the plugin support.
	 */
	public function register() {
		add_post_type_support( BKBM_POST_TYPE, 'thumbnail' );
	}
}
