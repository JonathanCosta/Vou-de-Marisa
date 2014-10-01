<?php
/* WIDGETS */

if (function_exists('register_sidebar'))
{
    register_sidebar(array(
		'name'			=> 'Sidebar',
        'before_widget'	=> '<div class="widget">',
        'after_widget'	=> '</div>',
		'before_title'	=> '<h3>',
		'after_title'	=> '</h3>',
    ));
}

add_theme_support( 'post-thumbnails' );
//set_post_thumbnail_size( 300, 335  );

//add_action( 'init', 'create_post_tags' );

/*
 *
 *
 * NEW POST TYPE TAG
 *
 *
 */

function create_post_tags() {
    register_post_type( 'Tags',
        array(
            'labels' => array(
                'name' => __( 'Tags' ),
                'singular_name' => __( 'Tag' )
            ),
            'menu_icon' => admin_url().'/images/se.png',
            'public' => true,
            'has_archive' => false,
            'query_var' => 'tag',
            'supports' => array(
                'title'
            ),
            'rewrite' => array(
                'slug' => 'tags/'
            ) 
        )
    );
}

function getLastPathSegment($url) {
    $path = parse_url($url, PHP_URL_PATH); // to get the path from a whole URL
    $pathTrimmed = trim($path, '/'); // normalise with no leading or trailing slash
    $pathTokens = explode('/', $pathTrimmed); // get segments delimited by a slash

    if (substr($path, -1) !== '/') {
        array_pop($pathTokens);
    }
    return end($pathTokens); // get the last segment
}

/*
 *
 *
 * EXTENDING CATEGORY FIELDS
 *
 *
 */

function create_category_taxonomies() {
    
    $taxonomy = "Background";
    $object_type = array( "category" );
    $labels = array(
		'name'              => _x( 'Backgrounds', 'taxonomy general name' ),
		'singular_name'     => _x( 'Background', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Backgrounds' ),
		'all_items'         => __( 'All Backgrounds' ),
		'parent_item'       => __( 'Parent Background' ),
		'parent_item_colon' => __( 'Parent Background:' ),
		'edit_item'         => __( 'Edit Background' ),
		'update_item'       => __( 'Update Background' ),
		'add_new_item'      => __( 'Add New Background' ),
		'new_item_name'     => __( 'New Background Name' ),
		'menu_name'         => __( 'Background' )
	);
    $args = array(
        'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'Background' )
    );

    register_taxonomy( $taxonomy, $object_type, $args );
    
}

//add_action( 'init', 'create_category_taxonomies', 0 );



function words($value, $words=100, $end='...') {
    preg_match('/^\s*+(?:\S++\s*+){1,'.$words.'}/u', $value, $matches);
    if ( ! isset($matches[0])) return $value;
    if (strlen($value) == strlen($matches[0])) return $value;
    return rtrim($matches[0]).$end;
}