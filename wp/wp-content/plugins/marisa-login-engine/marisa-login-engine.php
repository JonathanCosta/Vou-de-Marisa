<?php 
/*
Plugin Name: Marisa Login Engine
Plugin URI: http://vert.se
Description: Plugin de configura&ccedil;&otilde;es de login e cadastro espec&iacute;ficas para o Tema Marisa
Version: 1.0
Author: Miguel Alves
Author URI: http://vert.se
*/

function success_template() {
    $theme_opts = get_option('marisa_options');
    $descricao = $theme_opts['marisa_sucesso_descricao'];
    $handShake = getPayload(array('action' => 'get_latest_products'));
    $html =
<<<HTML
    <div class="cadastro-sucesso">
        <div class="header">
            <h2>Parabéns</h2>
            <strong>Seu cadastro foi realizado com sucesso!</strong>
        </div>
        <p class="desc">$descricao</p>

        <h1><span>Produtos exclusivos pra você</span></h1>

        <input type="hidden" id="fetch_products_handshake" value="$handShake">

        <div class="products">
            <div class="loading"></div>
        </div>

    </div>
HTML;
    return $html;
}

function form_template() {
    $theme_opts = get_option('marisa_options');
    $html = "";
    $html .= "<p>".$theme_opts['marisa_cadastrese_descricao']."</p>";
    $html .= "<div class='col1'>";
    $html .= print_msg();
    $html .= "<p class='font16'>Registre-se usando sua conta do Facebook:</p>
                <div class=\"newuser\">
                    <a href=\"#\" class=\"sprite-facebook-bt social-bt facebook-login-btn\">
                        Entrar com facebook
                    </a>
                </div>
                <p class='font16'>Ou cadastre seu email e senha:</p>
    ";
    $html .= "<form class=\"signup-form\" id=\"signup-form\" name=\"cadastro\" action=\"./\" method=\"post\"/>";
    $html .= "<label for=\"name\">Nome: <input id=\"name\" name=\"user_name\" type=\"text\" required/></label>";
    $html .= "<label for=\"email\">E-mail: <input id=\"email\" name=\"user_email\" type=\"text\" required/></label>";
    /*$html .= "<label for=\"cidade\">Cidade: <input id=\"cidade\" name=\"user_cidade\" type=\"text\"/></label>";
    $html .= "<label for=\"estado\">Estado: <select id=\"estado\" name=\"user_estado\" id=\"estado\">
                <option>Selecione</option>
                <option value=\"AC\">Acre</option>
                <option value=\"AL\">Alagoas</option>
                <option value=\"AP\">Amapá</option>
                <option value=\"AM\">Amazonas</option>
                <option value=\"BA\">Bahia</option>
                <option value=\"CE\">Ceará</option>
                <option value=\"DF\">Distrito Federal</option>
                <option value=\"ES\">Espirito Santo</option>
                <option value=\"GO\">Goiás</option>
                <option value=\"MA\">Maranhão</option>
                <option value=\"MT\">Mato Grosso</option>
                <option value=\"MS\">Mato Grosso do Sul</option>
                <option value=\"MG\">Minas Gerais</option>
                <option value=\"PA\">Pará</option>
                <option value=\"PB\">Paraiba</option>
                <option value=\"PR\">Paraná</option>
                <option value=\"PE\">Pernambuco</option>
                <option value=\"PI\">Piauí</option>
                <option value=\"RJ\">Rio de Janeiro</option>
                <option value=\"RN\">Rio Grande do Norte</option>
                <option value=\"RS\">Rio Grande do Sul</option>
                <option value=\"RO\">Rondônia</option>
                <option value=\"RR\">Roraima</option>
                <option value=\"SC\">Santa Catarina</option>
                <option value=\"SP\">São Paulo</option>
                <option value=\"SE\">Sergipe</option>
                <option value=\"TO\">Tocantis</option>
            </select></label>";*/
    $html .= "<label for=\"senha\">Senha: <input id=\"senha\" name=\"user_senha\" type=\"password\" class=\"half\" required /></label>";
    $html .= "<label for=\"repetirsenha\">Repita a senha: <input id=\"repetirsenha\" name=\"repetirsenha\" type=\"password\" class=\"half\" required /></label>";
    $html .= "<label for=\"lembrese\"><input name=\"lembrese\" type=\"checkbox\" value=\"lembrese\" class=\"\"/> Lembre-se de mim</label>";

    $html .= "<input name=\"cadastro\" type=\"hidden\" value=\"1\"/>";
    $html .= "<input name=\"facebook\" type=\"hidden\" value=\"0\"/>";

    $html .= "<button type=\"submit\"><ico class=\"sprite-cadastrese\"></ico>CADASTRE-SE</button>";
    $html .= "</form></div>";
    $html .= "<div class='col2'>";
    if ( isset($theme_opts[marisa_call_sign_fd]) && strlen($theme_opts[marisa_call_sign_fd]) > 0 ) {
        $html .= "<img src='".$theme_opts[marisa_call_sign_fd]."' title=''/>";
    }
    $html .= "</div>";
    
    return $html;
}

function cadastro_entries( ) {
    if(FrontUser::isLoggedIn()) {
        return success_template();
    }
    return form_template();
}

function login_entries( ) {
    $theme_opts = get_option('marisa_options');
    $html = "";
    $html .= "<div class='col1'>";
    $html .= print_msg();
    $html .=
<<<HTML
    <div class="newuser">
        <a href="#" class="sprite-facebook-bt social-bt facebook-login-btn">
            Conectar com o facebook
        </a>
    </div>
    <form id="signup-form" action="./" method="post">
        <label for="email">E-mail: <input id="email" name="user_email" type="text" class="half" required /></label>
        <label for="senha">Senha: <input id="senha" name="user_senha" type="password" class="half" required /></label>
        <label for="lembrese"><input name="lembrese" type="checkbox" value="lembrese" class=""/> Lembre-se de mim</label>

        <input name="front_login" type="hidden" value="1"/>
        <input name="facebook" type="hidden" value="0"/>

        <button type="submit"><ico class="sprite-cadastrese"></ico>ENTRAR</button>
    </form>
</div>
<div class='col2'>
HTML;

    if ( isset($theme_opts[marisa_call_sign_fd]) && strlen($theme_opts[marisa_call_sign_fd]) > 0 ) {
        $html .= "<img src='".$theme_opts[marisa_call_sign_fd]."' title=''/>";
    }
    $html .= "</div>";
    
    return $html;
}

function meusdados_entries( ) {
    $name = FrontUser::name();
    $theme_opts = get_option('marisa_options');
    $site_url = site_url();
    $change_passord = FrontUser::uid() ? '' :
<<<HTML
        <p class='bold'>Alterar Senha</p>
        <label for="senhaatual">Senha atual: <input id="senha_atual" name="senha_atual" type="password" class="half" /></label>
        <label for="senha">Nova senha: <input id="senha" name="user_senha" type="password" class="half" /></label>
        <label for="repetirsenha">Repita a senha: <input id="repetirsenha" name="repetirsenha" type="password" class="half" /></label>
HTML;
    $html = "";
    $html .= "<p>".$theme_opts['marisa_cadastrese_descricao']."</p>";
    $html .= "<div class='col1'>";
    $html .= print_msg();
    $html .=
<<<HTML
    <form id="signup-form" class="edit-info-form" name="cadastro" action="" method="post"/>
        <label for="name">Nome: <input name="user_name" value="{$name}" type="text" required/></label>

        {$change_passord}

        <input name="update_info" type="hidden" value="1"/>

        <button type="submit"><ico class="sprite-cadastrese"></ico>SALVAR ALTERAÇÕES</button>
        <a class="button" href="$site_url/?front_user_logout=true"><ico class="sprite-logoff"></ico>FAZER LOGOFF</a>
    </form>
</div>
<div class='col2'>
HTML;
    if ( isset($theme_opts[marisa_call_sign_fd]) && strlen($theme_opts[marisa_call_sign_fd]) > 0 ) {
        $html .= "<img src='".$theme_opts[marisa_call_sign_fd]."' title=''/>";
    }
    $html .= "</div>"; 
    
    return $html;
}

function print_msg() {
    $msg = '';
    if(isset($_SESSION['signup_error']) && $_SESSION['signup_error']) {
        $msg = '<p class="error">' . $_SESSION['signup_error'] . '</p>';
        unset($_SESSION['signup_error']);
    }
    if(isset($_SESSION['signup_success']) && $_SESSION['signup_success']) {
        $msg = '<p class="success">' . $_SESSION['signup_success'] . '</p>';
        unset($_SESSION['signup_success']);
    }    

    return $msg;
}

add_shortcode('cadastro', cadastro_entries);
add_shortcode('login', login_entries);
add_shortcode('meusdados', meusdados_entries);

//the_author_meta( $meta_key, $user_id );