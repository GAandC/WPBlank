<?php

function func_less_button($wp_admin_bar){
	$args = array(
		'id' => 'less_button',
		'title' => 'Refresh CSS',
		'href' => 'options-general.php?page=generate_less_css'

	);
	$wp_admin_bar->add_node($args);
}

add_action('admin_bar_menu', 'func_less_button', 100);


add_action('admin_menu', 'add_page_generate_less_css');

function add_page_generate_less_css() {
	add_submenu_page( 'options-general.php', 'Generate CSS', 'Generate CSS', 'edit_pages' ,'generate_less_css' ,'page_generate_less_css');
}


function page_generate_less_css()
{
	$success = generate_less_css();

	echo '<div class="wrap"><div id="icon-tools" class="icon32"></div>';
		echo '<h2>CSS généré avec succès à partir de LESS !</h2>';
	echo '</div>';
}
