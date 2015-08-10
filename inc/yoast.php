<?php


function disable_wp_emojicons() {
    // all actions related to emojis
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

    // filter to remove TinyMCE emojis
    add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
}

function disable_emojicons_tinymce( $plugins ) {
  if ( is_array( $plugins ) ) {
    return array_diff( $plugins, array( 'wpemoji' ) );
  } else {
    return array();
  }
}

add_action( 'init', 'disable_wp_emojicons' );



function wpc_disable_yoast_notifications() {
  if (is_plugin_active('wordpress-seo/wp-seo.php')) {
    remove_action('admin_notices', array(Yoast_Notification_Center::get(), 'display_notifications'));
    remove_action('all_admin_notices', array(Yoast_Notification_Center::get(), 'display_notifications'));
  }
}
add_action('admin_init', 'wpc_disable_yoast_notifications');