<?php
namespace KBDABP\Base;

/**
 * Class for plucin deactivation.
 *
 * @since: 1.1.0
 * @package KBDABP
 */
class Deactivate {

	/**
	 * Deactivate the plugin.
	 */
	public static function deactivate() { // phpcs:ignore
		flush_rewrite_rules();
	}
}
