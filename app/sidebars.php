<?php

function gaandc_sidebar_init() {
    register_sidebar( array(
        'name'          => esc_html__( 'Sidebar', 'wordpress' ),
        'id'            => 'sidebar-1',
        'description'   => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'gaandc_sidebar_init' );