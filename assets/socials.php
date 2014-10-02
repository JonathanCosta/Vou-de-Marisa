<?php
$theme_opts = get_option('marisa_options');
?>
<section id="socials">
	<div class="container">
        
        <?php if ( isset($theme_opts['marisa_facebook']) && strlen($theme_opts['marisa_facebook']) > 0 ) { ?>
        <div class="facebook social_box">
            <header>
                <a taget="_blank" href="http://www.facebook.com/<?php echo $theme_opts['marisa_facebook']; ?>">
                    <ico class="sprite-footer-facebook"></ico>
                    Facebook <span>Acompanhe no Facebook.</span>
                </a>
            </header>
            
            <ul class="box_facebook_lis">
                <li class="first">Últimas postagens</li>
                <img src="<?php echo get_template_directory_uri(); ?>/images/ajax-loader.gif" style="margin: 30px auto;display: block;"/>
            </ul>
            
            <div id="fb-root"></div>
            
            <footer>
                <a taget="_blank" href="http://www.facebook.com/<?php echo $theme_opts['marisa_facebook']; ?>">VER MAIS</a>
            </footer>
            
        </div>
        <?php } ?>
        
        <?php if ( isset($theme_opts['marisa_twitter']) && strlen($theme_opts['marisa_twitter']) > 0 ) { ?>
        <div class="twitter social_box">
            <header>
                <a taget="_blank" href="http://www.twitter.com/<?php echo $theme_opts['marisa_twitter']; ?>">
                    <ico class="sprite-footer-twitter"></ico>
                    Twitter <span>Acompanhe no Twitter.</span>
                </a>
            </header>
            <ul class="box_twitter_lis">
                <li class="first">Tweets</li>
                <img src="<?php echo get_template_directory_uri(); ?>/images/ajax-loader.gif" style="margin: 30px auto;display: block;"/>
            </ul>
            <footer>
                <a taget="_blank" href="http://www.twitter.com/<?php echo $theme_opts['marisa_twitter']; ?>">VER MAIS</a>
            </footer>
        </div>
        <?php } ?>
        
        
        
        <?php if ( isset($theme_opts['marisa_instagram']) && strlen($theme_opts['marisa_instagram']) > 0 ) { ?>
        <div class="instagram social_box">
            <header>
                <a taget="_blank" href="http://www.instagram.com/<?php echo $theme_opts['marisa_instagram']; ?>">
                    <ico class="sprite-footer-instagram"></ico>
                    Instagram <span>Acompanhe no Instagram.</span>
                </a>
            </header>
            <ul class="box_instagram_lis">
                <img src="<?php echo get_template_directory_uri(); ?>/images/ajax-loader.gif" style="margin: 30px auto;display: block;"/>
            </ul>
            <footer>
                <a taget="_blank" href="http://www.instagram.com/<?php echo $theme_opts['marisa_instagram']; ?>">VER MAIS</a>
            </footer>
        </div>
        <?php } ?>
        
        
        <?php if ( isset($theme_opts['marisa_gplus']) && strlen($theme_opts['marisa_gplus']) > 0 ) { ?>
        <div class="gplus social_box">
            <header>
                <a taget="_blank" href="http://plus.google.com/<?php echo $theme_opts['marisa_gplus']; ?>">
                    <ico class="sprite-footer-gplus"></ico>
                    Google Plus <span>Acompanhe no Google Plus.</span>
                </a>
            </header>
            <ul class="box_gplus_lis">
                <img src="<?php echo get_template_directory_uri(); ?>/images/ajax-loader.gif" style="margin: 30px auto;display: block;"/>
            </ul>
            <footer>
                <a taget="_blank" href="http://plus.google.com/<?php echo $theme_opts['marisa_gplus']; ?>">VER MAIS</a>
            </footer>
        </div>
        <?php } ?>
        
	</div>
</section>