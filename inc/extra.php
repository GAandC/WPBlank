<?php

// http://code.tutsplus.com/tutorials/50-filters-of-wordpress-the-first-10-filters--cms-21295

// Changing the Default Login Error Messages
add_filter( 'login_errors', 'login_errors_example' );
 
function login_errors_example( $error ) {
    $error = '';
    return $error;
}


// Redirecting Commenters to Another Page
add_filter( 'comment_post_redirect', 'comment_post_redirect_example' );
 
function comment_post_redirect_example( $location ) {
    return '/thanks-for-your-comment/';
}


// Allowing Subdomain Redirections
add_filter( 'allowed_redirect_hosts', 'allowed_redirect_hosts_example' );
 
function allowed_redirect_hosts_example( $content ) {
    $content[] = 'forum.mywebsite.com';
    $content[] = 'welcome.mywebsite.com';
    $content[] = 'help.mywebsite.com';
    return $content;
}
 

 // Adding classes to <body>
add_filter( 'body_class', 'body_class_example' );
 
function body_class_example( $classes ) {
    if( is_single() ) {
        foreach( get_the_category( get_the_ID() ) as $category )
            $classes[] = 'cat-' . $category->category_nicename;
    }
    return $classes;
}


// Changing the Locale
add_filter( 'locale', 'locale_example' );
 
function locale_example( $lang ) {
    if ( 'tr' == $_GET['language'] ) {
        return 'tr_TR';
    } else {
        return $lang;
    }
}


// Filtering Sanitization of Usernames
add_filter( 'sanitize_user', 'strtolower' );


// Filtering the Content of the Post
add_filter( 'the_content', 'the_content_example' );
 
function the_content_example( $content ) {
    return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}


// Filtering the Forms for Password Protected Posts
add_filter( 'the_password_form', 'the_password_form_example' );
 
function the_password_form_example() {
    $output  = '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">';
    $output .= '<span>' . __( "Enter the password:" ) . ' </span>';
    $output .= '<input name="post_password" type="password" size="20" />';
    $output .= '<input type="submit" name="Submit" value="' . esc_attr__( "Go" ) . '" />';
    $output .= '</form>';
    return $output;
}


// Filtering the the_terms() Function
add_filter( 'the_terms', 'strip_tags' );


// Changing the Email Address to Send From
add_filter( 'wp_mail_from', 'wp_mail_from_example' );
 
function wp_mail_from_example( $email ) {
    return 'my.email.address@mywebsite.com';
}



// http://code.tutsplus.com/tutorials/50-filters-of-wordpress-filters-11-20--cms-21296

// Playing With Translatable Data in WordPress
add_filter( 'gettext', 'gettext_example', 20, 3 );
 
function gettext_example( $translated_text, $text, $domain ) {
    switch ( $translated_text ) {
        case 'E-meil Adress' :
            $translated_text = __( 'Email Address', 'plugin_text_domain' );
            break;
    }
    return $translated_text
}


// Cleaning Up the Slug
add_filter( 'sanitize_title', 'sanitize_title_example' );
 
function sanitize_title_example( $title ) {
    $title = str_replace( '-the-', '-', $title );
    $title = preg_replace( '/^the-/', '', $title );
    return $title;
}


// Setting Exceptions for Shortcode Texturization
add_filter( 'no_texturize_shortcodes', 'no_texturize_shortcodes_example' );
 
function no_texturize_shortcodes_example( $shortcodes ) {
    $shortcodes[] = 'myshortcode';
    return $shortcodes;
}


// Filtering a Comment's Approval Status
add_filter( 'pre_comment_approved', 'pre_comment_approved_example', 99, 2 );
 
function pre_comment_approved_example( $approved, $commentdata ) {
    return ( strlen( $commentdata['comment_author'] ) > 75 ) ? 'spam' : $approved;
}


// Configuring the "Post By Email" Feature
add_filter( 'enable_post_by_email_configuration', '__return_false', 100 );



// Filtering Your Page Titles
add_filter( 'wp_title', 'wp_title_example', 10, 2 );
 
function wp_title_example( $title, $sep ) {
    global $paged, $page;
 
    if ( is_feed() )
        return $title;
 
    // Add the site name.
    $title .= get_bloginfo( 'name' );
 
    // Add the site description for the home/front page.
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) )
        $title = "$title $sep $site_description";
 
    // Add a page number if necessary.
    if ( $paged >= 2 || $page >= 2 )
        $title = sprintf( __( 'Page %s', 'tuts_filter_example' ), max( $paged, $page ) ) . " $sep $title";
 
    return $title;
}


// Processing Comments Before They're Saved to the Database
add_filter( 'preprocess_comment', 'preprocess_comment_example' );
 
function preprocess_comment_example( $commentdata ) {
    if( $commentdata['comment_content'] == strtoupper( $commentdata['comment_content'] ))
        $commentdata['comment_content'] = strtolower( $commentdata['comment_content'] );
    return $commentdata;
}


// Managing Redirection After Login
add_filter( 'login_redirect', 'login_redirect_example', 10, 3 );
 
function login_redirect_example( $redirect_to, $request, $user ) {
    global $user;
    if ( isset( $user->roles ) && is_array( $user->roles ) ) {
        if ( in_array( 'subscriber', $user->roles ) ) {
            return home_url();
        } else {
            return $redirect_to;
            }
    }
    return;
}


// Adding a "Settings" Link to Display in the Plugins Page
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'plugin_action_links_example' );
 
function plugin_action_links_example( $links ) {
    $links[] = '<a href="' . get_admin_url( null, 'options-general.php?page=my_plugin_settings' ) . '">' . __( 'Settings' ) . '</a>';
    return $links;
}


// Filtering the Content Inside the Post Editor
add_filter( 'the_editor_content', 'the_editor_content_example' );
 
function the_editor_content_example( $content ) {
    // Only return the filtered content if it's empty
    if ( empty( $content ) ) {
        $template  = 'Hey! Don\'t forget to...' . "\n\n";
        $template .= '<ul><li>Come up with good tags for the post,</li><li>Set the publish time to 08:00 tomorrow morning,</li><li>Change the slug to a SEO-friendly slug,</li><li>And delete this text, hehe.</li></ul>' . "\n\n";
        $template .= 'Bye!';
        return $template;
    } else
        return $content;
}


// http://code.tutsplus.com/tutorials/50-filters-of-wordpress-filters-21-30--cms-21298

// Filtering the Search Query
add_filter( 'posts_search', 'posts_search_example' );
 
function posts_search_example( $search ) {
    global $wpdb;
    if( !is_user_logged_in() ) {
        $pattern = " AND ({$wpdb->prefix}posts.post_password = '')";
        $search = str_replace( $pattern, '', $search );
    }
    return $search;
}


// Setting Compression Quality for Uploaded Images
add_filter( 'wp_editor_set_quality', 'wp_editor_set_quality_example' );
 
function wp_editor_set_quality_example( $quality ) {
    return 100;
}

// Filtering the Text Widget
add_filter( 'widget_text', 'do_shortcode' );


// Filtering the Feed Content
add_filter( 'the_content_feed', 'the_content_feed_example' );
 
function the_content_feed_example( $content ) {
    $featured_image = '';
    $featured_image = get_the_post_thumbnail( get_the_ID(), 'thumbnail', array( 'style' => 'float:left;margin-right:.75em;' ) );
    $content = get_the_excerpt() . ' <a href="'. get_permalink() .'">' . __( 'Read More' ) . '</a>';
    if( '' != $featured_image )
        $content = '<div>' . $featured_image . $content . '<br style="clear:both;" /></div>';
    return $content;
}


// Changing Buttons from the Visual Editor
add_filter( 'mce_buttons', 'mce_buttons_example' );
 
function mce_buttons_example( $buttons ) {
    $remove_array = array( 'strikethrough', 'blockquote', 'hr', 'alignleft', 'aligncenter', 'alignright', 'wp_more', 'wp_adv' );
    // full list (WP version 3.9)
    // 'bold', 'italic', 'strikethrough', 'bullist', 'numlist', 'blockquote', 'hr', 'alignleft', 'aligncenter', 'alignright', 'link', 'unlink', 'wp_more', 'spellchecker', 'fullscreen', 'wp_adv'
    foreach( $remove_array as $remove ) {
        if ( ( $key = array_search( $remove, $buttons ) ) !== false )
            unset( $buttons[ $key ] );
    }
    return $buttons;
}


// Excluding Terms from Lists
add_filter( 'list_terms_exclusions', 'list_terms_exclusions_example', 10, 2 );
 
function list_terms_exclusions_example( $exclusions, $args ) {
    // IDs of terms to be excluded
    $exclude = "42,132";
    $exterms = wp_parse_id_list( $exclude );
    foreach ( $exterms as $exterm ) {
        if ( empty( $exclusions ) )
            $exclusions  = ' AND ( t.term_id <> ' . intval( $exterm ) . ' ';
        else
            $exclusions .= ' AND t.term_id <> ' . intval( $exterm ) . ' ';
    }
    if ( !empty( $exclusions ) )
        $exclusions .= ')';
    return $exclusions;
}
 

// Changing the Image Sizes Dropdown
add_filter( 'image_size_names_choose', 'image_size_names_choose_example' );
 
function image_size_names_choose_example( $sizes ) {
    return array_merge( $sizes, array(
        'golden-ratio-thumb' => __( 'Golden Ratio Thumbnail' )
    ) );
}


// Changing the "More" String on Excerpts
add_filter( 'excerpt_more', 'excerpt_more_example' );
 
function excerpt_more_example( $text ) {
    global $post;
    return '... <a class="read-more-link" href="' . get_permalink( $post->ID ) . '">Read more</a>';
}


// Managing Columns in the Posts List
add_filter( 'manage_posts_columns', 'manage_posts_columns_example' );
 
function manage_posts_columns_example( $columns ) {
    unset( $columns['author'] );
    return $columns;
}

// Editing Users' Contact Methods
add_filter( 'user_contactmethods', 'user_contactmethods_example' );
 
function user_contactmethods_example( $contactmethods ) {
    unset( $contactmethods['yim'] );
    unset( $contactmethods['aim'] );
    unset( $contactmethods['jabber'] );
    $contactmethods['facebook']     = 'Facebook'; 
    $contactmethods['twitter']      = 'Twitter';
    $contactmethods['gplus']        = 'Google+';
    $contactmethods['linkedin']     = 'LinkedIn';
    $contactmethods['instagram']    = 'Instagram';
    return $contactmethods;
}


// http://code.tutsplus.com/tutorials/50-filters-of-wordpress-filters-31-40--cms-21297

// Filtering the Default Gallery Style
add_filter( 'use_default_gallery_style', '__return_false' );

// Filtering the Attachment URLs
add_filter( 'wp_get_attachment_url', 'wp_get_attachment_url_example' );
 
function wp_get_attachment_url_example( $url ) {
    $http  = site_url( false, 'http'  );
    $https = site_url( false, 'https' );
 
    if ( $_SERVER['HTTPS'] == 'on' )
        return str_replace( $http, $https, $url );
    else
        return $url;
}

// Setting the Default Content Type for Email
add_filter( 'wp_mail_content_type', 'wp_mail_content_type_example' );
 
function wp_mail_content_type_example( $content_type ) {
    return 'text/html';
}


// Saving the IP Address of the Commenter
add_filter( 'pre_comment_user_ip', 'pre_comment_user_ip_example' );
 
function pre_comment_user_ip_example() {
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


// Changing the Number of Revisions to Save for Posts
 
add_filter( 'wp_revisions_to_keep', 'wp_revisions_to_keep_example', 10, 2 );
 
function wp_revisions_to_keep_example( $num, $post ) {
    if ( 'event' == $post->post_type ) {
        return 0;
    }
    return $num;
}


// Rewriting the [caption] Shortcode
add_filter( 'img_caption_shortcode', 'img_caption_shortcode_example', 10, 3 );
 
function img_caption_shortcode_example( $empty, $attr, $content ) {
    $attr = shortcode_atts( array(
        'id'      => '',
        'align'   => 'alignnone',
        'width'   => '',
        'caption' => ''
    ), $attr );
 
    if ( 1 > (int) $attr['width'] || empty( $attr['caption'] ) ) {
        return '';
    }
 
    if ( $attr['id'] ) {
        $attr['id'] = 'id="' . esc_attr( $attr['id'] ) . '" ';
    }
     
    $figure_atts    = $attr['id']
                    . ' class="caption ' . esc_attr( $attr['align'] )
                    . '" ' . 'style="max-width: ' . ( 10 + (int) $attr['width'] ) . 'px;"';
     
    $output  = '<figure ' . $figure_atts . '>';
    $output .= do_shortcode( $content );
    $output .= '<figcaption>' . $attr['caption'] . '</figcaption>';
    $output .= '</figure>';
     
    return $output;
 
}


// Adding Post Classes
add_filter( 'post_class', 'post_class_example' );
 
function post_class_example( $classes ) {
    global $wp_query;
    if ( 0 == $wp_query->current_post ) {
        $classes[] = 'first-post';
    }
    return $classes;
}


// Adding Custom Fields for Attachments
add_filter( 'attachment_fields_to_edit', 'attachment_fields_to_edit_example', 10, 2 );
 
function attachment_fields_to_edit_example( $form_fields, $post ) {
    $field_value = get_post_meta( $post->ID, 'license', true );
    $form_fields['license'] = array(
        'value' => $field_value ? $field_value : '',
        'label' => __( 'License' ),
        'helps' => __( 'Specify the license type used for this image' )
    );
    return $form_fields;
}
 
add_action( 'edit_attachment', 'save_new_attachment_field' );
 
function save_new_attachment_field( $attachment_id ) {
    $license = $_REQUEST['attachments'][$attachment_id]['license'];
    if ( isset( $license ) ) {
        update_post_meta( $attachment_id, 'license', $license );
    }
}


// Changing the Automatic Excerpt Length
add_filter( 'excerpt_length', 'excerpt_length_example' );
 
function excerpt_length_example( $words ) {
    return 15;
}


// Playing With Bulk Actions in Admin Screens
add_filter( 'bulk_actions-edit-post', 'bulk_actions_edit_post_example' );
 
function bulk_actions_edit_post_example( $actions ) {
    unset( $actions['trash'] );
    return $actions;
}

// http://code.tutsplus.com/tutorials/50-filters-of-wordpress-filters-41-50--cms-21299

// Filtering the Script Loader Source
function script_loader_src_example( $src ) {
    return remove_query_arg( 'ver', $src );
}
 
add_filter( 'script_loader_src', 'script_loader_src_example' );
// Tiny bonus: You can do it with styles, too!
add_filter( 'style_loader_src', 'script_loader_src_example' );


// Adding HTML to the "Featured Image" metabox
add_filter( 'admin_post_thumbnail_html', 'admin_post_thumbnail_html_example' );
 
function admin_post_thumbnail_html_example( $html ) {
    return $html .= '<p>Hi Mr. Smith! Click above to add an image to be displayed at the top of your post. Remember: <strong>The width of the image should be at least 900px</strong>!</p>';
 
}

// Controlling Comment Flooding Attacks
add_filter( 'comment_flood_filter', 'comment_flood_filter_example', 10, 3 );
 
function comment_flood_filter_example( $flood_control, $time_last, $time_new ) {
    $seconds = 60;
    if ( ( $time_new - $time_last ) < $seconds )
        return true;
    return false;
}

// Changing the Items at the "At a Glance" Section 
add_filter( 'dashboard_glance_items', 'dashboard_glance_items_example' );
 
function dashboard_glance_items_example( $items = array() ) {
    $post_types = array( 'event' );
    foreach( $post_types as $type ) {
        if( ! post_type_exists( $type ) ) continue;
        $num_posts = wp_count_posts( $type );
        if( $num_posts ) {
            $published = intval( $num_posts->publish );
            $post_type = get_post_type_object( $type );
            $text = _n( '%s ' . $post_type->labels->singular_name, '%s ' . $post_type->labels->name, $published, 'your_textdomain' );
            $text = sprintf( $text, number_format_i18n( $published ) );
            if ( current_user_can( $post_type->cap->edit_posts ) ) {
            $output = '<a href="edit.php?post_type=' . $post_type->name . '">' . $text . '</a>';
                echo '<li class="post-count ' . $post_type->name . '-count">' . $output . '</li>';
            } else {
            $output = '<span>' . $text . '</span>';
                echo '<li class="post-count ' . $post_type->name . '-count">' . $output . '</li>';
            }
        }
    }
    return $items;
}


// Changing the Default Login Form Messages
add_filter( 'login_message', 'login_message_example' );
 
function login_message_example( $message ) {
    $action = $_REQUEST['action'];
    if( $action == 'lostpassword' ) {
        $message = '<p class="message">Enter your email address, then check your inbox for the "reset password" link!</p>';
        return $message;
    }
    return;
}

// Changing Bulk Update Messages
add_filter( 'bulk_post_updated_messages', 'bulk_post_updated_messages_example', 10, 2 );
 
function bulk_post_updated_messages_example( $bulk_messages, $bulk_counts ) {
    $bulk_messages['event'] = array(
        'updated'   => _n( '%s event updated.', '%s events updated.', $bulk_counts['updated'] ),
        'locked'    => _n( '%s event not updated, somebody is editing it.', '%s events not updated, somebody is editing them.', $bulk_counts['locked'] ),
        'deleted'   => _n( '%s event permanently deleted.', '%s events permanently deleted.', $bulk_counts['deleted'] ),
        'trashed'   => _n( '%s event moved to the Trash.', '%s events moved to the Trash.', $bulk_counts['trashed'] ),
        'untrashed' => _n( '%s event restored from the Trash.', '%s events restored from the Trash.', $bulk_counts['untrashed'] ),
    );
 
    return $bulk_messages;
}

// Filtering the Default Categories Widget
add_filter( 'widget_categories_args', 'widget_categories_args_example' );
 
function widget_categories_args_example( $cat_args ) {
    $exclude_arr = array( 4, 10 );
 
    if( isset( $cat_args['exclude'] ) && !empty( $cat_args['exclude'] ) )
        $exclude_arr = array_unique( array_merge( explode( ',', $cat_args['exclude'] ), $exclude_arr ) );
    $cat_args['exclude'] = implode( ',', $exclude_arr );
    return $cat_args;
}


// Redirecting the User Upon Successful Registration
add_filter( 'registration_redirect', 'registration_redirect_example' );
 
function registration_redirect_example() {
    return home_url( '/your-free-ebook/' ); 
}

// Altering Fields of the Comment Form
add_filter( 'comment_form_default_fields', 'comment_form_default_fields_example' );
 
function comment_form_default_fields_example( $fields ) {
    unset( $fields['url'] );
    return $fields;
}

// Altering the List of Acceptable File Types
add_filter( 'upload_mimes', 'upload_mimes_example' );
 
function upload_mimes_example( $existing_mimes = array() ) {
    unset( $existing_mimes['gif'] );
    return $existing_mimes;
}


