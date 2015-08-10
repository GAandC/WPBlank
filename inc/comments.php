<?php

// Disable support for comments and trackbacks in post types
function gaandc_disable_comments_post_types_support() {
    $post_types = get_post_types();
    foreach ($post_types as $post_type) {
        if(post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
}
add_action('admin_init', 'gaandc_disable_comments_post_types_support');



// Close comments on the front-end
function gaandc_disable_comments_status() {
    return false;
}
add_filter('comments_open', 'gaandc_disable_comments_status', 20, 2);
add_filter('pings_open', 'gaandc_disable_comments_status', 20, 2);



// Hide existing comments
function gaandc_disable_comments_hide_existing_comments($comments) {
    $comments = array();
    return $comments;
}
add_filter('comments_array', 'gaandc_disable_comments_hide_existing_comments', 10, 2);



// Remove comments page in menu
function gaandc_disable_comments_admin_menu() {
    remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'gaandc_disable_comments_admin_menu');



// Redirect any user trying to access comments page
function gaandc_disable_comments_admin_menu_redirect() {
    global $pagenow;
    if ($pagenow === 'edit-comments.php') {
        wp_redirect(admin_url()); exit;
    }
}
add_action('admin_init', 'gaandc_disable_comments_admin_menu_redirect');



// Remove comments metabox from dashboard
function gaandc_disable_comments_dashboard() {
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
}
add_action('admin_init', 'gaandc_disable_comments_dashboard');



// Remove comments links from admin bar
function gaandc_disable_comments_admin_bar() {
    if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
}
add_action('init', 'gaandc_disable_comments_admin_bar');




 // Saving the Real IP Address of the Commenter
function gaandc_pre_comment_user_ip_example() {
    $REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];
    if ( !empty( $_SERVER['X_FORWARDED_FOR'] ) ) {
        $X_FORWARDED_FOR = explode( ',', $_SERVER['X_FORWARDED_FOR'] );
        if ( !empty( $X_FORWARDED_FOR ) )
            $REMOTE_ADDR = trim( $X_FORWARDED_FOR[0] );
    } elseif( !empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
        $HTTP_X_FORWARDED_FOR = explode( ',', $_SERVER['HTTP_X_FORWARDED_FOR'] );
        if ( !empty( $HTTP_X_FORWARDED_FOR ) )
            $REMOTE_ADDR = trim( $HTTP_X_FORWARDED_FOR[0] );
    }
    return preg_replace( '/[^0-9a-f:\., ]/si', '', $REMOTE_ADDR );
}
add_filter( 'pre_comment_user_ip', 'gaandc_pre_comment_user_ip_example' );