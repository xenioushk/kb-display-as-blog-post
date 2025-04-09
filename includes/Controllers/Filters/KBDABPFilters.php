<?php
namespace KBDABP\Controllers\Filters;

use Xenioushk\BwlPluginApi\Api\Filters\FiltersApi;

use KBDABP\Callbacks\Filters\FeedCb;
use KBDABP\Callbacks\Filters\PostsFilterCb;

/**
 * Class for registering the frontend filters.
 *
 * @since: 1.1.0
 * @package KBDABP
 */
class KBDABPFilters {

    /**
	 * Register filters.
	 */
    public function register() {

        // Initialize API.
        $filters_api = new FiltersApi();

        // Initialize callbacks.
        $posts_filter_cb = new PostsFilterCb();
        $feed_cb         = new FeedCb();

        // All filters.
        $filters = [
            [
                'tag'      => 'pre_get_posts',
                'callback' => [ $posts_filter_cb, 'set_filter' ],
            ],
        ];

        if ( KBDABP_FEED_STATUS ) {
            $filters[] = [
                'tag'      => 'request',
                'callback' => [ $feed_cb, 'attach' ],
            ];
        }

        $filters_api->add_filters( $filters )->register();
    }
}
