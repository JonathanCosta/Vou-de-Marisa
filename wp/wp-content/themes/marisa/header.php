<?php
$theme_opts = get_option('marisa_options');

//VERIFICA SE USUÁRIO POSSUI COOKIE
if ( strlen($_COOKIE['username']) < 1 ) {
    $date_of_expiry =  mktime().time()+60*60*24*365;
    setcookie( "userlogin", "guest", $date_of_expiry );
    
    if ($_COOKIE['firsttime'] == "yes") {
        setcookie( "firsttime", "no", $date_of_expiry );
    } else if (strlen($_COOKIE['firsttime']) === 0 ) {
        setcookie( "firsttime", "yes", $date_of_expiry );
    }
}
 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta name="viewport" content="width=600, initial-scale=1, maximum-scale=1">
<title><?php wp_title(''); ?></title>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); wp_head(); ?>
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_url'); ?>/css/image-marker.css" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_url'); ?>/css/main.css?37" />

<script>
    window.app = {
        userLoggedIn: '<?php echo is_user_logged_in(); ?>',
        templateUrl: '<?php echo get_template_directory_uri(); ?>',
        adminUrl: '<?php echo get_admin_url(); ?>',
        siteUrl: '<?php echo get_site_url(); ?>',
        thisPageUrl: '<?php echo the_permalink(); ?>',
        thisPageUrlEncoded: '<?php echo urlencode(the_permalink()); ?>',
        filtercategory: '',
        filterorderby: 'modified'
    };
</script>
</head>
    
<?php 

    $current_user = wp_get_current_user();

    if ( is_home() ) {
        $backg = "style=\"background:url(".$theme_opts['marisa_home_background'].") center center;\"";
    } else if ( get_field( "background", $postid) && ($_GET['p']) ) { 
        $backg = "style=\"background:url(".get_field('background', $postid).") center center;\"";
    } else {
        // vars
        $queried_object = get_queried_object(); 
        $taxonomy = $queried_object->taxonomy;
        $term_id = $queried_object->term_id;  

        // load thumbnail for this taxonomy term (term object)
        $thumbnail = get_field('background', $queried_object);
        
        if ( strlen($thumbnail) > 0 ) {
            $backg = "style=\"background:url(".$thumbnail.") center center;\"";
        } else {
            //$backg = "style=\"background:url(".get_template_directory_uri()."/images/bg-home.png);\"";
            $backg = "";
        }
    }
    
?>
    
<body class="<?php echo constant("page"); ?>" <?php echo $backg; ?>>

    <section id="sup-header" class="hidemobile">
        <ul>
            <?php if (isset($theme_opts['marisa_cartao_marisa']) && strlen($theme_opts['marisa_cartao_marisa']) > 0) { ?>
            <li><a href="http://<?php echo $theme_opts['marisa_cartao_marisa']; ?>" target="_blank">Cart&atilde;o Marisa</a></li>
            <?php } ?>
            <?php if (isset($theme_opts['marisa_nossas_lojas']) && strlen($theme_opts['marisa_nossas_lojas']) > 0) { ?>
            <li><a href="http://<?php echo $theme_opts['marisa_nossas_lojas']; ?>" target="_blank">Nossas Lojas</a></li>
            <?php } ?>
            <?php if (isset($theme_opts['marisa_compre_online']) && strlen($theme_opts['marisa_compre_online']) > 0) { ?>
            <li><a href="http://<?php echo $theme_opts['marisa_compre_online']; ?>" target="_blank">Compre On-line</a></li>
            <?php } ?>
            <?php if (isset($theme_opts['marisa_facebook']) && strlen($theme_opts['marisa_facebook']) > 0) { ?>
            <li class="sprite-sprite-facebook box"><a href="http://www.facebook.com/<?php echo $theme_opts['marisa_facebook']; ?>" target="_blank" class="">Facebook</a></li>
            <?php } ?>
            <?php if (isset($theme_opts['marisa_youtube']) && strlen($theme_opts['marisa_youtube']) > 0) { ?>
            <li class="sprite-sprite-youtube box"><a href="http://www.youtube.com/<?php echo $theme_opts['marisa_youtube']; ?>" target="_blank" class="">Youtube</a></li>
            <?php } ?>
            <?php if (isset($theme_opts['marisa_twitter']) && strlen($theme_opts['marisa_twitter']) > 0) { ?>
            <li class="sprite-sprite-twitter box"><a href="http://www.twitter.com/<?php echo $theme_opts['marisa_twitter']; ?>" target="_blank" class="">Twitter</a></li>
            <?php } ?>
            <?php if (isset($theme_opts['marisa_instagram']) && strlen($theme_opts['marisa_instagram']) > 0) { ?>
            <li class="sprite-sprite-instagram box"><a href="http://www.instagram.com/<?php echo $theme_opts['marisa_instagram']; ?>" target="_blank" class="">Instagram</a></li>
            <?php } ?>
            <?php if (isset($theme_opts['marisa_gplus']) && strlen($theme_opts['marisa_gplus']) > 0) { ?>
            <li class="sprite-sprite-gplus box"><a href="http://www.plus.google.com/<?php echo $theme_opts['marisa_gplus']; ?>" target="_blank" class="">Google Plus</a></li>
            <?php } ?>
        </ul>
    </section>
    
	<section id="header">
        <div class="container">
            <a class="nav mobile menumobile">Exibir Menu Mobile</a>
            <h1 class="" onclick="document.location = '<?php echo site_url(); ?>';">
                <a href="<?php echo $theme_opts['marisa_logo_header_link']; ?>" title="<?php bloginfo('name'); ?>">
                    <img src="<?php echo $theme_opts['marisa_logo_header_fd']; ?>" alt="<?php bloginfo('name'); ?>" title="<?php bloginfo('name'); ?>" class="hidemobile" />
                    <img src="<?php echo $theme_opts['marisa_logo_header_mobile_fd']; ?>" alt="<?php bloginfo('name'); ?>" title="<?php bloginfo('name'); ?>" class="mobile" />
                </a>
            </h1>
            <?php if ( strlen($current_user->user_firstname) < 1 ) { ?>
            <a href="<?php echo site_url(); ?>/cadastre-se/" class="nav mobile entrar"><ico class="entrar sprite-door"></ico> Entrar</a>
            <?php } else { ?>
            <div class="sprite-home-user mobile">
                Ol&aacute; 
                <a href="meus-dados/">
                   <?php echo $current_user->user_firstname; ?>
                </a>
            </div>
            <?php } ?>
            <form class="<?php             
                            if ( 0 < $current_user->ID ) {
                                echo "logged";
                            } 
                          ?>" action="<?php echo site_url(); ?>/busca" method="get">
                    <input type="text" name="b" class="txtbusca" placeholder="O que voc&ecirc; procura?" />
                    <button value="btbusca" class="sprite-sprite-busca">O que voc&ecirc; procura?</button>
            </form>
            <a href="<?php echo site_url(); ?>/parceiros/" class="nav hidemobile parceiros"><ico class="parceiros sprite-people"></ico> Parceiros</a>
            <?php if ( strlen($current_user->user_firstname) < 1 ) { ?>
            <a href="<?php echo site_url(); ?>/cadastre-se/" class="nav hidemobile cadastro"><ico class="cadastro sprite-form"></ico> Cadastre-se</a>
            <a  href="<?php echo site_url(); ?>/cadastre-se/" class="nav hidemobile entrar"><ico class="entrar sprite-door"></ico> Entrar</a>
            <?php } else { ?>
            <div class="sprite-home-user hidemobile">
                Ol&aacute; 
                <a href="meus-dados/">
                   <?php echo $current_user->user_firstname; ?>
                </a>
            </div>
            <?php } ?>
            
            <nav class="">
                <ul>
                    <?php 
                        $args = array(
                            'orderby' => 'id',
                            'style'    => 'list',
                            'title_li' => ''
                        );
                        wp_list_categories( $args );
                    ?>
                    <li class="cat-item cat-item-6 mobile"><a href="<?php echo site_url(); ?>/parceiros/"><ico class="sprite-people"></ico>Parceiros</a></li>
                </ul>
            </nav>
        </div>
	</section>