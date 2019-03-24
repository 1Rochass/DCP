<?php 
/*
Plugin Name: DCP
Plugin URI: 
Description: DCP Delete category produts plugin
Version: 1.0.0
Author: me
Author URI: 
*/

/*
* Add css to the <head>
*/
function DCP_add_CSS() {
	$url = plugins_url('assets/css/style.css', __FILE__);
	echo "<link rel='stylesheet' type='text/css' href='$url'/> \n";
}
add_action('admin_head', 'DCP_add_CSS');

/*
* Add plugin to admin menu
*/
function DCP() {
	add_menu_page('DCP_title', 'DCP', 'manage_options', 'DCP_slug', 'DCP_func');
}
add_action('admin_menu', 'DCP');

/*
* Main DCP function
*/
function DCP_func() {
	echo "<div id='categories'></div>";
	echo "<div id='categoryInfo'></div>";
	echo "<div id='warning'></div>";
}

/*
* Add action
*/
add_action('wp_ajax_DCP_showCategories', 'DCP_showCategories', 99);
add_action('wp_ajax_DCP_showCountProducts', 'DCP_showCountProducts', 98);
add_action('wp_ajax_DCP_deleteProducts', 'DCP_deleteProducts', 97);
require 'DCP_DB.php';

/*
* Add js
*/
function DCP_add_js ($hook){
	// Check real plugin page name
	// echo "<p style='text-align:center;'>" .$hook. "</p>";
	if ('toplevel_page_DCP_slug' != $hook) {
		return;
	}

	wp_register_script('DCP_js', plugins_url('assets/js/script.js', __FILE__));
	wp_enqueue_script('DCP_js');	
}
add_action('admin_enqueue_scripts', 'DCP_add_js');