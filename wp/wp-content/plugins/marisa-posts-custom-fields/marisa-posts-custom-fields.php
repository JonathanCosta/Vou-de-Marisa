<?php 
/*
Plugin Name: Marisa - Posts Customizados
Plugin URI: http://vert.se
Description: Cadastra campos opcionais para os posts
Version: 1.0
Author: Miguel Alves
Author URI: http://vert.se
*/

function add_post_cf() {
    return add_meta_box(
        'name', // $id
        'Banner para o carrossel do post', // $title
        'show_post_cf', // $callback
        'post', // $page
        'normal', // $context
        'default'); // $priority
}

function show_post_cf() {
    global $post;  
    $cf_banner_foreground = get_post_meta($post->ID, 'cf_banner_foreground', true);
    $cf_banner_background = get_post_meta($post->ID, 'cf_banner_background', true);
    $cf_banner_foreground_mobile = get_post_meta($post->ID, 'cf_banner_foreground_mobile', true);
    $cf_banner_exibirhome = get_post_meta($post->ID, 'cf_banner_exibirhome', true);
    $cf_banner_exibircarrossel = get_post_meta($post->ID, 'cf_banner_exibircarrossel', true);
    
    // Use nonce for verification
    echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
    echo '<table class="form-table">';
	echo '<tbody>';
    
    echo "<script language=\"JavaScript\">
        jQuery(document).ready(function() {
            jQuery('#cf_banner_foreground_buttom').click(function() {
                window.formimgid = '#cf_banner_foreground';
                formfield = jQuery('#cf_banner_foreground').attr('name');
                tb_show('', 'media-upload.php?type=image&TB_iframe=true');
                return false;
            });
            jQuery('#cf_banner_background_buttom').click(function() {
                formfield = jQuery('#cf_banner_background').attr('name');
                window.formimgid = '#cf_banner_background';
                tb_show('', 'media-upload.php?type=image&TB_iframe=true');
                return false;
            });
            jQuery('#cf_banner_foreground_mobile_buttom').click(function() {
                formfield = jQuery('#cf_banner_foreground_mobile').attr('name');
                window.formimgid = '#cf_banner_foreground_mobile';
                tb_show('', 'media-upload.php?type=image&TB_iframe=true');
                return false;
            });
        
            window.send_to_editor = function(html) {
                if (  window.formimgid && window.formimgid.length > 0 ) {
                    imgurl = jQuery('img',html).attr('src');
                    jQuery(window.formimgid).val(imgurl);
                    tb_remove();
                } else {
                    html = html.replace('<a ','<a class=\"image_tag\"');
                    var b, c = \"undefined\" != typeof tinymce,
                        d = \"undefined\" != typeof QTags;
                    if (wpActiveEditor) c && (b = tinymce.get(wpActiveEditor));
                    else if (c && tinymce.activeEditor) b = tinymce.activeEditor, wpActiveEditor = b.id;
                    else if (!d) return !1;

                    // Tagger class trigger event
                    var Tagger;
                    if(Tagger && Tagger instanceof {}) {
                        Tagger.fire();
                    }

                    if (b && !b.isHidden() ? b.execCommand(\"mceInsertContent\", !1, html) : d ? QTags.insertContent(html) : document.getElementById(wpActiveEditor).value += html, window.tb_remove) {
                        try {
                            window.tb_remove();
                        } catch (e) {}
                    }
                }
                window.formimgid = '';
            }
        });
    </script>";
    echo '<tr>';
    echo '    <th><label for="cf_banner_foreground">Imagem</label></th>';
    echo '    <td><input id="cf_banner_foreground" type="text" size="36" name="cf_banner_foreground" value="'.$cf_banner_foreground.'">
                  <input id="cf_banner_foreground_buttom" type="button" value="Set Image" class="button add-image"/>
                  <br />';
    if ( isset($cf_banner_foreground) && strlen($cf_banner_foreground) > 0 ) {
        echo "<img style='width:100%;' src='{$cf_banner_foreground}' alt=''/>";
    }
    echo '</td></tr>';
    echo '<tr>';
    echo '    <th><label for="cf_banner_background">Background</label></th>';
    echo '    <td><input id="cf_banner_background" type="text" size="36" name="cf_banner_background" value="'.$cf_banner_background.'">
                  <input id="cf_banner_background_buttom" type="button" value="Set Image" class="button add-image"/>
                  <br />';
    if ( isset($cf_banner_background) && strlen($cf_banner_background) > 0 ) {
        echo "<img style='max-width:100%;' src='{$cf_banner_background}' alt=''/>";
    }
    echo '</td></tr>';
    echo '<tr>';
    echo '    <th><label for="cf_banner_foreground_mobile">Imagem do Banner Mobile</label></th>';
    echo '    <td><input id="cf_banner_foreground_mobile" type="text" size="36" name="cf_banner_foreground_mobile" value="'.$cf_banner_foreground_mobile.'">
                  <input id="cf_banner_foreground_mobile_buttom" type="button" value="Set Image" class="button add-image"/>
                  <br />';
    if ( isset($cf_banner_foreground_mobile) && strlen($cf_banner_foreground_mobile) > 0 ) {
        echo "<img style='max-width:100%;' src='{$cf_banner_foreground_mobile}' alt=''/>";
    }
    echo '</td></tr>';
    
    echo '</td></tr>';
    echo '<tr>';
    echo '    <th><label for="cf_banner_exibirhome">Exibir na Home?</label></th>';
    echo '    <td><input id="cf_banner_exibirhome" type="checkbox" ';
    if ($cf_banner_exibirhome == 1) { echo ' checked="checked" '; }
    echo 'name="cf_banner_exibirhome" value="1">';
    echo '</td></tr>';
    
    echo '</td></tr>';
    echo '<tr>';
    echo '    <th><label for="cf_banner_exibircarrossel">Exibir no carrossel?</label></th>';
    echo '    <td><input id="cf_banner_exibircarrossel" type="checkbox" ';
    if ($cf_banner_exibircarrossel == 1) { echo ' checked="checked" '; }
    echo 'name="cf_banner_exibircarrossel" value="1">';
    echo '</td></tr>';
    
    
    echo '</tbody>';
    echo '</table>';
    
}

function save_post_cf($post_id) { 
    
    // verify nonce
    //if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__)))
    //    return $post_id;
    
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;
        
    // check permissions
    if ('post' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
    }
    
    
            $old = get_post_meta($post_id, "cf_banner_foreground", true);
            $new = $_POST["cf_banner_foreground"];
            if ($new && $new != $old) {
                update_post_meta($post_id, "cf_banner_foreground", $new);
            } elseif ('' == $new && $old) {
                delete_post_meta($post_id, "cf_banner_foreground", $old);
            }
    
    
            $old = get_post_meta($post_id, "cf_banner_background", true);
            $new = $_POST["cf_banner_background"];
            if ($new && $new != $old) {
                update_post_meta($post_id, "cf_banner_background", $new);
            } elseif ('' == $new && $old) {
                delete_post_meta($post_id, "cf_banner_background", $old);
            }
    
    
            $old = get_post_meta($post_id, "cf_banner_foreground_mobile", true);
            $new = $_POST["cf_banner_foreground_mobile"];
            if ($new && $new != $old) {
                update_post_meta($post_id, "cf_banner_foreground_mobile", $new);
            } elseif ('' == $new && $old) {
                delete_post_meta($post_id, "cf_banner_foreground_mobile", $old);
            }
    
            
            $old = get_post_meta($post_id, "cf_banner_exibirhome", true);
            $new = $_POST["cf_banner_exibirhome"];
            if ($new && $new != $old) {
                update_post_meta($post_id, "cf_banner_exibirhome", $new);
            } elseif ('' == $new && $old) {
                delete_post_meta($post_id, "cf_banner_exibirhome", $old);
            }
    
            
            $old = get_post_meta($post_id, "cf_banner_exibircarrossel", true);
            $new = $_POST["cf_banner_exibircarrossel"];
            if ($new && $new != $old) {
                update_post_meta($post_id, "cf_banner_exibircarrossel", $new);
            } elseif ('' == $new && $old) {
                delete_post_meta($post_id, "cf_banner_exibircarrossel", $old);
            }
    
    
}
 
add_action('save_post', 'save_post_cf');
add_action('add_meta_boxes', 'add_post_cf');

