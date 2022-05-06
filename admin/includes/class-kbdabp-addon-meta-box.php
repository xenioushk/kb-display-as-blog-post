<?php

// Register Custom Meta Box For BWL Pro Related Post Manager

function bkb_kbdabp_custom_meta_init() {
    
    $custom_fields= array(
        
        'meta_box_id'           => 'cmb_bkb_kbdabp', // Unique id of meta box.
        'meta_box_heading'  => __( 'BKB Blog Post Display Settings', 'bwl-kb'), // That text will be show in meta box head section.
        'post_type'               => 'bwl_kb', // define post type. go to register_post_type method to view post_type name.        
        'context'                   => 'normal',
        'priority'                    => 'high',
        'fields'                       => array(
                                                    'bkb_kbdabp_status'  => array(
                                                                                'title'      => __( 'Hide From Blog List?', 'bwl-kb'),
                                                                                'id'         => 'bkb_kbdabp_status',
                                                                                'name'    => 'bkb_kbdabp_status',
                                                                                'type'      => 'select',
                                                                                'value'     => array(
                                                                                                        '0' => __('No', 'bwl-kb'),
                                                                                                        '1' => __('Yes', 'bwl-kb')
                                                                                                    ),
                                                                                'default_value' => 0,
                                                                                'class'      => 'widefat'
                                                                            )
            
                                                )
    );
    
    // A new meta box will be created in KB add/edit page.
    if( class_exists('BKB_Meta_Box') ) {
        new BKB_Meta_Box( $custom_fields );
    }
    
}


// META BOX START EXECUTION FROM HERE.

add_action('admin_init', 'bkb_kbdabp_custom_meta_init');