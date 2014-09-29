<?php 
/*
Plugin Name: Marisa Login Engine
Plugin URI: http://vert.se
Description: Plugin de configura&ccedil;&otilde;es de login e cadastro espec&iacute;ficas para o Tema Marisa
Version: 1.0
Author: Miguel Alves
Author URI: http://vert.se
*/

function cadastro_entries( ) {
    $theme_opts = get_option('marisa_options');
    $html = "";
    $html .= "<p>".$theme_opts['marisa_cadastrese_descricao']."</p>";
    $html .= "<div class='col1'>";
    $html .= "<p class='font16'>Registre-se usando sua conta do Facebook:</p>
                <div class=\"newuser\">
                    <a href=\"#\" class=\"sprite-facebook-bt social-bt\">
                        Entrar com facebook
                    </a>
                </div>
                <p class='font16'>Ou cadastre seu email e senha:</p>
    ";
    $html .= "<form name=\"cadastro\" action=\"\" method=\"post\"/>";
    $html .= "<label for=\"name\">Nome: <input name=\"name\" type=\"text\"/></label>";
    $html .= "<label for=\"email\">E-mail: <input name=\"email\" type=\"text\"/></label>";
    $html .= "<label for=\"cidade\">Cidade: <input name=\"cidade\" type=\"text\"/></label>";
    $html .= "<label for=\"estado\">Estado: <select name=\"estado\" id=\"estado\">
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
            </select></label>";
    $html .= "<label for=\"senha\">Senha: <input name=\"senha\" type=\"password\" class=\"half\"/></label>";
    $html .= "<label for=\"repetirsenha\">Repita a senha: <input name=\"repetirsenha\" type=\"password\" class=\"half\"/></label>";
    $html .= "<label for=\"lembrese\"><input name=\"lembrese\" type=\"checkbox\" value=\"lembrese\" class=\"\"/> Lembre-se de mim</label>";
    $html .= "<button type=\"submit\"><ico class=\"sprite-cadastrese\"></ico>CADASTRE-SE</button>";
    $html .= "</form></div>";
    $html .= "<div class='col2'>";
    if ( isset($theme_opts[marisa_call_sign_fd]) && strlen($theme_opts[marisa_call_sign_fd]) > 0 ) {
        $html .= "<img src='".$theme_opts[marisa_call_sign_fd]."' title=''/>";
    }
    $html .= "</div>";
    
    return $html;
}

function meusdados_entries( ) {
    $theme_opts = get_option('marisa_options');
    $html = "";
    $html .= "<p>".$theme_opts['marisa_cadastrese_descricao']."</p>";
    $html .= "<div class='col1'>";
    $html .= "<form name=\"cadastro\" action=\"\" method=\"post\"/>";
    $html .= "<label for=\"name\">Nome: <input name=\"name\" type=\"text\"/></label>";
    $html .= "<label for=\"email\">E-mail: <input name=\"email\" type=\"text\"/></label>";
    $html .= "<label for=\"cidade\">Cidade: <input name=\"cidade\" type=\"text\"/></label>";
    $html .= "<label for=\"estado\">Estado: <select name=\"estado\" id=\"estado\">
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
            </select></label>";
    $html .= "<p class='bold'>Alterar Senha</p>";
    $html .= "<label for=\"senhaatual\">Senha atual: <input name=\"senhaatual\" type=\"password\" class=\"half\"/></label>";
    $html .= "<label for=\"senha\">Nova senha: <input name=\"senha\" type=\"password\" class=\"half\"/></label>";
    $html .= "<label for=\"repetirsenha\">Repita a senha: <input name=\"repetirsenha\" type=\"password\" class=\"half\"/></label>";
    $html .= "<button type=\"submit\"><ico class=\"sprite-cadastrese\"></ico>SALVAR ALTERAÇÕES</button>";
    $html .= "</form></div>";
    $html .= "<div class='col2'>";
    if ( isset($theme_opts[marisa_call_sign_fd]) && strlen($theme_opts[marisa_call_sign_fd]) > 0 ) {
        $html .= "<img src='".$theme_opts[marisa_call_sign_fd]."' title=''/>";
    }
    $html .= "</div>";
    
    return $html;
}

add_shortcode('cadastro', cadastro_entries);
add_shortcode('meusdados', meusdados_entries);

//the_author_meta( $meta_key, $user_id );
