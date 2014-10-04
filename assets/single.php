<?php define("page", "single"); ?>
<?php get_header(); ?>
<?php
$args = array(
    'posts_per_page' => 10,
    'post_type' => 'post',
    'name' => getLastPathSegment($_SERVER['REQUEST_URI'])
);
query_posts($args);
?>
<?php if ( have_posts() ) { ?>
<section id="banner">
    <!--div class="container"-->
        <ul>
            <?php while ( have_posts() ) { ?>
            <?php the_post(); ?>
            <?php $postid = get_the_ID(); ?>
            <li id="<? echo $postid; ?>" data-title="<?php the_title(); ?>" data-link="<?php echo get_permalink(); ?>" data-window="_self" data-bg="<?php echo get_post_meta($postid, 'cf_banner_background', true); ?>" data-fg="<?php echo get_post_meta($postid, 'cf_banner_foreground', true); ?>" data-fgm="<?php echo get_post_meta($postid, 'cf_banner_foreground_mobile', true); ?>"></li>
            <?php } //endwhile ?>
        </ul>
        <ico class="arrow previous sprite-previous"><</ico>
        <ico class="arrow next sprite-next">></ico> 
        <div class="bullets"></div>
    <!--/div-->
</section>
<?php } //endif; ?>

<?php
$args = array(
    'posts_per_page' => 10,
    'name' => getLastPathSegment($_SERVER['REQUEST_URI'])
);

$pos = strrpos($_SERVER['REQUEST_URI'], "/tags/");
if ($pos > -1) {
    $args['name'] = null;
    $args['tag'] = getLastPathSegment($_SERVER['REQUEST_URI']);
} else {
    $args['tag'] = null;
}

$resultssingle = new WP_Query( $args );
?>

<section id="single">
	<div class="container">
		<div id="artigos">
			<?php if ( $resultssingle->have_posts() ) : while ( $resultssingle->have_posts() ) : $resultssingle->the_post(); ?>
				<div class="content_post">
                    <span class="date">
                        <span><?php the_time('d') ?></span>
                        <b class="sprite-monthyear"><?php the_time('F') ?><br><?php the_time('Y') ?></b>
                    </span>
					<h2><?php the_title(); ?></h2>
                    <h3><?php the_field('texto_de_apoio'); ?></h3>
                    <?php the_content(); ?>
                    <?
                    $current_post_id = get_the_id();
                    $current_user = wp_get_current_user();
                    if ( 0 < $current_user->ID ) {
                        echo get_post_meta($post->ID, 'restrict_field', true);
                    } else if ( strlen(get_post_meta($post->ID, 'restrict_field', true)) > 2 ) {
                        ?>
                    
                        <div class="unlogged sprite-unlogged">
                            <div class="text">
                                <h4>
                                    Quer ter acesso ao nosso<br />conteúdo exclusivo?
                                </h4>
                                <p>
                                    N&atilde;o perca nenhuma novidade.<br/>Cadastre-se agora ou fa&ccedil;a seu login.
                                </p>
                            </div>

                            <a href="cadastre-se/" class="sprite-facebook-menor-bt social-bt">
                                Entrar com facebook
                            </a>

                            <a href="cadastre-se/" class="sprite-email-menor-bt social-bt">
                                Entrar com E-mail
                            </a>
                        </div>
                    
                        <?php
                    }
                    ?>
                    
                    <div class="posttags">
                        <span>TAGS</span>
                        <?php
                        $posttags = get_the_tags();
                        if ($posttags) {
                          foreach($posttags as $tag) {
                            echo "<a href=\"".site_url()."/tags/".$tag->name."/"."\" rel=\"tag\">".$tag->name."</a>";
                          }
                        }
                        ?>
                    </div>
                    
                    <div class="facebook-comentarios <?php if ( 0 >= $current_user->ID ) { echo "nonlogged"; } ?>">
                        <!--h3><?php comments_number('0 Mensagens', '1 Mensagem', '% Mensagens' );?></h3-->
                        
                        <?php comments_template(); ?>
                        
                        <!--div id="fb-root"></div-->
                        
                        <!--script>(function(d, s, id) {
                          var js, fjs = d.getElementsByTagName(s)[0];
                          if (d.getElementById(id)) return;
                          js = d.createElement(s); js.id = id;
                          js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&appId=1464907580437603&version=v2.0";
                          fjs.parentNode.insertBefore(js, fjs);
                        }(document, 'script', 'facebook-jssdk'));</script-->
                        <!--div class="fb-comments" data-href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" data-width="100%" data-numposts="5" data-colorscheme="light"></div-->
                    </div>
				</div>
                <?php get_sidebar(); ?>
			<?php endwhile?>
				
			<?php else: ?>
            
			<?php endif; ?>
		</div>
	</div>
</section>

<section id="relacionados">
	<div class="container">
        <?php
        $categories = get_the_category();
        $category_id = $categories[0]->cat_ID;
        $args = array(
            'posts_per_page' => 3,
            'post_type' => 'post',
            'cat' => $category_id
        );
        query_posts($args);
        global $count;
        $count = 0;
        ?>
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <?php if ( $current_post_id != get_the_id() ) { ?>
            <?php if ( $current_post_id != get_the_id() && $count < 1 ) { ?>
                <header>
                    POSTS <span>RELACIONADOS</span>
                </header>
            <?php } ?>
            <div class="artigo <?php
                if ($count % 3 == 0) { echo "first"; }
            ?>">
                <a href="<?php the_permalink() ?>"><?php if ( has_post_thumbnail() ) { the_post_thumbnail(); } ?></a>
                <div class="call-box">
                    <h3><?php echo $first; ?><?php the_category(); ?></h3>
                    <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
                    <p><a href="<?php the_permalink() ?>"><?php the_field('resumo_de_capa'); ?></a></p>
                </div>
            </div>
        <?php } ?>
        <?php 
            $count++; 
            endwhile; 
        ?>
        <?php endif; ?>
    </div>
</section>
<?php get_footer(); ?>