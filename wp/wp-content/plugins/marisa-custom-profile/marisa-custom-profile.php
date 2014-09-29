<?php 
/*
Plugin Name: Marisa Custom Profile Fields - For Profile Functions
Plugin URI: http://vert.se
Description: Plugin de configura&ccedil;&otilde;es espec&iacute;ficas para o Tema Marisa
Version: 1.0
Author: Miguel Alves
Author URI: http://vert.se
*/

add_action( 'show_user_profile', 'my_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'my_show_extra_profile_fields' );

function my_show_extra_profile_fields( $user ) { ?>

	<h3>Extra profile information</h3>

	<table class="form-table">

		<tr>
			<th><label for="facebook">Facebook</label></th>

			<td>
				<input type="text" name="facebook" id="facebook" value="<?php echo esc_attr( get_the_author_meta( 'facebook', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Please enter your Facebook username.</span>
			</td>
		</tr>
        
        <tr>
			<th><label for="twitter">Twitter</label></th>

			<td>
				<input type="text" name="twitter" id="twitter" value="<?php echo esc_attr( get_the_author_meta( 'twitter', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Please enter your Twitter username.</span>
			</td>
		</tr>
        
        <tr>
			<th><label for="gplus">Google Plus</label></th>

			<td>
				<input type="text" name="gplus" id="gplus" value="<?php echo esc_attr( get_the_author_meta( 'gplus', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Please enter your Google plus username.</span>
			</td>
		</tr>
        
        
        
        <tr>
			<th><label for="avatar">Avatar</label></th>

			<td>
				<input type="file" name="avatar" id="avatar" value="<?php echo esc_attr( get_the_author_meta( 'avatar', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Select your avatar picture.</span>
                <?php 
                    if ( esc_attr(get_the_author_meta( 'avatar', $user->ID )) ) {
                        ?><br/><br/><img src="<?php echo esc_attr( get_the_author_meta( 'avatar', $user->ID ) ); ?>" alt="" /><?php
                    }
                ?>
			</td>
		</tr>
        
        <tr>
			<th><label for="avatar">Exibir como parceiro?</label></th>
            <td>
				<input type="checkbox" style="width: 18px; height: 18px;" name="parceiro" id="parceiro" value="sim" <?php if ( get_the_author_meta( 'parceiro', $user->ID ) == "sim" ) { echo " checked=\"checked\" "; } ?> class="regular-text" /><br />
			</td>
		</tr>

	</table>
<?php }

add_action( 'personal_options_update', 'my_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'my_save_extra_profile_fields' );

function my_save_extra_profile_fields( $user_id ) {

	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;
    
    //VALIDATE BACKGROUND HOME IMG
    if(!empty($_FILES['avatar']['tmp_name'])) {
        $override = array('test_form'=>false);
        $file = wp_handle_upload($_FILES['avatar'], $override);
        update_usermeta( $user_id, 'avatar', $file['url'] );
    }
    
	update_usermeta( $user_id, 'twitter', $_POST['twitter'] );

	update_usermeta( $user_id, 'facebook', $_POST['facebook'] );
    
	update_usermeta( $user_id, 'gplus', $_POST['gplus'] );
    
    update_usermeta( $user_id, 'parceiro', $_POST['parceiro'] );
}

function parceiros_entries( ) {
    $theme_opts = get_option('marisa_options');
    $html = "";
    $html .= "<p>".$theme_opts['marisa_parceiros_descricao']."</p>";
    
    
    $args = array(
        'blog_id'      => $GLOBALS['blog_id'],
        'role'         => '',
        'meta_key'     => 'parceiro',
        'meta_value'   => 'sim',
        'meta_compare' => '',
        'meta_query'   => array(),
        'include'      => array(),
        'exclude'      => array(),
        'orderby'      => 'name',
        'order'        => 'ASC',
        'offset'       => '',
        'search'       => '',
        'number'       => '',
        'count_total'  => false,
        'fields'       => 'all',
        'who'          => '');
    $blogusers = get_users( $args );
    // Array of WP_User objects.
    $first;
    $count = 0;
    foreach ( $blogusers as $user ) {
        if ($count % 4 == 0) { $first = ""; }
        if ( strlen($first) < 1 ) {
            $first = "first";
        } else {
            $first = " ";
        }
        
        $html .= '<div class="author '.$first.'">';
        if (strlen($user->avatar)>0) {
            $html .= '<span class="avatar"><img src="'.$user->avatar.'" title="'.esc_html( $user->user_nicename ).'" /></span>';
        } else {
            $html .= '<span class="avatar"><img src="'.get_template_directory_uri().'/images/unknown.png" title="'.esc_html( $user->user_nicename ).'" /></span>';
        }
        if (strlen($user->display_name)>0) {
            $html .= '<span class="name">'.esc_html( $user->first_name  ).' '.esc_html( $user->last_name  ).'</span>';
        }
        //if (strlen($user->description)>0) {
            $html .= '<span class="description">'.esc_html( $user->description ).'</span>';
        //}
        if (strlen($user->user_url)>0) {
            $html .= '<a href="'.esc_html( $user->user_url ).'" target="_blank" class="site"><ico class="sprite-user-site"></ico>'.esc_html( str_replace( "http://", "",$user->user_url ) ).'</a>';
        }
        $html .= '</div>';
        $count++;
    }
    
    
    return $html;
}
add_shortcode('parceiros', parceiros_entries);

//the_author_meta( $meta_key, $user_id );
