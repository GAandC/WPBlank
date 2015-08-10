<?php


    // Remove "Edit with Visual Composer" from WordPress Admin Bar
    function vc_remove_wp_admin_bar_button() {
        remove_action( 'admin_bar_menu', array( vc_frontend_editor(), 'adminBarEditLink' ), 1000 );
    }
    add_action( 'vc_after_init', 'vc_remove_wp_admin_bar_button' );



    // To completely remove "Edit with Visual Composer" link
    function vc_remove_frontend_links() {
        vc_disable_frontend(); // this will disable frontend editor
    }
    add_action( 'vc_after_init', 'vc_remove_frontend_links' );