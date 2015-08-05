<?php


// LESS - generate css
if(true)
{
    include __DIR__.'/../vendor/lessc.inc.php';
    $less = new lessc;
    $less->setFormatter("compressed");
    $less_file = __DIR__."/../less/site.less";
    $css_file =  __DIR__."/../css/style.css";
    $less->compileFile($less_file,$css_file);
    
}

// Load HTML5 Blank scripts (header.php)
function html5blank_header_scripts()
{
    if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {

        wp_dequeue_script('jquery');
        wp_register_script('custom_jquery', get_template_directory_uri() . '/js/libs/jquery-1.11.3.min.js', array(), '1.11.3'); 
        wp_enqueue_script('custom_jquery');
       
        wp_register_script('modernizr', get_template_directory_uri() . '/js/libs/modernizr-2.7.1.min.js', array(), '2.7.1'); // Modernizr
        wp_enqueue_script('modernizr'); // Enqueue it!

        // wp_register_script('custom_script', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0.0');
        // wp_enqueue_script('custom_script');


    }
}


// Load HTML5 Blank styles
function html5blank_styles()
{

    wp_register_style('style', get_template_directory_uri() . '/css/style.css', array(), '1.0', 'all');
    wp_enqueue_style('style'); // Enqueue it!

}

add_action('init', 'html5blank_header_scripts'); // Add Custom Scripts to wp_head
add_action('wp_enqueue_scripts', 'html5blank_styles'); // Add Theme Stylesheet

