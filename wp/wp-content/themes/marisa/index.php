<?php define("page", "index"); ?>
<?php get_header(); ?>

<?php
$args = array(
    'posts_per_page' => 10,
    'post_type' => 'post',
    'meta_key' => 'cf_banner_exibirhome',
    'meta_value' => '1'
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

<section id="index">
	<div class="container">
		<div id="artigos">
            <?php
            $theme_opts = get_option('marisa_options');
            $args = array(
                'posts_per_page' => $theme_opts['marisa_logo_posts_page'],
                'post_type' => 'post',
                'paged' => 1,
                'meta_key' => null,
                'meta_value' => null
            );
            $pos = strrpos($_SERVER['REQUEST_URI'], "/tags/");
            if ($pos > -1) {
                $args['tag'] = getLastPathSegment($_SERVER['REQUEST_URI']);
            } else {
                $args['tag'] = null;
            }
            query_posts($args);
            global $count;
            $count = 0;
            $totalposts = $wp_query->found_posts;
            ?>
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            
				<div class="artigo <?php
                    if ($count % 3 == 0) { echo "first"; }
                ?>">
                    <a href="<?php the_permalink() ?>"><?php if ( has_post_thumbnail() ) { the_post_thumbnail(); } ?></a>
                    <div class="call-box">
                        <h3><?php echo $first; ?><?php the_category(); ?></h3>
                        <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
                        <p><a href="<?php the_permalink() ?>"><?php echo words(the_field('resumo_de_capa'), 3); ?></a></p>
                    </div>
                    
				</div>
                <?php $count++; ?>
                <?php endwhile?>
				
			<?php else: ?>
				<div class="artigo">
					<h2>Nada Encontrado</h2>
				</div>			
			<?php endif; ?>
			
		</div>
        <?php if ( $count < $totalposts ) { ?>
        <div class="container loader">
            <div class="loaderPage"><img src="<?php echo get_template_directory_uri(); ?>/images/ajax-loader.gif"></div>
            <input type="hidden" id="pagenumber" value="2"/>
            <button type="button" class="mais" onclick="moreposts('<?php echo get_template_directory_uri(); ?>');"><ico class="sprite-mais"></ico>Carregar Mais</button>
        </div>
        <?php } ?>
		
		<?php //get_sidebar(); ?>
	</div>
    
</section>
<?php include(TEMPLATEPATH . '/socials.php'); ?>
<?php get_footer(); ?>