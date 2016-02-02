<?php


function gaandc_wordpress_setup() {

    // Translation
    // load_theme_textdomain( 'wordpress', get_template_directory() . '/languages' );

    // Add Menu Support
    add_theme_support('menus');


    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support( 'title-tag' );

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
     */
    add_theme_support( 'post-thumbnails' );


    // Thumbnails
    add_image_size('large', 700, '', true); // Large Thumbnail
    add_image_size('medium', 250, '', true); // Medium Thumbnail
    add_image_size('small', 120, '', true); // Small Thumbnail

}
add_action( 'after_setup_theme', 'gaandc_wordpress_setup' );

// Secutiry brut force
function mmx_remove_xmlrpc_methods( $methods )
{
    unset( $methods['system.multicall'] );
    return $methods;
}
add_filter( 'xmlrpc_methods', 'mmx_remove_xmlrpc_methods');



// Remove invalid rel attribute values in the categorylist
function gaandc_remove_category_rel_from_category_list($thelist)
{
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}
add_filter('the_category', 'gaandc_remove_category_rel_from_category_list');




// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function gaandc_add_slug_to_body_class($classes)
{
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}
add_filter('body_class', 'gaandc_add_slug_to_body_class');





// Remove wp_head() injected Recent Comment styles
function gaandc_remove_recent_comments_style()
{
    global $wp_widget_factory;
    remove_action('wp_head', array(
        $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
        'recent_comments_style'
    ));
}
add_action('widgets_init', 'gaandc_remove_recent_comments_style');




// Excerpt length
function gaandc_excerpt_length($length)
{
    return 40;
}
add_filter('excerpt_length', 'gaandc_excerpt_length');


// Excerpt link more
function gaandc_excerpt_more($more)
{
    global $post;
    return '... <a class="view-article" href="' . get_permalink($post->ID) . '">' . __('View Article', 'Wordpress') . '</a>';
}
add_filter('excerpt_more', 'gaandc_excerpt_more');




// Remove Admin bar
function gaandc_remove_admin_bar()
{
    return false;
}
add_filter('show_admin_bar', 'gaandc_remove_admin_bar');



// Remove 'text/css' from our enqueued stylesheet
function gaandc_style_remove($tag)
{
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}
add_filter('style_loader_tag', 'gaandc_style_remove');



// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function gaandc_remove_thumbnail_dimensions( $html )
{
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10);
// add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10);



// Remove version
function script_loader_src_example( $src ) {
    return remove_query_arg( 'ver', $src );
}

add_filter( 'script_loader_src', 'script_loader_src_example' );
add_filter( 'style_loader_src', 'script_loader_src_example' );



// Flush out the transients used in wordpress_categorized_blog.
function wordpress_category_transient_flusher() {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    // Like, beat it. Dig?
    delete_transient( 'wordpress_categories' );
}
add_action( 'edit_category', 'wordpress_category_transient_flusher' );
add_action( 'save_post',     'wordpress_category_transient_flusher' );



// Remove Actions
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);


// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether
remove_filter('the_content', 'wpautop');

/**
 * Advanced Custom Fields Options function
 * Always fetch an Options field value from the default language
 */
function cl_acf_set_language() {
  return acf_get_setting('default_language');
}
function get_global_option($name) {
	add_filter('acf/settings/current_language', 'cl_acf_set_language', 100);
	$option = get_field($name, 'option');
	remove_filter('acf/settings/current_language', 'cl_acf_set_language', 100);
	return $option;
}

/**
 * Debug
 */
function debug($var)
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}
