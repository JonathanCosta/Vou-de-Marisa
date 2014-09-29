<?php 
/*
Plugin Name: Marisa get newsletters signature
Plugin URI: http://vert.se
Description: Captura os cadastros para recebimento de newsletters
Version: 1.0
Author: Miguel Alves
Author URI: http://vert.se
*/

add_action( 'init', 'create_newsletter' );

function create_newsletter() {
    register_post_type( 'Newsletter',
        array(
            'labels' => array(
                'name' => __( 'Newsletters' ),
                'singular_name' => __( 'Newsletter' )
            ),
            'menu_icon' => admin_url().'/images/comment-grey-bubble.png',
            'public' => true,
            'has_archive' => true,
            'query_var' => 'newsletter',
            'supports' => array(
                'title'
            ),
            'rewrite' => array(
                'slug' => 'newsletters/'
            ) 
        )
    );
}

function add_newsletter() {
    return add_meta_box(
        'name', // $id
        'Nome', // $title
        'show_newsletter', // $callback
        'newsletter', // $page
        'advanced', // $context
        'default'); // $priority
}

function show_newsletter() {
    global $post;  
    $name = get_post_meta($post->ID, 'name', true);
    
    // Use nonce for verification  
    echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';  
    echo '<input type="text" id="name" name="name" value="' . esc_attr( $name ) . '" size="50" />';
}

function save_newsletter($post_id) {   
    // verify nonce
    if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__)))
        return $post_id;
        
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;
        
    // check permissions
    if ('newsletter' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
    }  
    
    $old = get_post_meta($post_id, "name", true);
    
    $new = $_POST["name"];
    
    if ($new && $new != $old) {
        update_post_meta($post_id, "name", $new);
    } elseif ('' == $new && $old) {
        delete_post_meta($post_id, "name", $old);
    }
}
 
add_action('save_post', 'save_newsletter');
add_action('add_meta_boxes', 'add_newsletter');

