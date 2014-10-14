<?php 
/*
Plugin Name: Marisa Post Custom Fields - For CRM functions
Plugin URI: http://vert.se
Description: Plugin de configura&ccedil;&otilde;es espec&iacute;ficas para o Tema Marisa
Version: 1.0
Author: Miguel Alves
Author URI: http://vert.se
*/

function add_restrict_field() {
    return add_meta_box(
        'add_restrict_field', // $id
        'Conteúdo restrito para usu&aacute;rios logados', // $title
        'show_restrict_field', // $callback
        'post', // $page
        'advanced', // $context
        'default'); // $priority
}

function show_restrict_field() {
    global $post;  
    $meta = get_post_meta($post->ID, 'restrict_field', true);  

    // Use nonce for verification  
    echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';  
    echo '<table class="form-table">';   
    // begin a table row with

            $content = $meta;
            $editor_id = 'restrict_field';
            wp_editor( $content, $editor_id );
}

function save_embed_tweet_meta($post_id) {   
    // verify nonce
    if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__)))
        return $post_id;
        
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;
        
    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
    }  
    
    $old = get_post_meta($post_id, "restrict_field", true);
    
    $new = $_POST["restrict_field"];
    
    if ($new && $new != $old) {
        update_post_meta($post_id, "restrict_field", $new);
    } elseif ('' == $new && $old) {
        delete_post_meta($post_id, "restrict_field", $old);
    }
}
 
add_action('save_post', 'save_embed_tweet_meta');
add_action('add_meta_boxes', 'add_restrict_field');

//RESTRICTED CONTENT FOR CRM USERS
function add_restrict_field_CRM() {
    return add_meta_box(
        'add_restrict_field_CRM', // $id
        'Conteúdo restrito para usu&aacute;rios logados (CRM)', // $title
        'show_restrict_field_CRM', // $callback
        'post', // $page
        'advanced', // $context
        'default'); // $priority
}

function show_restrict_field_CRM() {
    global $post;  
    $meta = get_post_meta($post->ID, 'restrict_field_CRM', true);  

    echo '<table class="form-table">';   
    // begin a table row with

            $content = $meta;
            $editor_id = 'restrict_field_CRM';
            wp_editor( $content, $editor_id );
}

function save_embed_tweet_meta_CRM($post_id) {   
    // verify nonce
    if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__)))
        return $post_id;
        
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;
        
    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
    }  
    
    $old = get_post_meta($post_id, "restrict_field_CRM", true);
    
    $new = $_POST["restrict_field_CRM"];
    
    if ($new && $new != $old) {
        update_post_meta($post_id, "restrict_field_CRM", $new);
    } elseif ('' == $new && $old) {
        delete_post_meta($post_id, "restrict_field_CRM", $old);
    }
}

add_action('save_post', 'save_embed_tweet_meta_CRM');
add_action('add_meta_boxes', 'add_restrict_field_CRM');