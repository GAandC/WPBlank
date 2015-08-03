<?php


function register_html5_menu()
{
    register_nav_menus(array(
        'main_menu' => 'Menu principal'
    ));
}

// HTML5 Blank navigation
function menu_principal()
{
	wp_nav_menu(
	array(
		'theme_location'  => 'main_menu',
		'menu'            => '',
		'container'       => false,
		'container_class' => 'menu-principal',
		'container_id'    => '',
		'menu_class'      => 'menu',
		'menu_id'         => '',
		'echo'            => true,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '<ul id="menu_principal">%3$s</ul>',
		'depth'           => 0,
		'walker'          => ''
		)
	);
}


add_action('init', 'register_html5_menu'); // Add HTML5 Blank Menu