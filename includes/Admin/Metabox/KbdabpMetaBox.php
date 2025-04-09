<?php

/**
 * @package BkbDabpAddon
 */

namespace BkbDabpAddon\Admin\Metabox;

use BwlKbManager\Api\CmbMetaBoxApi;
use BwlKbManager\Base\BaseController;

class KbdabpMetaBox {

    public function bkb_kbdabp_custom_meta_init() {

        $baseController = new BaseController();

        $custom_fields = [

            'meta_box_id'      => 'cmb_bkb_kbdabp', // Unique id of meta box.
            'meta_box_heading' => __( 'KB Blog Post Display Settings', 'bkb-kbdabp' ), // That text will be show in meta box head section.
            'post_type'        => $baseController->plugin_post_type, // define post type. go to register_post_type method to view post_type name.
            'context'          => 'normal',
            'priority'         => 'high',
            'fields'           => [
                'bkb_kbdabp_status' => [
                    'title'         => __( 'Hide From Blog List?', 'bkb-kbdabp' ),
                    'id'            => 'bkb_kbdabp_status',
                    'name'          => 'bkb_kbdabp_status',
                    'type'          => 'select',
                    'value'         => [
                        '0' => __( 'No', 'bkb-kbdabp' ),
                        '1' => __( 'Yes', 'bkb-kbdabp' ),
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
