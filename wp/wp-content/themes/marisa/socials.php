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
                <img src="<?php echo get_template_directory_uri(); ?>/images/ajax-loader-dark.gif" style="margin: 30px auto;display: block;"/>
            </ul>
            
            <div id="fb-root"></div>
            
            <script>
                (function() {
                    var e = document.createElement('script'); e.async = true;
                    e.src = document.location.protocol + '//connect.facebook.net/pt_BR/all.js';
                    document.getElementById('fb-root').appendChild(e);
                }());

                window.fbAsyncInit = function() {
                    FB.init({
                        appId: '114269431990058',
                        status: true,
                        cookie: true,
                        oauth : true
                    });

                    FB.api('/voudemarisa/posts?fields=id,message,picture,link&limit=3&access_token=CAABn7WznByoBAKzPq2dklJgIogTVLuhNpKVP2hJ1syB6HiAbZCRDBPa2RPYK3sE4Uc9OZCdeAU1JGGVqq25b1QOk8urrZAVotTaZBEKww6smBaffONjgTpA4Lp2ASoA4ZBjiLeAABjAmonWfrhzERioi9oIMn3XcVKsUng2cuiIyl185U08AyZAKJaXZCLwUDcZD', function(response) {
                        var html = '';
                        $.each(response.data, function(idx, p) {
                            html += '<li><a title="' + p.message + '" href="' + p.link + '" target="_blank"><img src="' + p.picture + '"></a></li>';
                        });
                        $('.box_twitter_lis img').remove();
                        $('.box_twitter_lis').append(html);
                    });
                };

            </script>
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
                <img src="<?php echo get_template_directory_uri(); ?>/images/ajax-loader-dark.gif" style="margin: 30px auto;display: block;"/>
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
                <img src="<?php echo get_template_directory_uri(); ?>/images/ajax-loader-dark.gif" style="margin: 30px auto;display: block;"/>
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