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
add_theme_support('html5', array('search-form'));

add_theme_support('post-formats', array('aside', 'image', 'video'));
	
}

add_action('after_setup_theme', 'custom_theme_setup');

	/*
		==================
		Add theme support fnctions
		==================

	*/

    /*
        ==================
        Sidebar function
        ==================

    */
function custom_widget_setup() {

    register_sidebar(
        array(
            'name' => 'Sidebar',
            'id' => 'sidebar-1',
            'class' => 'custom',
            'description' => 'Standart sidebar',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h1 class="widget-title">',
            'after_title'   => '</h1>',

        )
    );
}

add_action('widgets_init','custom_widget_setup');




//nav menu walker
require_once get_template_directory() . '/wp-bootstrap-navwalker.php';

//custom show menu
function clean_custom_menu( $theme_location ) {
    if ( ($theme_location) && ($locations = get_nav_menu_locations()) && isset($locations[$theme_location]) ) {
        $menu = get_term( $locations[$theme_location], 'nav_menu' );
        $menu_items = wp_get_nav_menu_items($menu->term_id);
 
        $menu_list  = '<nav>' ."\n";
        $menu_list .= '<ul class="main-nav">' ."\n";
 
        $count = 0;
        $submenu = false;

        $menu_tree = array();

        foreach($menu_items as $item):
            $param = $item->menu_item_parent;
            $menu_tree[$param][] = $item;
        endforeach;
        
        

         
        foreach( $menu_items as $menu_item ) {
             
            $link = $menu_item->url;
            $title = $menu_item->title;
             
            if ( !$menu_item->menu_item_parent ) {
                $parent_id = $menu_item->ID;
                 
                $menu_list .= '<li class="item">' ."\n";
                $menu_list .= '<a href="'.$link.'" class="title">'.$title.'</a>' ."\n";
            }
 
            if ( $parent_id == $menu_item->menu_item_parent ) {
 
                if ( !$submenu ) {
                    $submenu = true;
                    $menu_list .= '<ul class="sub-menu">' ."\n";
                }
 
                $menu_list .= '<li class="item">' ."\n";
                $menu_list .= '<a href="'.$link.'" class="title">'.$title.'</a>' ."\n";
                $menu_list .= '</li>' ."\n";
                     
 
                if ( $menu_items[ $count + 1 ]->menu_item_parent != $parent_id && $submenu ){
                    $menu_list .= '</ul>' ."\n";
                    $submenu = false;
                }
 
            }
 
            if ( $menu_items[ $count + 1 ]->menu_item_parent != $parent_id ) { 
                $menu_list .= '</li>' ."\n";      
                $submenu = false;
            }
 
            $count++;
        }
         
        $menu_list .= '</ul>' ."\n";
        $menu_list .= '</nav>' ."\n";
 
    } else {
        $menu_list = '<!-- no menu defined in location "'.$theme_location.'" -->';
    }
    echo $menu_list;
}


    /*
        ==================
        Include walker file
        ==================

    */

//require get_template_directory() . '/inc/walker.php'; 

    /*
        ==================
        Head function
        ==================

    */

function custom_remove_version() {

    return '';

}

add_filter('the_generator', 'custom_remove_version');


    /*
        ==================
        Custom Post Type
        ==================

    */
function custom_custom_post_type (){
    
    $labels = array(
        'name' => 'Portfolio',
        'singular_name' => 'Portfolio',
        'add_new' => 'Add Item',
        'all_items' => 'All Items',
        'add_new_item' => 'Add Item',
        'edit_item' => 'Edit Item',
        'new_item' => 'New Item',
        'view_item' => 'View Item',
        'search_item' => 'Search Portfolio',
        'not_found' => 'No items found',
        'not_found_in_trash' => 'No items found in trash',
        'parent_item_colon' => 'Parent Item'
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'publicly_queryable' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail',
            'revisions',
        ),
        'taxonomies' => array('category', 'post_tag'),
        'menu_position' => 5,
        'exclude_from_search' => false
    );
    register_post_type('portfolio',$args);
}
add_action('init','custom_custom_post_type');



function awesome_custom_taxonomies() {
    
    //add new taxonomy hierarchical
    $labels = array(
        'name' => 'Fields',
        'singular_name' => 'Field',
        'search_items' => 'Search Fields',
        'all_items' => 'All Fields',
        'parent_item' => 'Parent Field',
        'parent_item_colon' => 'Parent Field:',
        'edit_item' => 'Edit Field',
        'update_item' => 'Update Field',
        'add_new_item' => 'Add New Work Field',
        'new_item_name' => 'New Field Name',
        'menu_name' => 'Fields'
    );
    
    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'field' )
    );
    
    register_taxonomy('field', array('portfolio'), $args);
    
    //add new taxonomy NOT hierarchical
    
    register_taxonomy('software', 'portfolio', array(
        'label' => 'Software',
        'rewrite' => array( 'slug' => 'software' ),
        'hierarchical' => false
    ) );
    
}
add_action( 'init' , 'awesome_custom_taxonomies' );

    /*
        ==================
        Custom Term function
        ==================

    */

function custom_get_terms( $postID, $term ){
    
    $terms_list = wp_get_post_terms($postID, $term); 
    $output = '';
                    
    $i = 0;
    foreach( $terms_list as $term ){ $i++;
        if( $i > 1 ){ $output .= ', '; }
        $output .= '<a href="' . get_term_link( $term ) . '">'. $term->name .'</a>';
    }
    
    return $output;
    }
    