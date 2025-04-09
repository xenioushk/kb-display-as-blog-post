<?php
namespace KBDABP\Cmb;

use BwlKbManager\Api\CmbMetaBoxApi;

/**
 * Class for creating custom meta box in KB add/edit page.
 *
 * @since: 1.1.0
 * @package KBDABP
 */
class KbdabpMetaBox {

    /**
     * Register the plugin text domain.
     */
    public function register() {
        add_action( 'admin_init', [ $this, 'cmb_init' ] );
    }

    /**
     * Create a custom meta box.
     *
     * @return void
     */
    public function cmb_init() {

        $custom_fields = [
            'meta_box_id'      => 'cmb_bkb_kbdabp',
            'meta_box_heading' => esc_html__( 'KB Blog Post Display Settings', 'bkb-kbdabp' ),
            'post_type'        => BKBM_POST_TYPE,
            'context'          => 'normal',
            'priority'         => 'high',
            'fields'           => [
                'bkb_kbdabp_status' => [
                    'title'         => esc_html__( 'Hide From Blog List?', 'bkb-kbdabp' ),
                    'id'            => 'bkb_kbdabp_status',
                    'name'          => 'bkb_kbdabp_status',
                    'type'          => 'select',
                    'value'         => [
                        '0' => esc_html__( 'No', 'bkb-kbdabp' ),
                        '1' => esc_html__( 'Yes', 'bkb-kbdabp' ),
                    ],
                    'default_value' => 0,
                    'class'         => 'widefat',
                ],

            ],
        ];

        // A new meta box will be created in KB add/edit page.
        if ( class_exists( 'BwlKbManager\\Init' ) ) {
            new CmbMetaBoxApi( $custom_fields );
        }
    }
}
