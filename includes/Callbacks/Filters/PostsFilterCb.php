<?php
namespace KBDABP\Callbacks\Filters;

/**
 * Class for registering taxonomy callback.
 *
 * @package KBDABP
 * @since: 1.0.0
 * @author: Mahbub Alam Khan
 */
class PostsFilterCb {

	/**
	 * Set the filter for the posts.
	 *
	 * @param object $query The WP_Query object.
	 * @return object The modified WP_Query object.
	 */
	public function set_filter( $query ) {

		if ( $query->is_main_query() && is_home() && ! is_admin() && ! is_search() ) {

				$args = [
					'post_status'         => 'publish',
					'post_type'           => BKBM_POST_TYPE,
					'ignore_sticky_posts' => 1,
					'posts_per_page'      => -1,
				];

				$args['meta_query'] = [
					[
						'key'     => 'bkb_kbdabp_status',
						'compare' => '=',
						'value'   => '1',
					],
				];

				$loop = new \WP_Query( $args );

				$bkb_kbdabp_excluded_posts = [];

				if ( count( $loop->posts ) > 0 ) {

					foreach ( $loop->posts as $posts ) {

							$bkb_kbdabp_excluded_posts[] = $posts->ID;
					}
				}

				$query->set( 'post_type', [ 'post', BKBM_POST_TYPE ] );
				$query->set( 'post__not_in', apply_filters( 'bkb_rkb_blog_query_filter', $bkb_kbdabp_excluded_posts ) );
				return $query;
		} else {
				return $query;
		}
	}
}
