<?php
namespace KBDABP\Controllers\Filters\Admin;

/**
 * Custom Product Columns
 *
 * @package KBDABP
 */
class CustomColumns {

    /**
     * Register the column filters.
     */
	public function register() {
		if ( is_admin() ) {
			add_filter( 'manage_bwl_kb_posts_columns', [ $this,'columns_header' ] );
			add_action( 'manage_bwl_kb_posts_custom_column', [ $this,'columns_content' ], 10, 1 );
		}
	}

    /**
     * Add custom columns to the bwl_kb post type.
     *
     * @param array $columns The columns.
     *
     * @return array
     */
	public function columns_header( $columns ) {
		$columns['bkb_kbdabp_status'] = esc_html__( 'Hide From Blog?', 'bkb_rkb' );

		return $columns;
	}

    /**
     * Add content to the custom columns.
     *
     * @param string $column The column.
     */
	public function columns_content( $column ) {
		global $post;

		switch ( $column ) {

			case 'bkb_kbdabp_status':
				$status = (int) get_post_meta( $post->ID, 'bkb_kbdabp_status', true );

				$status_title = sprintf(
                    "<span class='dashicons %s' title='%s'></span>",
                    $status === 1 ? 'dashicons-yes' : 'dashicons-no',
                    $status === 1 ? esc_attr__( 'Yes', 'bkb-kbdabp' ) : esc_attr__( 'No', 'bkb-kbdabp' )
				);

				printf(
                    '<div id="bkb_kbdabp_status-%d" data-status_code="%d">%s</div>',
                    $post->ID,
                    $status,
                    $status_title
				);

				break;
		}
	}
}
