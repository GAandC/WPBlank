<?php
$dir = get_template_directory();

require $dir . '/inc/base.php';
require $dir . '/inc/tags.php';
require $dir . '/inc/comments.php';
require $dir . '/inc/pagination.php';
require $dir . '/inc/yoast.php';
require $dir . '/app/assets.php';
require $dir . '/app/custom_posts.php';
require $dir . '/app/menus.php';
require $dir . '/app/sidebars.php';
require $dir . '/inc/required_plugins.php';


// DB Replace. Commenter une fois en prod
if(WP_DEBUG===true && isset($_GET['_dbreplace_']) && isset($_GET['_to_']))
{
	$changes = array();
	$changes[$_GET['_dbreplace_']] = $_GET['_to_'];
	include_once $dir.' /vendor/dbreplace.php';
	echo 'DBReplace terminé !';
	exit;
}