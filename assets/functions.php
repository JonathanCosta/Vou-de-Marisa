<?php
/* WIDGETS */

session_start();

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

function encrypt($str, $key) {
    return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $str, MCRYPT_MODE_CBC, md5(md5($key))));
}

function decrypt($str, $key) {
    return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($str), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
}

function getPayload($data) {
    return encrypt(json_encode($data), SALT);
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
    require_once( dirname( __FILE__ ) . '/inc/facebook.php' );

    return new Facebook(array(
      'appId'  => APP_ID,
      'secret' => APP_SECRET
    ));
}

function checkForLogoutPages() {
    global $pagenow;

    $pages = array(
        'login'
    );
    $page = basename($_SERVER['REQUEST_URI']);
    if(in_array($page, $pages)) {
        FrontUser::logout('/' . $page);
    }
}

/* Authenticated user */
class FrontUser {

    const SESSION_NAME = 'front_user';

    /* CHECK IF USER IS LOGGED IN */
    static function isLoggedIn() {
        return ($_SESSION[self::SESSION_NAME] ? true : false);
    }

    /* LOGS USER OUT */
    static function logOut($url = null) {
        if(!$url) $url = site_url();
        unset($_SESSION[self::SESSION_NAME]);
        header('Location: ' . $url);
    }

    /* LOGS USER IN */
    static function login($id, $silent = false){
        if(!$id){
            return false;
        }
        global $wpdb;

        $login = $wpdb->get_results( "SELECT * FROM users WHERE id LIKE '".$id."' LIMIT 1");

        if($login){

            foreach ( $login as $l ){
                $_SESSION['front_user'] = array(
                    'id' => $id,
                    'name' => $l->name,
                    'email' => $l->email,
                    'uid' => $l->uid,
                );
            }

            if(!$silent) {
                header('Location:' . site_url());
                die();   
            }
        } else {
            return false;
        }
    } 

    public static function authenticate() {
        global $wpdb;

        $email          = $_POST['user_email'];
        $senha          = md5($_POST['user_senha']);
        $facebook       = $_POST['facebook'];

        if($facebook) {
            $fb = fb_sdk();

            try {
                $uid = $fb->getUser();
            } catch (FacebookApiException $e) {
                header('Location: ' . site_url() . '/');
            }
        }

        if($uid) {
            $login = $wpdb->get_var( "SELECT id FROM users WHERE uid = '". $uid . "' LIMIT 1" );
        } else {
            $login = $wpdb->get_var( "SELECT id FROM users WHERE email = '". $email . "' AND user_pass = '" . $senha . "' LIMIT 1" );
        }
        if($login) {
            self::login($login);
        } else {
            $_SESSION['signup_error'] = $uid ? 'Usuário não encontrado' : 'Usuário ou senha não encontrados';
            header('Location: '. site_url() .'/login');
            die();
        }        
    }

    public static function firstName() {
        if($value = self::hasValue('name')) {
            preg_match('/^[^\s]*/', $value, $match);
            return $match[0];
        }        
    }   

    public static function __callStatic($method, $args) {

        if($value = self::hasValue($method)) {
            return $value;
        }
    }

    protected static function hasValue($name) {
        return isset($_SESSION[self::SESSION_NAME]) && 
            isset($_SESSION[self::SESSION_NAME][$name]) ?
            $_SESSION[self::SESSION_NAME][$name] : false;
    }
}



function do_login(){

}

/* LOGSOUT USER */
function logoutFrontUser() {
    FrontUser::logOut();
}

/* LOGSIN USER */
function custom_user_login() {
    FrontUser::authenticate();
}


/* USER REGISTER */
function custom_user_register() {
    global $wpdb;

    $name           = $_POST['user_name'];
    $email          = $_POST['user_email'];
    $senha          = md5($_POST['user_senha']);
    $senha2          = md5($_POST['repetirsenha']);
    $facebook       = $_POST['facebook'];

    /* TODO: Sanitizar dados */

    $date = date("Y-m-d H:i:s");

    $uid = null;

    if($facebook) {
        $fb = fb_sdk();

        try {
            $uid = $fb->getUser();
        } catch (FacebookApiException $e) {
            header('Location: ' . site_url() . '/');
        }

        if ($uid) {
            try {

                $fbme = $fb->api('/me');
                $name  = $fbme['name'];
                $email = $fbme['email'];
            
            } catch (FacebookApiException $e) {
            }

            $senha = '';
        } else {
            return $_SESSION['signup_error'] = 'Usuário não pode ser autenticado pelo Facebook.';
        }       
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $_SESSION['signup_error'] = 'Email inválido.';
        }
        if ($senha != $senha2) {
            return $_SESSION['signup_error'] = 'As senhas não conferem.';
        }
    }


    $user = $wpdb->get_var( "SELECT COUNT(id) FROM users WHERE email = '$email'" );

    if($user > 0) {
        return $_SESSION['signup_error'] = 'Usuário já existe.';
    }

    $wpdb->insert( 
    'users', 
        array( 
            'name' => $name,
            'email' => $email,
            'uid' => $uid,
            'user_pass' => $senha,
            'created_at' => $date,
            'updated_at' => $date
        ), 
        array( 
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s'
        ) 
    );

    $the_id = $wpdb->insert_id;
    FrontUser::login($the_id, true);
}


/* USER REGISTER */
function custom_update_register() {
    global $wpdb;

    $name           = $_POST['user_name'];
    $senha          = null;
    $date = date("Y-m-d H:i:s");

    $values = array('name' => $name, 'updated_at' => $date);
    $formats = array('%s', '%s');

    $id  = FrontUser::id();
    $uid = FrontUser::uid();

    /* Not authenticated via Facebook */
    if(!$uid) {
        $senha_atual    = md5($_POST['senha_atual']);
        $senha          = $_POST['user_senha'];
        $senha2         = $_POST['repetirsenha'];

        if($senha) {
            $pass = $wpdb->get_var( "SELECT user_pass FROM users WHERE id = $id" );

            if($pass != $senha_atual) {
                return $_SESSION['signup_error'] = 'Senha atual não confere.';
            }
            if ($senha != $senha2) {
                return $_SESSION['signup_error'] = 'As senhas não conferem.';
            }

            $values['user_pass'] = md5($senha);
            $formats[] = '%s';
        }
    }

    $wpdb->update('users', $values, array('id' => $id), $formats);

    FrontUser::login($id, true);

    $_SESSION['signup_success'] = 'Dados atualizados!';
}

/* Form register hook */
if(isset($_POST['cadastro']) && $_POST['cadastro']) custom_user_register();

/* Form update register hook */
if(isset($_POST['update_info']) && $_POST['update_info']) custom_update_register();

/* Login register hook */
if(isset($_POST['front_login']) && $_POST['front_login']) custom_user_login();

/* Logout Hook */
if(isset($_GET['front_user_logout']) && $_GET['front_user_logout'] == 'true') logoutFrontUser();

/*$msg = encrypt($data, SALT);*/

checkForLogoutPages();