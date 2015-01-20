<?php
$theme_opts = get_option('marisa_options');
?>
<section id="footer">
	<div class="container">
        <form action="<?php bloginfo('template_directory'); ?>/receiver-newsletter.php" method="post">
            <p>Assine nossa Newsletter e fique por dentro de todas as nossas novidades.</p>
            <?php
            if (isset($_GET["news"]) && $_GET["news"]=="success") {
                echo '<input type="text" placeholder="Obrigado por se cadastrar!" name="email" disabled="disabled" id="disabled" value="Obrigado por se cadastrar!">';
            } else {
                echo '<input type="text" placeholder="Digite seu e-mail" name="email">';
                echo '<button name="Enviar" class="sprite-enviar-news">ENVIAR</button>';
            }
            ?>
        </form>
        <div>
            <p><?php echo $theme_opts['marisa_label_site_footer']; ?></p>
            <a href="http://www.marisa.com.br" target="blank" class="marisasite">
                <img src="<?php echo $theme_opts['marisa_logo_footer_fd']; ?>" title="Marisa.com.br" alt="Marisa.com.br"/>
            </a>
        </div>
		<?php wp_footer(); ?>
	</div>
    <section id="bot-header" class="mobile">
        <ul>
            <li class="first">RECOMENDAR</li>
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
    <p class="copyright"><?php echo $theme_opts['marisa_copyright']; ?></p>
</section>

<script src="<?php echo get_template_directory_uri(); ?>/js/jquery-1.11.1.min.js"></script>
<?php if(is_page('cadastre-se')): ?>
        <script src="<?php echo get_template_directory_uri(); ?>/js/carroussel.js"></script>
<?php endif; ?>
<script src="<?php echo get_template_directory_uri(); ?>/js/underscore.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/image-marker.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/TweenMax.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/general.js?117"></script>

<?php
    
    $isLoggedIn = FrontUser::isLoggedIn();
    if ( !$isLoggedIn &&
        strpos(getLastPathSegment($_SERVER['REQUEST_URI']),"cadastre-se") === false &&
        strpos(getLastPathSegment($_SERVER['REQUEST_URI']),"login") === false && $_COOKIE['firsttime'] == "yes") {
        ?>
            <div class="film"></div>
            <div class="formnewuser">
                <p class="title"> Fa&ccedil;a seu cadastro <a href="#" class="closelightbox">X</a></p>
                <div class="left">
                    <?php 
                            if ( isset($theme_opts[marisa_call_sign_fd]) && strlen($theme_opts[marisa_call_sign_fd]) > 0 ) {
                                echo "<img src='".$theme_opts[marisa_call_sign_fd]."' title='' />";
                            }
                    ?>
                </div>
                <div class="right">
                    <div class="text">
                        <h4>
                            faça seu cadastro agora e ganhe desconto em produtos exclusivos
                        </h4>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eu pulvinar mi. Duis eget porttitor quam. Proin fermentum urna id nisi convallis, id tincidunt ipsum dictum.
                        </p>
                    </div>
                    
                    <form id="signup-form" action="./" method="post">
                        <a href="<?php echo get_site_url(); ?>/cadastre-se" class="facebook-login-btn sprite-facebook-bt social-bt">
                            Entrar com facebook
                        </a>

                        <a href="#" id="modal-email-login-btn" class="sprite-twitter-bt social-bt">
                            Entrar com e-mail
                        </a>

                        <div class="fields-wrapper">
                                <label for="email">E-mail: <input id="email" name="user_email" type="text" required /></label>
                                <label for="senha">Senha: <input id="senha" name="user_senha" type="password" required /></label>
                                <button type="submit"><ico class="sprite-cadastrese"></ico>ENTRAR</button>    
                        </div>

                        <input name="front_login" type="hidden" value="1"/>
                        <input name="facebook" type="hidden" value="0"/>                      

                    </form>


                </div>
            </div>
        <?php
    } else {
        // Logged in.
    }

?>

<nav class="fixed_menu">
    <ul>
        <li>
            <a href="<?php echo site_url(); ?>"><img src="<?php echo $theme_opts['marisa_logo_header_fd']; ?>" height="30" /></a>
        </li>
        <?php 
            $args = array(
                'orderby' => 'id',
                'style'    => 'list',
                'title_li' => ''
            );
            wp_list_categories( $args ); 
        ?>
        <?php if ($isLoggedIn) { ?>
        <li class="sprite-home-user">
            <a href="<?php echo site_url() ?>/meus-dados">
                <?php echo FrontUser::firstName(); ?>
            </a>
        </li>
        <?php } ?>
    </ul>
</nav>

<div id="fb-rootz"></div>

</body>
</html>