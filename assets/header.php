<?php
$theme_opts = get_option('marisa_options');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php wp_title(''); ?></title>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); wp_head(); ?>
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_url'); ?>/css/main.css?2" />
</head>
    
<?php 

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

    <section id="sup-header">
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
            <h1 class="" onclick="document.location = '/';">
                <a href="<?php echo $theme_opts['marisa_logo_header_link']; ?>" title="<?php bloginfo('name'); ?>">
                    <img src="<?php echo $theme_opts['marisa_logo_header_fd']; ?>" alt="<?php bloginfo('name'); ?>" title="<?php bloginfo('name'); ?>" />
                </a>
            </h1>
            <form class="<?php             
                            $current_user = wp_get_current_user();
                            if ( 0 < $current_user->ID ) {
                                echo "logged";
                            }

                          ?>" action="<?php get_site_url(); ?>/busca" method="get">
                    <input type="text" name="b" class="txtbusca" placeholder="O que voc&ecirc; procura?" />
                    <button value="btbusca" class="sprite-sprite-busca">O que voc&ecirc; procura?</button>
            </form>
            <a href="<?php echo site_url(); ?>/parceiros/" class="nav"><ico class="parceiros sprite-people"></ico> Parceiros</a>
            <?php if ( strlen($current_user->user_firstname) < 1 ) { ?>
            <a href="<?php echo site_url(); ?>/cadastre-se/" class="nav"><ico class="cadastro sprite-form"></ico> Cadastre-se</a>
            <a class="nav"><ico class="entrar sprite-door"></ico> Entrar</a>
            <?php } else { ?>
            <div class="sprite-home-user">
                Ol&aacute; 
                <a href="meus-dados/">
                   <?php echo $current_user->user_firstname; ?>
                </a>
            </div>
            <?php } ?>
            
            <nav>
                <ul>
                    <?php 
                        $args = array(
                            'orderby' => 'id',
                            'style'    => 'list',
                            'title_li' => ''
                        );
                        wp_list_categories( $args ); 
                    ?>
                </ul>
            </nav>
        </div>
	</section>