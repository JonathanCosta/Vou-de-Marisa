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

// CUSTOM CSS FROM TEMPLATE
function custom_template_css() {
   echo '<link rel="stylesheet" href="'. get_template_directory_uri() .'/css/image-marker.css" type="text/css" media="all">';
}

// CUSTOM JS FROM TEMPLATE
function custom_template_js() {
   echo //'<script src="'. get_template_directory_uri() .'/js/jquery-1.11.1.min.js"></script>' .
        '<script src="'. get_template_directory_uri() .'/js/underscore.min.js"></script>' .
        '<script src="'. get_template_directory_uri() .'/js/image-marker.js"></script>';
}

add_action('admin_head', 'custom_template_css');
add_action('admin_footer', 'custom_template_js');



///FACEBOOK GETTING ACCESS TOKEN
define("APP_ID", "241686319233509");
define("APP_SECRET", "89d467e158e17da7dd7e148739c5e5ef");
define("ACCESS_TOKEN", "CAADbzZCs0eeUBAKildbvoTy4ri1RsfYZAoY569W8HkBDLoPyu2FdhkKRGktA84yLiCO8zEusiSwgqgG8hSWlhWEr7TLTnvVUMu1ROqHeZCdI3HVtsGNm3b8BpwZBB7aaa0TDRJafI4U2fN1EowpA7jnPsUreezLVtZBzw4lGUhEKrtZAPvZChfUrdV6OF4ddFgztBJwMWNkZAHhdmiJp8eVrddf2YQ1O0FkZD");

function get_resource($url) {
    parse_str(file_get_contents($url), $output);
    return $output;
}
 
function grant_app_token() {
    $res = get_resource('https://graph.facebook.com/oauth/access_token?'.
        http_build_query(array(
            'client_id' => APP_ID,
            'client_secret' => APP_SECRET,
            'grant_type' => 'client_credentials'
        ))
    );
    return $res['access_token'];
}
 
function grant_long_token($access_token) {
    $res = get_resource('https://graph.facebook.com/oauth/access_token?'.
        http_build_query(array(
            'client_id' => APP_ID,
            'client_secret' => APP_SECRET,
            'grant_type' => 'fb_exchange_token',
            'fb_exchange_token' => $access_token
        ))
    );
    return $res['access_token'];
}
 
function get_token_info($access_token) {
    $res = get_resource('https://graph.facebook.com/debug_token?'.
        http_build_query(array(
            'input_token' => $access_token,
            'access_token' => grant_app_token(),
        ))
    );
    return $res;
}
   
function fb_sdk() {
    include_once 'facebook.php';
    return new Facebook(array(
      'appId'  => APP_ID,
      'secret' => APP_SECRET
    ));
}