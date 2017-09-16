<?php
	/*
		==================
		Include scripts
		==================

	*/
function custom_script_enqueue() {
	//css
	wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '3.3.7', 'all');
	wp_enqueue_style('bootstrapmap', get_template_directory_uri() . '/css/bootstrap.min.css.map', array(), '3.3.7', 'all');
	wp_enqueue_style('customstyle', get_template_directory_uri() . '/css/custom.css', array(), '1.0.0', 'all');
	

	//js


	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', 'https://code.jquery.com/jquery-3.2.1.slim.min.js', '', '', true);
	wp_enqueue_script( 'jquery' );

	wp_enqueue_script('bootstrapjs', get_template_directory_uri() . '/js/bootstrap.min.js', array(), '3.3.7', true);
	wp_enqueue_script('customjs', get_template_directory_uri() . '/js/custom.js', array(), '1.0.0', true);
	
}
add_action( 'wp_enqueue_scripts', 'custom_script_enqueue');
	/*
		==================
		Activate menus
		==================

	*/
function custom_theme_setup() {

	add_theme_support('menus');

	//register_nav_menu('primary', 'Primary Header Navigation');
	register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'CUSTOMTHEME' ),
) );

	register_nav_menu('secondary', 'Footer Navigation');

add_theme_support('custom-background');
add_theme_support('custom-header');
add_theme_support('post-thumbnails');

add_theme_support('post-formats', array('aside', 'image', 'video'));
	
}

add_action('after_setup_theme', 'custom_theme_setup');

	/*
		==================
		Add theme support fnctions
		==================

	*/



//nav menu walker
require_once get_template_directory() . '/wp-bootstrap-navwalker.php';

