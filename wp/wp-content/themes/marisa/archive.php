<?php define("page", "archive"); ?>
<?php
$pos = strpos($_SERVER['REQUEST_URI'], 'tags/');
if ( $pos > -1 && !isset($_GET["t"]) ) {
    header('Location: '.get_site_url().'/?t='.getLastPathSegment($_SERVER['REQUEST_URI']));
    exit();
}
?>
<?php get_header(); ?>

<?php
$args = array(
    'posts_per_page' => 10,
    'post_type' => 'post',
    'meta_key' => 'cf_banner_exibircarrossel',
    'meta_value' => '1',
    'category_name' => getLastPathSegment($_SERVER['REQUEST_URI'])
);
query_posts($args);
?>
<?php if ( have_posts() ) { ?>
<section id="banner">
	<ul>
        <?php while ( have_posts() ) { ?>
        <?php the_post(); ?>
        <?php $postid = get_the_ID(); ?>
        <li id="<? echo $postid; ?>" data-title="<?php the_title(); ?>" data-link="<?php echo get_permalink(); ?>" data-window="_self" data-bg="<?php echo get_post_meta($postid, 'cf_banner_background', true); ?>" data-fg="<?php echo get_post_meta($postid, 'cf_banner_foreground', true); ?>" data-fgm="<?php echo get_post_meta($postid, 'cf_banner_foreground_mobile', true); ?>"></li>
        <?php } //endwhile ?>
    </ul>
    <div class="container">
        <ico class="arrow previous sprite-previous"><</ico>
        <ico class="arrow next sprite-next">></ico> 
        <div class="bullets"></div>
    </div>
</section>
<?php } //endif; ?>
    
<nav id="submenu">
    <div class="container">
        <?php
            $category = get_category_by_slug(getLastPathSegment($_SERVER['REQUEST_URI']));
        ?>
        <div>
            <h5>
                <?php echo $category->name; ?>
            </h5>
            <form method="post">
                <label for="filtro">
                    <input type="radio" value="date" class="filtroposts" name="filtroposts" checked="checked">
                    Mais recentes
                </label>
                <label for="filtro">
                    <input type="radio" value="comment_count" class="filtroposts" name="filtroposts">
                    Mais vistos
                </label>
            </form>
        </div>
        <ul>
            <li class="cat-item cat-item-0">
                <a href="" class="active">Todas</a>
            </li>
            <?php 
                $args_cat = array(
                    'orderby' => 'id',
                    'style'    => 'list',
                    'title_li' => ''
                );
                wp_list_categories( $args_cat );
            ?>
        </ul>
    </div>
</nav>

<section id="index">
    
    <div class="container">
		<div id="artigos">
            <?php
            $args = array(
                'posts_per_page' => 6,
                'post_type' => 'post',
                'category_name' => getLastPathSegment($_SERVER['REQUEST_URI'])
            );
            query_posts($args);
            global $count;
            $count = 0;
            $totalposts = $wp_query->found_posts;
            ?>
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            
				<div class="artigo <?php if ($count % 3 == 0) { echo "first"; } ?>">
					<a href="<?php the_permalink() ?>"><?php if ( has_post_thumbnail() ) { the_post_thumbnail(); } ?></a>
					<div class="call-box">
                        <h3><?php echo $first; ?><?php the_category(); ?></h3>
                        <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
                        <p><a href="<?php the_permalink() ?>"><?php the_field('resumo_de_capa'); ?></a></p>
                    </div>
				</div>
                <?php $count++; ?>
                <?php endwhile?>
				<div class="navegacao">
					<div class="recentes"><?php next_posts_link('&laquo; Artigos Anteriores') ?></div>
					<div class="anteriores"><?php previous_posts_link('Artigos Recentes &raquo;') ?></div>
				</div>
			<?php else: ?>
				<div class="artigo">
					<h2>Nada Encontrado</h2>
					<p>Erro 404</p>
					<p>Lamentamos mas não foram encontrados artigos.</p>
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
    
    <div class="parceiros">
        <div class="container">
            <h4>
                <a href="parceiros/" title="Parceiros de conteúdo">
                    Parceiros de conteúdo
                    <span>Conhe&ccedil;a o perfil dos nossos parceiros</span>
                </a>
            </h4>
            <a href="parceiros/" title="Parceiros de conteúdo">
                <img src="<?php echo get_template_directory_uri(); ?>/images/parceiros.png" alt="Parceiros de conteúdo" />
            </a>
        </div>
    </div>
</section>
<?php include(TEMPLATEPATH . '/socials.php'); ?>
<?php get_footer(); ?>