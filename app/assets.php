<?php

function generate_less_css()
{
    include_once __DIR__.'/../vendor/lessc.inc.php';
    $less = new lessc;
    $less->setFormatter("compressed");
    $less_file = __DIR__."/../less/site.less";
    $css_file =  __DIR__."/../css/style.css";
    return $less->compileFile($less_file,$css_file);
}

// LESS - generate css
if(WP_DEBUG)
{
    generate_less_css();
}


// Assets in header
function gaandc_header_scripts()
{
    if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {

        wp_dequeue_script('jquery');
        wp_register_script('custom_jquery', get_template_directory_uri() . '/js/libs/jquery-1.11.3.min.js', array(), '1.11.3');
        wp_enqueue_script('custom_jquery');

        wp_register_script('modernizr', get_template_directory_uri() . '/js/libs/modernizr-2.7.1.min.js', array(), '2.7.1');
        wp_enqueue_script('modernizr');
    }
}


// Assets in footer
function gaandc_footer_scripts()
{
    wp_register_style('style', get_template_directory_uri() . '/css/style.css', array(), '1.0', 'all');
    wp_enqueue_style('style');
}

add_action('init', 'gaandc_header_scripts');
add_action('wp_enqueue_scripts', 'gaandc_footer_scripts');
