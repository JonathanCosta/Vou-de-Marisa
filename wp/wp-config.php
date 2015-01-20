<?php
/** 
 * As configurações básicas do WordPress.
 *
 * Esse arquivo contém as seguintes configurações: configurações de MySQL, Prefixo de Tabelas,
 * Chaves secretas, Idioma do WordPress, e ABSPATH. Você pode encontrar mais informações
 * visitando {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. Você pode obter as configurações de MySQL de seu servidor de hospedagem.
 *
 * Esse arquivo é usado pelo script ed criação wp-config.php durante a
 * instalação. Você não precisa usar o site, você pode apenas salvar esse arquivo
 * como "wp-config.php" e preencher os valores.
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar essas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define('DB_NAME', 'marisawp');
//define('DB_NAME', 'vert255');

/** Usuário do banco de dados MySQL */
define('DB_USER', 'root');
//define('DB_USER', 'vert255');

/** Senha do banco de dados MySQL */
define('DB_PASSWORD', 'root');
//define('DB_PASSWORD', 'vert123');

/** nome do host do MySQL */
define('DB_HOST', 'localhost');
//define('DB_HOST', 'mysql56.vert.se');

/** Conjunto de caracteres do banco de dados a ser usado na criação das tabelas. */
define('DB_CHARSET', 'utf8');

/** O tipo de collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * Você pode alterá-las a qualquer momento para desvalidar quaisquer cookies existentes. Isto irá forçar todos os usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '-};b}Km7V3 AKWv2hXuKqsj Q*WM-+c}1TTir@{%>=Y&B&_T8Uf{:7d5D=_D$[.Y');
define('SECURE_AUTH_KEY',  '44pwkM`U|wF%v&,D6Ba=r(l_^m-J54tS25/4xQJv#|d2~4C#R4Tv}%{ovX?m<f9Z');
define('LOGGED_IN_KEY',    '@NZ#E]|![q/H{IQhcxhF/ra_hB.w.9_q6.I!<pPh&DOJicc[33jB9# >UQK`^BhD');
define('NONCE_KEY',        '+tOk#$B+:XV+l5CKr#8_v6k-C<)=Dq|)Kd||2cgCo/M=-6?uN;myb]~7p(q-UDdi');
define('AUTH_SALT',        'gD29|+r8&_|L$RE,ADBqVXMBlqvf^/Z0zg;+klqrd&h_:NY9,i-tX_Q +HwvCgE|');
define('SECURE_AUTH_SALT', 'oNrlEf?4^g:HsPfk,t/,{?L6|?=pEiC+lx%t9IoFAz:Cwm$[OL<KCM1)B&XZ}e`k');
define('LOGGED_IN_SALT',   '}=i7@?~xdN5%&SG9Rj0Ns?8#i|DxwH6-A:wSgL5hy55yW8ADsAe1madvW_cir2Z ');
define('NONCE_SALT',       'kR0+POr7M}}`huCcp?C6s-yj=Y6sx1CSZx Wyg1WYgkvVe|tRlvtWQ[ejXc:7xOW');

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der para cada um um único
 * prefixo. Somente números, letras e sublinhados!
 */
$table_prefix  = 'marisa_';

/**
 * O idioma localizado do WordPress é o inglês por padrão.
 *
 * Altere esta definição para localizar o WordPress. Um arquivo MO correspondente ao
 * idioma escolhido deve ser instalado em wp-content/languages. Por exemplo, instale
 * pt_BR.mo em wp-content/languages e altere WPLANG para 'pt_BR' para habilitar o suporte
 * ao português do Brasil.
 */
define('WPLANG', 'pt_BR');

/**
 * Para desenvolvedores: Modo debugging WordPress.
 *
 * altere isto para true para ativar a exibição de avisos durante o desenvolvimento.
 * é altamente recomendável que os desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 */
define('WP_DEBUG', false);

/* custom Settings */
define('FB_APP_ID', 241686319233509);

/* Encryption Salt */
define("SALT", "\xc8\xd9\xb9\x06\xd9\xe8\xc9\xd2");

/* Logger Base URL */
//define("LOGGER_BASE_URL", "http://ec2-54-94-184-27.sa-east-1.compute.amazonaws.com/");
define("LOGGER_BASE_URL", "http://local.vert/marisa/blog/log/");

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
	
/** Configura as variáveis do WordPress e arquivos inclusos. */
require_once(ABSPATH . 'wp-settings.php');
