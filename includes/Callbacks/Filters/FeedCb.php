<?php
namespace KBDABP\Callbacks\Filters;

/**
 * Class for registering feed filter callback.
 *
 * @package KBDABP
 * @since: 1.0.0
 * @author: Mahbub Alam Khan
 */
class FeedCb {

	/**
	 * Attach the filter to the query variables.
	 *
	 * @param array $qv The query variables.
	 * @return array The modified query variables.
	 */
	public function attach( $qv ) {
		if ( isset( $qv['feed'] ) && ! isset( $qv['post_type'] ) ) {
				$qv['post_type'] = [ 'bwl_kb' ];
		}
		return $qv;
	}
}
