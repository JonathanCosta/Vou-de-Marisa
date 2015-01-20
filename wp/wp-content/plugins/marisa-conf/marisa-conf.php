<?php 
/*
Plugin Name: Marisa Conf
Plugin URI: http://vert.se
Description: Plugin de configura&ccedil;&otilde;es espec&iacute;ficas para o Tema Marisa
Version: 1.0
Author: Miguel Alves
Author URI: http://vert.se
*/
class JW_Options {
    
    public $options;
    
    //First automatically running function of this class
    public function __construct() {
        //delete_option('marisa_options');
        $this->options = get_option('marisa_options');
        $this->register_settings_and_fields();
    }
    
    public function add_menu_page() {
        add_options_page('Op&ccedil;&otilde;es Marisa', 'Op&ccedil;&otilde;es Marisa', 'administrator', __FILE__, array('JW_Options', 'display_options_page'));
    }
    
    public function display_options_page() {
        ?>
        <div class="wrap">
            <?php screen_icon(); ?>
            <h2>Op&ccedil;&otilde;es Marisa</h2>
            <form method="post" action="options.php" enctype="multipart/form-data">
                <?php settings_fields('marisa_options'); ?>
                <?php do_settings_sections(__FILE__); ?>
                <p class="submit">
                    <input type="submit" name="submit" class="button-primary" value="Salvar"/>
                </p>
            </form>
        </div>
        <?php
    }
    
    public function register_settings_and_fields() {
        register_setting('marisa_options', 'marisa_options', array($this, 'marisa_validate_settings'));
        
        add_settings_section('marisa_main_section', 'Geral', array($this, 'marisa_main_section_cb'), __FILE__);
        add_settings_section('marisa_social_section', 'Redes Sociais', array($this, 'marisa_main_section_cb'), __FILE__);
        add_settings_section('marisa_footer_section', 'Rodapé', array($this, 'marisa_main_section_cb'), __FILE__);
        add_settings_section('marisa_parceiros_section', 'Parceiros', array($this, 'marisa_main_section_cb'), __FILE__);
        add_settings_section('marisa_cadastrese_section', 'Cadastre-se', array($this, 'marisa_main_section_cb'), __FILE__);
        add_settings_section('marisa_meusdados_section', 'Meus Dados', array($this, 'marisa_main_section_cb'), __FILE__);
        
        add_settings_field('marisa_cartao_marisa', 'Link Cart&atilde;o Marisa', array($this, 'marisa_cartao_marisa_fn'), __FILE__, 'marisa_social_section');
        add_settings_field('marisa_nossas_lojas', 'Link Nossas Lojas', array($this, 'marisa_nossas_lojas_fn'), __FILE__, 'marisa_social_section');
        add_settings_field('marisa_compre_online', 'Link Compre Online', array($this, 'marisa_compre_online_fn'), __FILE__, 'marisa_social_section');
        
        add_settings_field('marisa_call_sign', 'Lightbox Inicial', array($this, 'marisa_call_sign_fn'), __FILE__, 'marisa_main_section');
        add_settings_field('marisa_logo_header', 'Logotipo', array($this, 'marisa_logo_header_fn'), __FILE__, 'marisa_main_section');
        add_settings_field('marisa_logo_header_mobile', 'Logotipo Mobile', array($this, 'marisa_logo_header_mobile_fn'), __FILE__, 'marisa_main_section');
        add_settings_field('marisa_logo_header_link', 'LINK do Logotipo', array($this, 'marisa_logo_header_link_setting_fn'), __FILE__, 'marisa_main_section');
        add_settings_field('marisa_logo_posts_page', 'Quantidade de posts por p&aacute;gina', array($this, 'marisa_logo_posts_page_setting_fn'), __FILE__, 'marisa_main_section');
        add_settings_field('marisa_home_background', 'Plano de Fundo da Home', array($this, 'marisa_home_background_fn'), __FILE__, 'marisa_main_section');
        
        add_settings_field('marisa_facebook', 'Facebook', array($this, 'marisa_facebook_setting_fn'), __FILE__, 'marisa_social_section');
        add_settings_field('marisa_youtube', 'Youtube', array($this, 'marisa_youtube_setting_fn'), __FILE__, 'marisa_social_section');
        add_settings_field('marisa_twitter', 'Twiter', array($this, 'marisa_twitter_setting_fn'), __FILE__, 'marisa_social_section');
        add_settings_field('marisa_instagram', 'Instagram', array($this, 'marisa_instagram_setting_fn'), __FILE__, 'marisa_social_section');
        add_settings_field('marisa_gplus', 'Google Plus', array($this, 'marisa_gplus_setting_fn'), __FILE__, 'marisa_social_section');
        
        add_settings_field('marisa_logo_footer', 'Logotipo', array($this, 'marisa_logo_footer_fn'), __FILE__, 'marisa_footer_section');
        add_settings_field('marisa_label_site_footer', 'Visite marisa.com.br', array($this, 'marisa_label_site_setting_fn'), __FILE__, 'marisa_footer_section');
        add_settings_field('marisa_copyright', 'Copyright', array($this, 'marisa_copyright_footer_fn'), __FILE__, 'marisa_footer_section');
        
        add_settings_field('marisa_copyright', 'Copyright', array($this, 'marisa_copyright_footer_fn'), __FILE__, 'marisa_footer_section');
        
        add_settings_field('marisa_parceiros_descricao', 'Descri&ccedil;&atilde;o da página', array($this, 'marisa_parceiros_descricao_fn'), __FILE__, 'marisa_parceiros_section');
        add_settings_field('marisa_cadastrese_descricao', 'Descri&ccedil;&atilde;o da página', array($this, 'marisa_cadastrese_descricao_fn'), __FILE__, 'marisa_cadastrese_section');
        add_settings_field('marisa_sucesso_descricao', 'Descri&ccedil;&atilde;o da página de sucesso', array($this, 'marisa_sucesso_descricao_fn'), __FILE__, 'marisa_cadastrese_section');
        add_settings_field('marisa_meusdados_descricao', 'Descri&ccedil;&atilde;o da página', array($this, 'marisa_meusdados_descricao_fn'), __FILE__, 'marisa_meusdados_section');
        
    }
    
    public function marisa_main_section_cb() {
        
    }
    
    public function marisa_call_sign_fn() {
        echo "<input type='file' name='marisa_call_sign_fd'/><br /><br />";
        if ( isset($this->options['marisa_call_sign_fd']) ) {
            echo "<img src='{$this->options['marisa_call_sign_fd']}' alt=''/>";
        }
    }
    
    public function marisa_logo_header_fn() {
        echo "<input type='file' name='marisa_logo_header_fd'/><br /><br />";
        if ( isset($this->options['marisa_logo_header_fd']) ) {
            echo "<img src='{$this->options['marisa_logo_header_fd']}' " . $this->logo_style() . " alt=''/>";
        }
    }
    
    public function marisa_logo_header_mobile_fn() {
        echo "<input type='file' name='marisa_logo_header_mobile_fd'/><br /><br />";
        if ( isset($this->options['marisa_logo_header_mobile_fd']) ) {
            echo "<img src='{$this->options['marisa_logo_header_mobile_fd']}' " . $this->logo_style() . " alt=''/>";
        }
    }
    
    public function marisa_home_background_fn() {
        echo "<input type='file' name='marisa_home_background'/><br /><br />";
        if ( isset($this->options['marisa_home_background']) ) {
            echo "<img src='{$this->options['marisa_home_background']}' alt=''/>";
        }
    }
    
    public function marisa_logo_posts_page_setting_fn() {
        echo "<input name='marisa_options[marisa_logo_posts_page]' value='{$this->options['marisa_logo_posts_page']}' />";
    }
    
    public function marisa_logo_header_link_setting_fn() {
        echo "<input name='marisa_options[marisa_logo_header_link]' value='{$this->options['marisa_logo_header_link']}' />";
    }
    
        public function marisa_cartao_marisa_fn() {
            echo "http://<input name='marisa_options[marisa_cartao_marisa]' value='{$this->options['marisa_cartao_marisa']}' />";
        }

        public function marisa_nossas_lojas_fn() {
            echo "http://<input name='marisa_options[marisa_nossas_lojas]' value='{$this->options['marisa_nossas_lojas']}' />";
        }

        public function marisa_compre_online_fn() {
            echo "http://<input name='marisa_options[marisa_compre_online]' value='{$this->options['marisa_compre_online']}' />";
        }
    
    public function marisa_facebook_setting_fn() {
        echo "http://facebook.com/<input name='marisa_options[marisa_facebook]' value='{$this->options['marisa_facebook']}' />";
    }
    
    public function marisa_youtube_setting_fn() {
        echo "http://youtube.com/<input name='marisa_options[marisa_youtube]' value='{$this->options['marisa_youtube']}' />";
    }
    
    public function marisa_twitter_setting_fn() {
        echo "http://twitter.com/<input name='marisa_options[marisa_twitter]' value='{$this->options['marisa_twitter']}' />";
    }
    
    public function marisa_instagram_setting_fn() {
        echo "http://instagram.com/<input name='marisa_options[marisa_instagram]' value='{$this->options['marisa_instagram']}' />";
    }
    
    public function marisa_gplus_setting_fn() {
        echo "http://plus.google.com/<input name='marisa_options[marisa_gplus]' value='{$this->options['marisa_gplus']}' />";
    }
    
    public function marisa_logo_footer_fn() {
         echo "<input type='file' name='marisa_logo_footer_fd'/><br /><br />";
        if ( isset($this->options['marisa_logo_footer_fd']) ) {
            echo "<img src='{$this->options['marisa_logo_footer_fd']}' " . $this->logo_style() . " alt=''/>";
        }
    }
    
    public function marisa_label_site_setting_fn() {
        echo "<input name='marisa_options[marisa_label_site_footer]' value='{$this->options['marisa_label_site_footer']}' />";
    }
    
    public function marisa_copyright_footer_fn() {
        echo "<input name='marisa_options[marisa_copyright]' value='{$this->options['marisa_copyright']}' />";
    }
    
    public function marisa_cadastrese_descricao_fn() {
        echo "<textarea cols=\"60\" rows=\"10\" name='marisa_options[marisa_cadastrese_descricao]' >{$this->options['marisa_cadastrese_descricao']}</textarea>";
    }
    
    public function marisa_sucesso_descricao_fn() {
        echo "<textarea cols=\"60\" rows=\"10\" name='marisa_options[marisa_sucesso_descricao]' >{$this->options['marisa_sucesso_descricao']}</textarea>";
    }
    
    public function marisa_parceiros_descricao_fn() {
        echo "<textarea cols=\"60\" rows=\"10\" name='marisa_options[marisa_parceiros_descricao]' >{$this->options['marisa_parceiros_descricao']}</textarea>";
    }
    
    public function marisa_meusdados_descricao_fn() {
        echo "<textarea cols=\"60\" rows=\"10\" name='marisa_options[marisa_meusdados_descricao]' >{$this->options['marisa_meusdados_descricao']}</textarea>";
    }
    
    public function marisa_validate_settings($options) {
        
        //VALIDATE BACKGROUND HOME IMG
        if(!empty($_FILES['marisa_home_background']['tmp_name'])) {
            $override = array('test_form'=>false);
            $file = wp_handle_upload($_FILES['marisa_home_background'], $override);
            $options['marisa_home_background'] = $file['url'];
        } else {
            $options['marisa_home_background'] = $this->options['marisa_home_background'];   
        }
        
        //VALIDATE CALL SIGN INIT
        if(!empty($_FILES['marisa_call_sign_fd']['tmp_name'])) {
            $override = array('test_form'=>false);
            $file = wp_handle_upload($_FILES['marisa_call_sign_fd'], $override);
            $options['marisa_call_sign_fd'] = $file['url'];
        } else {
            $options['marisa_call_sign_fd'] = $this->options['marisa_call_sign_fd'];   
        }
        
        //VALIDATE LOGO HEADER IMG
        if(!empty($_FILES['marisa_logo_header_fd']['tmp_name'])) {
            $override = array('test_form'=>false);
            $file = wp_handle_upload($_FILES['marisa_logo_header_fd'], $override);
            $options['marisa_logo_header_fd'] = $file['url'];
        } else {
            $options['marisa_logo_header_fd'] = $this->options['marisa_logo_header_fd'];   
        }
        
        //VALIDATE LOGO HEADER MOBILE IMG
        if(!empty($_FILES['marisa_logo_header_mobile_fd']['tmp_name'])) {
            $override = array('test_form'=>false);
            $file = wp_handle_upload($_FILES['marisa_logo_header_mobile_fd'], $override);
            $options['marisa_logo_header_mobile_fd'] = $file['url'];
        } else {
            $options['marisa_logo_header_mobile_fd'] = $this->options['marisa_logo_header_mobile_fd'];   
        }
        
        //VALIDATE LOGO FOOTER IMG
        if(!empty($_FILES['marisa_logo_footer_fd']['tmp_name'])) {
            $override = array('test_form'=>false);
            $file = wp_handle_upload($_FILES['marisa_logo_footer_fd'], $override);
            $options['marisa_logo_footer_fd'] = $file['url'];
        } else {
            $options['marisa_logo_footer_fd'] = $this->options['marisa_logo_footer_fd'];   
        }
        
        return $options;
    }

    public function logo_style() {
        return "style='padding: 10px; background: url(" . admin_url() . "/images/bg-logo-offset.png)'";        
    }
    
}

add_action('admin_menu', function() {
    JW_Options::add_menu_page();
});

add_action('admin_init', function(){
    new JW_Options();
});
