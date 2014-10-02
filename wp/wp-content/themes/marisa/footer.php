<?php
$theme_opts = get_option('marisa_options');
?>
<section id="footer">
	<div class="container">
        <form action="<?php bloginfo('template_directory'); ?>/receiver-newsletter.php" method="post">
            <p>Assine nossa Newsletter e fique por dentro de todas as nossas novidades.</p>
            <?php
            if (isset($_GET["news"]) && $_GET["news"]=="success") {
                echo '<input type="text" placeholder="Obrigado por se cadastrar!" name="email" disabled="disabled">';
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
    <p class="copyright"><?php echo $theme_opts['marisa_copyright']; ?></p>
</section>

<script src="<?php echo get_template_directory_uri(); ?>/js/jquery-1.11.1.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/1.13.2/TweenMax.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/underscore.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/image-marker.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/general.js?30"></script>

<?php
    
    $current_user = wp_get_current_user();
    if ( 0 == $current_user->ID && strpos(getLastPathSegment($_SERVER['REQUEST_URI']),"cadastre-se") === false  ) {
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

                    <a href="cadastre-se/" class="sprite-facebook-bt social-bt">
                        Entrar com facebook
                    </a>

                    <a href="cadastre-se/" class="sprite-twitter-bt social-bt">
                        Entrar com Twitter
                    </a>

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
            <a href="index.php"><img src="<?php echo $theme_opts['marisa_logo_header_fd']; ?>" height="29" /></a>
        </li>
        <?php 
            $args = array(
                'orderby' => 'id',
                'style'    => 'list',
                'title_li' => ''
            );
            wp_list_categories( $args ); 
        ?>
        <?php if ( strlen($current_user->user_firstname) > 0 ) { ?>
        <li class="sprite-home-user">
            <a href="meus-dados/">
                <?php echo $current_user->user_firstname; ?>
            </a>
        </li>
        <?php } ?>
    </ul>
</nav>

</body>
</html>